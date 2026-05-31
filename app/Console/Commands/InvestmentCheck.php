<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Investment;
use App\OtherTransaction;
use App\User;
use DB;
use Carbon\Carbon;
use App\Jobs\SendEmailJob;
class InvestmentCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:check';

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
       $invs= $this->getMaturedInvestment();
       foreach($invs as $inv)
       {
           $roi = $inv->rate * $inv->amount * $inv->duration/100;
           $total =$roi + $inv->amount;
           $inv->update([
               'status'=>'completed',
               'profit'=>$roi,
               ]);
               
               
            $user =User::find($inv->user_id);
            $this->createTransaction($total,$user);
            $this->fundWallet($user,$total);
            $data=$this->emailTemplate($total,$inv,$user);
               
            dispatch(new SendEmailJob($data));
                 
                   DB::commit();
               
            
       }
       
    }
    
    public function fundWallet($user,$amount)
    {
        $user ->customerProfile->wallet_balance = 
        $user ->customerProfile->wallet_balance +  $amount;
        $user ->customerProfile->save();
        
    }
    
    public function emailTemplate($total,$inv,$user)
    {
          $name =$user->customerProfile->first_name;
            
              $email_body="
              <p>Hi ".ucwords(strtolower($name)).",</p>
              <p>We are excited to share some fantastic news with you: your investment has reached its payout time, and your proceeds have been successfully sent to your wallet!.</p>
             
              <p><strong>Investment Details:</strong>
              Reference: #".$inv->ref."
              Principal Amount: NGN $inv->amount
              Payout Amount :NGN $total 
              Duration: ".$inv->duration."months
              Start Date: ".Carbon::parse($inv->created_at)->format('d F, Y')."
              Payout Date: ".Carbon::parse($inv->created_at)->addMonths($inv->duration)->format('d F, Y')."
             </p>
            
              <p>Your decision to invest with us has proven to be a wise one, and we are delighted to witness the success of your investment journey. We understand that reaching the payout time is a significant milestone, and we are here to ensure a smooth and efficient process.</p>
              <p><strong>Payout Process:</strong>
              Your payout amount of NGN ".number_format($total,2)." has been credited to your designated wallet, making it easily accessible for your convenience. You can check your wallet balance and initiate any transactions or withdrawals as needed.</p>
              <p>We take pride in delivering on our commitment to provide you with a reliable investment experience, and your satisfaction is our top priority. If you have any questions or require further assistance regarding your wallet or any other financial matters, please do not hesitate to reach out to our dedicated support team.</p>
              <p>Thank you for choosing us as your investment partner. We are committed to your financial success and look forward to continuing to support your investment objectives</p>
              <p>Congratulations once again on your successful investment, and we are here to assist you every step of the way.</p>
              ";
              
               return $data=[
                        'header'=>"Congratulations! Your Investment Has Reached Payout Time",
                        'body'=>$email_body, 
                        'email'=>$user->email
                    ];
        
    }
    public function createTransaction($total,$user)
    {
        
        OtherTransaction::create([
        'user_id'=>$user->id,
        'type'=>'Investment Payout ',
        'cd'=>'credit',
        'amount'=>$total,
        'status'=>"success"
        ]);
         
    }
    
    public function getMaturedInvestment()
    {
return $investments = Investment::where('status', 'in progress')
    ->get()
    ->filter(function ($investment) {
        $duration = (int)$investment->duration;
        $created_at = Carbon::parse($investment->created_at);
        $cutoff_date = Carbon::now()->subMonths($duration);
        return $created_at->lte($cutoff_date);
    });

$investments = $investments->values(); 





    }
}
