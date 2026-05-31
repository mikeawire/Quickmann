<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomerProfile;
use App\WishTemplate;
use App\Models\StaffProfile;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;

class HolidayReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holiday:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->pushStaffReminder();
       $this->pushCustomerReminder();
    }

    public function pushStaffReminder()
    {
        foreach($this->getRunningStaffTemplate() as $template)
        {
           foreach($this->staffs() as $staff)
           {
           
           
            
                $replacements = [
                    '{last_name}' => $staff['surname'],   // Replace with the user's last name
                    '{first_name}' => $staff['first_name'], // Replace with the user's first name
                ];
                
                $email_body = str_replace(array_keys($replacements), $replacements, $template->email_body);
                 $sms_body = str_replace(array_keys($replacements), $replacements, $template->sms_body);
    
            // dispatch event
            if($template->email_platform ==1)
            {
               $data=[
                   'header'=>$template->subject ?? '',
                   'body'=>$email_body, 
                   'email'=>$staff['email']
               ];

                 dispatch(new SendEmailJob($data));

                
            }

            if($template->sms_platform ==1)
            {
               $data=[
                   'header'=>$template->subject ?? '',
                   'body'=>$sms_body, 
                   'phone'=>$staff['phone']
               ];
              
                 dispatch(new SendSmsJob($data));
            }

 }
            $template->status =0;
            $template->save();
              
          
        
        }
    }



    
    public function pushCustomerReminder()
    {
     
      
      
        foreach($this->getRunningCustomerTemplate() as $template)
        {
          
           foreach($this->customers() as $cus)
           {
            
                $replacements = [
                    '{last_name}' => $cus['surname'],   // Replace with the user's last name
                    '{first_name}' => $cus['first_name'], // Replace with the user's first name
                ];
                
                $email_body = str_replace(array_keys($replacements), $replacements, $template->email_body);
                 $sms_body = str_replace(array_keys($replacements), $replacements, $template->sms_body);
    
            // dispatch event
            if($template->email_platform ==1)
            {
               $data=[
                   'header'=>$template->subject ?? '',
                   'body'=>$email_body, 
                   'email'=>$cus['email']
               ];

                 dispatch(new SendEmailJob($data));
            }

            if($template->sms_platform ==1)
            {
               $data=[
                   'header'=>$template->subject ?? '',
                   'body'=>$sms_body, 
                   'phone'=>$cus['phone']
               ];
                 dispatch(new SendSmsJob($data));
            }

          
              
           }
           
             $template->status =0;
            $template->save();
        
        }
    }


    public function getRunningCustomerTemplate()
    {
        $fiveMinutesAgo = now()->subMinutes(5)->format('Y-m-d H:i:s');

return WishTemplate::where(function ($query) use ($fiveMinutesAgo) {
    $query->where('date', '>=', $fiveMinutesAgo);
})
->where('user_type', 'customer')
->where('status', 1)
->get();

    }
    public function getRunningStaffTemplate()
    {
       $fiveMinutesAgo = now()->subMinutes(5)->format('Y-m-d H:i:s');

return WishTemplate::where(function ($query) use ($fiveMinutesAgo) {
    $query->where('date', '>=', $fiveMinutesAgo);
})
->where('user_type', 'staff')
->where('status', 1)
->get();


    }
    



    public function customers()
    {
        return $customers = CustomerProfile::join('users','customer_profiles.user_id','users.id')->get(['email','surname','first_name','phone']);
    }


    
    public function staffs()
    {
      
     return $staffs = StaffProfile::join('users','staff_profiles.user_id','users.id')->get(['email','surname','first_name','phone']);
    }

}
