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
use App\Transaction;
use Session;
class HBDMController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
       
    }


    //FETCH BDO 1

    public function bdo()
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
               $count=1;
        $bdos= StaffProfile::where('role','BDO')->orderBy('created_at','DESC')->simplePaginate();
        
        return view('Staff/HBDM/BDO/index')->with(compact('bdos','count'));  
             }
       else
       {
           return redirect('/home');
       }
    }

//FETCH BDM 2
        public function bdm()
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
               $count=1;
        $bdms= StaffProfile::where('role','BDM')->orderBy('created_at','DESC')->simplePaginate();
        
        return view('Staff/HBDM/BDM/index')->with(compact('bdms','count'));  
             }
       else
       {
           return redirect('/home');
       }
    }

//SHOW BDO PROFILE 3
        public function show_bdo($id)
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
            
        $staff= User::FindOrFail($id);
if($staff->staffprofile->role !='BDO')
{
  return redirect('/home');

}
  
  else
  {
    return view('Staff/HBDM/BDO/show')->with(compact('staff')); 
  }      
         
             }
       else
       {
           return redirect('/home');
       }
    }

    //SHOW BDM PROFILE 4
        public function show_bdm($id)
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
            
        $staff= User::FindOrFail($id);
if($staff->staffprofile->role !='BDM')
{
  return redirect('/home');

}
  
  else
  {
    return view('Staff/HBDM/BDM/show')->with(compact('staff')); 
  }      
         
             }
       else
       {
           return redirect('/home');
       }
    }



    //Fetch Search Customers 5
        public function search_by_state()
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
            
    $count=1;
if(Session::get('state3'))
{
  $state3=Session::get('state3');

if($state3 =='all')
{
 $customers =CustomerProfile::orderBy('designated_state','ASC')->simplePaginate();
}
else
{
    $customers =CustomerProfile::where('designated_state',$state3)->orderBy('designated_state','ASC')->simplePaginate(20);
}

 
}

    else
    {
      $customers =CustomerProfile::orderBy('designated_state','ASC')->simplePaginate();
    }
        

       return view('Staff/HBDM/Customers/create')->with(compact('customers','count')); 
        
         
             }
       else
       {
           return redirect('/home');
       }
    }


     public function customers_by_state(Request $request)
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
            
               $request->validate([
           
            'state' => 'required',
            
          
            
        ]);
    $count=1;
 $step3 =Session::put('state3',$request->state);

       return redirect('/hbdmcustomerslist');
        
         
             }
       else
       {
           return redirect('/home');
       }
    }

   



    //ShowCustomers profile 7
        public function show_customer_profile($id)
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
            $count=1;
        $customer =User::FindOrFail($id);

if($customer->user_type !='customer')
{
  return redirect('/home');
}
else

{
     return view('Staff/HBDM/Customers/show')->with(compact('customer')); 
}
 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }


     //Show ALL sales 8
        public function show_sales()
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
          
            if(Session::get('state_n'))

{

 

 $state_n =Session::get('state_n');
 if($state_n=='all')
 {

  $sales =CustomerProperty::simplePaginate(20);
 }
 else
 {
   $sales =CustomerProperty::where('state',$state)->simplePaginate(20);
 }


}
else
{


  $sales =CustomerProperty::simplePaginate(20);
}
        
 $count=1;

 return view('Staff/HBDM/Sales/index')->with(compact('sales','count')); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }


     //Show ALL sales 10
        public function show_sales_details($id)
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
            $count=1;
        $sale =CustomerProperty::FindOrFail($id);


 return view('Staff/BDM/Sales/create')->with(compact('Sale')); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }


     //Show ALL sales 10
        public function show_sales_by_state(Request $request)
    
    {
       
          $request->validate([
           
            'state' => 'required',
              'month' => 'required',
          
            
        ]);
       
 
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM')
             {
          $state_n =Session::put('state_n',$request->state);


 return redirect('/hbdmsales'); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }


     //Transaction accross the states 11
        public function transaction_all()
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='HOR')
             {
            $count=1;
            if(Session::get('state'))
            {
              $month=Session::get('month');
              $month = date('Y-m-01',strtotime($month));
              $month=Carbon::parse($month);
            
              $state=Session::get('state');
 if($state =='all')
            {
                
              $transactions =Transaction::whereMonth('updated_at','=',$month)->whereYear('updated_at','=',$month)->simplePaginate(); 
             
            }
            else

            {
               $transactions =Transaction::whereMonth('updated_at','=',$month)->where('state',$state)->whereYear('updated_at','=',$month)->where('state',$state)->simplePaginate(20);
            }
            }
            else
            {
               $transactions =Transaction::orderBy('state','DESC')->simplePaginate(20);

            }
       

 return view('Staff/HBDM/Transaction/index')->with(compact('transactions','count')); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }


     //Transaction accross the states 11
        public function transaction_create()
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='HOR')
             {
          $newdate =Session::forget('newdate');
            $state =Session::forget('state');

 return view('Staff/HBDM/Transaction/create'); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }


     //Transaction accross each state 12
        public function transaction(Request $request)
    
    {

       $request->validate([
           
            'state' => 'required',
              'month' => 'required',
          
            
        ]);
       
       
 
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='HOR')
             {
            $count=1;

            Session::put('state',$request->state);
            Session::put('month',$request->month);
           
       


 return redirect('/transaction'); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }



     //show Transaction details 13
        public function show_transaction($id)
    
    {

       $request->validate([
           
            'state' => 'required',
          
            
        ]);
       
       
 
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='HOR')
             {
            
        $transaction =Transaction::FindOrFail($id);
$properties=CustomerProperty::where('customer_id',$transaction->user_id)->where('plot_id',$transaction->plot_id)->get();

foreach ($properties as $prop) {
  $MonthlyRecords =MonthlyRecord::where('customerproperty_id',$prop->id)->where('user_id',$transaction->user_id)->get();
  # code...
}

 return view('Staff/BDM/Transaction/show')->with(compact('transaction','properties','MonthlyRecords'));

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }


     //show Transaction details 13
        public function defaulters_create()
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO'  ||  Auth::user()->staffprofile->role =='HOR'||  Auth::user()->staffprofile->role =='CMO' || Auth::user()->staffprofile->role =='FDO' || Auth::user()->staffprofile->role =='CD')
             {
          $newdate2 =Session::forget('newdate2');
            $state2 =Session::forget('state2');
 return view('Staff/HBDM/Defaulters/create');

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }

     //show Transaction details 13
        public function defaulters_all()
    
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO'  ||  Auth::user()->staffprofile->role =='HOR' ||  Auth::user()->staffprofile->role =='CMO' || Auth::user()->staffprofile->role =='FDO' || Auth::user()->staffprofile->role =='CD' )
             {
              $count =1;
         if(Session::get('newdate2'))
         {
          $newdate2 =Session::get('newdate2');
            $state2 =Session::get('state2');
           if($state2 =='all')
                {

                 
                 $defaulters =MonthlyRecord::where('status','pending')->whereDate('month','=', $newdate2)->orderBy('state','ASC')->simplePaginate(20);
                 
                 $counting =MonthlyRecord::where('status','pending')->whereDate('month','=', $newdate2)->orderBy('state','ASC')->get();
               

                }
                else

                {
                   $defaulters =MonthlyRecord::where('status','pending')->whereDate('month',$newdate2)->whereYear('month',$newdate2)->where('state',$state2)->orderBy('state','ASC')->simplePaginate(20);

                      $counting =MonthlyRecord::where('status','pending')->whereDate('month',$newdate2)->where('state',$state2)->orderBy('state','ASC')->get();
                }


         }
         else
         {
           $defaulters =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->orderBy('state','ASC')->simplePaginate();
           $counting =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->orderBy('state','ASC')->get();
               $newdate2 =Session::forget('newdate2');
            $state2 =Session::forget('state2');
            $state2 =Session::put('state2','all');
         }
       


 return view('Staff/HBDM/Defaulters/index')->with(compact('defaulters','count','counting')); 

 
       
         
             }
             
               elseif(Auth::user()->staffprofile->role =='DRO' || Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='ABDM' || Auth::user()->staffprofile->role =='ABDO' )
             {
                 $users= CustomerProfile::where('dro_id',Auth::user()->id)->get();
                  if($users->count() > 0)
                 
                 {
                  
                 foreach($users as $user)
                 {
                     $count=1;
                      $defaulters =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->simplePaginate();
           $counting =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->get();
              $state2 =Session::put('state2','all');
                 }
                  return view('Staff/HBDM/Defaulters/index')->with(compact('defaulters','count','counting')); 
                 }
                 else
                 {
                     echo'<script>alert("No Defaulter Found")</script>';
                      echo'<script>window.location.replace("/home")</script>';
                     
                 }
             }
             
              elseif(Auth::user()->staffprofile->role =='EA' )
             {
                 $users= CustomerProfile::where('ea_id',Auth::user()->id)->orWhere('dro_id',Auth::user()->id)->get();
                 
                 if($users->count() > 0)
                 
                 {
                     
                 
                 foreach($users as $user)
                 {
                     $count=1;
                      $defaulters =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->simplePaginate();
           $counting =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->get();
              $state2 =Session::put('state2','all');
                 }
                
                  return view('Staff/HBDM/Defaulters/index')->with(compact('defaulters','count','counting')); 
                  
                 }
                 else
                 {
                     echo'<script>alert("No Defaulter Found")</script>';
                      echo'<script>window.location.replace("/home")</script>';
                     
                 }
             }
             
              elseif(Auth::user()->staffprofile->role =='PM' )
             {
                 $users= CustomerProfile::where('po_id',Auth::user()->id)->orWhere('dro_id',Auth::user()->id)->get();
                     if($users->count() > 0)
                 
                 {
                 foreach($users as $user)
                 {
                     $count=1;
                      $defaulters =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->simplePaginate();
           $counting =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->get();
              $state2 =Session::put('state2','all');
                 }
                  return view('Staff/HBDM/Defaulters/index')->with(compact('defaulters','count','counting')); 
                    
                 }
                 else
                 {
                     echo'<script>alert("No Defaulter Found")</script>';
                      echo'<script>window.location.replace("/home")</script>';
                     
                 }
             }
              elseif(Auth::user()->staffprofile->role =='AHO' )
             {
                 $users= CustomerProfile::where('aho_id',Auth::user()->id)->orWhere('dro_id',Auth::user()->id)->get();
                     if($users->count() > 0)
                 
                 {
                 foreach($users as $user)
                 {
                     $count=1;
                      $defaulters =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->simplePaginate();
           $counting =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->get();
              $state2 =Session::put('state2','all');
                 }
                  return view('Staff/HBDM/Defaulters/index')->with(compact('defaulters','count','counting')); 
                    
                 }
                 else
                 {
                     echo'<script>alert("No Defaulter Found")</script>';
                      echo'<script>window.location.replace("/home")</script>';
                     
                 }
             }
             
              elseif(Auth::user()->staffprofile->role =='TSO' || Auth::user()->staffprofile->role =='SO'  || Auth::user()->staffprofile->role =='AO')
             {
                 $users= CustomerProfile::where('dro_id',Auth::user()->id)->get();
                     if($users->count() > 0)
                 
                 {
                 foreach($users as $user)
                 {
                     $count=1;
                      $defaulters =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->simplePaginate();
           $counting =MonthlyRecord::where('status','pending')->whereDate('month','<',Carbon::now()->firstOfMonth())->where('user_id',$user->user_id)->orderBy('state','ASC')->get();
              $state2 =Session::put('state2','all');
                 }
                  return view('Staff/HBDM/Defaulters/index')->with(compact('defaulters','count','counting')); 
                    
                 }
                 else
                 {
                     echo'<script>alert("No Defaulter Found")</script>';
                      echo'<script>window.location.replace("/home")</script>';
                     
                 }
             }
       else
       {
           return redirect('/home');
       }
    }

    
     //show Transaction details 13
        public function defaulters(Request $request)
    
    {

       $request->validate([
           
            'state' => 'required',
            'month' => 'required',
          
            
        ]);
       

       
 
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
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO'  ||  Auth::user()->staffprofile->role =='HOR'||  Auth::user()->staffprofile->role =='CMO' || Auth::user()->staffprofile->role =='FDO' || Auth::user()->staffprofile->role =='CD')
             {


              if($request->month >= date('Y-m'))
              {
              return back()->with('warning_msg','You cannot get defaulters Records with the selected month');
              }
              else
              {
                       $date=$request->month;
$newdate =date('Y-m-01',strtotime($date));

              $state2=Session::put('state2',$request->state);
                  $newdate2=Session::put('newdate2',$newdate);
                
               
         




           


               
              }
          
        


 return redirect('/defaulters'); 

   
       
         
             }
       else
       {
           return redirect('/home');
       }
    }
}
