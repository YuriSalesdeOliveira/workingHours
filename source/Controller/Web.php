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

        $users = $this->user->is_admin ? User::find() : User::find(['id' => $this->user->id]);

        $this->view->load('users', [
            'page' => 'Usuários',
            'users' => $users
        ])
            ->render();
    }

    public function report($data): void
    {
        $this->restrict();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $reports = isset($data['user']) ?
        WorkingHours::find(['user' => $data['user'], 'sql_raw' => "work_date > '2021-12-1'"]) :
        WorkingHours::find(['sql_raw' => "work_date > '2021-12-1'"]);

        $this->view->load('report', [
            'page' => 'Relatório',
            'reports' => $reports
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