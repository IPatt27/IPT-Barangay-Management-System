<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Purok extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'name',
        'leader_name',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function households()
    {
        return $this->hasMany(Household::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }
}