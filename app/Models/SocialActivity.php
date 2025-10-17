<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialActivity extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'slug',
        'author',
        'title',
        'excerpt',
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
        static::updating(function ($socialActivity) {
            $oldThumbnail = $socialActivity->getOriginal('thumbnail');
            $newThumbnail = $socialActivity->thumbnail;
            $disk = Storage::disk('public');
            $tempUploadFolder = 'social_activity/temporary-upload'; // <-- Folder yang dicek

            // ... (Logic Thumbnail dipertahankan) ...

            // --- LOGIC CONTENT (Gambar yang sudah di DB dan yang baru di-upload) ---

            if ($socialActivity->isDirty('content')) {
                $oldContent = $socialActivity->getOriginal('content') ?? '';
                $newContent = $socialActivity->content ?? '';

                // Ambil semua path gambar yang TERSISA di konten BARU
                preg_match_all('/\/storage\/([^"\']+)/i', $newContent, $newImagesMatches);
                $newImages = array_unique(array_filter($newImagesMatches[1] ?? [], fn($path) => str_starts_with($path, 'social_activity/')));

                // 1. PEMBESIHAN GAMBAR LAMA (DARI DB)
                preg_match_all('/\/storage\/([^"\']+)/i', $oldContent, $oldImagesMatches);
                $oldImages = array_unique(array_filter($oldImagesMatches[1] ?? [], fn($path) => str_starts_with($path, 'social_activity/')));

                $deletedOldImages = array_diff($oldImages, $newImages);
                foreach ($deletedOldImages as $path) {
                    if ($disk->exists($path)) {
                        $disk->delete($path);
                    }
                }

                // 2. PEMBESIHAN DRAFT IMAGES (DARI FOLDER TEMPORARY)
                if ($disk->exists($tempUploadFolder)) {
                    $tempFiles = $disk->allFiles($tempUploadFolder);

                    foreach ($tempFiles as $tempPath) {
                        // Cek apakah file temporary TIDAK ADA di konten BARU
                        if (!in_array($tempPath, $newImages)) {
                            if ($disk->exists($tempPath)) {
                                $disk->delete($tempPath);
                            }
                        }
                    }
                }
            }
        });

        // =========================================================================
        // 2. OBSERVER: UPDATED (Memindahkan folder jika slug berubah/pertama kali)
        // =========================================================================
        static::updated(function ($socialActivity) {
            $slug = $socialActivity->slug;
            $oldSlug = $socialActivity->getOriginal('slug');
            $dir = "social_activity/{$slug}";
            $disk = Storage::disk('public');
            $tempUploadFolder = 'social_activity/temporary-upload';

            $needsSave = false;

            // Ambil list gambar yang TERSISA di konten baru
            $content = $socialActivity->content ?? '';
            preg_match_all('/\/storage\/([^"\']+)/i', $content, $newMatches);
            $newImages = array_unique(array_filter($newMatches[1] ?? [], fn($path) => str_starts_with($path, 'social_activity/')));

            $isFirstSaveWithSlug = is_null($oldSlug) && !is_null($slug);
            $hasSlugChanged = $oldSlug && $oldSlug !== $slug;

            // Logic pemindahan hanya berjalan jika slug diisi/berubah
            if ($hasSlugChanged || $isFirstSaveWithSlug) {

                // --- Tentukan Sumber Folder ---
                $sourceDirToMove = [];

                // Jika ini CREATE pertama kali, sumber utama adalah folder temporary
                if ($isFirstSaveWithSlug && $disk->exists($tempUploadFolder)) {
                    $sourceDirToMove[] = $tempUploadFolder;
                }

                // Jika slug berubah (saat UPDATE), sumber adalah folder slug lama
                if ($hasSlugChanged && $disk->exists("social_activity/{$oldSlug}")) {
                    $sourceDirToMove[] = "social_activity/{$oldSlug}";
                }

                $sourceDirToMove = array_unique(array_filter($sourceDirToMove));

                if (empty($sourceDirToMove) && !$socialActivity->isDirty('thumbnail')) {
                    return;
                }

                $disk->makeDirectory($dir);
                $updatedContent = $socialActivity->content;
                $updatedThumbnail = $socialActivity->thumbnail;

                foreach ($sourceDirToMove as $oldPathPrefix) {

                    // Pindahkan thumbnail (jika masih di folder lama/temporary)
                    $oldThumbnailPath = $socialActivity->getOriginal('thumbnail');
                    if ($oldThumbnailPath && str_starts_with($oldThumbnailPath, $oldPathPrefix) && $disk->exists($oldThumbnailPath)) {
                        $extension = pathinfo($oldThumbnailPath, PATHINFO_EXTENSION);
                        $newFilename = "{$slug}.{$extension}"; // rename sesuai slug
                        $newPath = "{$dir}/{$newFilename}";

                        if ($oldThumbnailPath !== $newPath) {
                            $disk->move($oldThumbnailPath, $newPath);
                            $updatedThumbnail = $newPath;
                            $needsSave = true;
                        }
                    }


                    // Pindahkan content images dan perbarui HTML
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

                    // Hapus folder lama (temporary/slug lama) jika sudah kosong
                    if ($oldPathPrefix !== $dir && $disk->exists($oldPathPrefix) && count($disk->allFiles($oldPathPrefix)) === 0) {
                        $disk->deleteDirectory($oldPathPrefix);
                    }
                }

                // Simpan content dan thumbnail jika ada path yang diubah
                if ($needsSave) {
                    $socialActivity->content = $updatedContent;
                    $socialActivity->thumbnail = $updatedThumbnail;
                    $socialActivity->saveQuietly();
                }
            }

            // Simpan content jika ada perubahan yang tersisa
            if ($socialActivity->isDirty('content')) {
                $socialActivity->saveQuietly();
            }
        });
        // =========================================================================
        // 3. OBSERVER: DELETING (Menghapus folder utama saat record dihapus)
        // =========================================================================
        static::deleting(function ($socialActivity) {
            if ($socialActivity->slug) {
                $dir = "social_activity/{$socialActivity->slug}";
                if (Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->deleteDirectory($dir);
                }
            }
            // Hapus juga thumbnail yang mungkin berada di luar folder slug
            if ($socialActivity->thumbnail && !str_starts_with($socialActivity->thumbnail, "social_activity/{$socialActivity->slug}")) {
                if (Storage::disk('public')->exists($socialActivity->thumbnail)) {
                    Storage::disk('public')->delete($socialActivity->thumbnail);
                }
            }
        });
    }
}
