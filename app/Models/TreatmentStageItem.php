<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreatmentStageItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'treatment_time_frame_id',
        'order',
        'thumbnail',
        'title',
        'desc',
    ];

    public function timeFrame()
    {
        return $this->belongsTo(TreatmentTimeFrame::class, 'treatment_time_frame_id');
    }

    protected static function booted()
    {
        // 1. DELETE OLD FILE AFTER NEW ONE IS SAVED
        static::updating(function ($stageItem) {
            if ($stageItem->isDirty('thumbnail')) {
                $oldFile = $stageItem->getOriginal('thumbnail');
                // Hapus file lama hanya jika ada dan ada di storage
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
        });

        // 2. DELETE FILE WHEN REPEATER ITEM IS DELETED
        static::deleting(function ($stageItem) {
            if ($stageItem->thumbnail) {
                Storage::disk('public')->delete($stageItem->thumbnail);
            }
        });
    }
}
