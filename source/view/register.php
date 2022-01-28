<form class="form width_35 centralize" action="<?= $router->route('auth.register') ?>" method="post">

    <?= getMessage('register'); ?>
        

    <label for="first_name">Primeiro Nome</label>
    <input class="input" type="text" name="first_name">

    <?= getMessage('first_name'); ?>

    <label for="last_name">Último Nome</label>
    <input class="input" type="text" name="last_name">

    <?= getMessage('last_name'); ?>

    <label for="email">E-mail</label>
    <input class="input" type="text" name="email">

    <?= getMessage('email'); ?>

    <label for="password">Senha</label>
    <input class="input" type="password" name="password">

    <?= getMessage('password'); ?>

    <?php if($user->is_admin): ?>
        
        <label for="is_admin">Admin</label>
        <input class="cursor_pointer" type="checkbox" name="is_admin">

        <?= getMessage('is_admin'); ?>
        
    <?php endif ?>
    

    <button class="button primary margin_top" type="submit">Cadastrar</button>

</form>