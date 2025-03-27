<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,softDeletes;

    protected $table='products';

    protected $fillable = ['name' , 'category_id','code','description','stock','price','is_active'];
}
