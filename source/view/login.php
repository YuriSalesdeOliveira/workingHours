<!doctype html>
<html lang="pt0br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= asset('css/font.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/color.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/button.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/message.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/login.css') ?>">
    <title>Working Hours - Login</title>
</head>
<body>

    <main class="main_content">

        <header class="main_content_header">

        </header>

        <form action="<?= $router->route('login.attempt'); ?>" method="post">

            <?= getMessage('login'); ?>

            <div class="form_group">

                <label for="email">E-mail</label>
                <input type="text" name="email">

                <?= getMessage('email'); ?>

            </div>

            <div class="form_group">

                <label for="password">Senha</label>
                <input type="password" name="password">

                <?= getMessage('password'); ?>

            </div>

            <button class="button fa_1x primary">Entrar</button>

        </form>

        <footer class="main_content_footer">

            <span>www.workinghours.com &copy; <?= $date->format('Y') ?></span>

        </footer>

    </main>

</body>
</html>