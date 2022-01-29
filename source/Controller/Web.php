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

    public function update($data): void
    {
        $this->restrict();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $logged_user = $data['user'] == $this->user->id ? true : false;

        if (!$logged_user && !$this->user->is_admin)
        {
            $this->router->redirect('web.home');
        }

        $user_update = User::find(['id' => $data['user']]);

        if (!$user_update) { $this->router->redirect('web.home'); }

        if (!$user_update->is_active && !checkMessage('update'))
        {
            setMessage(['update' => 'Usuário Desligado.'], 'warning');
        }

        $this->view->load('update', [
            'page' => 'Usuários',
            'user_update' => $user_update,
        ])
            ->render();
    }

    public function report($data): void
    {
        $this->restrict();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $users = $this->user->is_admin ? User::find() : $this->user;

        $currentDate = new DateTime();

        $selected_user = isset($data['user']) ? $data['user'] : $this->user->id;
        $selected_month = isset($data['month']) ? $data['month'] : $currentDate->format('m');
        $selected_year = isset($data['year']) ? $data['year'] : $currentDate->format('Y');

        $period = "{$selected_year}-{$selected_month}-1";

        if ($this->user->is_admin)
            $report = WorkingHours::getMonthlyReport($selected_user, $period);
        else
            $report = WorkingHours::getMonthlyReport($this->user->id, $period);

        $months = getPreviousMonthsThatDate(new DateTime());

        $years = getPreviousFiveYearsThatDate(new DateTime());

        $sum_of_worked_time = 0;

        foreach ($report as $working_hours) {

            $worked_time = $working_hours->worked_time;

            $sum_of_worked_time += $worked_time;
        }

        // Posso disponibilizar para o usuário selecionar
        $monthly_time = DAILY_TIME * 22;

        $balance = $sum_of_worked_time - $monthly_time;

        $balanceOperator = $sum_of_worked_time >= $monthly_time ? '+' : '-';
        
        $this->view->load('report', [
            'page' => 'Relatório',
            'users' => $users,
            'report' => $report,
            'months' => $months,
            'years' => $years,
            'selected_user' => $selected_user,
            'selected_month' => $selected_month,
            'selected_year' => $selected_year,
            'sum_of_worked_time' => $sum_of_worked_time,
            'balance' => $balance,
            'balanceOperator' => $balanceOperator
        ])
            ->render();
    }

    public function managerReport($data): void
    {
        $this->restrict(admin: true);

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $activeUsers = User::getActiveUsers();
        $activeUsersCount = count($activeUsers);
        $inactiveUsers = User::getInactiveUsers();
        $inactiveUsersCount = count($inactiveUsers);
        $absentUsers = WorkingHours::getAbsentUsers();
        $absentUsersCount = count($absentUsers);

        $currentDate = new DateTime();
        $selected_month = isset($data['month']) ? $data['month'] : $currentDate->format('m');
        $selected_year = isset($data['year']) ? $data['year'] : $currentDate->format('Y');

        $period = "{$selected_year}-{$selected_month}-1";

        $sum_of_worked_time_in_month = WorkingHours::getWorkedTimeInMonth($period);


        $this->view->load('managerReport', [
            'page' => 'Relatório Gerencial',
            'activeUsers' => $activeUsers,
            'activeUsersCount' => $activeUsersCount,
            'inactiveUsers' => $inactiveUsers,
            'inactiveUsersCount' => $inactiveUsersCount,
            'absentUsers' => $absentUsers,
            'absentUsersCount' => $absentUsersCount,
            'selected_month' => $selected_month,
            'selected_year' => $selected_year,
            'sum_of_worked_time_in_month' => $sum_of_worked_time_in_month
        ])
            ->render();
    }

    public function profile(): void
    {
        $this->restrict();

        $this->view->load('profile', [
            'page' => 'Perfil'
        ])
            ->render();
    }

    public function changePassword($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $logged_user = $data['user'] == $this->user->id ? true : false;

        if (!$logged_user && !$this->user->is_admin)
        {
            $this->router->redirect('web.home');
        }

        $this->view->load('changePassword', [
            'page' => 'Mudar Senha',
            'user_changePassword' => $data['user'],
            'logged_user' => $logged_user
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
        $this->restrict(admin: true);

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

    private function restrict($admin = false): void
    {
        if (!$this->user || !$this->user->is_active) {

            $this->router->redirect('web.login');
        }

        if ($admin && !$this->user->is_admin) {

            $this->router->redirect('web.home');
        }
    }
}