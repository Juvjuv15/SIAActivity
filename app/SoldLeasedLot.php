<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldLeasedLot extends Model
{
    public $table = 'soldleasedlots';
    protected $primaryKey='soldleased_id';
    public $timestamps = false;
}
