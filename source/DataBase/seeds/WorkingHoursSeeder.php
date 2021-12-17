<?php


use Phinx\Seed\AbstractSeed;

class WorkingHoursSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'UserSeeder'
        ];
    }

    public function run()
    {
        $dataUser01 = generateWorkingHours('1', '2021-10-01', 50, 40, 10);
        $dataUser02 = generateWorkingHours('2', '2021-10-01', 20, 20, 60);
        $dataUser03 = generateWorkingHours('3', '2021-10-01', 50, 50, 0);

        $data = array_merge($dataUser01, $dataUser02, $dataUser03);

        $working_hours = $this->table('working_hours');
        $working_hours->insert($data)->saveData();
    }
}
