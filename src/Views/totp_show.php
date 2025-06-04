<?php
helper('html');
helper('form');
?>
<?= doctype() ?>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title><?= lang('TOTP.title2FA') ?></title>

    <?= link_tag(service('settings')->get('TOTP.stylesheet')) ?>
</head>

<body>
    <h1><?= lang('TOTP.title2FA') ?></h1>

<?php if (session('error')) : ?>
    <p><?= session('error') ?></p>
<?php endif ?>

<?php if(isset($qrcode)): ?>
    <p><?= lang('TOTP.googleApp') ?></p>

    <p><?= $qrcode ?></p>

    <p><?= lang('TOTP.problems', ['placeholder' => $secret]) ?></p>
<?php else: ?>
    <p><?= lang('TOTP.confirmCode') ?></p>
<?php endif ?>

    <?= form_open(url_to('auth-action-verify')) ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'token',
            'placeholder' => '000000',
            'inputmode' => 'numeric',
            'pattern' => '[0-9]{6}',
            'autocomplete' => 'one-time-code',
            'required' => true,
        ]) ?>
        <?= form_submit('', lang('Auth.confirm')) ?>
    <?= form_close() ?>
</body>
</html>
