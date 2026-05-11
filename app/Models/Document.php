<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'resident_id',
        'document_type',
        'purpose',
        'or_number',
        'issued_by',
        'position',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    // A document belongs to a resident
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}