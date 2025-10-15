<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DoctorCertification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'doctor_id',
        'certification_year',
        'certification_title'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    protected static function booted()
    {
        static::creating(function ($cert) {
            if (is_null($cert->order)) {
                $cert->order = ($cert->doctor?->certifications()->max('order') ?? 0) + 1;
            }
        });
    }
}
