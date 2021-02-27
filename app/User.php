<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles(){
        return $this->hasMany('App\Models\Article');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
    public function roles(){
        return $this->belongsToMany('App\Models\Role', 'role_user');
    }

    public function canDo($permission, $require = false){
       if(is_array($permission)){
            dump($permission);
       }else{
            //dump($this->roles);
           foreach($this->roles as $role){
               foreach($role->perms as $perm){
                  // dump($perm->name);
                    if(Str::is($perm->name, $permission)){
                        return true;
                    }
               }

           }
       }
       return false;
    }

}
