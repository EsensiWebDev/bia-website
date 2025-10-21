<?php

namespace App\Models;

use Filament\Forms\Get;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Treatment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'category_treatment_id',
        'slug',
        'thumbnail',
        'thumbnail_alt_text',
        'title',
        'desc',
        'contact',
        'maintenance',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryTreatment::class, 'category_treatment_id');
    }

    public function whoNeeds()
    {
        return $this->hasMany(TreatmentWhoNeed::class);
    }

    public function timeFrames()
    {
        return $this->hasMany(TreatmentTimeFrame::class);
    }

    public function additionals()
    {
        return $this->hasMany(TreatmentAdditional::class);
    }

    /**
     * Generate dynamic upload directory based on treatment slug and type.
     *
     * @param  string  $type  Jenis folder ('thumbnail', 'whoneeds', 'timeframe-items')
     * @param  \Filament\Forms\Get  $get
     * @return string
     */
    public static function getUploadDirectory(string $type, Get $get): string
    {
        // Cari slug sampai ke level paling atas
        $slug = $get('slug')
            ?? $get('../slug')
            ?? $get('../../slug')
            ?? $get('../../../slug')
            ?? $get('../../../../slug')
            ?? $get('../../../../../slug')
            ?? null;

        // Jika tidak ketemu slug, fallback ke title (dari induk)
        $title = $get('title')
            ?? $get('../title')
            ?? $get('../../title')
            ?? $get('../../../title')
            ?? $get('../../../../title')
            ?? $get('../../../../../title')
            ?? 'treatment';

        $slug = $slug ?: Str::slug($title);

        return match ($type) {
            'thumbnail'       => "treatments/{$slug}/thumbnail",
            'whoneeds'        => "treatments/{$slug}/whoneeds",
            'timeframe-items' => "treatments/{$slug}/timeframe-items",
            default           => "treatments/{$slug}",
        };
    }

    /**
     * Booted model event.
     */
    protected static function booted()
    {
        // Hapus additionals jika tanpa deskripsi
        static::saved(function ($treatment) {
            $treatment->additionals()
                ->whereNull('desc')
                ->orWhere('desc', '')
                ->delete();
        });

        // Hapus thumbnail utama lama
        static::updating(function ($treatment) {
            if ($treatment->isDirty('thumbnail')) {
                $old = $treatment->getOriginal('thumbnail');
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
        });

        // Rename folder jika slug berubah
        static::updated(function ($treatment) {
            $oldSlug = $treatment->getOriginal('slug');
            $slug = $treatment->slug;

            // JIKA SLUG BERUBAH
            if ($oldSlug && $oldSlug !== $slug) {
                $oldDir = "treatments/{$oldSlug}";
                $newDir = "treatments/{$slug}";

                // Buat folder baru
                Storage::disk('public')->makeDirectory($newDir);

                // --- Pindahkan file dan update path di DB ---

                // 1. Thumbnail utama
                if ($treatment->thumbnail && str_starts_with($treatment->thumbnail, $oldDir)) {

                    // Dapatkan ekstensi dari file lama
                    $extension = pathinfo($treatment->thumbnail, PATHINFO_EXTENSION);

                    // NAMA FILE BARU: Gunakan slug baru sebagai nama file
                    $newFilename = "{$slug}.{$extension}";
                    $oldPath = $treatment->thumbnail;
                    $newPath = "{$newDir}/thumbnail/{$newFilename}"; // Mengganti nama file

                    Storage::disk('public')->move($oldPath, $newPath);

                    $treatment->thumbnail = $newPath;
                    $treatment->saveQuietly();
                }

                // 2. WhoNeeds
                foreach ($treatment->whoNeeds as $who) {
                    if ($who->thumbnail && str_starts_with($who->thumbnail, $oldDir)) {
                        $filename = basename($who->thumbnail);
                        $newPath = "{$newDir}/whoneeds/{$filename}";
                        Storage::disk('public')->move($who->thumbnail, $newPath);
                        $who->thumbnail = $newPath;
                        $who->saveQuietly();
                    }
                }

                // 3. StageItems
                foreach ($treatment->timeFrames as $frame) {
                    foreach ($frame->stageItems as $item) {
                        if ($item->thumbnail && str_starts_with($item->thumbnail, $oldDir)) {
                            $filename = basename($item->thumbnail);
                            $newPath = "{$newDir}/timeframe-items/{$filename}";
                            Storage::disk('public')->move($item->thumbnail, $newPath);
                            $item->thumbnail = $newPath;
                            $item->saveQuietly();
                        }
                    }
                }

                // Hapus folder lama (setelah semua file dipindahkan)
                Storage::disk('public')->deleteDirectory($oldDir);
            }
        });

        // Hapus seluruh folder jika treatment dihapus
        static::deleting(function ($treatment) {
            if ($treatment->slug) {
                $dir = "treatments/{$treatment->slug}";
                if (Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->deleteDirectory($dir);
                }
            }
        });
    }
}
