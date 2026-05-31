<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Excel;
use carbon\carbon;
use App\MonthlyRecord;
use App\Models\Deposit;
use App\Exports\DepositExport;
use App\Models\CustomerProfile;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   public function __construct()
    {
        $this->middleware('auth');
       
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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

             $deposits = Deposit::whereMonth('created_at',carbon::now())->where('status','success')->where('payment_type','!=','topup');
             $defaulters =MonthlyRecord::whereDate('month','<',carbon::now()->month)->where('status','pending');
            
             $arriers =MonthlyRecord::where('status','pending');

             $adv =MonthlyRecord::whereDate('month','>',carbon::now()->month)->where('status','success');


/*
           $users =User::where('user_type','customer')->get();
           //dd($users);
      $cs = CustomerProfile::get();
      //dd($cs);
           foreach ($users as $user) {
             $cs = CustomerProfile::where('user_id',$user->id)->get();
            if($cs->count() == 0)
            {
 DB::statement('SET FOREIGN_KEY_CHECKS=0;');
              foreach ($cs as $c) {

              
              }
              
               $user->delete();
              
               DB::statement('SET FOREIGN_KEY_CHECKS=1;');
          
           }
            }
            
            */
          
        return view('home')->with(compact('deposits','defaulters','arriers','adv'));
    }
    
    
 
public function show($type)
{
  
 return Excel::download(new DepositExport, 'disney.csv');
    
}
}

