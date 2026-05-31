<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Auth;
use DB;
class GeneralSettingController extends Controller
{
      
       public function __construct()
    {
        $this->middleware('auth');
    }
       public function index()
    {
        
         if(!Auth::user()->staffprofile->role =='MD')
        {
            return redirect('/home');
        }
        
        $setting = Setting::first();
        return view('Staff/setting/index')->with(compact('setting'));
    }
    
    
    
          public function store(Request $request)
    {
        
          
              $request->validate([
            'investment_rate' => 'required|numeric', 
            'investment_duration' => 'required|numeric', 
            'liquidation_profit_rate' => 'required|numeric', 
            'liquidation_request_email'=>'required|email'
        ]);
           
        
       try {
               \DB::beginTransaction();
    
        $setting = Setting::first();
        if($setting)
        {
             $setting->update($request->all());
             
        }
        else
        {
            Setting::create($request->all());
        }
            
            
        DB::commit();
       
      
       return back()->with('success_msg','Setting Updated Successful');
           
            
      
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('warning_msg',$th->getMessage());
            
     }
    }
}
