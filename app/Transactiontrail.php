<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transactiontrail extends Model
{
    use Notifiable;
    public $table='transactiontrails';
    protected $primarykey='trailId';
    public $timestamps = true;
}
