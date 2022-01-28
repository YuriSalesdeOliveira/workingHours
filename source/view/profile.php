<div class="flex_right">
    <a href="<?= $router->route('web.changePassword', ['user' => $user->id]) ?>"
        class="button trasnparent large margin_right_5">Trocar Senha</a>
    <a href="<?= $router->route('app.logout') ?>" class="button trasnparent large">Sair</a>
</div>

<form class="form width_35 centralize margin_top margin_bottom" action="<?= $router->route('auth.update') ?>" method="post">

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