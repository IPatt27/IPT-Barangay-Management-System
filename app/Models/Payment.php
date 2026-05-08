<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['resident_id', 'type', 'amount', 'status'];

    public function resident() {
        return $this->belongsTo(Resident::class);
    }
}