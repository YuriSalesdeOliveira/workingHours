<div class="flex_right">
    <a href="<?= $router->route('web.register') ?>" class="button trasnparent large margin_right_5">Cadastrar</a>
</div>

<div class="flex_left">
    
</div>

<div class="width_35 margin_top">

    <h3>Ativos (<?= $activeUsersCount ?>):</h3>

    <table class="margin_top">

        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Admin</th>
        </tr>

        <?php foreach ($activeUsers as $user): ?>

            <tr data-tr_href="<?= $router->route('web.update', ['user' => $user->id]); ?>">
                <td><?= $user->first_name ?></td>
                <td><?= $user->last_name ?></td>
                <td><?= $user->is_admin ? 'Sim' : 'Não' ?></td>
            </tr>

        <?php endforeach ?>

    </table>

</div>


<div class="width_35 margin_top">

    <h3>Desligados (<?= $inactiveUsersCount ?>):</h3>

    <table class="margin_top">

        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Admin</th>
        </tr>

        <?php foreach ($inactiveUsers as $user): ?>

            <tr data-tr_href="<?= $router->route('web.update', ['user' => $user->id]); ?>">
                <td><?= $user->first_name ?></td>
                <td><?= $user->last_name ?></td>
                <td><?= $user->is_admin ? 'Sim' : 'Não' ?></td>
            </tr>

        <?php endforeach ?>

    </table>

</div>


<div class="width_35 margin_top">

    <h3>Faltaram Hoje (<?= $absentUsersCount ?>):</h3>

    <table class="margin_top">

        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Admin</th>
        </tr>

        <?php foreach ($absentUsers as $user): ?>

            <tr data-tr_href="<?= $router->route('web.update', ['user' => $user->id]); ?>">
                <td><?= $user->first_name ?></td>
                <td><?= $user->last_name ?></td>
                <td><?= $user->is_admin ? 'Sim' : 'Não' ?></td>
            </tr>

        <?php endforeach ?>

    </table>

</div>

<div>
    <h3>Horas trabalhadas no mês:</h3>
    <div><?= secondsAsStringTime($sum_of_worked_time_in_month); ?></div>
</div>

<?php $v->addScripts(['tr_href' => asset('js/tr_href.js')]); ?>