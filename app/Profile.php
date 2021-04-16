<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $table = 'profiles';
    protected $primaryKey = 'profileId';
    public $timestamps = false; 

    // public function user()
    // {
    //     return $this->belongsTo('App\User','user_fk','id');
    // }

}
