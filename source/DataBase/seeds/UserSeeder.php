<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'first_name' => 'Yuri',
                'last_name' => 'Oliveira',
                'email' => 'yuri_oli@hotmail.com',
                'password' => password_hash('nomedamamae', PASSWORD_DEFAULT),
                'is_admin' => 1
            ],
            [
                'id' => 2,
                'first_name' => 'Anthony',
                'last_name' => 'Stark',  
                'email' => 'homendeferro@hotmail.com',
                'password' => password_hash('nomedamamae', PASSWORD_DEFAULT),
            ],
            [
                'id' => 3,
                'first_name' => 'Steven',
                'last_name' => 'Rogers',  
                'email' => 'cap@hotmail.com',
                'password' => password_hash('nomedamamae', PASSWORD_DEFAULT),
                'is_admin' => 1
            ],
            [
                'id' => 4,
                'first_name' => 'Gabi',
                'last_name' => 'Gol',
                'email' => 'flamengo@hotmail.com',
                'password' => password_hash('nomedamamae', PASSWORD_DEFAULT),
                'is_active' => 0
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)->saveData();
    }
}
