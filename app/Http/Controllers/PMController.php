<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use App\Models\CustomerProperty;
use App\Models\CustomerProfile;
use App\Models\Product;
use App\Models\Plot;

use App\Models\PlotType;



class PMController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
       
    }
    public function product($id)
    
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
             elseif(Auth::user()->staffprofile->role =='PM' || Auth::user()->staffprofile->role =='DRO' ||  Auth::user()->staffprofile->role =='EA' ||  Auth::user()->staffprofile->role =='AHO')
             {
               $count=1;
        $customerproperties = CustomerProperty::where('customer_id',$id)->orderBy('created_at','DESC')->simplePaginate();
        
        return view('Staff/PM/Property/index')->with(compact('customerproperties','count'));  
             }
       else
       {
           return redirect('/home');
       }
    }
    
      public function productdetails($id)
    
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
             elseif(Auth::user()->staffprofile->role =='PM')
             {
               
          $count=1;
        $plot =Plot::findOrFail($id);
        
           $product=Product::find($plot->product_id);
    
     $brand=PlotType::find($plot->plot_type_id);
     
       $customerproperties=CustomerProperty::where('plot_id',$plot->id)->get() ;
       
       foreach($customerproperties as $cp)


{
    $user =User::findOrFail($cp->customer_id);
    if($user->customerprofile->po_id != Auth::user()->id)
    {
        return redirect('/home');
    }
}
        
        return view('/Staff/PM/Property/show')->with(compact('plot','brand','product','cp','user'));
        
       
             }


               elseif(Auth::user()->staffprofile->role =='DRO')
             {
               
          $count=1;
        $plot =Plot::findOrFail($id);
        
           $product=Product::find($plot->product_id);
    
     $brand=PlotType::find($plot->plot_type_id);
     
       $customerproperties=CustomerProperty::where('plot_id',$plot->id)->get() ;
       
       foreach($customerproperties as $cp)


{
    $user =User::findOrFail($cp->customer_id);
    if($user->customerprofile->dro_id != Auth::user()->id)
    {
        return redirect('/home');
    }
}
        
        return view('/Staff/PM/Property/show')->with(compact('plot','brand','product','cp','user'));
        
       
             }


                        elseif(Auth::user()->staffprofile->role =='AHO')
             {
               
          $count=1;
        $plot =Plot::findOrFail($id);
        
           $product=Product::find($plot->product_id);
    
     $brand=PlotType::find($plot->plot_type_id);
     
       $customerproperties=CustomerProperty::where('plot_id',$plot->id)->get() ;
       
       foreach($customerproperties as $cp)


{
    $user =User::findOrFail($cp->customer_id);
    if($user->customerprofile->aho_id != Auth::user()->id)
    {
        return redirect('/home');
    }
}
        
        return view('/Staff/PM/Property/show')->with(compact('plot','brand','product','cp','user'));
        
       
             }

                        elseif(Auth::user()->staffprofile->role =='EA')
             {
               
          $count=1;
        $plot =Plot::findOrFail($id);
        
           $product=Product::find($plot->product_id);
    
     $brand=PlotType::find($plot->plot_type_id);
     
       $customerproperties=CustomerProperty::where('plot_id',$plot->id)->get() ;
       
       foreach($customerproperties as $cp)


{
    $user =User::findOrFail($cp->customer_id);
    if($user->customerprofile->ea_id != Auth::user()->id)
    {
        return redirect('/home');
    }
}
        
        return view('/Staff/PM/Property/show')->with(compact('plot','brand','product','cp','user'));
        
       
             }
       else
       {
           return redirect('/home');
       }
    }
}
