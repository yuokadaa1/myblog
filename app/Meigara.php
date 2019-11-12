<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meigara extends Model
{
  protected $table = 'meigaras';
  protected $primaryKey = ['meigaraCode', 'meigaraCodeA' ,'date'];
  //ここのキータイプの操作方法未確認。
  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable= array('meigaraCode', 'meigaraCodeA' ,'date');


}
