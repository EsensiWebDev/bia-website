<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreatmentTimeFrame extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'treatment_id',
        'stage',
        'show_stage',
        'frame',
        'order',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
    public function stageItems()
    {
        return $this->hasMany(TreatmentStageItem::class, 'treatment_time_frame_id');
    }
}
