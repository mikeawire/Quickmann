<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use Auth;
use DB;
use Carbon\Carbon;
use App\Jobs\SendEmailJob;
class AppointmentController extends Controller
{
    
    
    public function index()
    {
        
       

         
        $app = Appointment::
                   join('customer_properties','customer_properties.id','appointments.property_id')
                   ->join('plots','customer_properties.plot_id','plots.id')
                   ->join('products','products.id','plots.product_id')
                   ->select('products.location_name','plots.Plot_id','products.*','customer_properties.id as prop_id','appointments.*','appointments.id as app_id')
                   ->where('appointments.user_id',auth()->user()->id)
                   ->orderBy('appointments.schedule_date', 'DESC')
                   ->paginate(30);

        return view('Customer.appointment.index')->with(compact('app'));
      
     
    }
    
    public function schedule(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'schedule_date' => 'required|date',
        'title' => 'required',
        'appointment_message' => 'required|max:2000',
        'property' => 'required',
      
       
    ]);

    if ($validator->fails()) {
        
        $data=[
            'data'=>[
                'errors' => $validator->errors()
                ]
            ];
         return response()->json($data, 422);
    }
    
    
      
      Appointment::create([
        'user_id'=>auth()->user()->id,
        'message'=>$request->appointment_message,
        'title'=>$request->title,
        'schedule_date'=>$request->schedule_date,
        'property_id'=>$request->property,
        ]);
        
     
        $data=[
            'message'=>'Appointment scheduled successful. You will get a confirmation mail from our customer service.'
            ];
    
      return response()->json($data, 200);
    
    
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
        
    
         

                 
                   DB::commit();
     
     return back()->with('success_msg','Rescheduled Appointment Approved Successful');
           
            
      
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
        
                   DB::commit();
     
     return back()->with('success_msg','Rescheduled Appointment Declined Successful');
           
            
      
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('danger_msg',$th->getMessage());
            
     }

}
}
