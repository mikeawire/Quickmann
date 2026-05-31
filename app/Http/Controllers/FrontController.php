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
class FrontController extends Controller
{
    public function success_page()
    {
    return view('Staff/success_page');
    }
    
    
          public function __destruct()
    {
        $this->middleware('auth');
    }
    
    
      public function registerstaff(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255' , 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'access_code' => ['required', 'string', 'min:8', 'confirmed'],
            'position' => ['required'],
        ]);


        $user =User::where('email',$request->email)->first();
        if(!$user)
        {

       return back()->with('warning_msg','Email Not Registered Yet');

        }
        else
        {
        
     $access = AccessCode::where('user_id',$user->id)->where('access_code', $request->access_code)->first();

                if(!$access)
                {
                    return back()->with('warning_msg','Invalid Access Code or User Has been verified before');
                }
                 else  {

                $newuser =User::find($user->id);
                $newuser->username = $request->username;
                $newuser->password = Hash::make($request->password);
                $newuser->save();
                $staff = StaffProfile::where('user_id',$user->id)->first();

                        $staff->role =$request->position;
                        $staff->save();
                        $access->delete();
                        
                        return redirect('/success')->with('success_msg','Registration is successful, please login to complete your profile');
                    
                }
                }
            }
            
            
        
}
