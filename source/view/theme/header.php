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

        <a class="main_header_session_logout" href="<?= url('logout') ?>">Sair</a>

    </div>

</div>

<nav class="main_header_nav">

    <a title="inicio" href="<?= url('home') ?>" class="main_header_nav_item">Home</a>
    <a title="relatório" href="<?= url('relatorio') ?>" class="main_header_nav_item">Relatório</a>

</nav>