<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class DoctorAssociation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'doctor_id',
        'association_name',
        'order',
        'img',
        'show_name'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // 🔹 Mutator untuk gambar — hapus file lama jika diganti
    // ─── Hapus File Lama saat Diganti ─────────────────────────────
    public function setImgAttribute($value)
    {
        if (
            isset($this->attributes['img']) &&
            $this->attributes['img'] !== $value &&
            Storage::disk('public')->exists($this->attributes['img'])
        ) {
            Storage::disk('public')->delete($this->attributes['img']);
        }

        $this->attributes['img'] = $value;
    }

    // ─── Update Nama File jika Slug atau Nama Association Berubah ───────────────
    public function updateAssociationImagePath()
    {
        if (! $this->img || ! Storage::disk('public')->exists($this->img)) return;

        $doctor = $this->doctor;
        if (! $doctor || ! $doctor->slug) return;

        $ext = pathinfo($this->img, PATHINFO_EXTENSION);
        $newFileName = "{$doctor->slug}_" . ($this->order ?? 0) . "_" . Str::slug($this->association_name) . ".{$ext}";
        $newPath = "doctors/association/{$newFileName}";

        $disk = Storage::disk('public');
        $disk->makeDirectory('doctors/association');

        if ($this->img !== $newPath) {
            if ($disk->exists($newPath)) {
                $disk->delete($newPath);
            }
            $disk->move($this->img, $newPath);
            $this->updateQuietly(['img' => $newPath]);
        }
    }

    // ─── Hapus File saat Dihapus ─────────────────────────────
    public function deleteAssociationImage()
    {
        if ($this->img && Storage::disk('public')->exists($this->img)) {
            Storage::disk('public')->delete($this->img);
        }
    }

    protected static function booted()
    {
        static::saved(function (DoctorAssociation $assoc) {
            $assoc->updateAssociationImagePath();
        });

        static::deleting(function (DoctorAssociation $assoc) {
            $assoc->deleteAssociationImage();
        });
    }
}
