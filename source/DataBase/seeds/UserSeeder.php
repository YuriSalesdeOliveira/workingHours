<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'first_name' => 'Yuri',
                'last_name' => 'Oliveira',  
                'email' => 'yuri_oli@hotmail.com',
                'password' => password_hash('nomedamamae', PASSWORD_DEFAULT),
                'is_admin' => 1
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)->saveData();
    }
}
