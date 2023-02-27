<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= lang('Halberd.title2FA') ?></title>
</head>

<body>
    <h1 class="card-title mb-5"><?= lang('Halberd.title2FA') ?></h1>

<?php if (session('error')) : ?>
    <p><?= session('error') ?></p>
<?php endif ?>

    <?= $this->renderSection('main') ?>
    
    <form action="<?= url_to('auth-action-verify') ?>" method="post">
        <?= csrf_field() ?>
        <input type="number" name="token" placeholder="000000" inputmode="numeric" pattern="[0-9]*" required />
        <button type="submit"><?= lang('Auth.confirm') ?></button>
    </form>
</body>
</html>