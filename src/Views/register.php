<?= $this->extend(config('Halberd')->views['layout']) ?>

<?= $this->section('main') ?>

            <p><?= lang('Auth.register') ?></p>

            <p><?= $qrcode ?></p>

<?= $this->endSection() ?>
