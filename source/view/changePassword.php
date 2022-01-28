<form class="form width_35 centralize margin_top"
    action="<?= $router->route('auth.changePassword', ['user' => $user_changePassword]) ?>"
    method="post">

    <?= getMessage('changePassword'); ?>

    <label for="password">
        <?= $logged_user ? 'Senha Antiga' : 'Sua senha' ?>
    </label>
    <input class="input" type="text" name="password">

    <label for="new_password">
        <?= $logged_user ? 'Senha Nova' : 'Senha Nova do Usuário' ?>
    </label>
    <input class="input" type="text" name="new_password">

    <?= getMessage('password') ?>

    <button class="button primary margin_top" type="submit">Enviar</button>

</form>