<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('first_name', 'string', ['limit' => 200])
        ->addColumn('last_name', 'string', ['limit' => 200])
        ->addColumn('email', 'string', ['limit' => 200])
        ->addColumn('password', 'string', ['limit' => 200])
        ->addColumn('is_admin', 'boolean', ['default' => 0])
        ->addColumn('is_active', 'boolean', ['default' => 1])
        ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
        ->addColumn('updated_at', 'timestamp', ['null' => true])
        ->addIndex('email', ['unique' => true])
        ->create();
    }
}
