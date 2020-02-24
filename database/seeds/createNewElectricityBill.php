<?php

use App\newElectricityBill;
use Illuminate\Database\Seeder;

class createNewElectricityBill extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        newElectricityBill::create([
            'hour_number' => 'Flight 10',
            'course_number' => 'Flight 10',
            'name' => 'Flight 10',
            'relase_date' => 'Flight 10',
            'next_relase_date' => 'Flight 10',
            'power' => 'Flight 10',
            'previous_visa' => 'Flight 10',
            'current_visa' => 'Flight 10',
            'amount_of_consumption' => 'Flight 10',
            'amount_due_of_payment' => 'Flight 10',
            'city' => 'Flight 10',
            'area' => 'Flight 10',
            'street' => 'Flight 10',
        ]);
    }
}
