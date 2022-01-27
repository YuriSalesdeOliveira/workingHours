<?php


namespace Source\Controller;

use Source\Exception\AppException;
use Source\Exception\ValidationException;
use Source\Model\Login;
use Source\Model\User;

class Auth extends Controller
{
    public function login($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        try {

            $login = new Login();

            $login->email = $data['email'];
            $login->password = $data['password'];

            $user = $login->login();

            $_SESSION['user'] = $user->id;

            $this->router->redirect('web.home');

        } catch (ValidationException $e) {

            setMessage($e->getErrors());

        } catch (AppException $e) {

            setMessage(['login_error' => $e->getMessage()]);

        } finally {

            $this->router->redirect('web.login');
        }
    }

    public function register($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        try {

            $user = new User();

            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->password = $data['password'];

            if ($this->user->is_admin && isset($data['is_admin'])) { $user->is_admin = 1; }

            $user->save();

            setMessage(['register_success' => 'Usuário cadastrado.'], 'success');

            $this->router->redirect('web.register');

        } catch (ValidationException $e) {

            setMessage($e->getErrors());

        } catch (AppException $e) {

            setMessage(['register_error' => $e->getMessage()]);

        } finally {

            $this->router->redirect('web.register');
        }
    }

    public function update($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        try {

            $user = User::find(['id' => $this->user->id]);
            
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            
            $user->save();
            
            setMessage(['update_success' => 'Senha atualizada.'], 'success');

        } catch (ValidationException $e) {

            setMessage($e->getErrors());

        } catch (AppException $e) {

            setMessage(['update_error' => $e->getMessage()]);

        } finally {

            $this->router->redirect('web.profile');
        }
    }

    public function changePassword($data)
    {
        $data =  filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        try {

            if (empty($data['password']) || empty($data['new_password']))
            {
                throw new AppException('Informe a senha atual e a nova senha.');
            }

            $id = $this->user->id;

            $is_admin = $this->user->is_admin;

            if (isset($data['id']))
            {
                if (!$is_admin) { return; }

                $id = $data['id'];
            }

            $user = User::find(['id' => $id]);

            if ($user)
            {
                $password_protection = isset($data['id']) ? $this->user->password : $user->password;

                if (!password_verify($data['password'], $password_protection))
                {
                    throw new AppException('A senha informada não está correta.');
                }
                
                $user->password = $data['new_password'];

                $user->save();

                setMessage(['changePassword_success' => 'Senha atualizada.'], 'success');
            }

        } catch (ValidationException $e) {

            setMessage($e->getErrors());

        } catch (AppException $e) {

            setMessage(['changePassword_error' => $e->getMessage()]);

        } finally {

            $this->router->redirect('web.changePassword');
        }
    }
}