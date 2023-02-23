<?= $this->extend(config('Halberd')->views['layout']) ?>

<?= $this->section('main') ?>

            <p><?= lang('Auth.confirmCode') ?></p>

<?= $this->endSection() ?>
