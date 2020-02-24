<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\archivedElectricityBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class archivedElectricityBillController extends Controller
{

    public function count(Request $request)
    {
        $searsh = $request->searsh;

        $arr = ['yesterday', 'current_year', 'last_year', '0', '30', '7', 'all'];
        if (in_array($searsh, $arr)) {
            if ($searsh == 'yesterday') {
                $count = DB::select(
                    'select count(*) as count from archived_electricity_bills
                    where
                    payment_date =
                    DATE_SUB(CURRENT_DATE,INTERVAL 1 day)'
                );
            } else if ($searsh == 'current_year') {
                $year = now()->year;
                $count = DB::select(
                    'select count(*) as count from archived_electricity_bills
                    where
                    year(payment_date) =' . $year
                );
            } else if ($searsh == 'last_year') {
                $year = now()->year - 1;
                $count = DB::select(
                    'select count(*) as count from archived_electricity_bills
                    where
                    year(payment_date) =' . $year
                );
            } elseif ($searsh == 'all') {
                $count = archivedElectricityBill::count();
                return  response()->json([
                    'count' => $count,
                    'code' => '200'
                ]);
            } else {

                $count = DB::select(
                    'select count(*) as count from archived_electricity_bills
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
        $archivedElectricityBill = $request->searsh;

        $archivedElectricityBill = ['archivedElectricityBill' => $archivedElectricityBill];
        $validae = Validator::make(
            $archivedElectricityBill,
            ['archivedElectricityBill' => 'exists:archived_electricity_bills,hour_number']
        );
        if ($validae->fails()) {
            return response()->json([
                'data' => 'هذا الرقم غير موجود',
                'code' => '404'
            ]);
        }
        $archivedElectricityBill = archivedElectricityBill::find($archivedElectricityBill);
        return response()->json([
            'data' => $archivedElectricityBill,
            'code' => '200'
        ]);
    } // end index
    public function show($hour_number, $course_number)
    {
        $archivedElectricityBill = archivedElectricityBill::where('hour_number', $hour_number)
            ->where('course_number', $course_number)->get();
        if (empty($archivedElectricityBill[0])) {
            return response()->json([
                'data' => 'data not found',
                'code' => '404',
            ]);
        }
        return response()->json([
            'data' => $archivedElectricityBill[0],
            'code' => '200'
        ]);
    }
    public function RestoreConsumptionRates(Request $request)
    {
        $data = DB::select('select amount_due_of_payment,relase_date  from archived_electricity_bills where hour_number=?', [$request->hour_number]);
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
