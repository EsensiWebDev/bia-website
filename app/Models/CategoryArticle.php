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
        return $this->hasMany(Articles::class);
    }
    public function setThumbnailAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['thumbnail'] = !empty($value) ? reset($value) : null;
        } elseif (is_string($value)) {
            $this->attributes['thumbnail'] = $value;
        } else {
            $this->attributes['thumbnail'] = null;
        }
    }
    protected static function booted()
    {
        // Saat update
        static::updating(function ($article) {
            // Kalau thumbnail dikosongkan
            if (is_null($article->thumbnail) && $article->getOriginal('thumbnail')) {
                $oldFile = $article->getOriginal('thumbnail');

                // Hapus file lama
                if (Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                // Reset alt text juga
                $article->thumbnail_alt_text = null;
            }
        });

        // Saat delete record
        static::deleting(function ($article) {
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }
        });
    }
}
