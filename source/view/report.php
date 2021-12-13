<div class="flex_right">
    <form action="<?php $router->route('web.report') ?>" method="post">

    <select name="user">

        <?php if (is_array($users)): ?>
            <?php foreach ($users as $user): ?>

                <option value="<?= $user->id ?>"
                    <?= $user->id == $selected_user ? 'selected' : null; ?>>
                    <?= $user->first_name . ' ' . $user->last_name ?></option>

            <?php endforeach; ?>
        <?php else: ?>

            <option value="<?= $users->id ?>"
                <?= $users->id == $selected_user ? 'selected' : null; ?>>
                <?= $users->first_name . ' ' . $users->last_name ?></option>

        <?php endif; ?>

    </select>

    <select name="month">
        <?php foreach ($months as $number => $month): ?>

            <option value="<?= $number ?>"
                <?= $number == $selected_month ? 'selected' : null; ?>><?= $month ?></option>

        <?php endforeach; ?>
    </select>

    <select name="year">
        <?php foreach ($years as $year): ?>

            <option value="<?= $year ?>"
                <?= $year == $selected_year ? 'selected' : null; ?>><?= $year ?></option>

        <?php endforeach; ?>
    </select>

    <button type="submit">buscar</button>

    </form>
</div>

<table class="margin_top margin_bottom">

    <tr>
        <th>Usuário</th>
        <th>Ponto 01</th>
        <th>Ponto 02</th>
        <th>Ponto 03</th>
        <th>Ponto 04</th>
        <th>Data</th>
        <th>Horas trabalhadas</th>
    </tr>

    <?php foreach ($report as $working_hours): ?>

            <tr data-tr_href="<?= $router->route('web.users', ['user' => $working_hours->user()->id]); ?>">
                <td><?= $working_hours->user()->first_name . ' ' . $working_hours->user()->last_name; ?></td>
                <td><?= $working_hours->time1; ?></td>
                <td><?= $working_hours->time2; ?></td>
                <td><?= $working_hours->time3; ?></td>
                <td><?= $working_hours->time4; ?></td>
                <td><?= (new DateTime($working_hours->work_date))->format('d-m-Y'); ?></td>
                <td><?= (new DateTime($working_hours->worked_time))->format('H:i:s'); ?></td>
            </tr>

    <?php endforeach ?>

</table>

<?php $v->addScripts(['tr_href' => asset('js/tr_href.js')]); ?>