<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
class Admin extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    
    public $table = 'admins';
    protected $primaryKey ='admin_id';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['id','type','data','notifiable_type','notifiable_id','lotid','userid','content'];

}
