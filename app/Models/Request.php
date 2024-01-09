<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_RESOLVED = 'resolved';

    protected $fillable = [
        'name',
        'email',
        'status',
        'message',
        'comment',
    ];

    protected $hidden = [];

    protected $casts = [];
}
