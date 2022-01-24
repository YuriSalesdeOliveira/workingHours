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
    <?php if($user->is_admin): ?>
        <a title="relatório" href="<?= $router->route('web.managerReport') ?>"
            class="main_header_nav_item">Relatório Gerencial</a>
    <?php endif ?>
    <a title="perfil" href="<?= $router->route('web.profile') ?>" class="main_header_nav_item">Perfil</a>

</nav>