<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['body'];

    //comment->post を可能にする。
    public function post(){
      return $this->belongsTo('App\Post');
    }
}
