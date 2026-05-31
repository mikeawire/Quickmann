<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MonthlyRecord;
use App\User;
use App\Models\CustomerProperty;
use App\Models\Deposit;
use Carbon\Carbon;

class RecuringCharge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recuring:charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recuring Charge';

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
        $records= MonthlyRecord::whereDate('month','<',Carbon::now())->where('status','pending')->where('revoke_status','no')->orWhereMonth('month', Carbon::now()->month)->whereYear('month', Carbon::now()->year)->where('status','pending')->where('revoke_status','no')->take(100)->get();
    

        foreach($records as $record)
        {

            $deposit=Deposit::where('customer_id',$record->user_id)->where('customer_property_id',$record->customerproperty_id)->where('payment_method','online')->where('status','success')->whereNotNull('authorization_code')->orderBy('id','DESC')->first();

            $property=CustomerProperty::find($record->customerproperty_id);
            if($property->unpaid_balance >= $record->amount_due && $property->payment_status =="incomplete")
            {
                if($property->unpaid_balance < $record->amount_due && $property->unpaid_balance > 0)
                {
                    $amount_due=$property->unpaid_balance;
                }
                else
                {
                    $amount_due= $record->amount_due;
                }
                $user=User::find($record->user_id);
                $meta = json_encode($array = ['surname' =>$user->customerprofile->surname,'first_name' =>$user->customerprofile->first_name,'reg_id' =>$user->customerprofile->reg_no,'property_id'=>$record->customerproperty_id,'payment_type'=>'installment']);
               
                $tr=recuringCharge($deposit->authorization_code,$user,$amount_due,$meta);
              
                validateRecuringChargeResponse($tr,$user);
            }

           

           
           

        }
    }
}
