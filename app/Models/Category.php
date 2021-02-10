<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id', 'alias', 'title', 'keywords', 'meta_desc'];
    public function articles(){
        return $this->hasMany('App\Models\Article');
    }
}
