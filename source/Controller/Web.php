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

    public function users($data): void
    {
        $this->restrict();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $user = User::find(['id' => $data['user']]);

        if (!$user) setMessage(['users' => 'Usuário não foi encontrado']);

        $this->view->load('users', [
            'page' => 'Usuários',
            'user' => $user
        ])
            ->render();
    }

    public function report($data): void
    {
        $this->restrict();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $date = isset($data['year']) && isset($data['month']) ?
        $data['year'] . '-' . $data['month'] :
        new DateTime();

        $users = $this->user->is_admin ? User::find() : $this->user;

        $selected_user = isset($data['user']) ? $data['user'] : $this->user->id;
        $selected_month = isset($data['month']) ? $data['month'] : '1';
        $selected_year = isset($data['year']) ? $data['year'] : $date->format('Y');
        
        if ($this->user->is_admin)
            $report = WorkingHours::getMonthlyReport($selected_user, $date);
        else
            $report = WorkingHours::getMonthlyReport($this->user->id, $date);

        $months = getPreviousMonthsThatDate(new DateTime());

        $years = getPreviousFiveYearsThatDate(new DateTime());

        $this->view->load('report', [
            'page' => 'Relatório',
            'users' => $users,
            'report' => $report,
            'months' => $months,
            'years' => $years,
            'selected_user' => $selected_user,
            'selected_month' => $selected_month,
            'selected_year' => $selected_year
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