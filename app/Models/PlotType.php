<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plot;
class PlotType extends Model
{
    public function plot()
    {
          return $this->hasMany(Plot::class);
    } 
}
