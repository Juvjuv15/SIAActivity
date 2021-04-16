<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricerange extends Model
{
    protected $primarykey='rangeId';
    public $incrementing=true;
    public $timestamps = false;
}
