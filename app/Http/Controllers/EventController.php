<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BirthdayTemplate;
use App\WishTemplate;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
      

       
       
    }


  
 

    public function customerBirthday()
    {
        if(Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD')
        {
      

        $cus_birthday =BirthdayTemplate::where('user_type','customer')->first();

        return view('Staff.events.customer-birthday')->with(compact('cus_birthday'));
        }
        else
        {      return redirect('/home');
        }
    }

    public function staffBirthday()
    {
        if(Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD')
        {
      
        $staff_birthday =BirthdayTemplate::where('user_type','staff')->first();
        
        return view('Staff.events.staff-birthday')->with(compact('staff_birthday'));
    }
    else
    {      return redirect('/home');
    }
    }


    public function saveCustomerBirthday(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',  // Assuming you have an order_id field
            'email_body' => 'required|string',
            'sms_body' => 'required|string',
            'status'=>'required|boolean'
        ]);

       
         if($request->has("sms_platform"))
         {
            $sms =$request->sms_platform;
         }
         else
         {
            $sms =0;
         }

         if($request->has("email_platform"))
         {
            $email =$request->email_platform;
         }
         else
         {
            $email =0;
         }
        $cus_birthday =BirthdayTemplate::where('user_type','customer')->first();

        if($cus_birthday){
            $cus_birthday->update([
                'subject' => $request->subject,
                'email_body'=>$request->email_body,
                'sms_body'=>$request->sms_body,
                'status'=>$request->status,
                'sms_platform'=>$sms,
                'email_platform'=>$email,
                
            ]);
        }
        else
        {
            BirthdayTemplate::create([
              
                'subject' => $request->subject,
                'email_body'=>$request->email_body,
                'sms_body'=>$request->sms_body,
                'user_type'=>"customer",
                'status'=>$request->status,
                'sms_platform'=>$sms,
                'email_platform'=>$email,
            ]);
        }
      

        return back()->with('success_msg','Customer Birthday Template Updated Successful');   
    
    }



    

    public function saveStaffBirthday(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',  // Assuming you have an order_id field
            'email_body' => 'required|string',
            'sms_body' => 'required|string',
            'status'=>'required|boolean'
        ]);
        
         
        if($request->has("sms_platform"))
        {
           $sms =$request->sms_platform;
        }
        else
        {
           $sms =0;
        }

        if($request->has("email_platform"))
        {
           $email =$request->email_platform;
        }
        else
        {
           $email =0;
        }
        $staff_birthday =BirthdayTemplate::where('user_type','staff')->first();

        if($staff_birthday){
            $staff_birthday->update([
                'subject' => $request->subject,
                'email_body'=>$request->email_body,
                'sms_body'=>$request->sms_body,
                'status'=>$request->status,
                'sms_platform'=>$sms,
                'email_platform'=>$email,
                
            ]);
        }
        else
        {
            BirthdayTemplate::create([
              
                'subject' => $request->subject,
                'email_body'=>$request->email_body,
                'sms_body'=>$request->sms_body,
                'user_type'=>"staff",
                'status'=>$request->status,
                'sms_platform'=>$sms,
                'email_platform'=>$email,
            ]);
        }
      

        return back()->with('success_msg','Staff Birthday Template Updated Successful');   
    
    }


    public function wishes()
    {
        if(Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD')
        {
      
        $wishes =WishTemplate::orderBy('created_at','DESC')->get();

        return view('Staff.events.wishes.index')->with(compact('wishes'));
    }
    else
    {      return redirect('/home');
    }
    }
    public function createWish()
    {
        return view('Staff.events.wishes.create');
    }


    public function editWish($id)
    {
        $wish =WishTemplate::findOrFail($id);

        return view('Staff.events.wishes.edit')->with(compact('wish'));
    }





    

    public function storeWish(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',  // Assuming you have an order_id field
            'email_body' => 'required|string',
            'sms_body' => 'required|string',
            'date'=>'required|date',
            'category'=>'required',
            'status'=>'required|boolean'
        ]);
        
         
        if($request->has("sms_platform"))
        {
           $sms =$request->sms_platform;
        }
        else
        {
           $sms =0;
        }

        if($request->has("email_platform"))
        {
           $email =$request->email_platform;
        }
        else
        {
           $email =0;
        }
       
        
            WishTemplate::create([
              
                'subject' => $request->subject,
                'email_body'=>$request->email_body,
                'sms_body'=>$request->sms_body,
                'user_type'=>$request->category,
                'date'=>$request->date,
                'status'=>$request->status,
                'sms_platform'=>$sms,
                'email_platform'=>$email,
            ]);
        
      

        return back()->with('success_msg','Wish Template Created Successful');   
    
    }




    

    public function updateWish(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string',  // Assuming you have an order_id field
            'email_body' => 'required|string',
            'sms_body' => 'required|string',
            'date'=>'required|date',
            'category'=>'required',
            'status'=>'required|boolean'
        ]);
        
         
        if($request->has("sms_platform"))
        {
           $sms =$request->sms_platform;
        }
        else
        {
           $sms =0;
        }

        if($request->has("email_platform"))
        {
           $email =$request->email_platform;
        }
        else
        {
           $email =0;
        }
       
        $wish =WishTemplate::find($id);
        if($wish){

            $wish->update([
              
                'subject' => $request->subject,
                'email_body'=>$request->email_body,
                'sms_body'=>$request->sms_body,
                'user_type'=>$request->category,
                'date'=>$request->date,
                'status'=>$request->status,
                'sms_platform'=>$sms,
                'email_platform'=>$email,
            ]);
        }
        
        
      

        return back()->with('success_msg','Wish Template Updated Successful');   
    
    }



    
    

    public function deleteWish( $id)
    {
       
        $wish =WishTemplate::findOrFail($id)->delete();
        return back()->with('success_msg','Wish Template Deleted Successful');   
    
    }
}
