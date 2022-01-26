<div class="margin_top">

    <h3>Usuários ativos (<?= $activeUsersCount ?>):</h3>
    <?php foreach($activeUsers as $user): ?>
    <div>
        <span>nome: <?= $user->first_name ?></span> |
        <span>sobrenome: <?= $user->last_name ?></span> |
        <span>admin: <?= $user->is_admin ?></span>
    </div>
    <?php endforeach; ?>

</div>

<div>

    <h3>Usuários ausentes (<?= $absentUsersCount ?>):</h3>
    <?php foreach($absentUsers as $user): ?>
    <div>
        <span>nome: <?= $user->first_name ?></span> |
        <span>sobrenome: <?= $user->last_name ?></span> |
        <span>admin: <?= $user->is_admin ?></span>
    </div>
    <?php endforeach; ?>

</div>

<div>
    <h3>Horas trabalhadas no mês:</h3>
    <div><?= secondsAsStringTime($sum_of_worked_time_in_month); ?></div>
</div>
