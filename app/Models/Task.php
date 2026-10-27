<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'status',
        'position',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];
}
