<table>

    <th>
        <td>Nome</td>
        <td>Sobrenome</td>
        <td>E-mail</td>
        <td>Ações</td>
    </th>

    <?php if (is_object($users)): ?>

        <tr>
            <td><?= $user->first_name ?></td>
            <td><?= $user->last_name ?></td>
            <td><?= $user->email ?></td>
        </tr>

    <?php else:

        foreach ($users as $user): ?>

            <tr>
                <td><?= $user->first_name ?></td>
                <td><?= $user->last_name ?></td>
                <td><?= $user->email ?></td>
            </tr>

        <?php endforeach;

    endif ?>

</table>