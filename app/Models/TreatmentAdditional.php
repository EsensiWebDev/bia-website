<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreatmentAdditional extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'treatment_id',
        'order',
        'desc',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}
