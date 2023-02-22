<?= $this->extend(config('Auth')->views['qrcode_layout']) ?>

<?= $this->section('main') ?>

            <p><?= lang('QRAuth.qrcodeActivateBody') ?></p>

            <p><?= $qrcode ?></p>

<?= $this->endSection() ?>
