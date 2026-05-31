<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerProfile;
use App\Models\StaffProfile;
use App\Models\Product;
use App\Models\Deposit;
use App\Models\Plot;
use App\Models\PlotType;

use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
class SearchController extends Controller
{
    public function customer(Request $request)
    {
    	$count=1;
    	
    	$id =$request->id;

    	  if(Auth::user()->staffprofile->role =='DRO')
{

          $customers=DB::table('users')
            ->join('customer_profiles', 'users.id', '=', 'customer_profiles.user_id')
           
            ->select('users.*', 'customer_profiles.*')
            
            
           ->orWhere('customer_profiles.surname','LIKE',"%{$id}%")
            ->where('dro_id',Auth::user()->id)
              ->where('users.user_status','active')
            ->orWhere('customer_profiles.first_name','LIKE',"%{$id}%")
             ->where('dro_id',Auth::user()->id)
               ->where('users.user_status','active')
             ->orWhere('customer_profiles.othername','LIKE',"%{$id}%")
              ->where('dro_id',Auth::user()->id)
                ->where('users.user_status','active')
              ->orWhere('users.email','LIKE',"%{$id}%")
                ->where('users.user_status','active')
               ->where('dro_id',Auth::user()->id)
               ->orWhere('users.phone','LIKE',"%{$id}%")
               ->where('dro_id',Auth::user()->id)
                 ->where('users.user_status','active')->get();


          }
              
     
            
      
       
       

    
    elseif( Auth::user()->staffprofile->role =='PM')
    {
   $customers=DB::table('users')
            ->join('customer_profiles', 'users.id', '=', 'customer_profiles.user_id')
           
            ->select('users.*', 'customer_profiles.*')
            
            
           ->orWhere('customer_profiles.surname','LIKE',"%{$id}%")
            ->where('po_id',Auth::user()->id)
              ->where('users.user_status','active')
            ->orWhere('customer_profiles.first_name','LIKE',"%{$id}%")
             ->where('po_id',Auth::user()->id)
               ->where('users.user_status','active')
             ->orWhere('customer_profiles.othername','LIKE',"%{$id}%")
              ->where('po_id',Auth::user()->id)
                ->where('users.user_status','active')
              ->orWhere('users.email','LIKE',"%{$id}%")
               ->where('po_id',Auth::user()->id)
                 ->where('users.user_status','active')
                 ->orWhere('users.username','LIKE',"%{$id}%")
               ->where('po_id',Auth::user()->id)
                 ->where('users.user_status','active')
               ->orWhere('users.phone','LIKE',"%{$id}%")
                 ->where('users.user_status','active')
               ->where('po_id',Auth::user()->id)->get();

    }

    elseif( Auth::user()->staffprofile->role =='AHO')
    {
    $customers=DB::table('users')
            ->join('customer_profiles', 'users.id', '=', 'customer_profiles.user_id')
           
            ->select('users.*', 'customer_profiles.*')
            
            
           ->orWhere('customer_profiles.surname','LIKE',"%{$id}%")
            ->where('aho_id',Auth::user()->id)
              ->where('users.user_status','active')
            ->orWhere('customer_profiles.first_name','LIKE',"%{$id}%")
             ->where('aho_id',Auth::user()->id)
               ->where('users.user_status','active')
             ->orWhere('customer_profiles.othername','LIKE',"%{$id}%")
              ->where('aho_id',Auth::user()->id)
                ->where('users.user_status','active')
              ->orWhere('users.email','LIKE',"%{$id}%")
               ->where('aho_id',Auth::user()->id)
                 ->where('users.user_status','active')
                  ->orWhere('users.username','LIKE',"%{$id}%")
               ->where('aho_id',Auth::user()->id)
                 ->where('users.user_status','active')
               ->orWhere('users.phone','LIKE',"%{$id}%")
                 ->where('users.user_status','active')
               ->where('aho_id',Auth::user()->id)->get();

    }

    elseif( Auth::user()->staffprofile->role =='EA')
    {
     $customers=DB::table('users')
            ->join('customer_profiles', 'users.id', '=', 'customer_profiles.user_id')
           
            ->select('users.*', 'customer_profiles.*')
            
            
           ->orWhere('customer_profiles.surname','LIKE',"%{$id}%")
             ->where('users.user_status','active')
            ->where('ea_id',Auth::user()->id)
            ->orWhere('customer_profiles.first_name','LIKE',"%{$id}%")
             ->where('ea_id',Auth::user()->id)
               ->where('users.user_status','active')
             ->orWhere('customer_profiles.othername','LIKE',"%{$id}%")
              ->where('ea_id',Auth::user()->id)
                ->where('users.user_status','active')
                ->orWhere('users.email','LIKE',"%{$id}%")
               ->where('ea_id',Auth::user()->id)
                 ->where('users.user_status','active')
                 ->orWhere('users.username','LIKE',"%{$id}%")
               ->where('ea_id',Auth::user()->id)
                 ->where('users.user_status','active')
               ->orWhere('users.phone','LIKE',"%{$id}%")
                 ->where('users.user_status','active')
               ->where('ea_id',Auth::user()->id)->get();

    }

    elseif(Auth::user()->staffprofile->role == 'MD' || Auth::user()->staffprofile->role =='CFO' || Auth::user()->staffprofile->role =='CMO'|| Auth::user()->staffprofile->role == 'COO' ) 
    {
        $customers=DB::table('users')
            ->join('customer_profiles', 'users.id', '=', 'customer_profiles.user_id')
           
            ->select('users.*', 'customer_profiles.*')
            
            
           ->where('customer_profiles.surname','LIKE',"%{$id}%")
             ->where('users.user_status','active')

            ->orWhere('customer_profiles.first_name','LIKE',"%{$id}%")
              ->where('users.user_status','active')
             ->orWhere('customer_profiles.othername','LIKE',"%{$id}%")
               ->where('users.user_status','active')
              ->orWhere('users.email','LIKE',"%{$id}%")
                ->where('users.user_status','active')
                
              ->orWhere('users.username','LIKE',"%{$id}%")
                ->where('users.user_status','active')
               ->orWhere('users.phone','LIKE',"%{$id}%")
                 ->where('users.user_status','active')
           ->get();
    
    }


   



/*

$result='          
<table class="table table-striped">
<thead>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>

<th>

</th>
</thead>';

foreach($customers as $customer)
{
$user = DB::table('users')->find($customer->user_id);


$result.='<tbody><tr>
<td>
 





'.$count++.'

</td>
<td>
'.ucwords($customer->username ) .'
</td>
<td>
'.ucwords($customer->surname).'  '.ucwords($customer->first_name).' '. ucwords($customer->othername).'

</td>
<td>
'.ucwords($customer->phone)  .'

</td>
<td>
'.ucwords($customer->email) .'

</td>


<td class="d-flex bg-white">
  
  <form action="'. route('customer.show',$customer->user_id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '.csrf_field().'
                                    
                        <button onclick="return confirm("Are you sure want to view customer Profile?")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;">Profile</button>
                     </form>  
                     
                      


                         <form action="'.route('customer.edit',$customer->user_id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '. csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to edit customer Profile?"")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;">edit</button>
                     </form>  ';
                     
           if(Auth::user()->staffprofile->role=='CMO' || Auth::user()->staffprofile->role =='MD')
        {           
  
                       $result.= '<form action="'.route('customer.destroy',$customer->user_id) .'" method="POST">
<input name="_method" type="hidden" value="DELETE">
                                    '. csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to delete customer ?"")" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form> ';

}
                     $result.= ' </td>

</tr>';
}


$result.='</table>';

*/


    	return response()->json($customers);
    }


     public function staff(Request $request)
    {
    	$count=1;

   
              
     $staffs =StaffProfile::where('reg_no','LIKE',"%{$request->id}%")->orWhere('surname','LIKE',"%{$request->id}%")->orWhere('designated_state','LIKE',"%{$request->id}%")->get();
            
      
       
       






$result='          

<table class="table table-striped">
<thead>
<th>

</th>

<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
</thead>';

foreach($staffs as $staff)
{
$user = DB::table('users')->find($staff->user_id);
$branch =DB::table('branches')->find($staff->branch_id);

  if(Auth::user()->staffprofile->role == "MD" ||  Auth::user()->staffprofile->role =="HRM")
       {
       	      	

$result.='<tbody><tr>
<td>
 





'.$count++.'

</td>

<td>
'.ucwords($staff->surname).' '.ucwords($staff->first_name).' '.ucwords($staff->othername).'

</td>
<td>
'.ucwords($user->phone).'

</td>
<td>
'.ucwords($user->email).'

</td>


<td>
'.ucwords($branch->name).'

</td>
<td>
'.ucwords($staff->designated_state).'

</td>
<td>
'.strtoupper($staff->role).'

</td>


<td class="d-flex bg-white">
  
  <form action="'. route('staff.show',$staff->user_id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to view staff Profile?")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>

      
       
       	

<form action="'.route('staff.edit',$staff->user_id) .'" method="POST" class="ml-3">

'.csrf_field() .'


<input name="_method" type="hidden" value="GET">
<button onclick="return confirm("Are you sure want to edit this staff Profile ?")" 

class="btn btn-info btn-sm" style="margin-right: 10px;">

<i class="fa fa-edit"></i></button>

</form>
       
       <form action="'.route('staff.destroy',$staff->id) .'" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to delete Staff?")" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
                     
  

                     </td>

</tr>';
       	}
       	else
       	{

$result.='<tbody><tr>
<td>
 





'.$count++.'

</td>

<td>
'.ucwords($staff->surname).' '.ucwords($staff->first_name).' '.ucwords($staff->othername).'

</td>
<td>
'.ucwords($user->phone).'

</td>
<td>
'.ucwords($user->email).'

</td>


<td>
'.ucwords($branch->name).'

</td>
<td>
'.ucwords($staff->designated_state).'

</td>
<td>
'.strtoupper($staff->role).'

</td>


<td class="d-flex bg-white">
  
  <form action="'. route('staff.show',$staff->user_id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to view staff Profile?")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>

      
       
       	

                     
  

                     </td>

</tr>';
}
}


$result.='</table>';

    	return $result;
    }


public function stock(Request $request)
{

      $count=1;
        $products=Product::where('location_name','LIKE',"%{$request->id}%")->orWhere('town','LIKE',"%{$request->id}%")->orWhere('state','LIKE',"%{$request->id}%")->orderBy('created_at','Desc')->get();

$result='<table class="table table-striped">
<thead>
<th>

</th>
<th>

</th>
<th>

</th>

<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
</thead>';
foreach ($products as $product) {
if( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO')
{
$result.='
<tr>
<td>
'.$count++.'
</td>
<td>
'.ucwords($product->location_name).'
</td>
<td>
'.ucwords($product->address).'

</td>
<td>
'.ucwords($product->town).'

</td>
<td>
'.ucwords($product->state).'

</td>
<td>
'.ucwords($product->sqm).'

</td>
<td>
'.ucwords($product->no_of_plots).'

</td>
<td>
'.ucwords($product->purpose).'

</td>
<td class="d-flex bg-white">
<form action="'. route('product.show',$product->id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '. csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to view this product?")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>
                   
<form action="'.route('product.edit',$product->id) .'" method="POST">
                                <input name="_method" type="hidden" value="GET">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to edit this product?")" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;"><i class="fa fa-edit"></i></button>
                     </form>
<form action="'.route('product.destroy',$product->id) .'" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to delete this Product?")" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
                     
                   
                     </td>

</tr>';

}
else

{
$result.='
<tr>
<td>
'.$count++.'
</td>
<td>
'.ucwords($product->location_name).'
</td>
<td>
'.ucwords($product->address).'

</td>
<td>
'.ucwords($product->town).'

</td>
<td>
'.ucwords($product->state).'

</td>
<td>
'.ucwords($product->sqm).'

</td>
<td>
'.ucwords($product->no_of_plots).'

</td>
<td>
'.ucwords($product->purpose).'

</td>
<td class="d-flex bg-white">
<form action="'. route('product.show',$product->id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '. csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to view this product?")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>
             
                     
                   
                     </td>

</tr>';
}

}
$result.='</table>';
        return $result;
}

public function plot(Request $request)
{ $count=1;


       if( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM' ||  Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='CFO'
          )
          
          {
              
     
      
        $plots =Plot::where('product_id',$request->bid)->where('status','unsold')->where('Plot_id','LIKE',"%{$request->id}%")->orWhere('price','LIKE',"%{$request->id}%")->where('product_id',$request->bid)->where('status','unsold')->orderBy('created_at','DESC')->get();
  
          }
          
          elseif( Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO'
          )
          
          {
              
      
        $plots =Plot::where('product_id',$request->bid)->where('Plot_id','LIKE',"%{$request->id}%")->orWhere('price','LIKE',"%{$request->id}%")->where('product_id',$request->bid)->where('status','unsold')->orderBy('created_at','DESC')->get();
       
             
          }

           if( Auth::user()->staffprofile->role == 'MD'  ||  Auth::user()->staffprofile->role =='CMO')
           {

          $result = '<table class="table table-striped">
<thead>
<th>


</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>

<th>

</th>
<th>

</th>

<th>
    

</th>

</thead>';


 foreach ($plots as $plot) {

    $p = DB::table('products')->find($plot->product_id);
$pr = DB::table('plot_types')->find($plot->plot_type_id);

$result.='
<tr>
<td>
<i class="fa fa-circle text-success"></i>
'.$count++.'
</td>
<td>
'.ucwords($plot->Plot_id).'

</td>
<td>

'.ucwords($p->location_name).'
</td>

<td>
'.ucwords($pr->name).'

</td>
<td>
'.ucwords($plot->price).'

</td>
<td>
'.ucwords($plot->sqm).'

</td>
<td>
'.ucwords($plot->no_of_plots).'

</td>
<td class="d-flex">
<form action="'.route('plot.show',$plot->id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to sell this plot?")" 
                        class="btn btn-success btn-sm" style="margin-right: 10px;">SELL</button>
                     </form>
                     
                     
                      
                   
<form action="'.route('plot.edit',$plot->id) .' method="POST">
                                <input name="_method" type="hidden" value="GET">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to edit this product?")" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;"><i class="fa fa-edit"></i></button>
                     </form>
<form action="'.route('plot.destroy',$plot->id).'" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to delete this Product?")" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
</td>

</tr>';

 }
}
 elseif(Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO') {
   

          $result = '<table class="table table-striped">
<thead>
<th>


</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>

<th>

</th>
<th>

</th>

<th>
    

</th>

</thead>';


 foreach ($plots as $plot) {

    $p = DB::table('products')->find($plot->product_id);
$pr = DB::table('plot_types')->find($plot->plot_type_id);

$result.='
<tr>';
if($plot->status =='unsold')
{

$result.='<td>
<i class="fa fa-circle text-success"></i>
'.$count++.'
</td>';
}
elseif($plot->status =='sold')
{

$result.='<td>
<i class="fa fa-circle text-info"></i>
'.$count++.'
</td>';
}
elseif($plot->status =='pending')
{

$result.='<td>
<i class="fa fa-circle text-warning"></i>
'.$count++.'
</td>';
}



$result.='<td>
'.ucwords($plot->Plot_id).'

</td>
<td>

'.ucwords($p->location_name).'
</td>

<td>
'.ucwords($pr->name).'

</td>
<td>
'.ucwords($plot->price).'

</td>
<td>
'.ucwords($plot->sqm).'

</td>
<td>
'.ucwords($plot->no_of_plots).'

</td>';
if($plot->status == 'unsold')
{
  

$result.='

<td class="d-flex">

                     
                     
                      
                   
<form action="'.route('plot.edit',$plot->id) .' method="POST">
                                <input name="_method" type="hidden" value="GET">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to edit this product?")" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;"><i class="fa fa-edit"></i></button>
                     </form>
<form action="'.route('plot.destroy',$plot->id).'" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    '.csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to delete this Product?")" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
</td>';

}

$result.='</tr>';


 }



 }


 $result.='</table>';
 return $result;
}
public function ui(Request $request)
{
  $count=1;
 $plots =DB::table('plots')
 ->join('customer_properties','plots.id','=','customer_properties.plot_id')
 ->select('customer_properties.*','plots.*')
 ->where('plots.Plot_id','LIKE',"%{$request->id}%")->where('status','pending')->
 orWhere('plots.price','LIKE',"%{$request->id}%")->where('status','pending')
 ->orWhere('customer_properties.customer_reg_no','LIKE',"%{$request->id}%")->where('status','pending')
 ->orderBy('customer_properties.created_at','DESC')->get();


$result='
<table class="table table-striped">
<thead>
<th>

</th>

<th>

</th>
<th>

</th>
<th>

</th>

<th>
</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>

<th>

</th>
<th>

</th>
</thead>';
foreach($plots as $plot) {
    $product=DB::table('products')->find($plot->product_id);
    
     $brand=DB::table('plot_types')->find($plot->plot_type_id);
     
       $customers=DB::table('customer_properties')->where('plot_id',$plot->id)->get();

$result.='
<tr>
   
<td>
'.$count++.'
</td>
';
foreach($customers as $customer)
{



$result.='<td>'.$customer->customer_reg_no.'</td>';
}
$result.='
<td>
'.ucwords($product->location_name).'
</td>
<td>
'.ucwords($product->address).' '.ucwords($product->town).'

</td>
<td>

'.ucwords($product->state).'
</td>
<td>
'.ucwords($plot->Plot_id).'

</td>
<td>
'.ucwords($plot->sqm).'

</td>
<td>
'.ucwords($plot->no_of_plots).'

</td>
<td>
'.ucwords($product->purpose).'

</td>
<td>
'.ucwords($plot->price).'

</td>
<td class="d-flex bg-white">
<form action="'. route('installmentsales.show',$plot->id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '. csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to view sales details?")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>';
                     
                       
            if(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO'  ||  Auth::user()->staffprofile->role =='HOR' ||  Auth::user()->staffprofile->role =='CMO' || Auth::user()->staffprofile->role =='FDO' || Auth::user()->staffprofile->role =='CD' )
            {
                           foreach($customers as $customer)
                               
                               {   
                                    $users=DB::table('customer_profiles')->where('user_id',$customer->customer_id)->get();
                                     
                                 
                             
                     
                     
               $result .='<form action="'.route("customerrevoke.store").'" method="POST">

                                     '.csrf_field().'
                                    
                               

<input type="hidden" name="cp_id" value="'.$customer->id.'">


                                    
                                     <input type="hidden" name="plot_id" value="'.$plot->id.'">
                                     
                                    
                                  
                                      <input type="hidden" name="user_id" value="'.$customer->customer_id.'">
                                 
                        <button  onclick="return confirm("Are you Sure You To Revoke Property From Customer, Note This Can not be Undo ?")" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;">Revoke</button>
                     </form>  ';
                     
                               }
            }
      $result .='</td>

</tr>';
}

$result .='</table>';
return $result;
}


//for sold out product search


public function sold(Request $request)
{
  $count=1;
 $plots =Plot::where('Plot_id','LIKE',"%{$request->id}%")->where('status','sold')->orWhere('price','LIKE',"%{$request->id}%")->where('status','sold')->orderBy('created_at','DESC')->get();


$result='
<table class="table table-striped">
<thead>
<th>

</th>

<th>

</th>
<th>

</th>
<th>

</th>

<th>
</th>
<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>

<th>

</th>
<th>

</th>
</thead>';
foreach($plots as $plot) {
    $product=DB::table('products')->find($plot->product_id);
    
     $brand=DB::table('plot_types')->find($plot->plot_type_id);
     
       $customers=DB::table('customer_properties')->where('plot_id',$plot->id)->get();

$result.='
<tr>
   
<td>
'.$count++.'
</td>
';
foreach($customers as $customer)
{



$result.='<td>'.$customer->customer_reg_no.'</td>';
}
$result.='
<td>
'.ucwords($product->location_name).'
</td>
<td>
'.ucwords($product->address).' '.ucwords($product->town).'

</td>
<td>

'.ucwords($product->state).'
</td>
<td>
'.ucwords($plot->Plot_id).'

</td>
<td>
'.ucwords($plot->sqm).'

</td>
<td>
'.ucwords($plot->no_of_plots).'

</td>
<td>
'.ucwords($product->purpose).'

</td>
<td>
'.ucwords($plot->price).'

</td>
<td class="d-flex bg-white">
<form action="'. route('installmentsales.show',$plot->id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '. csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to view sales details?")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>';
                     
                     
                     
                      if(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO'  ||  Auth::user()->staffprofile->role =='HOR' ||  Auth::user()->staffprofile->role =='CMO' || Auth::user()->staffprofile->role =='FDO' || Auth::user()->staffprofile->role =='CD' )
                      {
                           
                                  
                    $users=DB::table('customer_profiles')->where('user_id',$customer->customer_id)->get();
                                     
                                  
                     $result.='<form action="'. route('customerrevoke.store' ).'" method="POST">

                                    '.csrf_field() .'
                                    
                               

<input type="hidden" name="cp_id" value="
'.$customer->id.'">


                                    
                                     <input type="hidden" name="plot_id" value="'.$plot->id.'">
                                     
                                    
                                  
                                      <input type="hidden" name="user_id" value="'.$customer->customer_id.'">
                                 
                        <button  onclick="return confirm("Are you Sure You To Revoke Property From Customer, Note This Can not be Undo ?")" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;">Revoke</button>
                     </form>';  
                       
                     }
                     
                     
                $result.= '</td>

</tr>';
}

$result .='</table>';
return $result;
}


//for deposit search

public function deposit(Request $request)
{

   $count=1;
        $deposits = Deposit::where('customer_reg_no','LIKE',"%{$request->id}%")->orderBy('created_at','DESC')->get();

  $result='<table class="table table-striped">
<thead>
<th>

</th>
<th>

</th>

<th>

</th>
<th>

</th>
<th>

</th>
<th>

</th>
</thead>';


foreach ($deposits as $deposit) {
    $customer=DB::table('users')->find($deposit->customer_id);
    
    $cusps =DB::table('customer_profiles')->where('user_id',$deposit->customer_id)->get();
  $result.='<tr>';
if($deposit->status =='pending')
{

  $result.='<td>
  
'.$count++.'<i class="fa fa-circle text-warning"></i>
</td>';
}
elseif($deposit->status =='success')
{

  $result.='<td>
  
'.$count++.'<i class="fa fa-circle text-success"></i>
</td>';
}
elseif($deposit->status =='cancel')
{

  $result.='<td>
  
'.$count++.'<i class="fa fa-circle text-danger"></i>
</td>';
}

   foreach($cusps as $cusp)
   {
$result.='
<td>  
    
    
'.ucwords($cusp->surname).' '.ucwords($cusp->first_name).' ' .ucwords($cusp->othername).'</td>';

}

$result.='
<td>

&#8358;'.$deposit->amount.'
</td>
<td>
    '.$deposit->ref_id.'

</td>
<td>
'.$deposit->created_at.'

</td>


<td class="d-flex bg-white">
<form action="'.route('deposittxn.show',$deposit->id) .'" method="POST">
<input name="_method" type="hidden" value="GET">
                                    '. csrf_field() .'
                                    
                        <button onclick="return confirm("Are you sure want to view Deposit History?")" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>

                     

                     </td>

</tr>';
}
$result.='</table>';
return $result;
}

     public function TestSms($recipient,$message)
    {


$url = "https://portal.nigeriabulksms.com/api/?username=quickaccesswebapps@gmail.com&password=$500@QuickAccess&message=.$message.&sender=QuickMann&mobiles=.$recipient.";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);





    }
}