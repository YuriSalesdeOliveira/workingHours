<form class="form width_35 centralize" action="<?= $router->route('auth.update') ?>" method="post">

    <?= getMessage('update_success'); ?>
    <?= getMessage('update_error'); ?>

    <label for="first_name">Nome</label>
    <input class="input" type="text" name="first_name" value="<?= $user->first_name ?>">

    <?= getMessage('first_name'); ?>

    <label for="last_name">Sobrenome</label>
    <input class="input" type="text" name="last_name" value="<?= $user->last_name ?>">

    <?= getMessage('last_name'); ?>

    <label for="email">E-mail</label>
    <input class="input" type="text" name="email" value="<?= $user->email ?>">

    <?= getMessage('email'); ?>

    <button class="button primary margin_top" type="submit">Enviar</button>

</form>