<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'customers';

    protected $fillable = ['name', 'phone', 'email', 'payment_method'];

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
