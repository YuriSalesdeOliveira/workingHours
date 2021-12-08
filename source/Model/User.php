<?php

namespace Source\Model;

class User extends Model
{
    protected static $entity = 'users';
    protected static $columns = [
        'primary' => 'id',
        'require' => ['first_name', 'last_name', 'email', 'password'],
        'timestamp' => true
    ];

    private function validation(): void
    {
        $validation = new Validation($this->attributes);

        if (empty($this->{static::$columns['primary']})) $validation->unique(['email' => User::class]);
        
        $validation->isEmail(['email']);

        $validation->min(['password' => 8]);

        $validation->require();

        $validation->throwErrors();
    }

    public function save(): bool
    {
        $this->validation();

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save();// VER SE QUER TRATAR A EXCEPTION AQUI OU MOSTAR PRO USUÁRIO
    }
}