<?php

namespace Source\Controller;

use DateInterval;
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

        $balanceOperator = $sum_of_worked_time > $monthly_time ? '+' : '-';
        
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