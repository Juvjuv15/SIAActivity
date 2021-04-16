<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Plotuser extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    public $table = 'systemusers';
    protected $primaryKey ='userid';
    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = [
        'fullname', 'address', 'email', 'password',
    ];

    protected $hidden =
        'password';
}
