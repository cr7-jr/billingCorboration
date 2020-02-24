<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class archivedTelecomeBill extends Model
{
    protected  $primaryKey = "phone_number";
    protected $fillable = ['phone_number', 'course_number', 'name', 'relase_date', 'next_relase_date', 'local_calls', 'international_calls', 'servise_adsl', 'amount_due_of_payment', 'city', 'area', 'street', 'payment_date', 'receipt_id', 'user_id'];
    public $timestamps = false;
}
