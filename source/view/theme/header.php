<div class="flex_row_space-between">

    <div class="main_header_logo">

        <h1>Working Hours</h1>

    </div>

    <div class="main_header_session">

        <div class="main_header_session_name">

            <?php if (isset($user)):

                echo 'Usuario: ' . $user->first_name . ' ' . $user->last_name;

            endif ?>

        </div>

        <a class="main_header_session_logout" href="<?= $router->route('app.logout') ?>">Sair</a>

    </div>

</div>

<nav class="main_header_nav">

    <a title="inicio" href="<?= $router->route('web.home') ?>" class="main_header_nav_item">Home</a>
    <a title="relatório" href="<?= $router->route('web.report') ?>" class="main_header_nav_item">Relatório</a>

</nav>