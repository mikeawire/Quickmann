<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerProfile;
use App\User;
use App\Outbox;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use Auth;
use Str;
use Illuminate\Support\Facades\Http;
class OutboxController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($id)
    {

        
if(Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD')
{

        $cus=CustomerProfile::where('user_id',$id)->first();
        $user=User::find($id);
        $outbox =Outbox::where('user_id',$id)->orderBy('created_at','DESC')->get();
        if(!$cus)
        {
            return redirect(404);

        }
        return view('Staff.crm.index')->with(compact('cus','user','outbox'));

    }
    else

    {
        return redirect('/home');
    }
    }


    
    public function createEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string', 
            'email_body' =>'required|string', 
            'status'=>'required|boolean'
        ]);
        
         
      
            Outbox::create([
                'user_id'=>$request->user_id,
                'subject' => $request->subject,
                'email_body'=>$request->email_body,
                'status'=>$request->status,
                'email_platform'=>1,
            ]);
        
       if($request->status ==1)
       {
        try {
            $user=User::find($request->user_id);
            $cus=CustomerProfile::where('user_id',$request->user_id)->first();

            $replacements = [
                '{last_name}' => $cus->surname,   // Replace with the user's last name
                '{first_name}' => $cus->first_name, // Replace with the user's first name
            ];
            
            $email_body = str_replace(array_keys($replacements), $replacements, $request->email_body);
            
           
                $data=[
                    'header'=>$request->subject ?? '',
                    'body'=>$email_body, 
                    'email'=>$user->email
                ];
                dispatch(new SendEmailJob($data));
             $outbox->update([
                'status'=>1
             ]);
          
        } catch (\Throwable $th) {
            
        }
        $msg ="sent";
       }
       else
       {
        $msg="saved";
       }

        return back()->with('success_msg','Message '.$msg.' Successful');   
    
    }




    public function createSms(Request $request)
    {
        $request->validate([
            'sms_body' =>'required|string', 
            'status'=>'required|boolean'
        ]);
        
         
       $outbox= Outbox::create([
            'user_id'=>$request->user_id,
            'sms_body'=>$request->sms_body,
            'status'=>0,
            'sms_platform'=>1,
        ]);
         
        
       if($request->status ==1)
       {
               try {
      
            $user=User::find($request->user_id);
            $cus=CustomerProfile::where('user_id',$request->user_id)->first();

            $replacements = [
                '{last_name}' => $cus->surname,   // Replace with the user's last name
                '{first_name}' => $cus->first_name, // Replace with the user's first name
            ];
            
            $sms_body = str_replace(array_keys($replacements), $replacements, $request->sms_body);
            
           
                $data=[
                    'header'=>'',
                    'body'=>$sms_body, 
                    'phone'=>$user->phone
                ];

               dispatch(new SendSmsJob($data));
               
               
              // $this->sendSms(intval($user->phone), $sms_body);

             $outbox->update([
                'status'=>1
             ]);
             
           
          
        } catch (\Throwable $th) {
            
        }


        $msg ="sent";
       }
       else
       {
        $msg="saved";
       }
    
        return back()->with('success_msg','Message '.$msg.' Successful');   
    
    }





 public function sendSms($recipient, $message)
{
    $url = 'https://sms.vanso.com/rest/sms/submit/long'; // Replace with your API endpoint
    $username = 'NG.106.0919';
    $password = 'B5RqUs24';

    $postData = [
        "sms" => [
            "dest" => $recipient,
            "referenceId" => Str::random(10),
            "src" => "ISWTest",
            "text" => $message,
            "unicode" => false
        ],
        "account" => [
            "password" => $password,
            "systemId" => $username
        ]
    ];

    $response = Http::withBasicAuth($username, $password)
        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->post($url, $postData);

    // Get the response body or other details
    $responseBody = $response->body();
 $status = $response->status();
   return $response;

    // Handle the response or return it as needed
}
    

    public function send(Request $request, $id)
    {
       
        $outbox=Outbox::findOrFail($id);

        try {
            $user=User::find($outbox->user_id);
            $cus=CustomerProfile::where('user_id',$outbox->user_id)->first();

            $replacements = [
                '{last_name}' => $cus->surname,   // Replace with the user's last name
                '{first_name}' => $cus->first_name, // Replace with the user's first name
            ];
            
            $email_body = str_replace(array_keys($replacements), $replacements, $outbox->email_body);
             $sms_body = str_replace(array_keys($replacements), $replacements, $outbox->sms_body);
            
             if($outbox->email_platform ==1)
             {
                $data=[
                    'header'=>$outbox->subject ?? '',
                    'body'=>$email_body, 
                    'email'=>$user->email
                ];

             dispatch(new SendEmailJob($data));
             }

             if($outbox->sms_platform ==1)
             {
                $data=[
                    'header'=>"",
                    'body'=>$sms_body, 
                    'phone'=>$user->phone,
                ];
                   dispatch(new SendSmsJob($data));
             }

             $outbox->update([
                'status'=>1
             ]);
             return back()->with('success_msg','Message Sent Successful'); 
        } catch (\Throwable $th) {
            return back()->with('danger_msg','Something went wrong'); 
        }

         
    
    }




    

    public function destroy($id)
    {
       
        $outbox=Outbox::findOrFail($id)->delete();
try{
         return back()->with('success_msg','Message Deleted Successful'); 
        } catch (\Throwable $th) {
            return back()->with('danger_msg','Something went wrong'); 
        }

         
    
    }

}
