<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'category_id',
        'user_id',
        'is_public',
        'thumbnail_path'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'file_size' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'])
            ->useDisk('documents')
            ->singleFile();

        $this->addMediaCollection('thumbnails')
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->useDisk('public')
            ->singleFile();
    }
}
