<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Plot;
use App\Models\PlotType;
use App\Models\Product;
use App\Models\Deposit;
use App\Models\CustomerProperty;
use App\Models\StaffProfile;
class StaffPropertyController extends Controller
{
      protected $guarded = ['id'];
      
        public function __construct()
    {
        $this->middleware('auth');
    }
  
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
          
      
               return view('/Staff/product/sold/index');
    }

 public function install_index()
    {
      
      
               return view('/Staff/product/installment/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $count=1;
        $plot =Plot::findOrFail($id);
        
           $product=Product::find($plot->product_id);
    
     $brand=PlotType::find($plot->plot_type_id);
     
       $customerproperties=CustomerProperty::where('plot_id',$plot->id)->get() ;
       
       foreach($customerproperties as $cp)


{
       $staffs =StaffProfile::where('reg_no',$cp->dro_reg_no)->get();  
    $user =User::findOrFail($cp->customer_id);
}
        
        return view('/Staff/product/sold/show')->with(compact('plot','brand','product','cp','user','staffs'));
        
        
    }
    
       public function install_show($id)
    {
            $count=1;
        $plot =Plot::findOrFail($id);
        
           $product=Product::find($plot->product_id);
    
     $brand=PlotType::find($plot->plot_type_id);
     
       $customerproperties=CustomerProperty::where('plot_id',$plot->id)->get() ;
       
       foreach($customerproperties as $cp)


{
  
    $staffs =StaffProfile::where('reg_no',$cp->dro_reg_no)->get();
     
    $user =User::findOrFail($cp->customer_id);
}
        
        return view('/Staff/product/installment/show')->with(compact('plot','brand','product','cp','user','staffs'));
        
        
    }
    
       public function deposit_history($id)
       
    {
        $count=1;
        $deposits=Deposit::where('customer_property_id',$id)->simplePaginate();
        
        return view('/Staff/product/sold/deposit')->with(compact('deposits','count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function install_edit($id)
    {
       $count=1;
        $plot =Plot::findOrFail($id);
        
           $product=Product::find($plot->product_id);
    
     $brand=PlotType::find($plot->plot_type_id);
     
       $cp=CustomerProperty::where('plot_id',$plot->id)->first();
       
     



  
    $staffs =StaffProfile::where('reg_no',$cp->dro_reg_no)->get();
     
    $user =User::findOrFail($cp->customer_id);
        
        return view('/Staff/product/installment/edit')->with(compact('plot','brand','product','cp','user','staffs'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function install_update(Request $request, $id)
    {
         $cp=CustomerProperty::find($id);
        
         $d=$cp->property_price - $request->price;
       
           $cp->unpaid_balance = $cp->unpaid_balance - $d;
           $cp->property_price =$request->price;
           $cp->save();

         $plot =Plot::findOrFail($cp->plot_id);
          $plot->price =$request->price;
         $plot->save();
          
 return back()->with('success_msg','Update Successful'); 
              }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
