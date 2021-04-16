<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotHistory extends Model
{
    public $table = 'lothistories';
    protected $primarykey = 'hId';
    public $incrementing = false;
    public $timestamps = true;


}
