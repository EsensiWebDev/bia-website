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
        // Hapus file lama jika diganti atau dikosongkan
        static::updating(function ($categoryTreatments) {
            $oldFile = $categoryTreatments->getOriginal('thumbnail');
            $newFile = $categoryTreatments->thumbnail;

            // Periksa apakah field 'thumbnail' berubah
            if ($categoryTreatments->isDirty('thumbnail')) {

                // Cek apakah ada file lama yang harus dihapus
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {

                    // File lama ada, dan file baru bukan NULL. Hapus file lama sebelum path baru disimpan.
                    if ($newFile !== $oldFile) {
                        Storage::disk('public')->delete($oldFile);
                    }

                    // File DIKOSONGKAN
                    if (is_null($newFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }

                // Jika thumbnail dikosongkan, pastikan alt text juga dikosongkan
                if (is_null($newFile)) {
                    $categoryTreatments->thumbnail_alt_text = null;
                }
            }
        });

        // Rename file thumbnail jika SLUG berubah
        static::updated(function ($categoryTreatments) {
            $oldSlug = $categoryTreatments->getOriginal('slug');
            $newSlug = $categoryTreatments->slug;
            $thumbnailPath = $categoryTreatments->thumbnail;

            // Periksa apakah SLUG berubah, dan file thumbnail saat ini ada.
            if ($oldSlug && $oldSlug !== $newSlug && $thumbnailPath) {

                $disk = Storage::disk('public');

                // Dapatkan direktori dan ekstensi dari path lama
                $directory = pathinfo($thumbnailPath, PATHINFO_DIRNAME); // Contoh: cat-treatments
                $extension = pathinfo($thumbnailPath, PATHINFO_EXTENSION); // Contoh: jpg

                // Buat nama file baru berdasarkan slug baru
                $newFilename = "{$newSlug}.{$extension}";
                $newPath = "{$directory}/{$newFilename}";

                // pastikan file lama ada dan path baru berbeda
                if ($disk->exists($thumbnailPath) && $thumbnailPath !== $newPath) {
                    $disk->move($thumbnailPath, $newPath);

                    // Update path baru di database
                    $categoryTreatments->thumbnail = $newPath;
                    $categoryTreatments->saveQuietly();
                }
            }
        });

        // Saat delete record
        static::deleting(function ($categoryTreatments) {
            if ($categoryTreatments->thumbnail && Storage::disk('public')->exists($categoryTreatments->thumbnail)) {
                Storage::disk('public')->delete($categoryTreatments->thumbnail);
            }
        });
    }
}
