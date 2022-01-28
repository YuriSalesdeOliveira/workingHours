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

            setMessage($e->getErrors(), 'error field');

        } catch (AppException $e) {

            setMessage(['login' => $e->getMessage()]);

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
            if (!empty($data['password']))
            {
                $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            if ($this->user->is_admin && isset($data['is_admin'])) { $user->is_admin = 1; }

            $user->save();

            setMessage(['register' => 'Usuário cadastrado.'], 'success');

            $this->router->redirect('web.register');

        } catch (ValidationException $e) {

            setMessage($e->getErrors(), 'error field');

        } catch (AppException $e) {

            setMessage(['register' => $e->getMessage()]);

        } finally {

            $this->router->redirect('web.register');
        }
    }

    public function update($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        try {
            
            if (isset($data['id']) && !$this->user->is_admin)
            {
                $this->router->redirect('web.home');
            }

            $id = isset($data['id']) ? $data['id'] : $this->user->id;

            $user = User::find(['id' => $id]);
            
            if ($user)
            {
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->email = $data['email'];
                
                $user->save();
                
                setMessage(['update' => 'Usuário atualizado.'], 'success');

                $this->router->redirect('web.update', ['user' => $id]);
            }

            throw new AppException('Não foi possivel editar esse usuário.');

        } catch (ValidationException $e) {

            setMessage($e->getErrors(), 'error field');

        } catch (AppException $e) {

            setMessage(['update' => $e->getMessage()]);

        } finally {

            $this->router->redirect('web.update', ['user' => $id]);
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

            if ($data['user'] != $this->user->id && !$this->user->is_admin)
            {
                $this->router->redirect('web.home');
            }

            $user = User::find(['id' => $data['user']]);

            if ($user)
            {
                if (!password_verify($data['password'], $this->user->password))
                {
                    throw new AppException('A senha informada não está correta.');
                }
                
                $user->password = password_hash($data['new_password'], PASSWORD_DEFAULT);

                $user->save();

                setMessage(['changePassword' => 'Senha atualizada.'], 'success');

                $this->router->redirect('web.changePassword', ['user' => $data['user']]);
            }

            throw new AppException('Não foi possivel alterar a senha');

        } catch (ValidationException $e) {

            setMessage($e->getErrors(), 'error field');

        } catch (AppException $e) {

            setMessage(['changePassword' => $e->getMessage()]);

        } finally {

            $this->router->redirect('web.changePassword', ['user' => $data['user']]);
        }
    }

    public function toggleAdmin($data)
    {
        $data =  filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        try 
        {
            if (!isset($data['user']) || !$this->user->is_admin)
            {
                throw new AppException('Não foi possivel tornar esse usuário um admin.');
            }

            if ($data['user'] == $this->user->id)
            {
                throw new AppException('Essa ação não é permitida.');
            }

            $user = User::find(['id' => $data['user']]);

            if ($user)
            {
                $is_admin = $user->is_admin;

                $user->is_admin = $is_admin ? 0 : 1;

                $user->save();

                $is_admin_string = $user->is_admin ? 'é' : 'não é';

                setMessage(
                    ['toggle_admin' => "O usuário {$user->first_name} {$is_admin_string} um admin"]
                    , 'success'
                );

                $this->router->redirect('web.update', ['user' => $data['user']]);
            }

            throw new AppException('Não foi possivel tornar esse usuário um admin.');

        } catch (AppException $e)
        {
            setMessage(['toggle_admin' => $e->getMessage()]);

        } finally
        {
            $this->router->redirect('web.update', ['user' => $data['user']]);
        }
    }

    public function toggleActive($data)
    {
        $data =  filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        try 
        {
            if (!isset($data['user']) || !$this->user->is_admin)
            {
                throw new AppException('Não foi possivel ativar esse usuário.');
            }

            if ($data['user'] == $this->user->id)
            {
                throw new AppException('Essa ação não é permitida.');
            }

            $user = User::find(['id' => $data['user']]);

            if ($user)
            {
                $is_active = $user->is_active;

                $user->is_active = $is_active ? 0 : 1;

                $user->save();

                $is_active_string = $user->is_active ? 'ativo' : 'desligado';

                setMessage(
                    ['toggle_active' => "O usuário {$user->first_name} está {$is_active_string}"],
                    'success'
                );

                $this->router->redirect('web.update', ['user' => $data['user']]);
            }

            throw new AppException('Não foi possivel ativar esse usuário.');

        } catch (AppException $e)
        {
            setMessage(['toggle_active' => $e->getMessage()]);

        } finally
        {
            $this->router->redirect('web.update', ['user' => $data['user']]);
        }
    }
}