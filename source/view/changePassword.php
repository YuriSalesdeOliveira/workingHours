<form class="form width_35 centralize margin_top" action="<?= $router->route('auth.changePassword') ?>" method="post">

    <?= getMessage('changePassword_success'); ?>
    <?= getMessage('changePassword_error'); ?>

    <label for="password">Senha Antiga</label>
    <input class="input" type="text" name="password">

    <label for="new_password">Senha Nova</label>
    <input class="input" type="text" name="new_password">

    <?= getMessage('password') ?>

    <button class="button primary margin_top" type="submit">Enviar</button>

</form>