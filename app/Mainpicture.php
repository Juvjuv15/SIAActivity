<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mainpicture extends Model
{
    public $table = 'mainpictures';
    protected $primaryKey = 'id';
    public $timestamps = false; 

    public function transaction()
    {
        return $this->belongsTo('App\sellLeasedTransaction','tid','tid');
    }

}
