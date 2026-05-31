<?php

use App\Models\CustomerProperty;
use App\Models\Deposit;
use App\Branch;
use App\User;
use App\MonthlyRecord;
use App\Transaction;
use App\Setting;
use App\Models\Plot;
use App\Models\PlotType;
use App\Models\Product;
use App\Http\Requests;
use App\Models\CustomerProfile;
use Carbon\Carbon;


function numberKFormat($adv)
{
    if ($adv < 1000) {
        return $adv;
    } elseif ($adv < 1000000) {
        return number_format($adv / 1000, 2) . 'K';
    } elseif ($adv < 1000000000) {
        return number_format($adv / 1000000, 2) . 'M';
    } elseif ($adv < 1000000000000) {
        return number_format($adv / 1000000000, 2) . 'B';
    } else {
        return number_format($adv / 1000000000000, 2) . 'T';
    }
}





function recuringCharge($authorization_code,$user,$amount,$meta)
{
    $url = "https://api.paystack.co/transaction/charge_authorization";
    $fields = [
      'authorization_code' => $authorization_code,
      'email' => $user->email,
      'last_name'=>$user->customerprofile->last_name ?? "",
      'first_name'=>$user->customerprofile->first_name ?? "",
      'amount' => $amount * 100,
      'phone'=>$user->phone,
      'metadata'=>$meta,
    ];
    $secret_key=Config::get('paystack.secretKey');
    $fields_string = http_build_query($fields);
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer ".$secret_key,
      "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    return json_decode($result);
}


function validateRecuringChargeResponse($response,$user)
{
if($response->status == true)
{
  $tr=json_decode(json_encode($response),true);

  $property=CustomerProperty::find($tr['data']['metadata']['property_id']);

  if($tr['data']['gateway_response']=="Approved")
  {
    $status="success";
  }
  elseif($tr['data']['gateway_response']=="Abandoned")
  {
    $status="cancel";
  }
  else
  {
    $status="pending";
  }
  $deposit =new Deposit;
  $deposit->customer_id = $user->id;
   
  $deposit->customer_property_id = $tr['data']['metadata']['property_id'];
  $deposit->plot_id = $property->plot_id;
  $deposit->customer_reg_no = $tr['data']['metadata']['reg_id'];
  $deposit->payment_type = $tr['data']['metadata']['payment_type'];
  $deposit->payment_method = "online";
  $deposit->amount = $tr['data']['amount']/100;
  $deposit->ref_id = $tr['data']['reference']; 
  $deposit->status = $status; 
  $deposit->authorization_code = $tr['data']['authorization']['authorization_code']; 
  $deposit->paid_at = $tr['data']['transaction_date']; 
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

if($response->data->status == "success" && $response->data->gateway_response=="Approved")
  {
   
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
}
else
{

}
}
}


function setting()
{
    return (object)Setting::first();
}

