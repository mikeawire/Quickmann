<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Plot;
class Deposit extends Model
{

    
    public function user()
    {
          return $this->hasOne(User::class);
    }
}
