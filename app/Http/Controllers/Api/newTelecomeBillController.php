<?php

namespace App\Http\Controllers\Api;

use App\archivedTelecomeBill;
use App\Http\Controllers\Controller;
use App\newTelecomeBill;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class newTelecomeBillController extends Controller
{
    public function index(Request $request)
    {
        $newTelecomeBill = $request->searsh;

        $newTelecomeBill = ['newTelecomeBill' => $newTelecomeBill];
        $validae = Validator::make(
            $newTelecomeBill,
            ['newTelecomeBill' => 'exists:new_telecome_bills,phone_number']
        );
        if ($validae->fails()) {
            return response()->json([
                'data' => 'هذا الرقم غير موجود',
                'code' => '404'
            ]);
        }
        $newTelecomeBill = newTelecomeBill::find($newTelecomeBill);
        return response()->json([
            'data' => $newTelecomeBill,
            'code' => '200'
        ]);
    } // end index
    public function show($phone_number, $course_number)
    {
        $newTelecomeBill = newTelecomeBill::where('phone_number', $phone_number)
            ->where('course_number', $course_number)->get();
        if (empty($newTelecomeBill[0])) {
            return response()->json([
                'data' => 'data not found',
                'code' => '404',
            ]);
        }
        return response()->json([
            'data' => $newTelecomeBill[0],
            'code' => '200'
        ]);
    }
    public function destroy($phone_number, $course_number, $receipt_id, $user_id)
    {
        $newTelecomeBill = newTelecomeBill::where('phone_number', $phone_number)
            ->where('course_number', $course_number)->first();
        //$newTelecomeBill = $newTelecomeBill[0];
        //dd($newTelecomeBill);
        archivedTelecomeBill::create([
            'phone_number' => $newTelecomeBill->phone_number,
            'course_number' => $newTelecomeBill->course_number,
            'name' => $newTelecomeBill->name,
            'relase_date' => $newTelecomeBill->relase_date,
            'next_relase_date' => $newTelecomeBill->next_relase_date,
            'local_calls' => $newTelecomeBill->local_calls,
            'international_calls' => $newTelecomeBill->international_calls,
            'servise_adsl' => $newTelecomeBill->servise_adsl,
            'amount_due_of_payment' => $newTelecomeBill->amount_due_of_payment,
            'city' => $newTelecomeBill->city,
            'area' => $newTelecomeBill->area,
            'street' => $newTelecomeBill->street,
            'payment_date' => now(),
            'receipt_id' => $receipt_id,
            'user_id' => $user_id,
        ]);

        DB::delete('delete from new_telecome_bills where phone_number = ? and course_number= ?', [$phone_number, $course_number]);

        return response()->json(true);
    }
}
