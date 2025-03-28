<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'inventory';

    protected $fillable = ['user_id', 'product_id', 'sale_id', 'price', 'quantity', 'amount'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
