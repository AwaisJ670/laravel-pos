<?php

namespace App\Models\Admin;

use App\Models\Admin\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,softDeletes;

    protected $table='products';

    protected $fillable = ['name' , 'category_id','code','description','stock','price','is_active'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
