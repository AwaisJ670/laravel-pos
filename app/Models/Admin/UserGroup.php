<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    protected $table = "user_groups";

    protected $fillable = [
        'id', 'name', 'assigned_modules', 'status', 'is_active'
    ];

    protected $casts = [
        'assigned_modules' => 'json'
    ];
}
