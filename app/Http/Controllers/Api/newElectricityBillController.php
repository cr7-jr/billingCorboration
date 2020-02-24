<?php

namespace App\Http\Controllers\Api;

use App\archivedElectricityBill;
use App\Http\Controllers\Controller;
use App\newElectricityBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class newElectricityBillController extends Controller
{
    public function index(Request $request)
    {
        $newElectricityBill = $request->searsh;
        $newElectricityBill = ['newElectricityBill' => $newElectricityBill];
        $validae = Validator::make(
            $newElectricityBill,
            ['newElectricityBill' => 'exists:new_electricity_bills,hour_number']
        );
        if ($validae->fails()) {
            return response()->json([
                'data' => 'هذا الرقم غير موجود',
                'code' => '404'
            ]);
        }

        $newElectricityBill = newElectricityBill::find($newElectricityBill);
        return response()->json([
            'data' => $newElectricityBill,
            'code' => '200'
        ]);
    } // end index
    public function show($hour_number, $course_number)
    {

        $newElectricityBill = newElectricityBill::where('hour_number', $hour_number)
            ->where('course_number', $course_number)->get();
        if (empty($newElectricityBill[0])) {
            return response()->json([
                'data' => 'data not found',
                'code' => '404',
            ]);
        }
        return response()->json([
            'data' => $newElectricityBill[0],
            'code' => '200'
        ]);
    }
    public function destroy($hour_number, $course_number, $receipt_id, $user_id)
    {
        $newElectricityBill = newElectricityBill::where('hour_number', $hour_number)
            ->where('course_number', $course_number)->first();
        //$newElectricityBill = $newElectricityBill[0];

        archivedElectricityBill::create([
            'hour_number' => $newElectricityBill->hour_number,
            'course_number' => $newElectricityBill->course_number,
            'name' => $newElectricityBill->name,
            'relase_date' => $newElectricityBill->relase_date,
            'next_relase_date' => $newElectricityBill->next_relase_date,
            'local_calls' => $newElectricityBill->local_calls,
            'international_calls' => $newElectricityBill->international_calls,
            'servise_adsl' => $newElectricityBill->servise_adsl,
            'amount_due_of_payment' => $newElectricityBill->amount_due_of_payment,
            'city' => $newElectricityBill->city,
            'area' => $newElectricityBill->area,
            'street' => $newElectricityBill->street,
            'payment_date' => now(),
            'receipt_id' => $receipt_id,
            'user_id' => $user_id,
        ]);
        DB::delete('delete from new_electricity_bills where hour_number = ? and course_number= ?', [$hour_number, $course_number]);

        return response()->json(true);
    }
}
