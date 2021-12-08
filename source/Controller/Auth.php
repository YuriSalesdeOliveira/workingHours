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

            $user->save();

            $this->router->redirect('web.home');

        } catch (ValidationException $e) {

            setMessage($e->getErrors());

        } catch (AppException $e) {

            setMessage(['login_error' => $e->getMessage()]);

        } finally {

            $this->router->redirect('web.register');
        }
    }
}