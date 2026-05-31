<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Auth;

use App\Models\CustomerProperty;
use App\Models\Deposit;
use Paystack;
use App\Branch;
use App\User;
use App\MonthlyRecord;
use App\Transaction;
use App\Models\Plot;
use App\Models\PlotType;
use App\Models\Product;
use App\Http\Requests;
use App\Models\CustomerProfile;
use Carbon\Carbon;
use DB;
class DepositController extends Controller
{
    
      public function __construct()
    {

    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function record($id)
     {
        $this->middleware('auth');
         $count=1;
         $records = MonthlyRecord::where('customerproperty_id',$id)->where('user_id',Auth::user()->id)->get();
         
 return view('Customer/product/record')->with(compact('records','count'));
     }
     
    public function index()
    {
        $this->middleware('auth');
        $count=1;
 $deposits = Deposit::where('customer_id',Auth::user()->id)->where('payment_type','!=','topup')->simplePaginate();
 return view('Customer/Deposit/index')->with(compact('deposits','count'));
      

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('auth');
        
        
        if($request->has('wallet'))
        {
            $amount =$request->amount/100;
           
            if(auth()->user()->customerProfile->wallet_balance < $amount)
            {
                return back()->with('warning_msg','Insufficent fund in your wallet ');
            }
              try {   
              
            \DB::beginTransaction();
            
           $deposit= $this->saveDepositInfo($request, $amount);
          
          $customerproperty = CustomerProperty::find($deposit->customer_property_id);
           $this->updateInstantCustomerProperty($deposit,$customerproperty, $amount);
           
          $this->updateInstantTransactionRecords(auth()->user(), $deposit, $amount);
          
          $this->updateInstantMonthlyRecords(auth()->user(),$customerproperty, $amount);
          
          auth()->user()->customerProfile->wallet_balance =auth()->user()->customerProfile->wallet_balance - $amount;
          auth()->user()->customerProfile->save();
          
              DB::commit();
            return back()->with('success_msg', 'Transaction was successful'); 
            
    
     } catch (\Throwable $th) {
            DB::rollback();
                      return back()->with('warning_msg', 'Transaction Failed');
            
     }
           
      
        }
    
    else
    
    {
         request()->reference = Paystack::genTranxRef();

       $url =Paystack::getAuthorizationUrl()->redirectNow();


       $deposit =new Deposit;
       $deposit->customer_id = Auth::user()->id;
       $deposit->customer_reg_no = Auth::user()->customerprofile->reg_no;
       $deposit->customer_property_id  = $request->property_id;
       $deposit->plot_id  = $request->plot_id;
       $deposit->payment_type  = $request->payment_type;
       $deposit->amount = $request->amount/100;
       $deposit->ref_id = $request->reference; 
       $deposit->save();
       
        return $url;
    }
       
    }

    
private function saveDepositInfo($request, $amount)
{
    $deposit = new Deposit;
    $deposit->customer_id = Auth::user()->id;
    $deposit->customer_reg_no = Auth::user()->customerprofile->reg_no;
    $deposit->customer_property_id = $request->property_id;
    $deposit->plot_id = $request->plot_id;
    $deposit->payment_type = $request->payment_type;
    $deposit->amount = $amount;
    $deposit->ref_id = $request->reference;
    $deposit->payment_method = "wallet";
    $deposit->status = 'success';
    $deposit->paid_at = now(); // Use the Carbon method to get the current date and time
    $deposit->channel = "wallet";
    $deposit->currency = "NGN";
    $deposit->ip_address = $request->ip();
    $deposit->fees = 0;
    $deposit->txn_id = "wt" . mt_rand(100000, 999999);
    $deposit->save();

    return $deposit;
}


private function updateInstantCustomerProperty($deposit,$customerproperty, $amount)
{
    $customerproperty->total_amount_paid += $amount;
    $customerproperty->unpaid_balance -= $amount;
    $customerproperty->no_of_remaining_installment -= $amount / $customerproperty->monthly_payment;

    if ($deposit->payment_type == 'installment') {
        $payment_type = 'monthly';
    } else {
        $payment_type = $deposit->payment_type;
    }

    if ($customerproperty->unpaid_balance <= 0) {
        $customerproperty->payment_status = 'complete';
    } else {
        $customerproperty->payment_status = 'incomplete';
    }

    $customerproperty->save();
}




private function updateInstantTransactionRecords($user, $deposit, $amount)
{
    $plot = Plot::find($deposit->plot_id);
    $product = Product::find($plot->product_id);
    $brand = PlotType::find($plot->plot_type_id);
    $branch = Branch::find($user->customerprofile->branch_id);

    $btransactions = Transaction::whereMonth('updated_at', Carbon::now()->month)
        ->whereYear('updated_at', Carbon::now()->year)
        ->where('user_id', $user->id)
        ->where('plot_id', $plot->id)
        ->where('payment_type', 'monthly')
        ->get();

    $payment_type = ($deposit->payment_type == 'installment') ? 'monthly' : $deposit->payment_type;

    if ($btransactions->count() > 0) {
        foreach ($btransactions as $tran) {
            $transaction = Transaction::find($tran->id);
            $transaction->user_id = $user->id;
            $transaction->plot_id = $plot->id;
            $transaction->customer_reg_no = $user->customerprofile->reg_no;
            $transaction->fullname = $user->customerprofile->surname . ' ' . $user->customerprofile->first_name . ' ' . $user->customerprofile->othername;
            $transaction->phone = $user->phone;
            $transaction->branch = $branch->name;
            $transaction->state = $user->customerprofile->designated_state;
            $transaction->plot_no = $plot->Plot_id;
            $transaction->location_name = $product->location_name;
            $transaction->brand = $brand->name;
            $transaction->ref_id = $deposit->ref_id;
            $transaction->txn_id = $deposit->txn_id;
            $transaction->no_of_times = $transaction->no_of_times + 1;
            $transaction->amount = $transaction->amount + $amount;
            $transaction->status = 'success';
            $transaction->payment_type = $payment_type;
            $transaction->save();
        }
    } elseif ($btransactions->count() == 0) {
        $transaction = new Transaction;
        $transaction->user_id = $user->id;
        $transaction->plot_id = $plot->id;
        $transaction->customer_reg_no = $user->customerprofile->reg_no;
        $transaction->fullname = $user->customerprofile->surname . ' ' . $user->customerprofile->first_name . ' ' . $user->customerprofile->othername;
        $transaction->phone = $user->phone;
        $transaction->branch = $branch->name;
        $transaction->state = $user->customerprofile->designated_state;
        $transaction->plot_no = $plot->Plot_id;
        $transaction->location_name = $product->location_name;
        $transaction->brand = $brand->name;
        $transaction->no_of_times = 1;
        $transaction->ref_id = $deposit->ref_id;
        $transaction->txn_id = $deposit->txn_id;
        $transaction->amount = $amount;
        $transaction->status = 'success';
        $transaction->payment_type = $payment_type;
        $transaction->save();
    }
}


  private function updateInstantMonthlyRecords($user,$customerproperty, $amount)
{
    $no_of_month = $amount / $customerproperty->monthly_payment;
    $n = intval($no_of_month);
    $monthlyrecords = MonthlyRecord::where('status', 'pending')
        ->where('user_id', $user->id)
        ->where('customerproperty_id', $customerproperty->id)
        ->orderBy('created_at', 'ASC')
        ->take($n)
        ->get();

    foreach ($monthlyrecords as $mr) {
        $mr->status = 'success';
        $mr->amount = $customerproperty->monthly_payment;
        $mr->save();
    }
}



    public function handleGatewayCallback()
{
   
      try {
            \DB::beginTransaction();
            
            $tr = Paystack::getPaymentData();
            
            
    $deposit = Deposit::where('ref_id', $tr['data']['reference'])->where('status', 'pending')->first();

        $user = User::find($deposit->customer_id);
        
        

        if ($tr['data']['status'] == 'success' && $tr['data']['metadata']['reg_id'] == $user->customerprofile->reg_no) {
            // Update the deposit record
            $this->updateDeposit($user,$deposit, $tr);
            
            if($deposit->payment_type=="topup")
            {
                $this->updateCustomerWallet($tr, $user);
                
             DB::commit();
            return redirect('/dashboard')->with('success_msg', 'Transaction was successful. Wallet funded'); 
            
            }
            else
            {
            $customerproperty = CustomerProperty::find($deposit->customer_property_id);
            
            $this->updateCustomerProperty($deposit,$customerproperty, $tr);
            $this->updateTransactionRecords($user, $deposit, $tr);
            $this->updateMonthlyRecords($user,$customerproperty, $tr);
            DB::commit();
            return redirect('/shelterproduct/' . $deposit->customer_property_id)->with('success_msg', 'Transaction was successful'); 
            }
         
        } else {
            // Handle failed transaction
            $this->handleFailedTransaction($deposit, $tr);
            DB::commit();
            
            return redirect('/shelterproduct/' . $deposit->customer_property_id)->with('warning_msg', 'Transaction Failed');
        }
        
         
        
     } catch (\Throwable $th) {
            DB::rollback();
                      return redirect('/shelterproduct/' . $deposit->customer_property_id)->with('warning_msg', 'Transaction Failed');
            
     }
    
}

private function updateCustomerWallet($tr, $user){
    
    $amount=$tr['data']['amount'] / 100;
    $user->customerprofile->wallet_balance = $user->customerprofile->wallet_balance +$amount;
      $user->customerprofile->save();
    
}

private function updateDeposit($user,$deposit, $tr)
{
    $deposit->customer_id = $user->id;
    $deposit->amount = $tr['data']['amount'] / 100;
    $deposit->ref_id = $tr['data']['reference'];
    $deposit->status = 'success';
    $deposit->authorization_code = $tr['data']['authorization']['authorization_code'];
    $deposit->paid_at = $tr['data']['paid_at'];
    $deposit->channel = $tr['data']['channel'];
    $deposit->currency = $tr['data']['currency'];
    $deposit->ip_address = $tr['data']['ip_address'];
    $deposit->fees = $tr['data']['fees'] / 100;
    $deposit->bin = $tr['data']['authorization']['bin'];
    $deposit->last4 = $tr['data']['authorization']['last4'];
    $deposit->exp_year = $tr['data']['authorization']['exp_year'];
    $deposit->exp_month = $tr['data']['authorization']['exp_month'];
    $deposit->card_type = $tr['data']['authorization']['card_type'];
    $deposit->bank = $tr['data']['authorization']['bank'];
    $deposit->country_code = $tr['data']['authorization']['country_code'];
    $deposit->account_name = $tr['data']['authorization']['account_name'];
    $deposit->txn_id = $tr['data']['id'];
    $deposit->save();
}



private function updateCustomerProperty($deposit,$customerproperty, $tr)
{
    $customerproperty->total_amount_paid += $tr['data']['amount'] / 100;
    $customerproperty->unpaid_balance -= $tr['data']['amount'] / 100;
    $customerproperty->no_of_remaining_installment -= ($tr['data']['amount'] / 100) / $customerproperty->monthly_payment;

    if ($deposit->payment_type == 'installment') {
        $payment_type = 'monthly';
    } else {
        $payment_type = $deposit->payment_type;
    }

    if ($customerproperty->unpaid_balance <= 0) {
        $customerproperty->payment_status = 'complete';
    } else {
        $customerproperty->payment_status = 'incomplete';
    }

    $customerproperty->save();
}


private function updateTransactionRecords($user, $deposit, $tr)
{
    $plot = Plot::find($deposit->plot_id);
    $product = Product::find($plot->product_id);
    $brand = PlotType::find($plot->plot_type_id);
    $branch = Branch::find($user->customerprofile->branch_id);

    $btransactions = Transaction::whereMonth('updated_at', Carbon::now()->month)
        ->whereYear('updated_at', Carbon::now()->year)
        ->where('user_id', $user->id)
        ->where('plot_id', $plot->id)
        ->where('payment_type', 'monthly')
        ->get();

    $payment_type = ($deposit->payment_type == 'installment') ? 'monthly' : $deposit->payment_type;

    if ($btransactions->count() > 0) {
        foreach ($btransactions as $tran) {
            $transaction = Transaction::find($tran->id);
            $transaction->user_id = $user->id;
            $transaction->plot_id = $plot->id;
            $transaction->customer_reg_no = $user->customerprofile->reg_no;
            $transaction->fullname = $user->customerprofile->surname . ' ' . $user->customerprofile->first_name . ' ' . $user->customerprofile->othername;
            $transaction->phone = $user->phone;
            $transaction->branch = $branch->name;
            $transaction->state = $user->customerprofile->designated_state;
            $transaction->plot_no = $plot->Plot_id;
            $transaction->location_name = $product->location_name;
            $transaction->brand = $brand->name;
            $transaction->ref_id = $tr['data']['reference'];
            $transaction->txn_id = $tr['data']['id'];
            $transaction->no_of_times = $transaction->no_of_times + 1;
            $transaction->amount = $transaction->amount + $tr['data']['amount'] / 100;
            $transaction->status = 'success';
            $transaction->payment_type = $payment_type;
            $transaction->save();
        }
    } elseif ($btransactions->count() == 0) {
        $transaction = new Transaction;
        $transaction->user_id = $user->id;
        $transaction->plot_id = $plot->id;
        $transaction->customer_reg_no = $user->customerprofile->reg_no;
        $transaction->fullname = $user->customerprofile->surname . ' ' . $user->customerprofile->first_name . ' ' . $user->customerprofile->othername;
        $transaction->phone = $user->phone;
        $transaction->branch = $branch->name;
        $transaction->state = $user->customerprofile->designated_state;
        $transaction->plot_no = $plot->Plot_id;
        $transaction->location_name = $product->location_name;
        $transaction->brand = $brand->name;
        $transaction->no_of_times = 1;
        $transaction->ref_id = $tr['data']['reference'];
        $transaction->txn_id = $tr['data']['id'];
        $transaction->amount = $tr['data']['amount'] / 100;
        $transaction->status = 'success';
        $transaction->payment_type = $payment_type;
        $transaction->save();
    }
}

  
  private function updateMonthlyRecords($user,$customerproperty, $tr)
{
    $no_of_month = ($tr['data']['amount'] / 100) / $customerproperty->monthly_payment;
    $n = intval($no_of_month);
    $monthlyrecords = MonthlyRecord::where('status', 'pending')
        ->where('user_id', $user->id)
        ->where('customerproperty_id', $customerproperty->id)
        ->orderBy('created_at', 'ASC')
        ->take($n)
        ->get();

    foreach ($monthlyrecords as $mr) {
        $mr->status = 'success';
        $mr->amount = $customerproperty->monthly_payment;
        $mr->save();
    }
}

private function handleFailedTransaction($deposit, $tr)
{
    $deposit->customer_id = $user->id;
    $deposit->amount = $tr['data']['amount'] / 100;
    $deposit->ref_id = $tr['data']['reference'];
    $deposit->status = 'cancel';
    $deposit->authorization_code = $tr['data']['authorization']['authorization_code'];
    $deposit->paid_at = $tr['data']['paid_at'];
    $deposit->channel = $tr['data']['channel'];
    $deposit->currency = $tr['data']['currency'];
    $deposit->ip_address = $tr['data']['ip_address'];
    $deposit->fees = $tr['data']['fees'] / 100;
    $deposit->bin = $tr['data']['authorization']['bin'];
    $deposit->last4 = $tr['data']['authorization']['last4'];
    $deposit->exp_year = $tr['data']['authorization']['exp_year'];
    $deposit->exp_month = $tr['data']['authorization']['exp_month'];
    $deposit->card_type = $tr['data']['authorization']['card_type'];
    $deposit->bank = $tr['data']['authorization']['bank'];
    $deposit->country_code = $tr['data']['authorization']['country_code'];
    $deposit->account_name = $tr['data']['authorization']['account_name'];
    $deposit->txn_id = $tr['data']['id'];
    $deposit->save();
}
  
    
    
  
    public function handleGatewayWebhook(Request $request)
    {
        
        $tr = $request->toArray();
    
            
         
          $deposits= Deposit::where('ref_id',$tr['data']['reference'])->get();
          //dd($deposits);
      foreach($deposits as $deposit)
{
    
if($deposit->ref_id == $tr['data']['reference'] && $deposit->status == 'pending')
{
    
  $user=User::find($deposit->customer_id);
  
if($tr['data']['status'] =='success' && $tr['data']['metadata']['reg_id'] == $user->customerprofile->reg_no )
{
    $deposit->customer_id = $user->id;
    $deposit->amount = $tr['data']['amount']/100;
    $deposit->ref_id = $tr['data']['reference']; 
    $deposit->status = 'success'; 
    $deposit->authorization_code = $tr['data']['authorization']['authorization_code']; 
    $deposit->paid_at = $tr['data']['paid_at']; 
    $deposit->channel = $tr['data']['channel']; 
    $deposit->currency = $tr['data']['currency']; 
    $deposit->ip_address = $tr['data']['ip_address']; 
    $deposit->fees = $tr['data']['fees']/100; 
    $deposit->bin = $tr['data']['authorization']['bin']; 
    $deposit->last4 = $tr['data']['authorization']['last4']; 
    $deposit->exp_year = $tr['data']['authorization']['exp_year']; 
    $deposit->exp_month = $tr['data']['authorization']['exp_month']; 
    $deposit->card_type = $tr['data']['authorization']['card_type']; 
    $deposit->bank = $tr['data']['authorization']['bank']; 
    $deposit->country_code = $tr['data']['authorization']['country_code']; 
    $deposit->account_name = $tr['data']['authorization']['account_name']; 
    $deposit->txn_id = $tr['data']['id']; 
    $deposit->save();
 $plot =Plot::find($deposit->plot_id);
 $product =Product::find($plot->product_id);
 $brand =PlotType::find($plot->plot_type_id);
 $branch =Branch::find($user->customerprofile->branch_id);
 
 $customerproperty =CustomerProperty::find($deposit->customer_property_id);
  $customerproperty->total_amount_paid =  $customerproperty->total_amount_paid + $tr['data']['amount']/100;
  $customerproperty->unpaid_balance =  $customerproperty->unpaid_balance - $tr['data']['amount']/100;
   
   
    $customerproperty->no_of_remaining_installment =  $customerproperty->no_of_remaining_installment - ($tr['data']['amount']/100)/$customerproperty->monthly_payment;
    $customerproperty->save();
    
    if($deposit->payment_type =='installment')
    {
        $payment_type ='monthly';
    }
    else
    {
          $payment_type =$deposit->payment_type ;
    }
    
   
 
    if($customerproperty->unpaid_balance <=0)
    {
         $customerproperty->payment_status ='complete';
         $customerproperty->save();
    }
    else
    {
       $customerproperty->payment_status ='incomplete';
         $customerproperty->save(); 
    }
  

 $btransactions =Transaction::whereMonth('updated_at',Carbon::now()->month)->whereYear('updated_at',Carbon::now()->year)->where('user_id',$user->id)->where('plot_id',$plot->id)->where('payment_type','monthly')->get();
 if($btransactions->count() > 0)
 {
 foreach($btransactions as  $tran)
 {
  
  $transaction= Transaction::find($tran->id);
    
      $transaction->user_id =$user->id;
       $transaction->plot_id =$plot->id;
        $transaction->customer_reg_no =$user->customerprofile->reg_no;
         $transaction->fullname = $user->customerprofile->surname .''. $user->customerprofile->first_name .''.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->ref_id =$tr['data']['reference'];
         $transaction->txn_id =$tr['data']['id'];
         $transaction->no_of_times =  $transaction->no_of_times +1;
          $transaction->amount =$transaction->amount + $tr['data']['amount']/100;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
               $transaction->save();
 }
 }
 elseif($btransactions->count() == 0)
 {
     $transaction = new Transaction;
      $transaction->user_id =$user->id;
       $transaction->plot_id =$plot->id;
        $transaction->customer_reg_no =$user->customerprofile->reg_no;
         $transaction->fullname = $user->customerprofile->surname .''. $user->customerprofile->first_name .''.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->no_of_times =1;
         $transaction->ref_id =$tr['data']['reference'];
         $transaction->txn_id =$tr['data']['id'];
          $transaction->amount =$tr['data']['amount']/100;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
               $transaction->save();
 }

 $no_of_month =($tr['data']['amount']/100)/$customerproperty->monthly_payment;
 $n = intval($no_of_month);
 $monthlyrecords= MonthlyRecord::where('status','pending')->where('user_id',$user->id)->where('customerproperty_id',$customerproperty->id)->orderBy('created_at','ASC')->take($n)->get();
 foreach($monthlyrecords as  $mr)
 {
     $mr->status ='success';
     $mr->amount =$customerproperty->monthly_payment;
     $mr->save();
 }
 
 
 
    // return redirect('/shelterproduct/'.$deposit->customer_property_id)->with('success_msg','Transaction was successful');
}
else 
{
   $deposit->customer_id = $user->id;
    $deposit->amount = $tr['data']['amount']/100;
    $deposit->ref_id = $tr['data']['reference']; 
    $deposit->status = 'cancel'; 
    $deposit->authorization_code = $tr['data']['authorization']['authorization_code']; 
    $deposit->paid_at = $tr['data']['paid_at']; 
    $deposit->channel = $tr['data']['channel']; 
    $deposit->currency = $tr['data']['currency']; 
    $deposit->ip_address = $tr['data']['ip_address']; 
    $deposit->fees = $tr['data']['fees']/100; 
    $deposit->bin = $tr['data']['authorization']['bin']; 
    $deposit->last4 = $tr['data']['authorization']['last4']; 
    $deposit->exp_year = $tr['data']['authorization']['exp_year']; 
    $deposit->exp_month = $tr['data']['authorization']['exp_month']; 
    $deposit->card_type = $tr['data']['authorization']['card_type']; 
    $deposit->bank = $tr['data']['authorization']['bank']; 
    $deposit->country_code = $tr['data']['authorization']['country_code']; 
    $deposit->account_name = $tr['data']['authorization']['account_name']; 
    $deposit->txn_id = $tr['data']['id']; 
    $deposit->save();
    
 // return redirect('/shelterproduct/'.$deposit->customer_property_id)->with('warning_msg','Transaction Failed');
}

}
}
 }  

   

/*
     public function handleGatewayCallback()
    {
        
    
        $tr = Paystack::getPaymentData();
        


      
         
          $deposits= Deposit::where('ref_id',$tr['data']['reference'])->get();
          //dd($deposits);
      foreach($deposits as $deposit)
{
    
if($deposit->ref_id == $tr['data']['reference'] && $deposit->status == 'pending')
{
    
  $user=User::find($deposit->customer_id);
  
if($tr['data']['status'] =='success' && $tr['data']['metadata']['reg_id'] == $user->customerprofile->reg_no )
{
    $deposit->customer_id = $user->id;
    $deposit->amount = $tr['data']['amount']/100;
    $deposit->ref_id = $tr['data']['reference']; 
    $deposit->status = 'success'; 
    $deposit->authorization_code = $tr['data']['authorization']['authorization_code']; 
    $deposit->paid_at = $tr['data']['paid_at']; 
    $deposit->channel = $tr['data']['channel']; 
    $deposit->currency = $tr['data']['currency']; 
    $deposit->ip_address = $tr['data']['ip_address']; 
    $deposit->fees = $tr['data']['fees']/100; 
    $deposit->bin = $tr['data']['authorization']['bin']; 
    $deposit->last4 = $tr['data']['authorization']['last4']; 
    $deposit->exp_year = $tr['data']['authorization']['exp_year']; 
    $deposit->exp_month = $tr['data']['authorization']['exp_month']; 
    $deposit->card_type = $tr['data']['authorization']['card_type']; 
    $deposit->bank = $tr['data']['authorization']['bank']; 
    $deposit->country_code = $tr['data']['authorization']['country_code']; 
    $deposit->account_name = $tr['data']['authorization']['account_name']; 
    $deposit->txn_id = $tr['data']['id']; 
    $deposit->save();
 $plot =Plot::find($deposit->plot_id);
 $product =Product::find($plot->product_id);
 $brand =PlotType::find($plot->plot_type_id);
 $branch =Branch::find($user->customerprofile->branch_id);
 
 $customerproperty =CustomerProperty::find($deposit->customer_property_id);
  $customerproperty->total_amount_paid =  $customerproperty->total_amount_paid + $tr['data']['amount']/100;
  $customerproperty->unpaid_balance =  $customerproperty->unpaid_balance - $tr['data']['amount']/100;
   
   
    $customerproperty->no_of_remaining_installment =  $customerproperty->no_of_remaining_installment - ($tr['data']['amount']/100)/$customerproperty->monthly_payment;
    $customerproperty->save();
    
    if($deposit->payment_type =='installment')
    {
        $payment_type ='monthly';
    }
    else
    {
          $payment_type =$deposit->payment_type ;
    }
    
   
 
    if($customerproperty->unpaid_balance <=0)
    {
         $customerproperty->payment_status ='complete';
         $customerproperty->save();
    }
    else
    {
       $customerproperty->payment_status ='incomplete';
         $customerproperty->save(); 
    }
  

 $btransactions =Transaction::whereMonth('updated_at',Carbon::now()->month)->whereYear('updated_at',Carbon::now()->year)->where('user_id',$user->id)->where('plot_id',$plot->id)->where('payment_type','monthly')->get();
 if($btransactions->count() > 0)
 {
 foreach($btransactions as  $tran)
 {
  
  $transaction= Transaction::find($tran->id);
    
      $transaction->user_id =$user->id;
       $transaction->plot_id =$plot->id;
        $transaction->customer_reg_no =$user->customerprofile->reg_no;
         $transaction->fullname = $user->customerprofile->surname .''. $user->customerprofile->first_name .''.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->ref_id =$tr['data']['reference'];
         $transaction->txn_id =$tr['data']['id'];
         $transaction->no_of_times =  $transaction->no_of_times +1;
          $transaction->amount =$transaction->amount + $tr['data']['amount']/100;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
               $transaction->save();
 }
 }
 elseif($btransactions->count() == 0)
 {
     $transaction = new Transaction;
      $transaction->user_id =$user->id;
       $transaction->plot_id =$plot->id;
        $transaction->customer_reg_no =$user->customerprofile->reg_no;
         $transaction->fullname = $user->customerprofile->surname .''. $user->customerprofile->first_name .''.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->no_of_times =1;
         $transaction->ref_id =$tr['data']['reference'];
         $transaction->txn_id =$tr['data']['id'];
          $transaction->amount =$tr['data']['amount']/100;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
               $transaction->save();
 }

 $no_of_month =($tr['data']['amount']/100)/$customerproperty->monthly_payment;
 $n = intval($no_of_month);
 $monthlyrecords= MonthlyRecord::where('status','pending')->where('user_id',$user->id)->where('customerproperty_id',$customerproperty->id)->orderBy('created_at','ASC')->take($n)->get();
 foreach($monthlyrecords as  $mr)
 {
     $mr->status ='success';
     $mr->amount =$customerproperty->monthly_payment;
     $mr->save();
 }
 
 
 
     return redirect('/shelterproduct/'.$deposit->customer_property_id)->with('success_msg','Transaction was successful');
}
else 
{
   $deposit->customer_id = $user->id;
    $deposit->amount = $tr['data']['amount']/100;
    $deposit->ref_id = $tr['data']['reference']; 
    $deposit->status = 'cancel'; 
    $deposit->authorization_code = $tr['data']['authorization']['authorization_code']; 
    $deposit->paid_at = $tr['data']['paid_at']; 
    $deposit->channel = $tr['data']['channel']; 
    $deposit->currency = $tr['data']['currency']; 
    $deposit->ip_address = $tr['data']['ip_address']; 
    $deposit->fees = $tr['data']['fees']/100; 
    $deposit->bin = $tr['data']['authorization']['bin']; 
    $deposit->last4 = $tr['data']['authorization']['last4']; 
    $deposit->exp_year = $tr['data']['authorization']['exp_year']; 
    $deposit->exp_month = $tr['data']['authorization']['exp_month']; 
    $deposit->card_type = $tr['data']['authorization']['card_type']; 
    $deposit->bank = $tr['data']['authorization']['bank']; 
    $deposit->country_code = $tr['data']['authorization']['country_code']; 
    $deposit->account_name = $tr['data']['authorization']['account_name']; 
    $deposit->txn_id = $tr['data']['id']; 
    $deposit->save();
    
  return redirect('/shelterproduct/'.$deposit->customer_property_id)->with('warning_msg','Transaction Failed');
}

}
}
      
      */
      
      
      
      
      
      
     
    public function transactionDetails()
    {
      $trs=  Paystack::getAllTransactions();
     //dd($trs);
 
      foreach($trs as $tr)
      {
$deposits= Deposit::all();
foreach($deposits as $deposit)
{


if($deposit->ref_id == $tr['reference'] && $deposit->status == 'pending')
{
    
  
  
if($tr['status'] =='success' )
{
    $deposit->user_id = $deposit->user_id;
    $deposit->amount = $tr['amount']/100;
    $deposit->ref_id = $tr['reference']; 
    $deposit->status = 'success'; 
    $deposit->authorization_code = $tr['authorization']['authorization_code']; 
    $deposit->paid_at = $tr['paid_at']; 
    $deposit->channel = $tr['channel']; 
    $deposit->currency = $tr['currency']; 
    $deposit->ip_address = $tr['ip_address']; 
    $deposit->fees = $tr['fees']/100; 
    $deposit->bin = $tr['authorization']['bin']; 
    $deposit->last4 = $tr['authorization']['last4']; 
    $deposit->exp_year = $tr['authorization']['exp_year']; 
    $deposit->exp_month = $tr['authorization']['exp_month']; 
    $deposit->card_type = $tr['authorization']['card_type']; 
    $deposit->bank = $tr['authorization']['bank']; 
    $deposit->country_code = $tr['authorization']['country_code']; 
    $deposit->account_name = $tr['authorization']['account_name']; 
    $deposit->txn_id = $tr['id']; 
    $deposit->save();
    $cp =CustomerProperty::find($deposit->customer_property_id);
    
    $cp->total_amount_paid =  $cp->total_amount_paid + $deposit->amount;
     $cp->unpaid_balance =  $cp->unpaid_balance - $deposit->amount;
     $cp->save();
  
}
elseif($tr['status'] =='abandoned' )
{
    $deposit->user_id =$deposit->user_id;
    $deposit->amount = $tr['amount']/100;
    $deposit->ref_id = $tr['reference']; 
    $deposit->status = 'cancel'; 
    $deposit->authorization_code = $tr['authorization']['authorization_code']; 
    $deposit->paid_at = $tr['paid_at']; 
    $deposit->channel = $tr['channel']; 
    $deposit->currency = $tr['currency']; 
    $deposit->ip_address = $tr['ip_address']; 
    $deposit->fees = $tr['fees']/100; 
    $deposit->txn_id = $tr['id']; 
    $deposit->bin = $tr['authorization']['bin']; 
    $deposit->last4 = $tr['authorization']['last4']; 
    $deposit->exp_year = $tr['authorization']['exp_year']; 
    $deposit->exp_month = $tr['authorization']['exp_month']; 
    $deposit->card_type = $tr['authorization']['card_type']; 
    $deposit->bank = $tr['authorization']['bank']; 
    $deposit->country_code = $tr['authorization']['country_code']; 
    $deposit->account_name = $tr['authorization']['account_name']; 
    $deposit->save();
}

}
}
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deposit= Deposit::findOrFail($id);
   

        $plot =Plot::find($deposit->plot_id);
        $product =Product::find($plot->product_id);
        $brand = PlotType::find($plot->plot_type_id);
       
        
        return view('Customer/Deposit/show')->with(compact('deposit','plot','brand','product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
