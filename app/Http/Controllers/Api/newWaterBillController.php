<?php

namespace App\Http\Controllers\Api;

use App\archivedWaterBill;
use App\Http\Controllers\Controller;
use App\newWaterBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class newWaterBillController extends Controller
{
    public function index(Request $request)
    {

        $newWaterBill = $request->searsh;
        $newWaterBill = ['newWaterBill' => $newWaterBill];
        $validae = Validator::make(
            $newWaterBill,
            ['newWaterBill' => 'exists:new_water_bills,counter_number']
        );
        if ($validae->fails()) {
            return response()->json([
                'data' => 'هذا الرقم غير موجود',
                'code' => '404'
            ]);
        }

        $newWaterBill = newWaterBill::find($newWaterBill);
        return response()->json([
            'data' => $newWaterBill,
            'code' => '200'
        ]);
    } // end index
    public function show($counter_number, $course_number)
    {

        $newWaterBill = newWaterBill::where('counter_number', $counter_number)
            ->where('course_number', $course_number)->get();
        if (empty($newWaterBill[0])) {
            return response()->json([
                'data' => 'data not found',
                'code' => '404',
            ]);
        }
        return response()->json([
            'data' => $newWaterBill[0],
            'code' => '200'
        ]);
    }
    public function destroy($counter_number, $course_number, $receipt_id, $user_id)
    {
        $newWaterBill = newWaterBill::where('counter_number', $counter_number)
            ->where('course_number', $course_number)->first();
        // $newWaterBill = $newWaterBill[0];
        // dd('$newWaterBill');
        archivedWaterBill::create([
            'counter_number' => $newWaterBill->counter_number,
            'course_number' => $newWaterBill->course_number,
            'name' => $newWaterBill->name,
            'relase_date' => $newWaterBill->relase_date,
            'next_relase_date' => $newWaterBill->next_relase_date,
            'local_calls' => $newWaterBill->local_calls,
            'international_calls' => $newWaterBill->international_calls,
            'servise_adsl' => $newWaterBill->servise_adsl,
            'amount_due_of_payment' => $newWaterBill->amount_due_of_payment,
            'city' => $newWaterBill->city,
            'area' => $newWaterBill->area,
            'street' => $newWaterBill->street,
            'payment_date' => now(),
            'receipt_id' => $receipt_id,
            'user_id' => $user_id,
        ]);
        DB::delete('delete from new_water_bills where counter_number = ? and course_number= ?', [$counter_number, $course_number]);
        return response()->json(true);
    }
}
