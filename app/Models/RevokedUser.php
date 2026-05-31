<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevokedUser extends Model
{
    public function user()
    {
          return $this->hasOne(User::class);
    }
}
