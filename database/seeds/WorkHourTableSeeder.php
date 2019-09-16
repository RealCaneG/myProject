<?php

use Illuminate\Database\Seeder;

class WorkHourTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\WorkHourType::create([
            'office_in_time' => new DateTime('2019-07-01 08:30:00'),
            'office_out_time' => new DateTime('2019-07-01 17:30:00'),
        ]);

        App\WorkHourType::create([
            'office_in_time' => new DateTime('2019-07-01 09:30:00'),
            'office_out_time' => new DateTime('2019-07-01 18:30:00'),
        ]);
    }
}
