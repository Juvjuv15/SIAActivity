<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Uuids;
class Lot extends Model
{
    // 
    protected $primaryKey='lotId';
    protected $fillable=['lotNumber'];
    public $incrementing = false;
    public $timestamps = false;

    public function images()
    {
        return $this->hasMany('App\Panoimage','lotId_fk','lotId');
    }
}
