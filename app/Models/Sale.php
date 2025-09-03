<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'employee',
        'date_transaction',
        'content',
        'type_voucher',
        'type_document',
        'n_document',
        'names',
        'razon_social',
        'dirección fiscal',
        'type_emision',
        'methd_payment',
        'paid_amount',
        'total'
    ];

    protected $casts = [
        'paid_amount' => 'decimal:2',
        'content' => 'array',
    ];
}
