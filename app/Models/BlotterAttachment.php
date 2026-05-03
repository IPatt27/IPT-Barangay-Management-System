<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlotterAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blotter_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function blotter()
    {
        return $this->belongsTo(Blotter::class);
    }
}
