<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\archivedTelecomeBill;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class archivedTelecomeBillController extends Controller
{

    public function count(Request $request)
    {

        $searsh = $request->searsh;
        //when request not found Today's stats will show you
        if (is_null($searsh)) {
            $searsh = 0;
        }

        $arr = ['yesterday', 'current_year', 'last_year', '0', '30', '7', 'all'];
        if (in_array($searsh, $arr)) {
            if ($searsh == 'yesterday') {
                $count = DB::select(
                    'select count(*) as count from archived_telecome_bills
                    where
                    payment_date =
                    DATE_SUB(CURRENT_DATE,INTERVAL 1 day)'
                );
            } else if ($searsh == 'current_year') {
                $year = now()->year;
                $count = DB::select(
                    'select count(*) as count from archived_telecome_bills
                    where
                    year(payment_date) =' . $year
                );
            } else if ($searsh == 'last_year') {

                $year = now()->year - 1;
                $count = DB::select(
                    'select count(*) as count from archived_telecome_bills
                    where
                    year(payment_date) =' . $year
                );
            } elseif ($searsh == 'all') {
                $count = archivedTelecomeBill::count();
                return  response()->json([
                    'count' => $count,
                    'code' => '200'
                ]);
            } else {

                $count = DB::select(
                    'select count(*) as count from archived_telecome_bills
                where
                payment_date between
                DATE_SUB(CURRENT_DATE,INTERVAL ? day)
                and
                CURRENT_DATE ',
                    [$searsh]
                );
            }
            return response()->json([
                'count' => $count[0]->count,
                'code' => '200'
            ]);
        } else {
            return response()->json([
                'count' => null,
                'code' => '404'
            ]);
        }
    } //end count
    public function index(Request $request)
    {
        $archivedTelecomeBill = $request->searsh;

        $archivedTelecomeBill = ['archivedTelecomeBill' => $archivedTelecomeBill];
        $validae = Validator::make(
            $archivedTelecomeBill,
            ['archivedTelecomeBill' => 'exists:archived_telecome_bills,phone_number']
        );
        if ($validae->fails()) {
            return response()->json([
                'data' => 'هذا الرقم غير موجود',
                'code' => '404'
            ]);
        }
        $archivedTelecomeBill = archivedTelecomeBill::find($archivedTelecomeBill);
        return response()->json([
            'data' => $archivedTelecomeBill,
            'code' => '200'
        ]);
    } // end index

    public function show($phone_number, $course_number)
    {
        $archivedTelecomeBill = archivedTelecomeBill::where('phone_number', $phone_number)
            ->where('course_number', $course_number)->get();
        if (empty($archivedTelecomeBill[0])) {
            return response()->json([
                'data' => 'data not found',
                'code' => '404',
            ]);
        }
        return response()->json([
            'data' => $archivedTelecomeBill[0],
            'code' => '200'
        ]);
    }
    public function RestoreConsumptionRates(Request $request)
    {
        $data = DB::select('select amount_due_of_payment,relase_date from archived_telecome_bills where phone_number =?', [$request->phone_number]);
        if (empty($data)) {
            return response()->json([
                'data' => 'not found',
                'code' => '404'
            ]);
        } else {
            return response()->json(
                [
                    'data' => $data,
                    'code' => '200'
                ]
            );
        }
    }
}
