<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_code',
        'purok_id',
        'head_of_family',
        'family_size',
        'voter_count'
    ];

    public function purok()
    {
        return $this->belongsTo(Purok::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }
}