<?php

use App\newTelecomeBill;
use Illuminate\Database\Seeder;

class createNewTelecomeBill extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        newTelecomeBill::create([
            'phone_number' => 'Flight 10',
            'course_number' => 'Flight 10',
            'name' => 'Flight 10',
            'relase_date' => 'Flight 10',
            'next_relase_date' => 'Flight 10',
            'local_calls' => 'Flight 10',
            'international_calls' => 'Flight 10',
            'servise_adsl' => 'Flight 10',
            'amount_due_of_payment' => 'Flight 10',
            'city' => 'Flight 10',
            'area' => 'Flight 10',
            'street' => 'Flight 10',
        ]);
    }
}
