<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";

    protected $fillable = [
        'id', 'name', 'permissions', 'status', 'is_active'
    ];

    protected $casts = [
        'permissions' => 'json'
    ];
}
