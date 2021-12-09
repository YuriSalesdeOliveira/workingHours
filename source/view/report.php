<table>

    <th>
        <td>Ponto 01</td>
        <td>Ponto 02</td>
        <td>Ponto 03</td>
        <td>Ponto 04</td>
        <td>Data</td>
        <td>Horas trabalhadas</td>
    </th>

    <?php if (is_object($reports)): ?>

        <tr>
            <td><?= $reports->time1 ?></td>
            <td><?= $reports->time2 ?></td>
            <td><?= $reports->time3 ?></td>
            <td><?= $reports->time4 ?></td>
            <td><?= (new DateTime($reports->work_date))->format('d-m-Y') ?></td>
            <td><?= (new DateTime($reports->worked_time))->format('H:i:s') ?></td>
        </tr>

    <?php else:

        foreach ($reports as $report): ?>

            <tr>
                <td><?= $report->time1 ?></td>
                <td><?= $report->time2 ?></td>
                <td><?= $report->time3 ?></td>
                <td><?= $report->time4 ?></td>
                <td><?= (new DateTime($report->work_date))->format('d-m-Y') ?></td>
                <td><?= $report->worked_time ?></td>
            </tr>

        <?php endforeach;

    endif ?>

</table>