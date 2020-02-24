<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivedElectricityBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archived_electricity_bills', function (Blueprint $table) {
            $table->string('hour_number', 7);
            $table->string('course_number', 7);
            $table->primary(['hour_number', 'course_number']);
            $table->string('name');
            $table->date('relase_date');
            $table->date('next_relase_date');
            $table->string('power');
            $table->string('previous_visa');
            $table->string('current_visa');
            $table->string('amount_of_consumption', 10, 2);
            $table->double('amount_due_of_payment', 10, 2);
            $table->string('city');
            $table->string('area');
            $table->string('street');
            $table->date('payment_date');
            $table->integer('receipt_id');
            $table->integer('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archived_electricity_bills');
    }
}
