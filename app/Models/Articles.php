<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;

class Articles extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'category_article_id',
        'slug',
        'author',
        'title',
        'thumbnail',
        'thumbnail_alt_text',
        'content',
        'is_published',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'publish_date'
    ];
    protected $casts = [
        'publish_date' => 'datetime', // tambahkan ini
        'is_published' => 'boolean',
    ];


    public function category()
    {
        return $this->belongsTo(CategoryArticle::class, 'category_article_id');
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
        // Saat update record
        static::updating(function ($article) {
            // Hapus thumbnail lama jika dikosongkan
            if (is_null($article->thumbnail) && $article->getOriginal('thumbnail')) {
                $oldFile = $article->getOriginal('thumbnail');
                if (Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
                $article->thumbnail_alt_text = null;
            }
        });

        static::updated(function ($article) {
            $slug = $article->slug;
            $dir = "articles/{$slug}";
            $oldSlug = $article->getOriginal('slug');
            $oldDir = "articles/{$oldSlug}";

            // ==============================
            // 1. Pindahkan thumbnail jika diperlukan
            // ==============================
            if ($article->thumbnail && !str_starts_with($article->thumbnail, $dir)) {
                $filename = basename($article->thumbnail);
                $newPath = "{$dir}/{$filename}";
                if (Storage::disk('public')->exists($article->thumbnail)) {
                    Storage::disk('public')->makeDirectory($dir);
                    Storage::disk('public')->move($article->thumbnail, $newPath);
                    $article->thumbnail = $newPath;
                    $article->saveQuietly();
                }
            }

            // ==============================
            // 2. Hapus content images yang dihapus
            // ==============================
            if ($article->isDirty('content')) {
                $oldContent = $article->getOriginal('content') ?? '';
                $newContent = $article->content ?? '';

                preg_match_all('/<img [^>]*src=["\'](?:https?:\/\/[^\/]+)?\/storage\/([^"\']+)["\']/i', $oldContent, $oldMatches);
                preg_match_all('/<img [^>]*src=["\'](?:https?:\/\/[^\/]+)?\/storage\/([^"\']+)["\']/i', $newContent, $newMatches);

                $oldImages = $oldMatches[1] ?? [];
                $newImages = $newMatches[1] ?? [];
                $deletedImages = array_diff($oldImages, $newImages);

                foreach ($deletedImages as $img) {
                    if (Storage::disk('public')->exists($img)) {
                        Storage::disk('public')->delete($img);
                    }
                }

                // ==============================
                // 3. Pindahkan content images ke folder slug baru jika slug berubah
                // ==============================
                if ($oldSlug !== $slug) {
                    foreach ($newImages as $img) {
                        if (!str_starts_with($img, $dir) && Storage::disk('public')->exists($img)) {
                            $filename = basename($img);
                            $newPath = "{$dir}/{$filename}";
                            Storage::disk('public')->makeDirectory($dir);
                            Storage::disk('public')->move($img, $newPath);
                            $article->content = str_replace($img, $newPath, $article->content);
                        }
                    }
                }

                $article->saveQuietly();
            }

            // ==============================
            // 4. Hapus folder lama jika slug berubah
            // ==============================
            if ($oldSlug && $oldSlug !== $slug && Storage::disk('public')->exists($oldDir)) {
                Storage::disk('public')->deleteDirectory($oldDir);
            }
        });

        // Saat delete record → hapus seluruh folder articles/{slug}
        static::deleting(function ($article) {
            if ($article->slug) {
                $dir = "articles/{$article->slug}";
                if (Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->deleteDirectory($dir);
                }
            }
        });
    }
}
