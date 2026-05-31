<?php

namespace App\Http\Controllers;


use App\Withdrawal;
use App\Investment;
use Illuminate\Http\Request;
use App\User;
use App\ OtherTransaction;
use App\Models\CustomerProperty;
use App\Models\CustomerProfile;
use Auth;
use DB;
use Carbon\Carbon;
use App\Jobs\SendEmailJob;
class AdminTransactionController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    
    
       public function withdrawal()
    {
        if(!Auth::user()->staffprofile->role =='MD')
        {
            return redirect('/home');
        }
        $count=1;
        $withdrawals = Withdrawal::join('customer_profiles','customer_profiles.user_id','withdrawals.user_id')->join('users','customer_profiles.user_id','users.id')->orderBy('withdrawals.created_at','DESC')->select('withdrawals.id as w_id','withdrawals.*','users.phone','customer_profiles.*')->simplePaginate();
        
        return view('Staff/withdrawal/index')->with(compact('withdrawals','count'));
    }
    
    
      public function approveWithdrawal(Request $request, $id)
    {
        
       
        
       try {   
           
               \DB::beginTransaction();
    
        $withdrawal =  Withdrawal::findOrFail($id);
        $withdrawal->update([
            'status'=>'success'
            ]);
            
            
        DB::commit();
       
      
       return back()->with('success_msg','Withdrawal approved successful');
           
            
      
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('danger_msg',$th->getMessage());
            
     }
    }
    
    
    
    
      public function declineWithdrawal(Request $request, $id)
    {
        
       
        
            try { 
      
           
               \DB::beginTransaction();
        $withdrawal =  Withdrawal::findOrFail($id);
           $user=User::find($withdrawal->user_id);
              $user_profile=CustomerProfile::where('user_id',$withdrawal->user_id)->first();
        
        $withdrawal->update([
            'status'=>'failed'
            ]);
            
            
            
         
         
            $user_profile->wallet_balance = $user_profile->wallet_balance + $withdrawal->amount;
            $user_profile->save();
            
               
        OtherTransaction::create([
        'user_id'=>$user->id,
        'type'=>'withdrawal reverser',
        'cd'=>'credit',
        'amount'=>$withdrawal->amount,
        'status'=>"success"
        ]);
            
            
            
            
             $name =$user_profile->first_name;
            
              $email_body="
              <p>Hi ".ucwords(strtolower($name)).",</p>
              <p>I hope this message finds you in good health. We are pleased to inform you about the status of your withdrawal request of NGN".number_format($withdrawal->amount,2).".
              Unfortunately, the request has been declined and your fund reversed to your wallet. 
              Kindly contact the support for more clarification</p>
             <p>Thanks</p>
              ";
              
                $data=[
                        'header'=>"Withdrawal decline alert",
                        'body'=>$email_body, 
                        'email'=>$user->email
                    ];

          dispatch(new SendEmailJob($data));
        DB::commit();
       
      
       return back()->with('success_msg','Withdrawal declined successful');
           
         
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('danger_msg',$th->getMessage());
            
     }
    }
  
  
  
  
     
       public function investment()
    {
         if(!Auth::user()->staffprofile->role =='MD')
        {
            return redirect('/home');
        }
        $count=1;
        $investments = Investment::join('customer_profiles','customer_profiles.user_id','investments.user_id')->join('users','customer_profiles.user_id','users.id')->select('investments.id as inv_id','investments.*','users.phone','customer_profiles.*', 'investments.created_at as inv_created_at')->orderBy('investments.created_at','DESC')->simplePaginate();
        
        return view('Staff/investment/index')->with(compact('investments','count'));
    }
    
    
           public function liquidationRequest()
    {
         if(!Auth::user()->staffprofile->role =='MD' )
        {
            return redirect('/home');
        }
        $count=1;
        $investments = Investment::join('customer_profiles','customer_profiles.user_id','investments.user_id')->join('users','customer_profiles.user_id','users.id')->select('investments.id as inv_id','investments.*','users.phone','customer_profiles.*', 'investments.created_at as inv_created_at')->where('status','liquidation requested')->orderBy('investments.created_at','DESC')->simplePaginate();
        
        return view('Staff/investment/liquidation_request')->with(compact('investments','count'));
    }
    
    
public function approveLiquidationRequest(Request $request, $id)
{
   
    
       try {   
           
           $inv =Investment::findorFail($id);
           
              
            \DB::beginTransaction();
    
    
    $createdAt = $inv->created_at; 
    $currentDate = carbon::now();
    $monthsDifference = $createdAt->diffInMonths($currentDate);
    
    $rate= $inv->rate/100;
    $roi = $monthsDifference * $rate * $inv->amount;
    $lq=setting()->liquidation_profit_rate ?? 0;
    $profit = $roi * ($lq/100);
    $total =$profit + $inv->amount;
    
        $inv->update([
        'status'=>"liquidated",
        ]);

       $user = CustomerProfile::where('user_id',$inv->user_id)->first();
        
       $user->wallet_balance = 
        $user->wallet_balance +  $inv->profit;
         $user->save();
     
         
         
        OtherTransaction::create([
        'user_id'=>$user->user_id,
        'type'=>'investment liquidation ',
        'cd'=>'credit',
        'amount'=>$inv->profit,
        'status'=>"success"
        ]);
        
        
         
      
             $name =$user->first_name;
             
              
              $email_body="
              <p>Hi ".ucwords(strtolower($name)).",</p>
              <p>We have diligently executed the liquidation of your investment in accordance with your instructions and  established procedures. The proceeds from the liquidation have been credited into your bank wallet. Please verify that you have received the funds accordingly.</p>
               <p><strong>Investment Details:</strong>
              Reference: #".$inv->ref."
              Principal Amount: NGN $inv->amount
              Liquidation Amount :NGN $total 
              Duration: ".$inv->duration."months
              Start Date: ".Carbon::parse($inv->created_at)->format('d F, Y')."
              Payout Date: ".Carbon::parse($inv->created_at)->addMonths($inv->duration)->format('d F, Y')."
              Liquidation Date: ".Carbon::parse($inv->liquidation_date)->format('d F, Y')."</p>
            
              <p>We have diligently executed the liquidation of your investment in accordance with your instructions and our established procedures. The proceeds from the liquidation have been credited into your bank wallet. Please verify that you have received the funds accordingly.</p>
              <p>If you have any questions or require additional information regarding the liquidation, the final statement, or any other related matters, our dedicated support team is here to assist you. Your satisfaction and peace of mind are of utmost importance to us.</p>
              <p>We genuinely appreciate your trust in us, and we are honored to have been a part of your investment journey. Whether it's considering new opportunities, financial planning, or any other financial needs, please know that we remain at your service.</p>
              <p>Once again, thank you for choosing us as your investment partner. We wish you continued success in your financial endeavors and look forward to the possibility of working with you again in the future.</p>
              ";
              
           
                $data=[
                        'header'=>"Successful Investment Liquidation",
                        'body'=>$email_body, 
                        'email'=>auth()->user()->email
                    ];
                 dispatch(new SendEmailJob($data));
                 
                 
                 
                   DB::commit();
     
     return back()->with('success_msg','Liquidation request approved successful. please check your email for more infomation');
           
            
      
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('danger_msg',$th->getMessage());
            
     }

}
}
