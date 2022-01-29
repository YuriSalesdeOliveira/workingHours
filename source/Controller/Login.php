<?php

namespace Source\Controller;

use DateTime;
use Source\Exception\AppException;
use Source\Model\Login as ModelLogin;
use Source\Exception\ValidationException;

class Login extends Controller
{
    public function login(): void
    {
        $this->view->load('login', [
            'date' => new DateTime()
        ])
            ->render();
    }

    public function attempt($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        try {

            $login = new ModelLogin();

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

            $this->router->redirect('login.login');
        }
    }

    public function logout(): void
    {
        $this->restrict();

        unset($_SESSION['user']);

        $this->router->redirect('login.login');
    }
}