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

    public static function getActiveUsers()
    {
        return static::fetch(['is_active' => '1']);
    }

    public static function getInactiveUsers()
    {
        return static::fetch(['is_active' => '0']);
    }

    private function validation(): void
    {
        $attributes = $this->attributes;

        unset($attributes['created_at']);
        unset($attributes['updated_at']);

        $validation = new Validation($attributes);

        if (empty($this->{static::$columns['primary']})) $validation->unique(['email' => User::class]);
        
        $validation->isEmail(['email']);

        $validation->min(['password' => 8]);

        $validation->require();

        $validation->throwErrors();
    }

    public function save(): bool
    {
        $this->validation();

        return parent::save();
    }
}