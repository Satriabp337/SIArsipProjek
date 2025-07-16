<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Setting.php
class Setting extends Model
{
    protected $fillable = ['key', 'value'];
}

