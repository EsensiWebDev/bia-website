<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Career extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'careers';
    protected $fillable = [
        'slug',
        'author',
        'career_title',
        'short_desc',
        'content',
        'is_published',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'email_send',
        'subject_send',
        'exsubject_send',
        'publish_date',
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'publish_date' => 'datetime', // tambahkan ini
        'is_published' => 'boolean',
    ];
    protected static function booted()
    {
        // =========================================================================
        // 1. OBSERVER: UPDATING (Membersihkan gambar lama dari content)
        // =========================================================================
        static::updating(function ($careers) {
            $disk = Storage::disk('public');
            $tempUploadFolder = 'career/temporary-upload';

            if ($careers->isDirty('content')) {
                $oldContent = $careers->getOriginal('content') ?? '';
                $newContent = $careers->content ?? '';

                // Ambil path gambar baru di konten
                preg_match_all('/\/storage\/([^"\']+)/i', $newContent, $newImagesMatches);
                $newImages = array_unique(array_filter($newImagesMatches[1] ?? [], fn($path) => str_starts_with($path, 'career/')));

                // Ambil path gambar lama di konten sebelumnya
                preg_match_all('/\/storage\/([^"\']+)/i', $oldContent, $oldImagesMatches);
                $oldImages = array_unique(array_filter($oldImagesMatches[1] ?? [], fn($path) => str_starts_with($path, 'career/')));

                // Hapus gambar lama yang sudah tidak digunakan
                $deletedOldImages = array_diff($oldImages, $newImages);
                foreach ($deletedOldImages as $path) {
                    if ($disk->exists($path)) {
                        $disk->delete($path);
                    }
                }

                // Bersihkan file sementara yang tidak ada di konten baru
                if ($disk->exists($tempUploadFolder)) {
                    $tempFiles = $disk->allFiles($tempUploadFolder);

                    foreach ($tempFiles as $tempPath) {
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
        static::updated(function ($careers) {
            $slug = $careers->slug;
            $oldSlug = $careers->getOriginal('slug');
            $dir = "career/{$slug}";
            $disk = Storage::disk('public');
            $tempUploadFolder = 'career/temporary-upload';

            $needsSave = false;
            $content = $careers->content ?? '';

            // Ambil list gambar dari konten baru
            preg_match_all('/\/storage\/([^"\']+)/i', $content, $newMatches);
            $newImages = array_unique(array_filter($newMatches[1] ?? [], fn($path) => str_starts_with($path, 'career/')));

            $isFirstSaveWithSlug = is_null($oldSlug) && !is_null($slug);
            $hasSlugChanged = $oldSlug && $oldSlug !== $slug;

            if ($hasSlugChanged || $isFirstSaveWithSlug) {
                $sourceDirToMove = [];

                if ($isFirstSaveWithSlug && $disk->exists($tempUploadFolder)) {
                    $sourceDirToMove[] = $tempUploadFolder;
                }

                if ($hasSlugChanged && $disk->exists("career/{$oldSlug}")) {
                    $sourceDirToMove[] = "career/{$oldSlug}";
                }

                $sourceDirToMove = array_unique(array_filter($sourceDirToMove));

                if (empty($sourceDirToMove)) {
                    return;
                }

                $disk->makeDirectory($dir);
                $updatedContent = $careers->content;

                foreach ($sourceDirToMove as $oldPathPrefix) {
                    // Pindahkan content images dan update HTML path-nya
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

                    // Hapus folder lama jika sudah kosong
                    if ($oldPathPrefix !== $dir && $disk->exists($oldPathPrefix) && count($disk->allFiles($oldPathPrefix)) === 0) {
                        $disk->deleteDirectory($oldPathPrefix);
                    }
                }

                if ($needsSave) {
                    $careers->content = $updatedContent;
                    $careers->saveQuietly();
                }
            }

            // Simpan content jika ada perubahan tersisa
            if ($careers->isDirty('content')) {
                $careers->saveQuietly();
            }
        });

        // =========================================================================
        // 3. OBSERVER: DELETING (Menghapus folder utama saat record dihapus)
        // =========================================================================
        static::deleting(function ($careers) {
            if ($careers->slug) {
                $dir = "career/{$careers->slug}";
                if (Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->deleteDirectory($dir);
                }
            }
        });
    }
}
