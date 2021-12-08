<?php


namespace Source\Controller;


use Source\Model\WorkingHours;

class App extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);
    }

    public function toClockIn($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $working_hours = WorkingHours::workingHours($this->user->id, date('Y-m-d'));

        $current_time = date('H:i:s');

        if (isset($data['forced_to_clock_in'])) {

            $current_time = $data['forced_to_clock_in'];
        }

        $working_hours->toClockIn($current_time);

        $this->router->redirect('web.home');
    }

    public function logout(): void
    {
        unset($_SESSION['user']);

        $this->router->redirect('web.login');
    }
}