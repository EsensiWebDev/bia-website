<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryTreatment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title', 'slug', 'thumbnail', 'desc'];

    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'category_treatment_id');
    }
    public function setThumbnailAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['thumbnail'] = !empty($value) ? reset($value) : null;
        } elseif (is_string($value) || is_null($value)) {
            $this->attributes['thumbnail'] = $value;
        } else {
            $this->attributes['thumbnail'] = null;
        }
    }
    protected static function booted()
    {
        // Saat update (Hapus file lama jika diganti atau dikosongkan)
        static::updating(function ($categoryTreatment) {
            $oldFile = $categoryTreatment->getOriginal('thumbnail');
            $newFile = $categoryTreatment->thumbnail;

            // Periksa apakah field 'thumbnail' berubah
            if ($categoryTreatment->isDirty('thumbnail')) {

                // File lama ada, dan path-nya berbeda dari file baru (File baru sudah di-upload di storage)
                if ($oldFile && $oldFile !== $newFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                // File baru NULL, tapi file lama ada
                if (is_null($newFile) && $oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
        });

        // Saat delete record (Hapus file)
        static::deleting(function ($categoryTreatment) {
            if ($categoryTreatment->thumbnail && Storage::disk('public')->exists($categoryTreatment->thumbnail)) {
                Storage::disk('public')->delete($categoryTreatment->thumbnail);
            }
        });
    }
}
