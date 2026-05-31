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

class Soldproducts extends Component
{

    	use WithPagination;
      protected $paginationTheme = 'bootstrap';
	public $search="";
    	  
    public function render()
    {
    	 
    	 //check sold products
    	 $checks =DB::table('customer_properties')
    	 ->join('plots','plots.id','customer_properties.plot_id')
    	 ->where('customer_properties.unpaid_balance','<=',0)
    	 ->where('customer_properties.property_status','preown')->where('plots.status','!=','pending')->update( [
    	         'plots.status' => 'sold',
    	         'customer_properties.property_status'=> 'own',
    	         ]);
    
    	 
          
       $count=1; 
          $plots =DB::table('plots')
          ->join('products','products.id','plots.product_id')
          ->join('customer_properties','customer_properties.plot_id','plots.id')

          
          ->select('customer_properties.*','plots.*','products.*', 'plots.id as nplot_id','customer_properties.id as cp_id')

          ->where('plots.status','sold')
          ->where('plots.Plot_id', 'like', '%'.$this->search.'%')

           ->orWhere('plots.status','sold')
           ->where('plots.price', 'like', '%'.$this->search.'%')
                  ->orWhere('plots.status','sold')
           ->where('plots.price', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','sold')
           ->where('products.location_name', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','sold')
           ->where('plots.price', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','sold')
           ->where('products.no_of_plots', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','sold')
           ->where('products.state', 'like', '%'.$this->search.'%')
             ->orWhere('plots.status','sold')
           ->where('products.address', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','sold')
           ->where('products.town', 'like', '%'.$this->search.'%')
              ->orWhere('plots.status','sold')
           ->where('products.purpose', 'like', '%'.$this->search.'%')
             ->orWhere('plots.status','sold')
           ->where('customer_properties.customer_reg_no', 'like', '%'.$this->search.'%')


          ->orderBy('plots.created_at','DESC')->simplePaginate();
          
      
        return view('livewire.soldproducts')->with(compact('plots','count'));
    }
}
