<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

use App\Models\CustomerProperty;
use App\Models\CustomerProfile;
use App\Models\Product;
use App\Models\Plot;
use App\Models\StaffProfile;

use App\Models\PlotType;
use DB;

class BDMController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');
       
    }
    
    
     public function dro()
    
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
             elseif(Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='ABDM' || Auth::user()->staffprofile->role =='ABDO')
             {
               $count=1;
        $dros = StaffProfile::where('designated_state',Auth::user()->staffprofile->designated_state)->where('role','DRO')->orderBy('created_at','DESC')->simplePaginate();
        
        return view('Staff/BDM/DRO/index')->with(compact('dros','count'));  
             }
             
               elseif(Auth::user()->staffprofile->role =='HBDM')
             {
               $count=1;
        $dros = StaffProfile::where('role','DRO')->orderBy('created_at','DESC')->simplePaginate();
        
        return view('Staff/BDM/DRO/index')->with(compact('dros','count'));  
             }

                elseif(Auth::user()->staffprofile->role =='MD' )
             {
               $count=1;
        $dros = StaffProfile::where('role','DRO')->orderBy('created_at','DESC')->simplePaginate();
        
        return view('Staff/BDM/DRO/index')->with(compact('dros','count'));  
             }


       else
       {
           return redirect('/home');
       }
    }
    
    
     public function dro_hbdm($id)
    
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
             elseif(Auth::user()->staffprofile->role =='HBDM' )
             {
               $count=1;
        $dros = StaffProfile::where('designated_state',$id)->where('role','DRO')->orderBy('created_at','DESC')->simplePaginate();
        
        return view('Staff/BDM/DRO/index')->with(compact('dros','count'));  
             }
             


       else
       {
           return redirect('/home');
       }
    }
    
    
     public function dro_show($id)
    
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
             elseif(Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='MD' || Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='ABDO' || Auth::user()->staffprofile->role =='ABDM')
             {
             $staff= User::findOrFail($id);
      
        
        return view('Staff/BDM/DRO/show')->with(compact('staff'));  
             }
             
          
       else
       {
           return redirect('/home');
       }
    }
    
    
      public function dro_customer($id)
    
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
             elseif(Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='MD' || Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='ABDO' || Auth::user()->staffprofile->role =='ABDM')
             {
                 $count=1;
                 $staff = User::findOrFail($id);
                 
       
           // $customers =CustomerProfile::where('dro_id',$staff->id)->simplePaginate();
                 $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*')
        ->where('users.user_status','active')

        ->where('users.user_type','customer')
        ->where('customer_profiles.dro_id',$staff->id)
        ->orderBy('users.created_at','DESC')
        ->simplePaginate(50);
     
        return view('Staff/BDM/Customer/index')->with(compact('customers','count'));  
             }
             
          
       else
       {
           return redirect('/home');
       }
    }
    
    
    
      public function dro_customer_product($id)
    
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
             elseif(Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='MD' || Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='DRO' || Auth::user()->staffprofile->role =='ABDO' || Auth::user()->staffprofile->role =='ABDM')
             {
                 $count=1;
        $plot =Plot::findOrFail($id);
        
           $product=Product::find($plot->product_id);
    
     $brand=PlotType::find($plot->plot_type_id);
     
       $customerproperties=CustomerProperty::where('plot_id',$plot->id)->get() ;
       
       foreach($customerproperties as $cp)


{
    $user =User::findOrFail($cp->customer_id);
}
        
        return view('Staff/BDM/Customer/show')->with(compact('plot','brand','product','cp','user')); 
             }
             
          
       else
       {
           return redirect('/home');
       }
    }
    
    
    
      public function bdmsales()
    
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

             elseif(Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='MD' || Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='ABDO' || Auth::user()->staffprofile->role =='ABDM')
             {
                 
                 $count=1;
                $customerproperties = CustomerProperty::where('state',Auth::user()->staffprofile->designated_state)->orderBy('created_at','DESC')->simplePaginate();
     
        return view('Staff/BDM/sales/index')->with(compact('customerproperties','count'));  
             }
             
               elseif(Auth::user()->staffprofile->role =='DRO' )
             {
                 
                 $count=1;
                $customerproperties = CustomerProperty::where('dro_reg_no',Auth::user()->staffprofile->reg_no)->simplePaginate();
     
        return view('Staff/BDM/Customer/index')->with(compact('customerproperties','count'));  
             }
             
          
       else
       {
           return redirect('/home');
       }
    }
    
    
      public function bdmcustomers()
    
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
             elseif(Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='MD' || Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='ABDO' || Auth::user()->staffprofile->role =='ABDM')
             {
                 $count=1;
               
                 
       
          //$customers = CustomerProfile::where('branch_id',Auth::user()->staffprofile->branch_id)->orderBy('created_at','DESC')->simplePaginate();

                 $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*')
        ->where('users.user_status','active')

        ->where('users.user_type','customer')
        ->where('customer_profiles.branch_id',Auth::user()->staffprofile->branch_id)
        ->orderBy('users.created_at','DESC')
        ->simplePaginate(50);
     
     
        return view('Staff/BDM/Branch/index')->with(compact('customers','count'));  
             }
             
          
       else
       {
           return redirect('/home');
       }
    }
    
      public function bdmcustomers_show($id)
    
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
             elseif(Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='MD' || Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='ABDO' || Auth::user()->staffprofile->role =='ABDM')
             {
                 $count=1;
               
                 
       
          $customer = User::findOrFail($id);
     
        return view('Staff/BDM/Branch/show')->with(compact('customer','count'));  
             }
             
          
       else
       {
           return redirect('/home');
       }
    }
    
}
