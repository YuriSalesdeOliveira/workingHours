<div class="flex_row_space-between">
    <div class="flex_right">
        <a href="<?= $router->route('auth.toggleAdmin', ['user' => $user_update->id]) ?>"   
            class="button <?= $user_update->is_admin ? 'primary' : 'trasnparent' ?> large">Admin</a>
        <a href="<?= $router->route('auth.toggleActive', ['user' => $user_update->id]) ?>"
            class="button <?= $user_update->is_active ? 'primary' : 'trasnparent' ?> large margin_left_5">Ativo</a>
    </div>

    <div class="flex_right">
        <a href="<?= $router->route('web.changePassword', ['user' => $user_update->id]) ?>"
        class="button trasnparent large margin_right_5">Trocar Senha</a>
    </div>
</div>

<form class="form width_35 centralize margin_top margin_bottom"
    action="<?= $router->route('auth.update') ?>" method="post">

    <?= getMessage('update'); ?>

    <?= getMessage('toggle_admin'); ?>
    <?= getMessage('toggle_active'); ?>

    <input type="hidden" name="id" value="<?= $user_update->id ?>">

    <label for="first_name">Nome</label>
    <input class="input" type="text" name="first_name" value="<?= $user_update->first_name ?>">

    <?= getMessage('first_name'); ?>

    <label for="last_name">Sobrenome</label>
    <input class="input" type="text" name="last_name" value="<?= $user_update->last_name ?>">

    <?= getMessage('last_name'); ?>

    <label for="email">E-mail</label>
    <input class="input" type="text" name="email" value="<?= $user_update->email ?>">

    <?= getMessage('email'); ?>

    <button class="button primary margin_top" type="submit">Enviar</button>

</form>