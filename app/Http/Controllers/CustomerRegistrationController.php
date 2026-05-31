<?php

namespace App\Http\Controllers;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use App\User;
use App\Models\CustomerProfile;
use App\Models\CustomerProperty;
use App\Models\Plot;
use App\Models\StaffProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Session;
use App\Branch;
use DB;
use App\MonthlyRecord;

use Illuminate\Support\Facades\Auth;
class CustomerRegistrationController extends Controller
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
       
            
        
 
          
    
        else
        {
           $count=1;
       
        //$customers = CustomerProfile::where('dro_id',Auth::user()->id)->simplePaginate(10);

         $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*')
       ->where('users.user_status','active')

        ->where('users.user_type','customer')
        ->where('customer_profiles.dro_id',Auth::user()->id)
        ->orderBy('users.created_at','DESC')

        ->simplePaginate(20);
      
        $x=1;
        $y=1;
        /************Testing purpose***************/
           $bcustomers=CustomerProfile::all();
         
           
           
               $users = User::where('user_type','customer')->get();
                                  $plot =Plot::find(2720);
                 $plot->status='unsold';
                 $plot->save();
                 
                 //dd($plot);
              
              $cps=CustomerProperty::where('unpaid_balance','!=',0)->get();
              foreach($cps as $cp)
              {
                  $plot =Plot::find($cp->plot_id);
                  $plot->status ='pending';
                  $plot->save();
              }
              
              
             
             
         
        
           
           
        
         
       
     
                  
    return view('Staff/Customer/Customer/mycustomer')->with(compact('count','customers','users','bcustomers','x','y')); 
        
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches =Branch::all();
$pms = StaffProfile::where('role','PM')->where('status','active')->get();
$dros = StaffProfile::where('status','active')->get();
$ahos = StaffProfile::where('role','AHO')->where('status','active')->get();
$eas = StaffProfile::where('role','EA')->where('status','active')->get();
    return view('Staff/Customer/Customer/create')->with(compact('pms','dros','eas','ahos','branches'));
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
    'phone' => ['required', 'unique:users', new PhoneNumber],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'surname' => ['required'],
    'first_name' => ['required'],
   
     'dro' => ['required'],
      'pm' => ['required'],
    
      'marital_status' => ['required'],
     'gender' => ['required'],
      'dob' => ['required'],
       'designated_state' => ['required'],
        'branch' => ['required'],
]);

Function generateCode($limit)
{
    $code="";
    for($i=0; $i<$limit; $i++)
    {
        $code .=mt_rand(0,9);
        
    }
    return $code;
}

$reg_no = generateCode(10);

$reg_no ='QUK'.$reg_no.'CUS';
$user = new User;
$user->phone = $request->phone;
$user->email = $request->email;
$user->password = 1234;
$user->save();

$user_id =$user->id;
$customerprofile = new CustomerProfile;
$customerprofile->user_id = $user_id;
$customerprofile->reg_no = $reg_no;
$customerprofile->po_id = $request->pm;
$customerprofile->dro_id = $request->dro;
$customerprofile->aho_id = $request->aho;
$customerprofile->ea_id = $request->ea;
$customerprofile->marital_status = $request->marital_status;
$customerprofile->gender = $request->gender;
$customerprofile->dob = $request->dob;
$customerprofile->first_name = $request->first_name;
$customerprofile->surname = $request->surname;
$customerprofile->othername = $request->othername;
$customerprofile->designated_state = $request->designated_state;
$customerprofile->branch_id = $request->branch;
$customerprofile->address = $request->address;
$customerprofile->city = $request->city;
$customerprofile->state = $request->state;
$customerprofile->save();
/*
$checks =CustomerProfile::where('user_id',$customer->id)->get();
if($checks->count()==0)
{
   
          DB::statement('SET FOREIGN_KEY_CHECKS=0;');
           $user= User::find($customer->id);
          $user->delete();
          DB::statement('SET FOREIGN_KEY_CHECKS=1;');
}
*/

$data = array('surname'=>$request->surname, 'first_name'=>$request->first_name,'othername'=>$request->othername);


  $email =Session::put('email',$request->email);



     
     
Mail::send(['html'=>'mail'], $data, function($message) {
    
    $email=Session::get('email');
   $message->to($email, 'Quickmann')->subject
      ('Quickmann Customer Relation Manager');
   $message->from('noreply@quickmann.app','Quickmann');
});


Session::forget('email');



return back()->with('success_msg','Registration  successful ');


 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer=User::findOrFail($id);
   return view('Staff/Customer/Customer/logindet')->with(compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
   //
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
                'username' => ['required', 'string', 'max:255','unique:users,username,'.$id.',id'],
           
            'password' => ['required', 'string', 'min:8', 'confirmed'],
           

           
       
        ]);

//find customer
             $customer =User::findOrFail($id);

             //update password

             $customer->username =$request->username;
             $customer->password =Hash::make($request->password);
             $customer->save();
             return back()->with('success_msg','Login Details Updated successful');
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
