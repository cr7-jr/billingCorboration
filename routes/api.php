<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//استرجاع احصائيات للادمن
Route::get('archivedTelecomeBill/count', 'Api\archivedTelecomeBillController@count');
Route::get('archivedWaterBill/count', 'Api\archivedWaterBillController@count');
Route::get('archivedElectricityBill/count', 'Api\archivedElectricityBillController@count');

//استرجاع الكل
Route::get('archivedTelecomeBill', 'Api\archivedTelecomeBillController@index');
Route::get('archivedElectricityBill', 'Api\archivedElectricityBillController@index');
Route::get('archivedWaterBill', 'Api\archivedWaterBillController@index');

Route::get('newTelecomeBill', 'Api\newTelecomeBillController@index');
Route::get('newElectricityBill', 'Api\newElectricityBillController@index');
Route::get('newWaterBill', 'Api\newWaterBillController@index');

//استرجاع فاتورة معين
Route::get('getNewTelecomeBill/{phone_number}/{course_number}', 'Api\newTelecomeBillController@show');
Route::get('getNewElectricityBill/{hour_number}/{course_number}', 'Api\newElectricityBillController@show');
Route::get('getNewWaterBill/{counter_number}/{course_number}', 'Api\newWaterBillController@show');

Route::get('getArchivedTelecomeBill/{phone_number}/{course_number}', 'Api\archivedTelecomeBillController@show');
Route::get('getArchivedElectricityBill/{hour_number}/{course_number}', 'Api\archivedElectricityBillController@show');
Route::get('getArchivedWaterBill/{counter_number}/{course_number}', 'Api\archivedWaterBillController@show');

Route::get('complatePayTelecome/{phone_number}/{course_number}/{receipt_id}/{user_id}', 'Api\newTelecomeBillController@destroy');
Route::get('complatePayElectricity/{hour_number}/{course_number}/{receipt_id}/{user_id}', 'Api\newElectricityBillController@destroy');
Route::get('complatePayWater/{counter_number}/{course_number}/{receipt_id}/{user_id}', 'Api\newWaterBillController@destroy');

Route::get('telecome/RestoreConsumptionRates', 'Api\archivedTelecomeBillController@RestoreConsumptionRates');
Route::get('electricity/RestoreConsumptionRates', 'Api\archivedElectricityBillController@RestoreConsumptionRates');
Route::get('water/RestoreConsumptionRates', 'Api\archivedWaterBillController@RestoreConsumptionRates');
