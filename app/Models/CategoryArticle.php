<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryArticle extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['slug', 'title', 'description', 'thumbnail', 'thumbnail_alt_text'];

    public function articles()
    {
        return $this->hasMany(Articles::class, 'category_article_id');
    }


    protected static function booted()
    {
        // Hapus file lama jika diganti atau dikosongkan
        static::updating(function ($categoryArticle) {
            $oldFile = $categoryArticle->getOriginal('thumbnail');
            $newFile = $categoryArticle->thumbnail;

            // Periksa apakah field 'thumbnail' berubah
            if ($categoryArticle->isDirty('thumbnail')) {

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
                    $categoryArticle->thumbnail_alt_text = null;
                }
            }
        });

        // Rename file thumbnail jika SLUG berubah
        static::updated(function ($categoryArticle) {
            $oldSlug = $categoryArticle->getOriginal('slug');
            $newSlug = $categoryArticle->slug;
            $thumbnailPath = $categoryArticle->thumbnail;

            // Periksa apakah SLUG berubah, dan file thumbnail saat ini ada.
            if ($oldSlug && $oldSlug !== $newSlug && $thumbnailPath) {

                $disk = Storage::disk('public');

                // Dapatkan direktori dan ekstensi dari path lama
                $directory = pathinfo($thumbnailPath, PATHINFO_DIRNAME); // Contoh: cat-articles
                $extension = pathinfo($thumbnailPath, PATHINFO_EXTENSION); // Contoh: jpg

                // Buat nama file baru berdasarkan slug baru
                $newFilename = "{$newSlug}.{$extension}";
                $newPath = "{$directory}/{$newFilename}";

                // pastikan file lama ada dan path baru berbeda
                if ($disk->exists($thumbnailPath) && $thumbnailPath !== $newPath) {
                    $disk->move($thumbnailPath, $newPath);

                    // Update path baru di database
                    $categoryArticle->thumbnail = $newPath;
                    $categoryArticle->saveQuietly();
                }
            }
        });

        // Saat delete record
        static::deleting(function ($categoryArticle) {
            if ($categoryArticle->thumbnail && Storage::disk('public')->exists($categoryArticle->thumbnail)) {
                Storage::disk('public')->delete($categoryArticle->thumbnail);
            }
        });
    }
}
