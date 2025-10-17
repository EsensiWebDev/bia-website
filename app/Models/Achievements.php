<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievements extends Model
{

    use HasFactory, HasUuids;
    protected $table = 'achievements';
    protected $fillable = [
        'id',
        'slug',
        'author',
        'title',
        'thumbnail',
        'doc',
        'thumbnail_alt_text',
        'content',
        'is_published',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'publish_date',
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
        static::updating(function ($achievement) {
            $oldThumbnail = $achievement->getOriginal('thumbnail');
            $newThumbnail = $achievement->thumbnail;
            $oldDoc = $achievement->getOriginal('doc');
            $newDoc = $achievement->doc;
            $disk = Storage::disk('public');
            $tempUploadFolder = 'achievements/temporary-upload'; // <-- Folder yang dicek

            // --- Hapus file doc lama jika diganti ---
            if ($oldDoc && $oldDoc !== $newDoc && $disk->exists($oldDoc)) {
                $disk->delete($oldDoc);
            }

            // --- LOGIC CONTENT (Gambar yang sudah di DB dan yang baru di-upload) ---
            if ($achievement->isDirty('content')) {
                $oldContent = $achievement->getOriginal('content') ?? '';
                $newContent = $achievement->content ?? '';

                // Ambil semua path gambar yang TERSISA di konten BARU
                preg_match_all('/\/storage\/([^"\']+)/i', $newContent, $newImagesMatches);
                $newImages = array_unique(array_filter($newImagesMatches[1] ?? [], fn($path) => str_starts_with($path, 'achievements/')));

                // 1. PEMBERSIHAN GAMBAR LAMA (DARI DB)
                preg_match_all('/\/storage\/([^"\']+)/i', $oldContent, $oldImagesMatches);
                $oldImages = array_unique(array_filter($oldImagesMatches[1] ?? [], fn($path) => str_starts_with($path, 'achievements/')));

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
        static::updated(function ($achievement) {
            $slug = $achievement->slug;
            $oldSlug = $achievement->getOriginal('slug');
            $dir = "achievements/{$slug}";
            $disk = Storage::disk('public');
            $tempUploadFolder = 'achievements/temporary-upload';

            $needsSave = false;

            // Ambil list gambar yang TERSISA di konten baru
            $content = $achievement->content ?? '';
            preg_match_all('/\/storage\/([^"\']+)/i', $content, $newMatches);
            $newImages = array_unique(array_filter($newMatches[1] ?? [], fn($path) => str_starts_with($path, 'achievements/')));

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
                if ($hasSlugChanged && $disk->exists("achievements/{$oldSlug}")) {
                    $sourceDirToMove[] = "achievements/{$oldSlug}";
                }

                $sourceDirToMove = array_unique(array_filter($sourceDirToMove));

                if (empty($sourceDirToMove) && !$achievement->isDirty('thumbnail')) {
                    return;
                }

                $disk->makeDirectory($dir);
                $updatedContent = $achievement->content;
                $updatedThumbnail = $achievement->thumbnail;
                $updatedDoc = $achievement->doc;

                foreach ($sourceDirToMove as $oldPathPrefix) {
                    // --- Pindahkan thumbnail (jika masih di folder lama/temporary) ---
                    $oldThumbnailPath = $achievement->getOriginal('thumbnail');
                    if ($oldThumbnailPath && str_starts_with($oldThumbnailPath, $oldPathPrefix) && $disk->exists($oldThumbnailPath)) {
                        $extension = pathinfo($oldThumbnailPath, PATHINFO_EXTENSION);
                        $newFilename = "{$slug}.{$extension}";
                        $newPath = "{$dir}/{$newFilename}";

                        if ($oldThumbnailPath !== $newPath) {
                            $disk->move($oldThumbnailPath, $newPath);
                            $updatedThumbnail = $newPath;
                            $needsSave = true;
                        }
                    }

                    // --- Pindahkan doc (jika masih di folder lama/temporary) ---
                    $oldDocPath = $achievement->getOriginal('doc');
                    if ($oldDocPath && str_starts_with($oldDocPath, $oldPathPrefix) && $disk->exists($oldDocPath)) {
                        $extension = pathinfo($oldDocPath, PATHINFO_EXTENSION);
                        $newDocPath = "{$dir}/doc.{$extension}";

                        if ($oldDocPath !== $newDocPath) {
                            $disk->move($oldDocPath, $newDocPath);
                            $updatedDoc = $newDocPath;
                            $needsSave = true;
                        }
                    }

                    // --- Pindahkan content images dan perbarui HTML ---
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

                // --- Simpan jika ada path yang berubah ---
                if ($needsSave) {
                    $achievement->content = $updatedContent;
                    $achievement->thumbnail = $updatedThumbnail;
                    $achievement->doc = $updatedDoc;
                    $achievement->saveQuietly();
                }
            }

            if ($achievement->isDirty('content')) {
                $achievement->saveQuietly();
            }
        });

        // =========================================================================
        // 3. OBSERVER: DELETING (Menghapus folder utama saat record dihapus)
        // =========================================================================
        static::deleting(function ($achievement) {
            $disk = Storage::disk('public');
            $slug = $achievement->slug;

            if ($slug && $disk->exists("achievements/{$slug}")) {
                $disk->deleteDirectory("achievements/{$slug}");
            }

            // Hapus thumbnail di luar folder slug
            if ($achievement->thumbnail && !str_starts_with($achievement->thumbnail, "achievements/{$slug}")) {
                if ($disk->exists($achievement->thumbnail)) {
                    $disk->delete($achievement->thumbnail);
                }
            }

            // Hapus doc di luar folder slug
            if ($achievement->doc && !str_starts_with($achievement->doc, "achievements/{$slug}")) {
                if ($disk->exists($achievement->doc)) {
                    $disk->delete($achievement->doc);
                }
            }
        });
    }
}
