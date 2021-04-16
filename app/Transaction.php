<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use Notifiable;
    public $table = 'transactions';
    protected $primaryKey = 'tid';
    public $timestamps = true;

    // public function images()
    // {
    //     return $this->hasMany('App\Panoimage','tid','tid');
    // }

    public function documents()
    {
        return $this->hasMany('App\Document','tid','tid');
    }

    public function user(){
        return $this->belongsTo("App\User",'user_fk','userId');
    }

}
