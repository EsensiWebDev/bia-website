<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail_profile',
        'thumbnail_alt_text',
        'avatar',
        'position',
        'short_desc',
        'desc',
        'language',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function educations()
    {
        return $this->hasMany(DoctorEducation::class);
    }

    public function certifications()
    {
        return $this->hasMany(DoctorCertification::class);
    }

    public function associations()
    {
        return $this->hasMany(DoctorAssociation::class)->orderBy('order', 'asc');
    }
    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = is_array($value)
            ? (!empty($value) ? reset($value) : null)
            : $value;
    }

    public function setThumbnailProfileAttribute($value)
    {
        $this->attributes['thumbnail_profile'] = is_array($value)
            ? (!empty($value) ? reset($value) : null)
            : $value;
    }
    protected static function booted()
    {
        // ── Hapus file lama saat update avatar/thumbnail/association ──
        static::updating(function (Doctor $doctor) {
            $disk = Storage::disk('public');

            // Avatar & Thumbnail
            foreach (['avatar', 'thumbnail_profile'] as $field) {
                if ($doctor->isDirty($field)) {
                    $old = $doctor->getOriginal($field);
                    $new = $doctor->$field;
                    if ($old && $old !== $new && $disk->exists($old)) {
                        $disk->delete($old);
                    }
                }
            }

            // Associations
            foreach ($doctor->associations as $assoc) {
                if ($assoc->isDirty('img')) {
                    $old = $assoc->getOriginal('img');
                    $new = $assoc->img;
                    if ($old && $old !== $new && $disk->exists($old)) {
                        $disk->delete($old);
                    }
                }
            }
        });

        // ── Setelah update, pindahkan folder & update path file ──
        static::updated(function (Doctor $doctor) {
            $disk = Storage::disk('public');

            $oldSlug = $doctor->getOriginal('slug');
            $slug = $doctor->slug;

            if ($oldSlug && $oldSlug !== $slug) {
                $oldDir = "doctors/{$oldSlug}";
                $newDir = "doctors/{$slug}";

                // Pastikan folder baru ada
                $disk->makeDirectory($newDir);

                // 1️⃣ Avatar
                if ($doctor->avatar && str_starts_with($doctor->avatar, $oldDir)) {
                    $ext = pathinfo($doctor->avatar, PATHINFO_EXTENSION);
                    $newPath = "{$newDir}/avatar.{$ext}";
                    $disk->move($doctor->avatar, $newPath);
                    $doctor->forceFill(['avatar' => $newPath])->saveQuietly();
                }

                // 2️⃣ Thumbnail
                if ($doctor->thumbnail_profile && str_starts_with($doctor->thumbnail_profile, $oldDir)) {
                    $ext = pathinfo($doctor->thumbnail_profile, PATHINFO_EXTENSION);
                    $newPath = "{$newDir}/thumbnail_profile.{$ext}";
                    $disk->move($doctor->thumbnail_profile, $newPath);
                    $doctor->forceFill(['thumbnail_profile' => $newPath])->saveQuietly();
                }

                // 3️⃣ Associations (pindahkan & update nama file agar sesuai slug baru)
                foreach ($doctor->associations as $index => $assoc) {
                    if ($assoc->img && $disk->exists($assoc->img)) {
                        $ext = pathinfo($assoc->img, PATHINFO_EXTENSION);
                        $order = $assoc->order ?? $index + 1;
                        $uuidSuffix = substr((string) Str::uuid(), 0, 4);
                        $assocNameSlug = Str::slug($assoc->association_name ?? 'association');
                        // $newAssocDir = "{$newDir}/association";
                        $newAssocDir = "doctors/association";

                        // Pastikan folder association ada
                        $disk->makeDirectory($newAssocDir);

                        $newPath = "{$newAssocDir}/{$slug}_{$uuidSuffix}_{$assocNameSlug}.{$ext}";

                        // Hapus file lama jika sudah ada dengan nama sama (hindari tumpukan)
                        if ($disk->exists($newPath)) {
                            $disk->delete($newPath);
                        }

                        // Pindahkan file
                        if (str_starts_with($assoc->img, $oldDir)) {
                            $disk->move($assoc->img, $newPath);
                        } else {
                            // Jika path lama tidak di dalam oldDir (misalnya sudah custom)
                            $disk->copy($assoc->img, $newPath);
                            $disk->delete($assoc->img);
                        }

                        // Update path di database
                        $assoc->forceFill(['img' => $newPath])->saveQuietly();
                    }
                }

                // 4️⃣ Hapus folder lama setelah semua file dipindahkan
                if ($disk->exists($oldDir)) {
                    $disk->deleteDirectory($oldDir);
                }
            }
        });

        // ── Hapus folder doctor & associations saat delete ──
        static::deleting(function (Doctor $doctor) {
            $disk = Storage::disk('public');

            if ($doctor->slug && $disk->exists("doctors/{$doctor->slug}")) {
                $disk->deleteDirectory("doctors/{$doctor->slug}");
            }

            foreach ($doctor->associations as $assoc) {
                $assoc->deleteAssociationImage();
            }
        });
    }
}
