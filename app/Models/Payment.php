<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payable_type',
        'payable_id',
        'or_number',
        'amount',
        'status',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function payable()
    {
        return $this->morphTo();
    }
}