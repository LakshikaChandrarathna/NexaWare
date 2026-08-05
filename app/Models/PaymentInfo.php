<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    protected $table = 'payment_infos';

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_holder_name',
        'card_number',
        'expire_date',
        'cvv',
    ];
}