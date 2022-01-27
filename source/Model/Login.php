<?php


namespace Source\Model;


use Source\Exception\AppException;

class Login extends Model
{
    private function validation(): void
    {
        $validation = new Validation($this->attributes);

        $validation->min(['password' => 8]);

        $validation->isEmail(['email']);

        $validation->require();

        $validation->throwErrors();
    }

    public function login(): User
    {
        $this->validation();

        $user = User::find(['email' => $this->email]);

        if ($user) {
            if (password_verify($this->password, $user->password)) {

                if ($user->is_active)
                {
                    return $user;
                }

                throw new AppException('Esse usuário está desligado.');
            }
        }

        throw  new AppException('Verifique seu E-MAIL/SENHA.');
    }

}