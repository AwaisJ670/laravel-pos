<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory,softDeletes;

    protected $table = 'sales';

    protected $fillable = ['user_id','customer_id','amount','returned_date'];
}
