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
    /**
     * The "booted" method of the model.
     * Contains observers for automatic file management.
     *
     * @return void
     */
    protected static function booted()
    {
        // =========================================================================
        // 1. OBSERVER: UPDATING (Menghapus file lama saat diganti atau dibuang)
        // =========================================================================
        static::updating(function ($article) {
            $oldThumbnail = $article->getOriginal('thumbnail');
            $newThumbnail = $article->thumbnail;
            $disk = Storage::disk('public');
            $tempUploadFolder = 'articles/temporary-upload'; // <-- Folder yang dicek

            // --- LOGIC CONTENT (Gambar yang sudah di DB dan yang baru di-upload) ---
            if ($article->isDirty('content')) {
                $oldContent = $article->getOriginal('content') ?? '';
                $newContent = $article->content ?? '';

                // Ambil semua path gambar yang TERSISA di konten BARU
                preg_match_all('/\/storage\/([^"\']+)/i', $newContent, $newImagesMatches);
                $newImages = array_unique(array_filter($newImagesMatches[1] ?? [], fn($path) => str_starts_with($path, 'articles/')));

                // 1. PEMBERSIHAN GAMBAR LAMA (DARI DB)
                preg_match_all('/\/storage\/([^"\']+)/i', $oldContent, $oldImagesMatches);
                $oldImages = array_unique(array_filter($oldImagesMatches[1] ?? [], fn($path) => str_starts_with($path, 'articles/')));

                $deletedOldImages = array_diff($oldImages, $newImages);
                foreach ($deletedOldImages as $path) {
                    if ($disk->exists($path)) {
                        $disk->delete($path);
                    }
                }

                // 2. PEMBERSIHAN DRAFT IMAGES (DARI FOLDER TEMPORARY)
                if ($disk->exists($tempUploadFolder)) {
                    $tempFiles = $disk->allFiles($tempUploadFolder);
                    foreach ($tempFiles as $tempPath) {
                        if (!in_array($tempPath, $newImages) && $disk->exists($tempPath)) {
                            $disk->delete($tempPath);
                        }
                    }
                }
            }

            // --- LOGIC THUMBNAIL: Hapus file lama jika thumbnail diganti atau dikosongkan ---
            if ($article->isDirty('thumbnail')) {
                if ($oldThumbnail && $disk->exists($oldThumbnail)) {
                    if ($newThumbnail !== $oldThumbnail) {
                        $disk->delete($oldThumbnail);
                    }
                    if (is_null($newThumbnail)) {
                        $disk->delete($oldThumbnail);
                    }
                }
            }
        });

        // =========================================================================
        // 2. OBSERVER: UPDATED (Memindahkan folder jika slug berubah / pertama kali)
        // =========================================================================
        static::updated(function ($article) {
            $slug = $article->slug;
            $oldSlug = $article->getOriginal('slug');
            $dir = "articles/{$slug}";
            $disk = Storage::disk('public');
            $tempUploadFolder = 'articles/temporary-upload';

            $needsSave = false;
            $content = $article->content ?? '';

            preg_match_all('/\/storage\/([^"\']+)/i', $content, $newMatches);
            $newImages = array_unique(array_filter($newMatches[1] ?? [], fn($path) => str_starts_with($path, 'articles/')));

            $isFirstSaveWithSlug = is_null($oldSlug) && !is_null($slug);
            $hasSlugChanged = $oldSlug && $oldSlug !== $slug;

            // Logic pemindahan hanya berjalan jika slug diisi/berubah
            if ($hasSlugChanged || $isFirstSaveWithSlug) {
                $sourceDirToMove = [];

                if ($isFirstSaveWithSlug && $disk->exists($tempUploadFolder)) {
                    $sourceDirToMove[] = $tempUploadFolder;
                }

                if ($hasSlugChanged && $disk->exists("articles/{$oldSlug}")) {
                    $sourceDirToMove[] = "articles/{$oldSlug}";
                }

                $sourceDirToMove = array_unique(array_filter($sourceDirToMove));

                if (empty($sourceDirToMove) && !$article->isDirty('thumbnail')) {
                    return;
                }

                $disk->makeDirectory($dir);
                $updatedContent = $article->content;
                $updatedThumbnail = $article->thumbnail;

                foreach ($sourceDirToMove as $oldPathPrefix) {
                    // --- Pindahkan thumbnail ke folder baru ---
                    $oldThumbnailPath = $article->getOriginal('thumbnail');
                    if ($oldThumbnailPath && str_starts_with($oldThumbnailPath, $oldPathPrefix) && $disk->exists($oldThumbnailPath)) {
                        $extension = pathinfo($oldThumbnailPath, PATHINFO_EXTENSION);
                        $newThumbnailPath = "{$dir}/{$slug}.{$extension}";

                        // Jika thumbnail lama punya nama berbeda, rename + pindahkan
                        if ($oldThumbnailPath !== $newThumbnailPath) {
                            $disk->move($oldThumbnailPath, $newThumbnailPath);
                            $updatedThumbnail = $newThumbnailPath;
                            $needsSave = true;
                        }
                    }

                    // --- Pindahkan semua gambar di content ke folder slug baru ---
                    foreach ($newImages as $img) {
                        if (str_starts_with($img, $oldPathPrefix) && $disk->exists($img)) {
                            $filename = basename($img);
                            $newPath = "{$dir}/{$filename}";

                            if ($img !== $newPath) {
                                $disk->move($img, $newPath);
                                $updatedContent = str_replace($img, $newPath, $updatedContent);
                                $needsSave = true;
                            }
                        }
                    }

                    // --- Hapus folder lama jika sudah kosong ---
                    if ($oldPathPrefix !== $dir && $disk->exists($oldPathPrefix) && count($disk->allFiles($oldPathPrefix)) === 0) {
                        $disk->deleteDirectory($oldPathPrefix);
                    }
                }

                // --- Simpan ulang jika ada perubahan path ---
                if ($needsSave) {
                    $article->content = $updatedContent;
                    $article->thumbnail = $updatedThumbnail;
                    $article->saveQuietly();
                }
            }

            // --- Pastikan content tersimpan jika masih ada perubahan ---
            if ($article->isDirty('content')) {
                $article->saveQuietly();
            }
        });

        // =========================================================================
        // 3. OBSERVER: DELETING (Menghapus folder utama saat record dihapus)
        // =========================================================================
        static::deleting(function ($article) {
            if ($article->slug) {
                $dir = "articles/{$article->slug}";
                if (Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->deleteDirectory($dir);
                }
            }

            // Hapus juga thumbnail yang mungkin berada di luar folder slug
            if ($article->thumbnail && !str_starts_with($article->thumbnail, "articles/{$article->slug}")) {
                if (Storage::disk('public')->exists($article->thumbnail)) {
                    Storage::disk('public')->delete($article->thumbnail);
                }
            }
        });
    }
}
