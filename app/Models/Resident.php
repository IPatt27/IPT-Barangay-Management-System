<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = 
    [
        'first_name',
        'last_name',
        'age',
        'sex',
        'birthdate',
        'civil_status',
        'address',
        'contact_number',
        'status',
        'purok_id',
        'household_id'
    ];

    use HasFactory;

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function purok()
    {
        return $this->belongsTo(Purok::class);
    }
}
