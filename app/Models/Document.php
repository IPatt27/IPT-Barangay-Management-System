<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'document_type',
        'purpose',
        'or_number',
        'issued_by',
        'position',
        'status',
    ];

    // A document belongs to a resident
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
