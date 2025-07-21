<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'sub_category',
        // 'department_id',
        // 'access_level',
        'description',
        'tags',
        'filename',
        'original_filename',
        'file_type',
        'file_size'
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    // public function department()
    // {
    //     return $this->belongsTo(Department::class);
    // }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    // public function departments()
    // {
    //     return $this->belongsTo(\App\Models\Department::class, 'department_id');
    // }
}
