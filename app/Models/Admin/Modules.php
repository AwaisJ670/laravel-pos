<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;

    protected $table = "modules";

    protected $fillable = [
        'id', 'name', 'route', 'head_name', 'icon', 'parent_id', 'order', 'is_active'
    ];

    public function modules()
    {
        return $this->hasMany(Modules::class, 'parent_id');
    }

    public function childrenModules()
    {
        return $this->hasMany(Modules::class, 'parent_id')->with('childrenModules');
    }

    public function parentModule()
    {
        return $this->belongsTo(Modules::class, 'parent_id');
    }
}
