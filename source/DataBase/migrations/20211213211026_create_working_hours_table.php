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
        ->addColumn('time1', 'time')
        ->addColumn('time2', 'time')
        ->addColumn('time3', 'time')
        ->addColumn('time4', 'time')
        ->addColumn('worked_time', 'integer')
        ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
        ->addColumn('updated_at', 'timestamp', ['null' => true])
        ->addForeignKey('user', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
        ->create();
    }
}
