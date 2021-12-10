
<?= getMessage('exceeded_to_clock_in') ?>

<div class="card margin_bottom">

    <div class="card_header">

        <i>

            <img src="<?= asset('image/icon/calendar.png') ?>">

        </i>

        <h2><?= strftime('%d de %B de %Y', $date->getTimestamp()) ?></h2>

    </div>

    <div class="card_body">

        <div class="card_group">

            <div class="timers">

                <div class="timers_item">

                    <div class="info">

                        <span>

                            Horas de trabalho

                        </span>

                        <span
                        <?= $working_hours->getActiveClock() === 'worked_time' ? 'active_clock' : null ?>>

                            <?= convertDateIntervalToDateTime($working_hours->workedHours())->format('H:i:s'); ?>

                        </span>

                    </div>

                </div>

                <div class="timers_item">

                    <div class="info">

                       <span>

                            Horas de almoço
                        </span>

                        <span
                        <?= $working_hours->getActiveClock() === 'break_and_exit' ? 'active_clock' : null ?>>

                             <?= convertDateIntervalToDateTime($working_hours->breakHours())->format('H:i:s'); ?>

                        </span>

                    </div>

                </div>

                <div class="timers_item">

                    <div class="info">

                        <span>

                            Hora de saída

                        </span>

                        <span
                        <?= $working_hours->getActiveClock() === 'exit_time' ||
                        $working_hours->getActiveClock() === 'break_and_exit' ?
                            'active_clock' : null ?>>

                             <?= $working_hours->exitTime()->format('H:i:s'); ?>

                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="card_group">

            <div class="to_clock_in">

                <div class="period">

                    <h3 class="margin_bottom">Primeiro Periodo</h3>

                    <div>

                        <span>Entrada: <?= isset($working_hours->time1) ? $working_hours->time1 : '---' ?></span>
                        <span>Saída: <?= isset($working_hours->time2) ? $working_hours->time2 : '---' ?></span>

                    </div>

                </div>

                <div class="period">

                    <h3 class="margin_bottom">Segundo Periodo</h3>

                    <div>

                        <span>Entrada: <?= isset($working_hours->time3) ? $working_hours->time3 : '---' ?></span>
                        <span>Saída: <?= isset($working_hours->time4) ? $working_hours->time4 : '---' ?></span>

                    </div>

                </div>

            </div>

        </div>

        <div class="card_group">

            <div class="actions">

                <a href="<?= url('toclockin') ?>" class="button primary">Bater Ponto</a>

                <?php if ('true'):

                    ?><a href="javascript:" class="button_modal button secondary">Bater Ponto Forçado</a>
                <?php

                endif ?>

            </div>

        </div>

    </div>

    <div class="card_footer"></div>

</div>

<div class="modal_container">
    <div class="modal">

        <div class="info">
            <h3>Informe o horario no formado 00:00:00</h3>
            <p>
                Antes de efetuar o batimento forçado é necessário ter
                em mente que isso deve ser feito por uma pessoa autorizada
                por isso se você está usando a conta de outra pessoa efetue
                o batimento apenas com o consentimento do mesmo.
            </p>
        </div>

        <form action="<?= url('toclockin') ?>" method="post">

            <input type="text" name="forced_to_clock_in" placeholder="00:00:00">

            <button class="button secondary">Bater Ponto Forçado</button>

        </form>

    </div>
</div>

<?php $v->addScripts([
    'modal' => asset('js/modal.js'),
    'active_clock' => asset('js/active_clock')
]); ?>
