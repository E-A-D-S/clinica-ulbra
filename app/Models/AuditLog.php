<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'user_email', 'user_role',
        'action', 'subject_type', 'subject_id', 'description', 'ip', 'is_demo',
    ];

    protected $casts = [
        'is_demo' => 'boolean',
    ];
}
