<?php


namespace Source\Controller;

use Exception;
use Source\Exception\AppException;
use Source\Exception\ValidationException;
use Source\Model\Login;
use Source\Model\User;

class Auth extends Controller
{
    public function login($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (isset($data['email']) && isset($data['password'])) {

            try {

                $login = new Login([
                    'email' => $data['email'],
                    'password' => $data['password']
                ]);

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
    }

    public function register($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if ($data['first_name'] &&
            $data['last_name'] &&
            $data['email'] &&
            $data['password']) {

            try {

                $user = new User();

                $user->save();

                $data['_POST'] = [];

                $this->router->redirect('web.home');

            } catch (Exception $e) {


            }

        }
    }
}