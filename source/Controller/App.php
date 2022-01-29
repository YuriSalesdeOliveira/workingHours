<?php


namespace Source\Controller;

use Source\Exception\AppException;
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

        try
        {
            $current_time = date('H:i:s');

            $working_hours = WorkingHours::workingHours($this->user->id, date('Y-m-d'));

            if (isset($data['forced_to_clock_in']))
            {
                if (!$this->user->is_admin) { throw new AppException('Ponto não registrado.'); }

                $current_time = $data['forced_to_clock_in'];
            }

            $working_hours->toClockIn($current_time);
            
            setMessage(['to_clock_in' => 'Ponto registrado !'], 'success');

        } catch (AppException $e)
        {
            setMessage(['to_clock_in' => $e->getMessage()]);

        } finally
        {
            $this->router->redirect('web.home');
        }        
    }

    public function dataGenerator() {}

    public function logout(): void
    {
        unset($_SESSION['user']);

        $this->router->redirect('web.login');
    }
}