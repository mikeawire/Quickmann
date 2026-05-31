<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Plot;
use App\Models\PlotType;
use App\Models\CustomerProfile;
use App\Models\CustomerProperty;
use App\Models\StaffProfile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\MonthlyRecord;
use App\Branch;
use App\User;
use DB;
class PlotController extends Controller
{
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        
        
         if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif(Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO'
          )
          
          {
              
     
      
        $products=Product::all();
        $brands = PlotType::all();
        return view('/Staff/Property/Plot/create')->with(compact('brands','products'));
          }
    
        else
        {
           return redirect('/home');
        }
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           
            'location_name' => 'required',
            'plot_id' => 'required',
            'brand' => 'required',
            'no_of_plots' => 'required',
            'sqm' => 'required',
              'sqm' => 'required',
              'price' => 'required',
          
            
        ]);
    

        $plot = new Plot;
        $plot->Plot_id =$request->plot_id;
        $plot->product_id =$request->location_name;
        $plot->plot_type_id =$request->brand;
        $plot->price =$request->price;
        $plot->no_of_plots=$request->no_of_plots;
        $plot->sqm =$request->sqm;
        $plot->description =$request->description;
        $plot->save(); 
        $product= Product::find($request->location_name);
        $product->sqm = $product->sqm +$request->sqm;
        $product->no_of_plots =   $product->no_of_plots +   $request->no_of_plots;
        $product->save();
        return back()->with('success_msg','Added Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {
      
      
         if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif( Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO'  ||  Auth::user()->staffprofile->role =='CMO'
          )
          
          {
              
     
            $plot = Plot::find($id);
        $product=Product::find($plot->product_id);
        $brand = PlotType::find($plot->plot_type_id);
        $customers =CustomerProfile::orderBy('surname','ASC')->get();
        
        $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*','customer_profiles.id as id','users.id as user_id')
       ->where('users.user_status','active')
        ->where('users.user_type','customer')->orderBy('customer_profiles.surname','ASC')->get();
        
         $staffs =StaffProfile::orderBy('surname','ASC')->get();
         
         

        return view('/Staff/Property/Plot/show')->with(compact('brand','product','plot','customers','staffs'));
          }
    
        else
        {
           return redirect('/home');
        }
 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
          if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif( Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO'
          )
          
          {
              
     
             $products=Product::all();
        $brands = PlotType::all();
        $plot =Plot::find($id);
        return view('/Staff/Property/Plot/edit')->with(compact('plot','products','brands'));
          }
    
        else
        {
           return redirect('/home');
        }
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
           
            'location_name' => 'required',
            'plot_id' => 'required',
            'brand' => 'required',
            'no_of_plots' => 'required',
            'sqm' => 'required',
              'sqm' => 'required',
              'price' => 'required',
          
            
        ]);
    

        $plot = Plot::find($id);
         
        $product= Product::find($request->location_name);
        $product->sqm = $product->sqm + $request->sqm -  $plot->sqm;
        $product->no_of_plots =   $product->no_of_plots +   $request->no_of_plots - $plot->no_of_plots;
        $product->save();

        $plot->Plot_id =$request->plot_id;
        $plot->product_id =$request->location_name;
        $plot->plot_type_id =$request->brand;
        $plot->price =$request->price;
        $plot->no_of_plots=$request->no_of_plots;
        $plot->sqm =$request->sqm;
        $plot->description =$request->description;
        $plot->save(); 
       
        return back()->with('success_msg','Edited Successful');
    }


//get customer

public function get_customer(Request $request)
{
    $customers =CustomerProfile::where('reg_no',$request->id)->get();
    foreach($customers as $customer)
    {
        return strtoupper($customer->surname).' '.strtoupper($customer->first_name).' '.strtoupper($customer->othername);
    }
}


public function get_dro(Request $request)
{
    $staffs =StaffProfile::where('reg_no',$request->id)->get();
    foreach($staffs as $staff)
    {
        return strtoupper($staff->surname).' '.strtoupper($staff->first_name).' '.strtoupper($staff->othername);
    }
}
//get dro

//sale property
    public function saleProperty(Request $request)


    {
  
          if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif( Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
             
             
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='CMO'
          )
          
          {
              
     
      if($request->payment_mode =='outright' ||  $request->payment_mode ==null)
        {
        $request->validate([
           
       
            'plot_id' => 'required',
        
            'dro_id' => 'required',
        
              'customer_id' => 'required',
              

              'payment_mode' => 'required',
          
            
        ]);

        

    }
    else{

        $request->validate([
           
          'dro_id' => 'required',
            'plot_id' => 'required',
        
              'initial_payment' => 'required','numeric',

              'monthly_payment' => 'required','numeric',
              'customer_id' => 'required',
              

              'payment_mode' => 'required',
          
            
        ]);

    }
      
        $plot=Plot::find($request->plot_id);
     
        if($plot->status =='sold' || $plot->status =='pending')
        {
return back()->with('warning_msg', 'property not available');


        }
        else
        {
       $customers =CustomerProfile::where('reg_no',$request->customer_id)->get();
       if($customers->count() ==0)

       return back()->with('warning_msg', 'Not a register customer');

       else
      foreach($customers as $customer)
      {
        $dro =User::find($request->dro_id);

       // if($dros->count() ==0)

        //return back()->with('warning_msg', 'Not a register D.R.O');
 
        //else 

  $no_of_inst = ($plot->price - $request->initial_payment);

$no_of_inst =$no_of_inst/$request->monthly_payment;
      $r =round($no_of_inst);
      
      if(($no_of_inst - $r) > 0)
      {
          $rw = $r +1;
      }
      else
      {
          $rw =$r;
      }
    
         
     

   $branch =Branch::find($customer->branch_id);

     $user =User::find($customer->user_id);

     $property = new CustomerProperty;
     $property->customer_id = $customer->user_id;
     $property->customer_reg_no = $request->customer_id;
     $property->dro_reg_no = $dro->staffProfile->reg_no ?? "";
     $property->plot_id = $request->plot_id;
     $property->initial_deposit = $request->initial_payment;
     $property->monthly_payment = $request->monthly_payment;
     $property->no_of_installment = $rw;
     $property->branch_id = $branch->id;
     $property->state = $customer->designated_state;

     $property->no_of_remaining_installment = $rw;

  
     $property->payment_type = $request->payment_mode;
     $property->property_price = $plot->price;
       $property->total_amount_paid = $request->initial_payment;
     $property->unpaid_balance = $plot->price - $request->initial_payment;
     $property->save();
     
$dt      = Carbon::now();
$rw =intval($rw) +1;

$dts = $dt->addMonths($rw);
 
    $dates = [];

    for($date = Carbon::now()->addMonth(); $date->lte($dts); $date->addMonths()) {


        $dates[] = $date->format('Y-m-01');
      
        


    }
   
 
   
 $month_records = [];
 
 foreach($dates as $date)
       {
           
             $month_records[] = [
                    'user_id' =>$customer->user_id,
                    'customerproperty_id' => $property->id,
                    'month' => $date,
                    'month' => $date,
                    'fullname' => $customer->surname.' '.$customer->first_name.' '.$customer->othername,
                    'email' =>  $user->email,
                    'phone' =>  $user->phone,
                    'amount_due' =>  $request->monthly_payment,
                    'branch' =>$branch->name,
                    'state' => $customer->designated_state,
                    
                    'updated_at' => $dt,  // remove if not sing timestamps
                    'created_at' => $dt   // remove if not using timestamps
                ];
       


       }

$mrs=MonthlyRecord::insert($month_records);

if($property->unpaid_balance <=0)
{
    $bstatus ='sold';
}
else
{
    $bstatus='pending';
}
     
     $plot->status =$bstatus;
     $plot->save();
     $product = Product::find($plot->product_id);
     $product->sqm = $product->sqm - $plot->sqm;
     $product->no_of_plots = $product->no_of_plots - $plot->no_of_plots;
     $product->save();
     

     return back()->with('success_msg', 'Property have been issued to the customer');


      
      }
       
        }
    

    
          }
    
        else
        {
           return redirect('/home');
        }
    

       
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

// find plot
        $plot =Plot::findOrFail($id);
//find loctaion 
        $product =Product::findOrFail($plot->product_id);
        //subtract sqm and no of plots
        $product->sqm =  $product->sqm - $plot->sqm;
         $product->no_of_plots =  $product->no_of_plots - $plot->no_of_plots;
          $product->save();
          $plot->delete();

        return back()->with('success_msg','deleted Successful');
    }
}
