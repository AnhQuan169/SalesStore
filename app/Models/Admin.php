<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Admin extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'admin_mail','admin_password','admin_name','admin_phone'
    ];
    protected $primaryKey = 'admin_id';
    protected $table = 'tbl_admin';

    // public function roles(){
    //     return $this->belongsToMany('App\Models\Roles');
    // }

    public function getAuthPassword(){
        return $this->admin_password;
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Roles');
    }

    public function hasAbyRoles($roles){
        return null !== $this->roles()->where('name',$roles)->first();
    }

    public function hasRole($role){
        return null !== $this->roles()->where('name',$role)->first();
    }
}
