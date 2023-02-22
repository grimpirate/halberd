<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= lang('QRAuth.qrcode2FATitle') ?></title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94W>
</head>

<body class="bg-light">

    <main role="main" class="container">
        <div class="container d-flex justify-content-center p-5">
            <div class="card col-12 col-md-5 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-5"><?= lang('QRAuth.qrcode2FATitle') ?></h5>

                <?php if (session('error')) : ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif ?>

                    <?= $this->renderSection('main') ?>
                    
                    <form action="<?= url_to('auth-action-verify') ?>" method="post">
                        <?= csrf_field() ?>

                        <!-- Code -->
                        <div class="mb-2">
                            <input type="number" class="form-control" name="token" placeholder="000000" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" required />
                        </div>

                        <div class="d-grid col-8 mx-auto m-3">
                            <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.confirm') ?></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>