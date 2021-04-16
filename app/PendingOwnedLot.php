<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingOwnedLot extends Model
{
    public $table = 'pendingOwnedLots';
    public $incrementing=true;
    public $timestamps = true; 
}
