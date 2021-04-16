<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $primarykey='contractid';
    public $incrementing=true;
    public $timestamps = false;
}
