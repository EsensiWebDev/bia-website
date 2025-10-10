<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreatmentWhoNeed extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'treatment_id',
        'order',
        'thumbnail',
        'desc',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    protected static function booted()
    {
        // 1. PENGGANTIAN FILE (DELETE OLD FILE AFTER NEW ONE IS SAVED)
        static::updating(function ($whoNeed) {
            if ($whoNeed->isDirty('thumbnail')) {
                $oldFile = $whoNeed->getOriginal('thumbnail');
                // Hapus file lama hanya jika ada dan ada di storage
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
        });

        // 2. PENGHAPUSAN BARIS (DELETE FILE WHEN REPEATER ITEM IS DELETED)
        static::deleting(function ($whoNeed) {
            if ($whoNeed->thumbnail) {
                Storage::disk('public')->delete($whoNeed->thumbnail);
            }
        });
    }
}
