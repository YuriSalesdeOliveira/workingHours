<table>

    <tr>
        <th>Usuário</th>
        <th>Ponto 01</th>
        <th>Ponto 02</th>
        <th>Ponto 03</th>
        <th>Ponto 04</th>
        <th>Data</th>
        <th>Horas trabalhadas</th>
    </tr>

    <?php if (is_object($reports)): ?>

        <tr data-tr_href="<?= $router->route('web.report.user', ['user' => $reports->user()->id]); ?>">
            <td><?= $reports->user()->first_name . ' ' . $reports->user()->last_name; ?></td>
            <td><?= $reports->time1; ?></td>
            <td><?= $reports->time2; ?></td>
            <td><?= $reports->time3; ?></td>
            <td><?= $reports->time4; ?></td>
            <td><?= (new DateTime($reports->work_date))->format('d-m-Y'); ?></td>
            <td><?= (new DateTime($reports->worked_time))->format('H:i:s'); ?></td>
        </tr>

    <?php else:

        foreach ($reports as $report): ?>

            <tr data-tr_href="<?= $router->route('web.report.user', ['user' => $report->user()->id]); ?>">
                <td><?= $report->user()->first_name . ' ' . $report->user()->last_name; ?></td>
                <td><?= $report->time1; ?></td>
                <td><?= $report->time2; ?></td>
                <td><?= $report->time3; ?></td>
                <td><?= $report->time4; ?></td>
                <td><?= (new DateTime($report->work_date))->format('d-m-Y'); ?></td>
                <td><?= (new DateTime($report->worked_time))->format('H:i:s'); ?></td>
            </tr>

        <?php endforeach;

    endif ?>

</table>

<?php $v->addScripts(['tr_href' => asset('js/tr_href.js')]); ?>