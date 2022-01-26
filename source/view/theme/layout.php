<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= asset('css/font.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/color.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/button.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/form.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/message.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <title>Working Hours - <?= $page ?></title>
</head>
<body>

    <header class="main_header centralize">

        <?php $v->view('theme/header'); ?>

    </header>

    <main class="main_content centralize">

        <?php $v->view(); ?>

    </main>

    <footer class="main_footer">

        <?php $v->view('theme/footer'); ?>

    </footer>
    <?php $v->getScripts(); ?>
</body>
</html>