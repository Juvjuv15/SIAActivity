<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use Notifiable;
    public $table = 'notifications';
    protected $primaryKey='id';


    protected $fillable = ['type','tid_fk','notifiable_type','notifiable_id','data'];
}
