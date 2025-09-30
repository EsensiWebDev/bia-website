<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    // Define which fields can be mass-assigned
    protected $fillable = [
        'title',
        'slug',
        'category',
        'author',
        'thumbnail',
        'thumbnail_alt_text',
        'content',
        'is_published',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'publish_date',
    ];
}
