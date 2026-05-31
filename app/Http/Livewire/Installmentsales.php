<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Http\Request;
use App\User;
use App\Models\Plot;
use App\Models\PlotType;
use App\Models\Product;
use App\Models\Deposit;
use App\Models\CustomerProperty;
use App\Models\StaffProfile;
use DB;

class Installmentsales extends Component
{
    
    	use WithPagination;
      protected $paginationTheme = 'bootstrap';
	public $search="";
    	  


public function render()
{
          
    	 $count=1;
          $plots =DB::table('plots')
          ->join('products','products.id','plots.product_id')
          ->join('customer_properties','customer_properties.plot_id','plots.id')

          
          ->select('customer_properties.*','plots.*','products.*', 'plots.id as nplot_id','customer_properties.id as cp_id')

          ->where('plots.status','pending')
          ->where('plots.Plot_id', 'like', '%'.$this->search.'%')

           ->orWhere('plots.status','pending')
           ->where('plots.price', 'like', '%'.$this->search.'%')
                  ->orWhere('plots.status','pending')
           ->where('plots.price', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','pending')
           ->where('products.location_name', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','pending')
           ->where('plots.price', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','pending')
           ->where('products.no_of_plots', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','pending')
           ->where('products.state', 'like', '%'.$this->search.'%')
             ->orWhere('plots.status','pending')
           ->where('products.address', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','pending')
           ->where('products.town', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','pending')
           ->where('products.purpose', 'like', '%'.$this->search.'%')
             ->orWhere('plots.status','pending')
           ->where('customer_properties.customer_reg_no', 'like', '%'.$this->search.'%')


          ->orderBy('plots.created_at','DESC')->simplePaginate();

          
      
           return view('livewire.installmentsales')->with(compact('plots','count'));
    }
}
