<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse; // Import JsonResponse class
use App\Models\Deposit;
use App\Withdrawal;
use App\Investment;
use App\OtherTransaction;
use Paystack;
use DB;
use Str;
use Auth;
use Carbon\Carbon;
use App\Jobs\SendEmailJob;
class WalletController extends Controller
{
    
    public function __construct()
    {
          $this->middleware('auth');
    }
    
    public function topup(Request $request)
    {
       
        if($request->amount ==null)
        {
          $data = [
    'data' => [
        'errors' => [
            'amount' => [
                0 => "Amount is required"
            ]
        ]
    ]
];

            return response()->json($data, 422);
        }

      
      
        $this->middleware('auth');
    
        request()->reference = Paystack::genTranxRef();
        request()->amount =$request->amount *100;

        $url =Paystack::getAuthorizationUrl();

       $deposit =new Deposit;
       $deposit->customer_id = Auth::user()->id;
       $deposit->customer_reg_no = Auth::user()->customerprofile->reg_no;
       $deposit->payment_type  = "topup";
       $deposit->amount = $request->amount;
       $deposit->ref_id = $request->reference; 
       $deposit->save();
        return response()->json($url, 200);
       
    
    }
    
    
public function withdraw(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'account_name' => 'required',
        'bank_name' => 'required',
        'account_number' => 'required',
        'account_type' => 'required',
        'withdrawal_amount' => 'required',
       
    ],[
     'withdrawal_amount.required'=>'Amount is required'
    ]);

    if ($validator->fails()) {
        
        $data=[
            'data'=>[
                'errors' => $validator->errors()
                ]
            ];
         return response()->json($data, 422);
    }
    
  
        
    if($request->withdrawal_amount < 1)
    {
         $data=[
            'message'=>'Amount must be greater than 0'
            ];
    
         return response()->json($data, 401);
    }
        
    if( auth()->user()->customerProfile->wallet_balance  < $request->withdrawal_amount)
    {
         $data=[
            'message'=>'Insufficient fund in your wallet balance'
            ];
    
         return response()->json($data, 401);
    }
    
      Withdrawal::create([
        'user_id'=>auth()->user()->id,
        'account_number'=>$request->account_number,
        'account_name'=>$request->account_name,
        'bank_name'=>$request->bank_name,
        'account_type'=>$request->account_type,
        'amount'=>$request->withdrawal_amount,
        'status'=>"pending"
        ]);
        
        auth()->user()->customerProfile->wallet_balance =  auth()->user()->customerProfile->wallet_balance - $request->withdrawal_amount;
         auth()->user()->customerProfile->save();
        $data=[
            'message'=>'Withdrawal request sent successful'
            ];
    
      return response()->json($data, 200);

}




public function invest(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'investment_amount' => 'required',
       
    ],[
     'investment_amount.required'=>'Amount is required'
    ]);

    if ($validator->fails()) {
        
        $data=[
            'data'=>[
                'errors' => $validator->errors()
                ]
            ];
         return response()->json($data, 422);
    }
    

        
    if($request->investment_amount < 1)
    {
         $data=[
            'message'=>'Amount must be greater than 0'
            ];
    
         return response()->json($data, 401);
    }
        
    if( auth()->user()->customerProfile->wallet_balance  < $request->withdrawal_amount)
    {
         $data=[
            'message'=>'Insufficient fund in your wallet balance'
            ];
    
         return response()->json($data, 401);
    }
       try {   
              
            \DB::beginTransaction();
    $ref=Str::random(20);
    $rate=setting()->investment_rate ?? 0;
     $f_rate= $rate/100;
     $duration=setting()->investment_duration ?? 12;
     $roi =$request->investment_amount * $f_rate * $duration;
     $total =($request->investment_amount * $f_rate * $duration) + $request->investment_amount;
        $inv=Investment::create([
        'user_id'=>auth()->user()->id,
        'rate'=>$rate,
        'duration'=>$duration,
        'amount'=>$request->investment_amount,
        'status'=>"in progress",
        'ref'=>$ref
        ]);
        
        auth()->user()->customerProfile->wallet_balance =  auth()->user()->customerProfile->wallet_balance - $request->investment_amount;
         auth()->user()->customerProfile->save();
         
        OtherTransaction::create([
        'user_id'=>auth()->user()->id,
        'type'=>'investment',
        'cd'=>'debit',
        'amount'=>$request->investment_amount,
        'status'=>"success"
        ]);
         
      
             $name =auth()->user()->customerProfile->first_name;
            
              $email_body="
              <p>Hi ".ucwords(strtolower($name)).",</p>
              <p>Thank you for creating a new investment plan with us. We appreciate your trust in our services. Below, you will find the breakdown of your investment:</p>
              <p>Reference: #".$ref."
              Principal Amount: NGN $request->investment_amount
              Rate: ".$rate."% per month
              Expected ROI: NGN $roi
              Investment Return :NGN $total 
              Duration: ".$duration."months
              Start Date: ".carbon::parse($inv->created_at)->format('d F, Y')."
              Payout Date: ".carbon::parse($inv->created_at)->addMonths(12)->format('d F, Y')."</p>
            
              <p>If you have any questions or need further information, please don't hesitate to reach out to us. We are here to assist you every step of the way.</p>
              <p>Once again, thank you for choosing us as your investment partner. We look forward to the success of your new investment plan.</p>
              ";
              
                $data=[
                        'header'=>"Thank You for Creating a New Investment Plan",
                        'body'=>$email_body, 
                        'email'=>auth()->user()->email
                    ];


                 dispatch(new SendEmailJob($data));
      $r_data=[
            'message'=>'Investment processed successful. Check your email for more information about the investment'
            ];
             DB::commit();
               return response()->json($r_data, 200);
      
       } catch (\Throwable $th) {
            DB::rollback();
            
              $data=[
            'message'=>'error occured'
            ];
                     return response()->json($data, 401);
            
     }

}





public function liquidate(Request $request, $id)
{
   
    
       try {   
           
           $inv =Investment::where('id',$id)->where('user_id',auth()->user()->id)->first();
           
              
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
        'status'=>"liquidation requested",
        'profit'=>$profit,
        'liquidation_date'=>now()
        ]);
        
       /* auth()->user()->customerProfile->wallet_balance = 
        auth()->user()->customerProfile->wallet_balance +  $total;
         auth()->user()->customerProfile->save();
     
         
         
        OtherTransaction::create([
        'user_id'=>auth()->user()->id,
        'type'=>'investment liquidation',
        'cd'=>'credit',
        'amount'=>$total,
        'status'=>"success"
        ]);
        
        */
         
      
             $name =auth()->user()->customerProfile->first_name;
             
              
              $email_body="
              <p>Hi ".ucwords(strtolower($name)).",</p>
              <p>I hope this message finds you in good health. We are pleased to inform you that the liquidation process of your investment has been Initiated.</p>
             
              <p><strong>Investment Details:</strong>
              Reference: #".$inv->ref."
              Principal Amount: NGN $inv->amount
              Liquidation Amount :NGN $total 
              Duration: ".$inv->duration."months
              Start Date: ".Carbon::parse($inv->created_at)->format('d F, Y')."
              Payout Date: ".Carbon::parse($inv->created_at)->addMonths($inv->duration)->format('d F, Y')."
              Liquidation Date: ".Carbon::parse($inv->liquidation_date)->format('d F, Y')."</p>
            
              <p>We will diligently execute the liquidation of your investment in accordance with our instructions and established procedures. The proceeds from the liquidation will be credited to your Quickmann wallet, and you will be informed when it is approved.</p>
              <p>If you have any questions or require additional information regarding the liquidation, the final statement, or any other related matters, our dedicated support team is here to assist you. Your satisfaction and peace of mind are of utmost importance to us.</p>
              <p>We genuinely appreciate your trust in us, and we are honored to have been a part of your investment journey. Whether it's considering new opportunities, financial planning, or any other financial needs, please know that we remain at your service.</p>
              <p>Once again, thank you for choosing us as your investment partner. We wish you continued success in your financial endeavors and look forward to the possibility of working with you again in the future.</p>
              ";
            /*
              $email_body="
              <p>Hi ".ucwords(strtolower($name)).",</p>
              <p>I hope this message finds you in good health. We are pleased to inform you that the liquidation process of your investment has been successfully completed. Your trust in our investment services and the opportunity to serve your financial needs have been greatly appreciated.</p>
             
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
              
              */
           
                $data=[
                        'header'=>"Investment Liquidation Request",
                        'body'=>$email_body, 
                        'email'=>auth()->user()->email
                    ];
                 dispatch(new SendEmailJob($data));
                 
                 
                    $email_bodyb="
              <p>Hi,</p>
              <p>$name initiated a request for liquidation of investment.</p>
             
              <p><strong>Investment Details:</strong>
              Reference: #".$inv->ref."
              Principal Amount: NGN $inv->amount
              Liquidation Amount :NGN $total 
              Duration: ".$inv->duration."months
              Start Date: ".Carbon::parse($inv->created_at)->format('d F, Y')."
              Payout Date: ".Carbon::parse($inv->created_at)->addMonths($inv->duration)->format('d F, Y')."
              Liquidation Date: ".Carbon::parse($inv->liquidation_date)->format('d F, Y')."</p>
             ";
                
                $data_b=[
                        'header'=>"Investment Liquidation Request",
                        'body'=>$email_bodyb, 
                        'email'=>setting()->liquidation_request_email
                    ];

             
               

                 dispatch(new SendEmailJob($data_b));
                 
                   DB::commit();
     
     return back()->with('success_msg','Liquidation request sent successful. please check your email for more infomation');
           
            
      
       } catch (\Throwable $th) {
            DB::rollback();
            
            return back()->with('warning_msg',$th->getMessage());
            
     }

}




 public function transaction()
{
    $userId = auth()->user()->id;

    // Deposits Query
    $depositsQuery = DB::table('deposits')
        ->where('customer_id', $userId)
        ->where('status','success')
        ->where('payment_type','topup')
        ->select(
            'deposits.customer_id as user_id',
            'deposits.id as txn_id',
            'deposits.status',
            'deposits.amount',
            'deposits.created_at',
             DB::raw("'deposit' as type"),
             DB::raw("'credit' as cd"),
               DB::raw("'Wallet topup via paystack' as description")
             
        );

    // Withdrawals Query
  $withdrawalsQuery = DB::table('withdrawals')
    ->where('user_id', $userId)
    ->select(
        'withdrawals.user_id',
        'withdrawals.id as txn_id',
        'withdrawals.status',
        'withdrawals.amount',
        'withdrawals.created_at',
        DB::raw("'withdrawal' as type"),
        DB::raw("'debit' as cd"),
        DB::raw("CONCAT('Withdrawn to: ', withdrawals.account_name, ', ', withdrawals.account_number, ', ', withdrawals.bank_name, ', ', withdrawals.account_type) as description")
    );


    // Invoice Deposits Query
  $transferQuery = DB::table('internal_transfers')
    ->where('sender_id', $userId)
    ->select(
        'internal_transfers.sender_id as user_id',
        'internal_transfers.id as txn_id',
        'internal_transfers.status',
        'internal_transfers.amount',
        'internal_transfers.created_at',
        DB::raw("'transfer' as type"),
        DB::raw("'debit' as cd"),
        DB::raw("CONCAT('Transfered to: ', customer_profiles.surname, ' ', customer_profiles.first_name) as description")
    )->leftJoin('customer_profiles', 'customer_profiles.user_id', '=', 'internal_transfers.receiver_id');

        
         $transferQueryb = DB::table('internal_transfers')
        ->orWhere('receiver_id',$userId)
        ->select(
            'internal_transfers.receiver_id as user_id',
            'internal_transfers.id as txn_id',
            'internal_transfers.status',
            'internal_transfers.amount',
            'internal_transfers.created_at',
            DB::raw("'transfer' as type"),
            DB::raw("'credit' as cd"),
            DB::raw("CONCAT('Received from: ', customer_profiles.surname, ' ', customer_profiles.first_name) as description")
    )->leftJoin('customer_profiles', 'customer_profiles.user_id', '=', 'internal_transfers.sender_id');
        
         $salesQuery = DB::table('deposits')
        ->where('customer_id', $userId)
        ->where('status','success')
        ->where('payment_method','wallet')
        ->select(
            'deposits.customer_id as user_id',
            'deposits.id as txn_id',
            'deposits.status',
            'deposits.amount',
            'deposits.created_at',
             DB::raw("'purchase' as type"),
             DB::raw("'debit' as cd"),
                      DB::raw("'Property installment payment' as description")
             
        );
        
          
         $otherQuery = DB::table('other_transactions')
        ->where('user_id', $userId)
        ->select(
            'other_transactions.user_id',
            'other_transactions.id as txn_id',
            'other_transactions.status',
            'other_transactions.amount',
            'other_transactions.created_at',
            'other_transactions.type',
            'other_transactions.cd',
         'other_transactions.remark as description'
        );

    // Combine results
    $transactions = $depositsQuery
        ->union($withdrawalsQuery)
        ->union($transferQuery)
         ->union($transferQueryb)
          ->union($salesQuery)
           ->union($otherQuery)
        ->orderBy('created_at', 'desc')
        ->paginate(20);


   
    return view('Customer.history.transaction')->with(compact('transactions'));
}


 public function investment()
{
    $investments = Investment::where('user_id',auth()->user()->id)->orderBy('created_at','DESC')->paginate();
    return view('Customer.history.investment')->with(compact('investments'));  
}


}
