<?php


namespace Source\Controller;


use Source\Model\User;
use Source\Model\WorkingHours;
use DateTime;

class Web extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);

        $this->view->layout('theme/layout')
            ->addData(['date' => new DateTime()])
            ->addData(['user' => $this->user]);
    }

    public function home(): void
    {
        $this->restrict();

        $working_hours = WorkingHours::workingHours($this->user->id, date('Y-m-d'));

        $this->view->load('home', [
            'page' => 'Home',
            'working_hours' => $working_hours
        ])
            ->render();
    }

    public function users(): void
    {
        $this->restrict();

        $this->view->load('users', [
            'page' => 'Usuários',
            'users' => User::find()
        ])
            ->render();
    }

    public function report(): void
    {
        $this->restrict();

        $this->view->load('report', [
            'page' => 'Relatório'
        ])
            ->render();
    }

    public function login(): void
    {
        $this->view->layout(null);

        $this->view->load('login')
            ->render();
    }

    public function register(): void
    {
        $this->restrict();

        $this->view->load('register', [
            'page' => 'Registrar'
        ])
            ->render();
    }

    public function error($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (!$this->user) {

            $this->view->layout(null);
        }

        $this->view->load('error', $data)
            ->render();
    }

    private function restrict(): void
    {
        if (!$this->user) {

            $this->router->redirect('web.login');
        }
    }
}