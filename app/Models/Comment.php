<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // один ко многим
    public function article(){
        return $this->belongsTo('App\Models\Article');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
