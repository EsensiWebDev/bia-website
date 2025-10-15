<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DoctorEducation extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctor_educations';
    protected $fillable = [
        'doctor_id',
        'graduation_year',
        'education_title'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    protected static function booted()
    {
        static::creating(function ($education) {
            if (is_null($education->order)) {
                $education->order = ($education->doctor?->educations()->max('order') ?? 0) + 1;
            }
        });
    }
}
