<?php

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

use PragmaRX\Google2FA\Google2FA;

if(!function_exists('qrcode'))
{
	function qrcode($issuer, $accountname, $secret)
	{
		$writer = new Writer(new ImageRenderer(
			new RendererStyle(120),
			new SvgImageBackEnd()
		));

		$google2fa = new Google2FA();

		$svg = $writer->writeString($google2fa->getQRCodeUrl($issuer, $accountname, $secret));

		return preg_replace('/<svg/', '<svg style="width: 100%; height: 300px"', $svg);
	}
}