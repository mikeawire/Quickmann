<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomerProfile;
use App\BirthdayTemplate;
use App\Models\StaffProfile;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
class DobReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dob:reminder';

    /**
     * The console command description.
     *
     * @var string
     */

   
    protected $description = 'date of birth reminder';

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
       
       
        $this->pushCustomerBirthdayWish();
        //$this->pushStaffBirthdayWish();
       
    }


   


    public function pushCustomerBirthdayWish()

    {
       

        if($this->birthDayCustomers()->count() > 0)
        {
          $template=  $this->customerBirthdayTemplate();
          if($template && $template->status ==1)
          {
            foreach($this->birthDayCustomers()->toArray() as $birthday)
            {

                $replacements = [
                    '{last_name}' => $birthday['surname'],   // Replace with the user's last name
                    '{first_name}' => $birthday['first_name'], // Replace with the user's first name
                ];
                
                 $email_body = str_replace(array_keys($replacements), $replacements, $template->email_body);
                 $sms_body = str_replace(array_keys($replacements), $replacements, $template->sms_body);

                 // dispatch event
                 if($template->email_platform ==1)
                 {
                    $data=[
                        'header'=>$template->subject ?? '',
                        'body'=>$email_body, 
                        'email'=>$birthday['email']
                    ];

                 dispatch(new SendEmailJob($data));
                 }

                 if($template->sms_platform ==1)
                 {
                    $data=[
                        'header'=>$template->subject ?? '',
                        'body'=>$sms_body, 
                        'phone'=>$birthday['phone'],
                    ];
                       dispatch(new SendSmsJob($data));
                 }
                   
                
            }

        }
        }
       
    }


    public function pushStaffBirthdayWish()

    {
       

        if($this->birthDayStaffs()->count() > 0)
        {
          $template=  $this->staffBirthdayTemplate();
          if($template && $template->status ==1)
          {
            foreach($this->birthDayStaffs()->toArray() as $birthday)
            {

                $replacements = [
                    '{last_name}' => $birthday['surname'],   // Replace with the user's last name
                    '{first_name}' => $birthday['first_name'], // Replace with the user's first name
                ];
                
                 $email_body = str_replace(array_keys($replacements), $replacements, $template->email_body);
                 $sms_body = str_replace(array_keys($replacements), $replacements, $template->sms_body);

                 // dispatch event
                 if($template->email_platform ==1)
                 {
                    $data=[
                        'header'=>$template->subject ?? '',
                        'body'=>$email_body, 
                        'email'=>$birthday['email']
                    ];

                    dispatch(new SendEmailJob($data));
                 }

                 if($template->sms_platform ==1)
                 {
                    $data=[
                        'header'=>$template->subject ?? '',
                        'body'=>$sms_body, 
                        'phone'=>$birthday['phone']
                    ];
                       dispatch(new SendSmsJob($data));
                 }
                   
                
            }

        }
        }
       
    }

    public function customerBirthdayTemplate()
    {
       return BirthdayTemplate::where('user_type','customer')->where('status',1)->first();
    }

    public function staffBirthdayTemplate()
    {
       return BirthdayTemplate::where('user_type','staff')->where('status',1)->first();
    }
    public function birthDayCustomers()
    {
         $today = now();
         $month = $today->month; 
         $day = $today->day;  

    return $customers = CustomerProfile::join('users','customer_profiles.user_id','users.id')->whereMonth('dob', $month)
        ->whereDay('dob', $day)
        ->get(['email','surname','first_name','phone']);
    }


    
    public function birthDayStaffs()
    {
         $today = now();
         $month = $today->month; 
         $day = $today->day;  

    return $staffs = StaffProfile::join('users','Customer_profiles.user_id','users.id')->whereMonth('dob', $month)
        ->whereDay('dob', $day)
        ->get(['email','surname','first_name','phone']);
    }
}
