<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\InternalTransfer;
use App\Rules\PhoneNumber;
use App\Models\CustomerProfile;
use App\Jobs\SendEmailJob;
use App\Models\CustomerProperty;
use Session;
class CustomerDashbard extends Controller
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
        $image = Session::get('image');
        if(Auth::user()->user_status !="active")
        {
            Session::flush();
            return redirect('/')->with('danger_msg','Your Account have been already Terminated');

        }


        elseif(Auth::user()->customerprofile->profile_status =='incomplete')

        return view('Customer/profile_completion/step_one');
        elseif(Auth::user()->customerprofile->profile_status =='step_one')
        return view('Customer/profile_completion/step_two');

        elseif(Auth::user()->customerprofile->profile_status =='step_two')
        return view('Customer/profile_completion/step_three');
        elseif(Auth::user()->customerprofile->profile_status =='step_three' && $image ==null)
        return view('Customer/profile_completion/step_four');
        elseif($image!=null && Auth::user()->customerprofile->profile_status =='step_three' )
        {
            return view('Customer/profile_completion/step_five');
        }

        $customerproperty= CustomerProperty::where('customer_id',Auth::user()->id)->where('property_status','!=','revoked')->get();
        return view('Customer/index')->with(compact('customerproperty'));
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
     
     public function internalTransfer()
     {
         return view('Customer/Transfer/index');
         
     }
    public function initiateTransfer(Request $request)
    {
         if($request->account ==null)
        {
          $data = [
    'data' => [
        'errors' => [
            'account' => [
                0 => "please enter customer account number or email address"
            ]
        ]
    ]
];

            return response()->json($data, 422);
        }
        
        
  $user = User::join('customer_profiles', 'customer_profiles.user_id', 'users.id')
    ->where(function ($query) use ($request) {
        $query->where('users.email', $request->account)
            ->orWhere('customer_profiles.reg_no', $request->account);
    })
    ->where('users.id', '!=', auth()->user()->id)
    ->first();

   
   if(!$user)
   {
             $data = [
                 'message'=>'No customer found with such account'
                 ];
        
         return response()->json($data, 401);
   }
   
                $data = [
                 'data'=>$user
                 ];
    return response()->json($data, 200);
   
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Transfer(Request $request)
    {
        if($request->amount > auth()->user()->customerProfile->wallet_balance)
        {
            return back()->with('warning_msg','Insufficient fund in your wallet balance');
        }
          $user = User::join('customer_profiles', 'customer_profiles.user_id', 'users.id')
    ->where(function ($query) use ($request) {
        $query->where('users.email', $request->account)
            ->orWhere('customer_profiles.reg_no', $request->account);
    })
    ->where('users.id', '!=', auth()->user()->id)
    ->first();

           
          if(!$user)
          {
                return back()->with('warning_msg','Customer not found');
          }
        
        InternalTransfer::create([
            'sender_id'=>auth()->user()->id,
            'receiver_id'=>$user->user_id,
            'status'=>'success',
            'amount'=>$request->amount,
            ]);
            
            //debit sender
            auth()->user()->customerProfile->wallet_balance =  auth()->user()->customerProfile->wallet_balance - $request->amount;
             auth()->user()->customerProfile->save();
             
             //credit receiver
             
             $new_user =CustomerProfile::where('user_id',$user->user_id)->first();
              $new_user->wallet_balance =$new_user->wallet_balance +$request->amount;
              $new_user->save();
              
              
              //dispatch email to reciever
              $name =$user->first_name;
              $email_body="
              <p>Hi ".ucwords(strtolower($name)).",</p>
              <p>The sum of NGN ".number_format($request->amount)." was transfer into your quickmann wallet from ".auth()->user()->customerProfile->surname." ". auth()->user()->customerProfile->first_name."</p>
              <p>Available Balance: NGN ".number_format($new_user->wallet_balance)."</p>
              ";
              
                $data=[
                        'header'=>"Credit Alert",
                        'body'=>$email_body, 
                        'email'=>$user->email
                    ];


                 dispatch(new SendEmailJob($data));
                 
                 
                 
                 //send to sender
                 
                    $name =auth()->user()->customerProfile->first_name;
              $email_body="
              <p>Hi ".ucwords(strtolower($name)).",</p>
              <p>You transfered the sum of NGN ".number_format($request->amount)."  from your quickmann wallet to ".$user->surname." ". $user->first_name."</p>
              <p>Available Balance: NGN ".number_format(auth()->user()->customerProfile->wallet_balance)."</p>
              ";
              
                $data=[
                        'header'=>"Debit Alert",
                        'body'=>$email_body, 
                        'email'=>auth()->user()->email
                    ];


                 dispatch(new SendEmailJob($data));
              
             return back()->with('success_msg','Transaction successful');
        
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
        if($request->type == 'step_one')
        {

            $request->validate([
                'gender' => ['required'],
                'marital_status' => ['required'],

            ]);

            Auth::user()->customerprofile->othername =$request->othername;
            Auth::user()->customerprofile->dob =$request->dob;

            Auth::user()->customerprofile->gender =$request->gender;
            Auth::user()->customerprofile->marital_status =$request->marital_status;
            Auth::user()->customerprofile->profile_status ='step_one';
            Auth::user()->customerprofile->save();
            return redirect('/dashboard');


        }
        elseif($request->type == 'step_two')
        {

        $request->validate([
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'address' => ['required'],

        ]);

        Auth::user()->customerprofile->city =$request->city;
        Auth::user()->customerprofile->state =$request->state;
        Auth::user()->customerprofile->address =$request->address;
        Auth::user()->customerprofile->profile_status ='step_two';
        Auth::user()->customerprofile->save();

        return redirect('/dashboard');


        }

        elseif($request->type == 'step_three')
        {
            $request->validate([
                'address' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'names' => ['required'],
                'email' => ['required','email','string'],
                'phone_number' => ['required',new phonenumber],
                'address' => ['required'],
                'relationship' => ['required'],
                'gender' => ['required'],

            ]);

            Auth::user()->customerprofile->next_of_kin_city =$request->city;
            Auth::user()->customerprofile->next_of_kin_state =$request->state;
            Auth::user()->customerprofile->next_of_kin_address =$request->address;
            Auth::user()->customerprofile->next_of_kin_name =$request->names;
            Auth::user()->customerprofile->next_of_kin_email =$request->email;
            Auth::user()->customerprofile->next_of_kin_phone =$request->phone_number;
            Auth::user()->customerprofile->next_of_kin_relationship =$request->relationship;
            Auth::user()->customerprofile->next_of_kin_gender =$request->gender;
            Auth::user()->customerprofile->profile_status ='step_three';
            Auth::user()->customerprofile->save();

        return redirect('/dashboard');


        }
        elseif($request->type == 'step_four')
        {

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

       ]);


       $image = time().'.'.$request->profile_photo->getClientOriginalExtension();

       $request->profile_photo->move(public_path('/images'), $image);
       Auth::user()->customerprofile->profile_photo =$image;


       Auth::user()->customerprofile->save();

       $image = Session::put('image',$image);

       return redirect('/dashboard');

        }
        elseif($request->type == 'change')
        {

            $image = Session::forget('image');


       return redirect('/dashboard');
        }
        elseif($request->type == 'save')
        {

            $image = Session::forget('image');

            Auth::user()->customerprofile->profile_status ='complete';
            Auth::user()->customerprofile->save();

       return redirect('/dashboard');
        }
         elseif($request->type == 'step_six')
        {

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

       ]);


       $image = time().'.'.$request->profile_photo->getClientOriginalExtension();

       $request->profile_photo->move(public_path('/images'), $image);
       Auth::user()->customerprofile->profile_photo =$image;


       Auth::user()->customerprofile->save();



       return back()->with('success_msg','Uploaded Successful');

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
        //
    }
}
