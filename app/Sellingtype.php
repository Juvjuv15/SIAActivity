<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sellingtype extends Model
{
    public $table = 'sellingtypes';
    protected $primaryKey='id';
    public $timestamps = false;
}
