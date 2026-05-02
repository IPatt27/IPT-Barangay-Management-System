<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

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
}