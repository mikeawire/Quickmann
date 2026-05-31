<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
     protected $guarded=[];
     
    protected $casts = [
        'duration' => 'integer',
    ];
}
