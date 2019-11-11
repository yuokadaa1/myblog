<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeigaraList extends Model
{
  protected $table = 'meigara_lists';
  protected $primaryKey = 'meigaraCode';
  protected $keyType = 'smallInteger';
  public $incrementing = false;

}
