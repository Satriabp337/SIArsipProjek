<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class audit extends Model
{
    use HasFactory;

        protected $fillable = [
        'doc_name',
        'user_name',
        'user_id',
        'user_email',
        'action',
        'details'
    ];
}
