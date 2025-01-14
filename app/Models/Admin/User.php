<?php

namespace App\Models\Admin;

use App\Models\Admin\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','access_key', 'parent_id', 'first_name', 'last_name','dob', 'mobile', 'email', 'is_active','last_login', 'last_ip', 'image',
        'address','password','role_id','readable_password'
    ];


    public function role(){
        return $this->belongsTo(Role::class , 'role_id','id')->select('id','name');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'readable_password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
