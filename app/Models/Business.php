<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← add

class Business extends Model
{
    use HasFactory, SoftDeletes; // ← add SoftDeletes

    protected $fillable = [
        'business_name',
        'owner_name',
        'business_type',
        'address',
        'contact_number',
        'permit_number',
        'reference_number',
        'issued_date',
        'expiry_date',
        'status',
    ];

    protected $casts = [
        'deleted_at' => 'datetime', // ← add
    ];
}