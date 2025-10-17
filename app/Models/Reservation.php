<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'reservations';
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'preferred_date',
        'preferred_time',
        'required_service',
        'country_of_origin',
        'how_did_you_find_out',
        'message',
        'submit_date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
            $model->submit_date = now();
        });
    }
}
