<?php

namespace App\Http\Controllers\Api;

use App\archivedElectricityBill;
use App\Http\Controllers\Controller;
use App\archivedWaterBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class archivedWaterBillController extends Controller
{

    public function count(Request $request)
    {
        $searsh = $request->searsh;
        $arr = ['yesterday', 'current_year', 'last_year', '0', '30', '7', 'all'];
        if (in_array($searsh, $arr)) {
            if ($searsh == 'yesterday') {
                $count = DB::select(
                    'select count(*) as count from archived_water_bills
                    where
                    payment_date =
                    DATE_SUB(CURRENT_DATE,INTERVAL 1 day)'
                );
            } else if ($searsh == 'current_year') {
                $year = now()->year;
                $count = DB::select(
                    'select count(*) as count from archived_water_bills
                    where
                    year(payment_date) =' . $year
                );
            } else if ($searsh == 'last_year') {
                $year = now()->year - 1;
                $count = DB::select(
                    'select count(*) as count from archived_water_bills
                    where
                    year(payment_date) =' . $year
                );
            } elseif ($searsh == 'all') {
                $count = archivedWaterBill::count();
                return  response()->json([
                    'count' => $count,
                    'code' => '200'
                ]);
            } else {

                $count = DB::select(
                    'select count(*) as count from archived_water_bills
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
        $archivedWaterBill = $request->searsh;

        $archivedWaterBill = ['archivedWaterBill' => $archivedWaterBill];
        $validae = Validator::make(
            $archivedWaterBill,
            ['archivedWaterBill' => 'exists:archived_water_bills,counter_number']
        );
        if ($validae->fails()) {
            return response()->json([
                'data' => 'هذا الرقم غير موجود',
                'code' => '404'
            ]);
        }
        $archivedWaterBill = archivedWaterBill::find($archivedWaterBill);
        return response()->json([
            'data' => $archivedWaterBill,
            'code' => '200'
        ]);
    } // end index
    public function show($counter_number, $course_number)
    {

        $archivedWaterBill = archivedWaterBill::where('counter_number', $counter_number)
            ->where('course_number', $course_number)->get();
        if (empty($archivedWaterBill[0])) {
            return response()->json([
                'data' => 'data not found',
                'code' => '404',
            ]);
        }
        return response()->json([
            'data' => $archivedWaterBill[0],
            'code' => '200'
        ]);
    }
    public function RestoreConsumptionRates(Request $request)
    {
        $data = DB::select('select amount_due_of_payment,relase_date from archived_water_bills where counter_number =?', [$request->counter_number]);
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
