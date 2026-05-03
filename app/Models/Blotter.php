<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blotter extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_number',
        'incident_type',
        'incident_date',
        'incident_location',
        'incident_description',
        'status',
        'recorded_by',
        'remarks',
    ];

    protected $casts = [
        'incident_date' => 'datetime',
    ];

    public function parties()
    {
        return $this->hasMany(BlotterParty::class);
    }

    public function complainants()
    {
        return $this->parties()->where('role', 'Complainant');
    }

    public function respondents()
    {
        return $this->parties()->where('role', 'Respondent');
    }

    public function witnesses()
    {
        return $this->parties()->where('role', 'Witness');
    }

    public function attachments()
    {
        return $this->hasMany(BlotterAttachment::class);
    }
}
