<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waiting extends Model
{
    protected $fillable = [
        'name','latitude','longitude'
    ];

    protected $table = 'waiting';

    public $timestamps = false;
}
