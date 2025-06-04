<?php

namespace GrimPirate\Halberd\Services;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

use PragmaRX\Google2FA\Google2FA;

use CodeIgniter\Config\Factories;
use CodeIgniter\Shield\Models\UserIdentityModel;
use GrimPirate\Halberd\Authentication\Authenticators\TOTP;

class Halberd
{
	public const SECRET_KEY_LENGTH = 16;

	public function __construct(protected Google2FA $google2fa = new Google2FA())
	{
	}

	public function generateSecretKey()
	{
		return $this->google2fa->generateSecretKey(service('settings')->get('TOTP.secretKeyLength') ?? SECRET_KEY_LENGTH);
	}

	public function verifyKeyNewer($secret, $code, $timestamp)
	{
		return false !== $this->google2fa->verifyKeyNewer($secret, $code, floor($timestamp / $this->google2fa->getKeyRegeneration()));
	}

	public function svg($path)
	{
		return '<svg version="1.1" viewBox="-4 -4 45 45"><path d="' . gzuncompress(base64_decode($path)) . '" /></svg>';
	}

	public function qrcode($issuer, $accountname, $secret)
	{
		$writer = new Writer(new ImageRenderer(
			new RendererStyle(120),
			new SvgImageBackEnd()
		));

		$path = preg_replace(
			'/^.*d="([^"]+).*$/s',	// Leave only path data
			'$1',
			$writer->writeString($this->google2fa->getQRCodeUrl($issuer, $accountname, $secret)));

		// Optimize path data
		$path = preg_split('/([MLZ]+)/', $path, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		$prevCoord = preg_split('/\h+/', $path[1], -1, PREG_SPLIT_NO_EMPTY);
		for($i = 3; $i < count($path); $i += 2)
		{
			$currCoord = preg_split('/\h+/', $path[$i], -1, PREG_SPLIT_NO_EMPTY);
			if($path[$i - 1] == 'L')
			{
				$path[$i - 1] = $prevCoord[1] == $currCoord[1] ? 'H' : 'V';
				$path[$i] = $currCoord[$prevCoord[1] == $currCoord[1] ? 0 : 1];
			}
			$prevCoord = $currCoord;
		}

		return base64_encode(gzcompress(implode('', $path), 9));
	}

	public function regenerateIdentity($id)
	{
		$user = auth()->getProvider()->findById($id);

		$actionClass = service('settings')->get('Auth.actions')['register'];

		$action = Factories::actions($actionClass);

		$identityModel = model(UserIdentityModel::class);

		$identityModel->deleteIdentitiesByType($user, TOTP::ID_TYPE_TOTP_2FA);

		$action->createIdentity($user);

		$user->deactivate();
	}
}