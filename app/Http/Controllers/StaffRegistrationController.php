<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\PhoneNumber;
use Mail;
use App\User;
use App\Models\StaffProfile;
use App\Models\AccessCode;
use App\Http\Requests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Branch;
use Illuminate\Support\Facades\Auth;

class StaffRegistrationController extends Controller
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
          elseif( Auth::user()->staffprofile->role == 'DRO' && Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM'
          )
          
          {
              $branches=Branch::all();
              
                return view('/Staff/staff/create')->with(compact('branches'));
             
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
    'phone' => ['required', 'unique:users', new PhoneNumber],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
$reg_no ='QUK'.$reg_no.'ACC';

$user =new User;
$user->email =$request->email;
$user->phone =$request->phone;
$user->user_type ='staff';
$user->password =123456;
$user->save();
$user_id =$user->id;
$access_code2 = Str::random(8);

$staffprofile = new StaffProfile;
$staffprofile->user_id = $user_id ;
$staffprofile->reg_no = $reg_no ;
$staffprofile->branch_id = $request->branch;
$staffprofile->designated_state = $request->designated_state ;
$staffprofile->save();
//store access code
$access_code= new AccessCode;
$access_code->access_code = $access_code2;
$access_code->phone = $request->phone;
$access_code->email = $request->email;
$access_code->user_id = $user_id ;
$access_code->save();
$email=$request->email;
$email =Session::put('email',$request->email);




$data = array('email'=>$request->email,'access_code'=>$access_code2);
     
Mail::send(['html'=>'mail_staff'], $data,

function($message) {
$email=Session::get('email');

   $message->to($email, 'staff')->subject('HR Quickmann');

   $message->from('noreply@quickmann.app','Quickmann');
});

Session::forget('email');
return back()->with('success_msg','Registration was successful and access code has been sent the registrant email');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    //profile step 1 completion

    public function profile_step1(Request $request)
    {
        $request->validate([
            'surname' => ['required'],
            'first_name' => ['required'],
            'gender' => ['required'],
            'marital_status' => ['required'],
          
        ]);
Auth::user()->staffprofile->surname =$request->surname;
Auth::user()->staffprofile->first_name =$request->first_name;
Auth::user()->staffprofile->othername =$request->othername;
Auth::user()->staffprofile->gender =$request->gender;
Auth::user()->staffprofile->marital_status =$request->marital_status;
Auth::user()->staffprofile->save();

return redirect('/home');
    }

    //profile step 2 completion

    public function profile_step2(Request $request)
    {
            
$request->validate([
    'phone' => ['required', new PhoneNumber],
    'address' => ['required'],
    'city' => ['required'],
    'state' => ['required'],

]);
   
Auth::user()->staffprofile->second_phone =$request->phone;
Auth::user()->staffprofile->address =$request->address;
Auth::user()->staffprofile->city =$request->city;
Auth::user()->staffprofile->state =$request->state;

Auth::user()->staffprofile->save();
return redirect('/home');
    }
    
    //profile step 3 completion
    public function profile_step3(Request $request)
    {
        
        if($request->has('skip'))
        {
     Auth::user()->staffprofile->profile_status ='complete';

       Auth::user()->staffprofile->save();
        return redirect('/home');
            
        }
        else
        {
            
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
   
       ]);
       
         
       $image = time().'.'.$request->profile_photo->getClientOriginalExtension();
   
       $request->profile_photo->move(public_path('/images'), $image);
       Auth::user()->staffprofile->profile_photo =$image;
       Auth::user()->staffprofile->profile_status ='complete';

       Auth::user()->staffprofile->save();
       return redirect('/home');
        }

    }
    
    //profile step 4 completion for dro
    public function profile_step4(Request $request)
    {
        
        $request->validate([
            'state' => 'required',
             'branch' => 'required',
   
   
       ]);
       
         
 
       Auth::user()->staffprofile->designated_state =$request->state;
        Auth::user()->staffprofile->branch_id =$request->branch;

       Auth::user()->staffprofile->save();
       return redirect('/home');

    }
    
      public function __destruct()
    {
        $this->middleware('auth');
    }
    
    
      public function update(Request $request, $id)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255' , 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'access_code' => ['required', 'string', 'min:8', 'confirmed'],
            'position' => ['required'],
        ]);

        $users =User::where('email',$request->email)->get();
        if($users->count() == 0)
        {

       return back()->with('warning_msg','Email Not Registered Yet');

        }
        else
        {
            foreach($users as $user)
            {
                $accesses = AccessCode::where('user_id',$user->id)->get();

                if($accesses->count()==0)
                {
                    return back()->with('warning_msg','Invalid Access Code or User Has been verified before');
                }
                else
                {

                
                foreach($accesses as $access)
                {
                    if($access->access_code != $request->access_code)
                    {
                    return back()->with('warning_msg','Invalid Access Code or User Has been verified before');

                }

              
              else  {

                $newuser =User::find($user->id);

$newuser->username = $request->username;
$newuser->password = Hash::make($request->password);
$newuser->save();


                    $staffs = StaffProfile::where('user_id',$user->id)->get();

                    foreach($staffs as $staff)
                    {
                        $staff->role =$request->position;
                        $staff->save();
                        $access->delete();
                        return redirect('/success')->with('success_msg','Registration is successful, please login to complete your profile');
                    }
                }
                }
            }
            
            }
           
        }
    }
   
}
