<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateWorkingHoursTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('working_hours');
        $table->addColumn('user', 'integer')
        ->addColumn('work_date', 'date')
        ->addColumn('time1', 'time', ['null' => true])
        ->addColumn('time2', 'time', ['null' => true])
        ->addColumn('time3', 'time', ['null' => true])
        ->addColumn('time4', 'time', ['null' => true])
        ->addColumn('worked_time', 'integer')
        ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
        ->addColumn('updated_at', 'timestamp', ['null' => true])
        ->addForeignKey('user', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
        ->create();
    }
}
