<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use Auth;
use DB;
use Carbon\Carbon;
use App\Jobs\SendEmailJob;
class AdminAppointmentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
      

       
       
    }
    
    
    public function index()
    {
        
          if(Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD')
        {
      

         
        $app = Appointment::
                   join('customer_properties','customer_properties.id','appointments.property_id')
                   ->join('users','users.id','appointments.user_id')
                   ->join('customer_profiles','customer_profiles.user_id','users.id')
                   ->join('plots','customer_properties.plot_id','plots.id')
                   ->join('products','products.id','plots.product_id')
                   ->select('products.location_name','plots.Plot_id','products.*','customer_properties.id as prop_id','appointments.*','customer_profiles.*','users.*', 'appointments.id as app_id')
                   ->orderBy('appointments.schedule_date', 'DESC')
                   ->paginate(30);

        return view('Staff.appointment.index')->with(compact('app'));
        }
        else
        {      return redirect('/home');
        }
     
    }
    
    
    
    

public function approve(Request $request, $id)
{
   
    
       try {   
           
           $app =Appointment::join('customer_properties','customer_properties.id','appointments.property_id')
                   ->join('users','users.id','appointments.user_id')
                   ->join('customer_profiles','customer_profiles.user_id','users.id')
                   ->join('plots','customer_properties.plot_id','plots.id')
                   ->join('products','products.id','plots.product_id')
                   ->where('appointments.id',$id)->first();
                   
                   
                       $appb =Appointment::where('id',$id)->first();
           
              
            \DB::beginTransaction();
    
    
    
        $appb->update([
        'status'=>"approved",
        ]);
        
    
         
      
             $name =$app->first_name;
             
              
              $email_body="<p>Hi ".ucwords(strtolower($name)).",</p>
              <p>I hope this message finds you well.</p>
              <p>I'm writing to inform you that your appointment schedule has been successfully approved. We look forward to welcoming you on ".Carbon::parse($app->schedule_date)->format('d F, Y' )."
              at ".Carbon::parse($app->schedule_date)->format('h:ia' )." for your appointment at $app->Plot_id  $app->location_name $app->address $app->town $app->state .</p>
              <p>Should you have any questions or need further assistance, feel free to reach out to us. We're here to ensure a seamless experience for you.</p>
              <p>Thank you for choosing us. We appreciate your trust in us and are committed to making your appointment a valuable and efficient session.</p>
              <p>Best Regards,</p>";
            
           
                $data=[
                        'header'=>"Appointment Approval",
                        'body'=>$email_body, 
                        'email'=>$app->email
                    ];
                 dispatch(new SendEmailJob($data));
                 
                 
                 
                   DB::commit();
     
     return back()->with('success_msg','Appointment Approved Successful');
           
            
      
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('danger_msg',$th->getMessage());
            
     }

}



public function decline(Request $request, $id)
{
   
    
       try {   
           
           $app =Appointment::join('customer_properties','customer_properties.id','appointments.property_id')
                   ->join('users','users.id','appointments.user_id')
                   ->join('customer_profiles','customer_profiles.user_id','users.id')
                   ->join('plots','customer_properties.plot_id','plots.id')
                   ->join('products','products.id','plots.product_id')
                   ->where('appointments.id',$id)->first();
                   
                   
            $appb =Appointment::where('id',$id)->first();
           
              
            \DB::beginTransaction();
    
    
    
        $appb->update([
        'status'=>"declined",
        ]);
        
    
         
      
             $name =$app->first_name;
             
              
              $email_body="<p>Hi ".ucwords(strtolower($name)).",</p>
             <p>I hope this message finds you well.</p>
             <p>I regret to inform you that, unfortunately, your requested appointment schedule has been declined due to certain circumstances.</p>
             <p>We understand the importance of your appointment and apologize for any inconvenience this may cause. If you have any further questions or would like to reschedule, please feel free to contact us, and we'll be more than happy to assist you in finding an alternative arrangement that suits your needs.</p>
             <p>Thank you for your understanding. We appreciate your consideration and look forward to the possibility of scheduling a future appointment with you.</p>
             <p>Best Regards,</p>";
            
           
                $data=[
                        'header'=>"Decline Appointment",
                        'body'=>$email_body, 
                        'email'=>$app->email
                    ];
                 dispatch(new SendEmailJob($data));
                 
                 
                 
                   DB::commit();
     
     return back()->with('success_msg','Appointment Declined Successful');
           
            
      
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('danger_msg',$th->getMessage());
            
     }

}


public function reschedule(Request $request, $id)
{
   
    
       try {   
               
            \DB::beginTransaction();
           $app =Appointment::join('customer_properties','customer_properties.id','appointments.property_id')
                   ->join('users','users.id','appointments.user_id')
                   ->join('customer_profiles','customer_profiles.user_id','users.id')
                   ->join('plots','customer_properties.plot_id','plots.id')
                   ->join('products','products.id','plots.product_id')
                   ->where('appointments.id',$id)->first();
                   
                   
            $appb =Appointment::where('id',$id)->first();
           
          
    
    
    
        $appb->update([
        'status'=>"awaiting reschedule approval",
        'reschedule_date'=>$request->reschedule_date
        ]);
        
    
         
      
             $name =$app->first_name;
             
              
              $email_body="<p>Hi ".ucwords(strtolower($name)).",</p>
              <p>I trust this message finds you well.</p>
              <p>I wanted to inform you promptly about a change in the schedule for your upcoming appointment.
              The appointment previously set for ".Carbon::parse($app->schedule_date)->format('d F, Y h:ia' )." has been rescheduled to ".Carbon::parse($request->reschedule_date)->format('d F, Y h:ia' ).".</p>

<p>If the revised timing doesn't suit your schedule, we completely understand. To decline the rescheduled appointment, kindly log in to your dashboard on our platform. You'll find the option to decline there, ensuring we can accommodate your needs effectively.</p>

<p>However, if the new schedule aligns with your availability, acknowledging it by logging into your dashboard would be greatly appreciated. The updated appointment details are available for your review.</p>

<p>Should you encounter any challenges or require assistance in navigating the dashboard, please don't hesitate to reach out. Our team is dedicated to assisting you and ensuring a seamless experience.</p>

<p>Thank you for your cooperation and understanding. We strive to provide the best service tailored to your convenience.</p>
<center'><a class='btn btn-sm btn primary' style='background:blue; color:#fff; border-radius:1px solid blue; padding:5px 7px' href='".url('/')."/dashboard'>Goto Dashboard</a></center>
<p>Best Regards,</p>
";
            
           
                $data=[
                        'header'=>"Update: Rescheduled Appointment",
                        'body'=>$email_body, 
                        'email'=>$app->email
                    ];
                 dispatch(new SendEmailJob($data));
                 
                 
                 
                   DB::commit();
     
     return back()->with('success_msg','Appointment Rescheduled Successful');
           
            
      
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('danger_msg',$th->getMessage());
            
     }

}
}
