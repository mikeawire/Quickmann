<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\PhoneNumber;
use Mail;
use App\User;
use App\Models\CustomerProfile;
use App\Models\AccessCode;
use App\Models\Otp;

use App\Http\Requests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Twilio;
use Session;
use App\Jobs\SendSmsJob;
use Carbon\Carbon;
class CustomerSideRegisterController extends Controller
{
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


            if(Auth::user())

            return redirect('home');
            else

        return view('customerregister');
    }


    ///generate otp

    public function generateOTP(){
        $otp = mt_rand(1000,9999);
        return $otp;
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
            'phone_number' => ['required',new PhoneNumber],

        ]);
        //generate otp
        $otp = $this->generateOTP();

        //find user
        $user= User::where('phone',$request->phone_number)->first();
        if(!$user)
        {
            return back()->with('warning_msg','Phone Number not registered on QuickMann ');
        }

        else{
            
          $message='Verify your account with '.$otp.' which expire in 24hrs';

 if($user->customerprofile->isVerified ==true)

    return back()->with('warning_msg','User already have a verified account');
else
    $phone=Session::put('phone', $request->phone_number);
    $otp_code=Session::put('otp_code', $otp);

    $otp_user = new Otp;
    $otp_user->user_id = $user->id;
    $otp_user->otp_code = $otp;
    $otp_user->phone = $request->phone_number;
    $otp_user->save();

    //send otp

  $data=[
             'header'=>'',
                        'body'=>$message, 
                        'phone'=>intval($request->phone_number),
                    ];
                       dispatch(new SendSmsJob($data));
  

   $phone_number = $request->phone_number;
    return redirect('/verify')->with('phone_number',''.$phone_number.'');



        }
    }

     public function sendSms($recipient,$message)
    {

$req_url = "https://portal.nigeriabulksms.com/api/?username=quickaccesswebapps@gmail.com&password=$500@QuickAccess&message=".$message."&sender=quickmann&mobiles=".$recipient."";
        $response_json = file_get_contents($req_url);

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
    public function update(Request $request, $id)
    {

        $request->validate([
            'otp' => ['required'],

        ]);

        $otp_code = Session::get('otp_code');
        $phone = Session::get('phone');
        if($otp_code != $request->otp)
        return back()->with('warning_msg','Invalid One time password ');
else


        $otps = Otp::where('phone',$phone)->where('otp_code',$request->otp)->where('created_at', '>', Carbon::now()->subMinutes(1440)->toDateTimeString())->get();
if($otps->count() ==0)
{
    Session::forget('phone');
    Session::forget('otp_code');
    return back()->with('warning_msg','otp session have expired reverify your phone number ');
}



else
{


        foreach($otps as $otp)
{
    Session::forget('phone');
    Session::forget('otp_code');

    $user_id=Session::put('user_id', $otp->user_id);
    $otp->delete();
    return redirect('mainregister');

}
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
