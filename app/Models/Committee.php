<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $table = 'committee_records';

    protected $fillable = [
        'committee_slug',
        'type',
        'title',
        'file_path',
        'description',
    ];
}