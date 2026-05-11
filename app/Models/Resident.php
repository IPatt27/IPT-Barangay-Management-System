<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Resident extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'sex',
        'birthdate',
        'civil_status',
        'address',
        'contact_number',
        'status',
        'is_voter',
        'purok_id',
        'household_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime', 
    ];

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function purok()
    {
        return $this->belongsTo(Purok::class);
    }
}