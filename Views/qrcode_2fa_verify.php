<?= $this->extend(config('Auth')->views['qrcode_layout']) ?>

<?= $this->section('main') ?>

            <p><?= lang('QRAuth.qrcodeConfirmCode') ?></p>

<?= $this->endSection() ?>
