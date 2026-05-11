<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← add

class Household extends Model
{
    use HasFactory, SoftDeletes; // ← add SoftDeletes

    protected $fillable = [
        'household_code',
        'purok_id',
        'head_of_family',
        'family_size',
        'voter_count',
    ];

    protected $casts = [
        'deleted_at' => 'datetime', // ← add
    ];

    public function purok()
    {
        return $this->belongsTo(Purok::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($household) {
            $latest = Household::latest()->first();
            $number = $latest ? intval(substr($latest->household_code, 2)) + 1 : 1;
            $household->household_code = 'HH' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }
}