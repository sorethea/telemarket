<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientEncounter extends Model
{
    use HasFactory;
    protected $fillable =[
        "patient_id",
        "provider_id",
        "encounter_date",
        "symptoms",
        "diagnosis",
    ];

    protected $casts=[
        "patient_id"=>"integer",
        "provider_id"=>"integer",
        "encounter_date"=>"datetime",
        "symptoms"=>"json",
        "diagnosis"=>"json",
    ];

    public function provider():BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
    public function patient():BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
