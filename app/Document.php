<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $table = 'documents';
    protected $primaryKey = 'id';
    public $timestamps = false; 
}
