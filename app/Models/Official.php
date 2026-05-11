<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   // ← ADD THIS

class Official extends Model
{
    use HasFactory, SoftDeletes;                 // ← ADD SoftDeletes HERE

    protected $fillable = [
        'first_name', 'last_name', 'position', 'designation',
        'contact', 'address', 'birthdate', 'term_start', 'term_end',
        'photo', 'status',
    ];

    protected $casts = [
        'birthdate'  => 'date',
        'term_start' => 'date',
        'term_end'   => 'date',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}