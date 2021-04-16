<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panoimage extends Model
{
    public $table = 'panoimages';
    protected $primaryKey = 'panoId';
    public $timestamps = false; 


}
