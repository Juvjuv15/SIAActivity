<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotType extends Model
{   
    public $table = 'lottypes';
    protected $primaryKey='id';
    public $timestamps = false;
}
