<?= $this->extend(config('Halberd')->views['layout']) ?>

<?= $this->section('main') ?>

            <p><?= lang('Auth.googleApp') ?></p>

            <p><?= $qrcode ?></p>

<?= $this->endSection() ?>
