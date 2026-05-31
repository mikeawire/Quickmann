<?php

namespace App\Models;
use App\Models\PlotType;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Plot extends Model

{
    
    public function plottype()
    {
          return $this->hasOne(PlotType::class);
    } 
    public function product()
    {
          return $this->hasOne(Product::class);
    } 
}
