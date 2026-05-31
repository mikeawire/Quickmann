<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Plot;
use App\Models\PlotType;
use App\Models\CustomerProfile;
use App\Models\CustomerProperty;
use App\Models\StaffProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\RevokedUser;
use Carbon\Carbon;
use Session;
use Mail;
use Twilio;
use Excel;
use Illuminate\Support\Facades\Input;
use Redirect;
use App\Jobs\SendSmsJob;

use App\User;
use App\MonthlyRecord;
use App\PartialPayment;
use Illuminate\Support\Str;

use App\Models\Deposit;

use App\Branch;


use App\Transaction;

use App\Http\Requests;
use App\Exports\DepositExport;

use App\Exports\TransactionExport;
use App\Exports\soldTransactionExport;


use DB;
class TransactionController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function postpayment(Request $request)
    {
       if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif( Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='EA' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='PM')
             {


        if(Auth::user()->staffprofile->role =='EA' ||   Auth::user()->staffprofile->role =='PM')

        {
          $ref_id =Str::random(10);
            $txn_id =time();
            
            $deposit=new Deposit;
            $deposit->amount =$request->amount;
            $deposit->customer_id =$request->customer_id;
            $deposit->customer_property_id =$request->customer_property_id;
             $deposit->plot_id =$request->plot_id;
             $deposit->customer_reg_no =$request->customer_reg_no;
             $deposit->ref_id =$ref_id;
             $deposit->txn_id =$txn_id;
              $deposit->payment_method ='offline';
               $deposit->payment_type =$request->payment_type;
                $deposit->status ='pending';
                 $deposit->account_name =Auth::user()->id;
                  $deposit->card_type =$request->mode;
                 $deposit->save();
        }
        elseif (Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO') {
        
        
     
       if($request->mode =='complete')
       {


            $ref_id =Str::random(10);
            $txn_id =time();
            
            $deposit=new Deposit;
            $deposit->amount =$request->amount;
            $deposit->customer_id =$request->customer_id;
            $deposit->customer_property_id =$request->customer_property_id;
             $deposit->plot_id =$request->plot_id;
             $deposit->customer_reg_no =$request->customer_reg_no;
             $deposit->ref_id =$ref_id;
             $deposit->txn_id =$txn_id;
              $deposit->payment_method ='offline';
               $deposit->payment_type =$request->payment_type;
               $deposit->status ='success';
                $deposit->card_type =$request->mode;
                 $deposit->account_name =Auth::user()->id;
                $deposit->save();
                
                
 $plot =Plot::find($deposit->plot_id);
 $product =Product::find($plot->product_id);
 $brand =PlotType::find($plot->plot_type_id);
 $user=User::find($request->customer_id);
 $branch =Branch::find($user->customerprofile->branch_id);
 
 $customerproperty =CustomerProperty::find($deposit->customer_property_id);
  $customerproperty->total_amount_paid =  $customerproperty->total_amount_paid + $request->amount;
  $customerproperty->unpaid_balance =  $customerproperty->unpaid_balance - $request->amount;
   
   
    $customerproperty->no_of_remaining_installment =  $customerproperty->no_of_remaining_installment - ($request->amount)/$customerproperty->monthly_payment;
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
         $transaction->fullname = $user->customerprofile->surname .'  '. $user->customerprofile->first_name .'  '.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->ref_id =$ref_id;
         $transaction->txn_id =$txn_id;
         $transaction->no_of_times =  $transaction->no_of_times +1;
          $transaction->amount =$transaction->amount + $request->amount;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
               $transaction->payment_method='offline';
               $transaction->save();
 }
 }
 
 elseif($btransactions->count() == 0)
 {
     $transaction = new Transaction;
      $transaction->user_id =$user->id;
       $transaction->plot_id =$plot->id;
        $transaction->customer_reg_no =$user->customerprofile->reg_no;
         $transaction->fullname = $user->customerprofile->surname .'    '. $user->customerprofile->first_name .'  '.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->no_of_times =1;
         $transaction->ref_id =$ref_id;
         $transaction->txn_id =$txn_id;
          $transaction->amount =$request->amount;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
                $transaction->payment_method='offline';
               $transaction->save();
 }
 $no_of_month =($request->amount)/$customerproperty->monthly_payment;
 $n = intval($no_of_month);
 $monthlyrecords= MonthlyRecord::where('status','pending')->where('user_id',$user->id)->where('customerproperty_id',$customerproperty->id)->orderBy('created_at','ASC')->take($n)->get();
 foreach($monthlyrecords as  $mr)
 {
     $mr->status ='success';
     $mr->amount =$customerproperty->monthly_payment;
     $mr->save();
 }
 }


       if($request->method =='complete')
       {


        
            
            $deposit=Deposit::find($request->id);
            $deposit->amount =$request->amount;
            $deposit->customer_id =$request->customer_id;
            $deposit->customer_property_id =$request->customer_property_id;
             $deposit->plot_id =$request->plot_id;
             $deposit->customer_reg_no =$request->customer_reg_no;
               $deposit->status ='success';
               $deposit->save();
                
                
 $plot =Plot::find($deposit->plot_id);
 $product =Product::find($plot->product_id);
 $brand =PlotType::find($plot->plot_type_id);
 $user=User::find($request->customer_id);
 $branch =Branch::find($user->customerprofile->branch_id);
 
 $customerproperty =CustomerProperty::find($deposit->customer_property_id);
  $customerproperty->total_amount_paid =  $customerproperty->total_amount_paid + $request->amount;
  $customerproperty->unpaid_balance =  $customerproperty->unpaid_balance - $request->amount;
   
   
    $customerproperty->no_of_remaining_installment =  $customerproperty->no_of_remaining_installment - ($request->amount)/$customerproperty->monthly_payment;
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
         $transaction->fullname = $user->customerprofile->surname .'  '. $user->customerprofile->first_name .'  '.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
            $transaction->ref_id =$deposit->ref_id;
         $transaction->txn_id =$deposit->txn_id;
         $transaction->no_of_times =  $transaction->no_of_times +1;
          $transaction->amount =$transaction->amount + $request->amount;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
               $transaction->payment_method='offline';
               $transaction->save();
 }
 }
 
 elseif($btransactions->count() == 0)
 {
     $transaction = new Transaction;
      $transaction->user_id =$user->id;
       $transaction->plot_id =$plot->id;
        $transaction->customer_reg_no =$user->customerprofile->reg_no;
         $transaction->fullname = $user->customerprofile->surname .'    '. $user->customerprofile->first_name .'  '.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->no_of_times =1;
          $transaction->ref_id =$deposit->ref_id;
         $transaction->txn_id =$deposit->txn_id;
          $transaction->amount =$request->amount;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
                $transaction->payment_method='offline';
               $transaction->save();
 }
 $no_of_month =($request->amount)/$customerproperty->monthly_payment;
 $n = intval($no_of_month);
 $monthlyrecords= MonthlyRecord::where('status','pending')->where('user_id',$user->id)->where('customerproperty_id',$customerproperty->id)->orderBy('created_at','ASC')->take($n)->get();
 foreach($monthlyrecords as  $mr)
 {
     $mr->status ='success';
     $mr->amount =$customerproperty->monthly_payment;
     $mr->save();
 }
 }
 elseif ($request->mode =='partial') {
   

            $ref_id =Str::random(10);
            $txn_id =time();
            
            $deposit=new Deposit;
            $deposit->amount =$request->amount;
            $deposit->customer_id =$request->customer_id;
            $deposit->customer_property_id =$request->customer_property_id;
             $deposit->plot_id =$request->plot_id;
             $deposit->customer_reg_no =$request->customer_reg_no;
             $deposit->ref_id =$ref_id;
             $deposit->txn_id =$txn_id;
              $deposit->payment_method ='offline';
               $deposit->payment_type =$request->payment_type;
             $deposit->status ='success';
                $deposit->card_type =$request->mode;
                 $deposit->account_name =Auth::user()->id;
                $deposit->save();



                
                
 $plot =Plot::find($deposit->plot_id);
 $product =Product::find($plot->product_id);
 $brand =PlotType::find($plot->plot_type_id);
 $user=User::find($request->customer_id);
 $branch =Branch::find($user->customerprofile->branch_id);
 
 $customerproperty =CustomerProperty::find($deposit->customer_property_id);


                $checks =PartialPayment::where('user_id',$request->customer_id)->where('customerproperty_id',$request->customer_property_id)->get();
                if($checks->count() == 0)
                {
                 $pp = new PartialPayment;
                 $pp->user_id = $request->customer_id;
                   $pp->customerproperty_id = $request->customer_property_id;
                   $pp->amount = $request->amount;
                   $pp->monthly_payment = $request->monthly_payment;
                   $pp->status ='success';
                   $pp->monthly_payment =$customerproperty->monthly_payment;
                   $pp->save();
                }
                else
                {
                  foreach ($checks as $check) {
                  $pp = PartialPayment::find($check->id);
                  $pp->user_id = $request->customer_id;
                   $pp->customerproperty_id = $request->customer_property_id;
                   $pp->amount = $pp->amount + $request->amount;
                   $pp->monthly_payment = $request->monthly_payment;
                   $pp->status ='success';
                   $pp->monthly_payment =$customerproperty->monthly_payment;
                   $pp->save();

                  }
                }


    $n = (float)($pp->amount/$customerproperty->monthly_payment);
    $n = intval($n);


    $namount =$n * $customerproperty->monthly_payment;
   

  $customerproperty->total_amount_paid =  $customerproperty->total_amount_paid + $request->amount;
  $customerproperty->unpaid_balance =  $customerproperty->unpaid_balance - $request->amount;
   
   if($n >= 1)
   {
$pp->amount = $pp->amount - $namount;
$pp->save();
   }

   
    $customerproperty->no_of_remaining_installment =  $customerproperty->no_of_remaining_installment - $n;
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
         $transaction->fullname = $user->customerprofile->surname .'  '. $user->customerprofile->first_name .'  '.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->ref_id =$ref_id;
         $transaction->txn_id =$txn_id;
         $transaction->no_of_times =  $transaction->no_of_times +1;
          $transaction->amount =$transaction->amount + $request->amount;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
               $transaction->payment_method='offline';
               $transaction->save();
 }
 }
 
 elseif($btransactions->count() == 0)
 {
     $transaction = new Transaction;
      $transaction->user_id =$user->id;
       $transaction->plot_id =$plot->id;
        $transaction->customer_reg_no =$user->customerprofile->reg_no;
         $transaction->fullname = $user->customerprofile->surname .'    '. $user->customerprofile->first_name .'  '.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->no_of_times =1;
         $transaction->ref_id =$ref_id;
         $transaction->txn_id =$txn_id;
          $transaction->amount =$request->amount;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
                $transaction->payment_method='offline';
               $transaction->save();
 }

 $monthlyrecords= MonthlyRecord::where('status','pending')->where('user_id',$user->id)->where('customerproperty_id',$customerproperty->id)->orderBy('created_at','ASC')->take($n)->get();
 foreach($monthlyrecords as  $mr)
 {
     $mr->status ='success';
     $mr->amount =$customerproperty->monthly_payment;
     $mr->save();
 }
}
elseif ($request->method =='partial') {
   

           
            
            $deposit=Deposit::find($request->id);
            $deposit->amount =$request->amount;
            $deposit->customer_id =$request->customer_id;
            $deposit->customer_property_id =$request->customer_property_id;
             $deposit->plot_id =$request->plot_id;
             $deposit->customer_reg_no =$request->customer_reg_no;
             $deposit->status ='success';
                
                $deposit->save();



                
                
 $plot =Plot::find($deposit->plot_id);
 $product =Product::find($plot->product_id);
 $brand =PlotType::find($plot->plot_type_id);
 $user=User::find($request->customer_id);
 $branch =Branch::find($user->customerprofile->branch_id);
 
 $customerproperty =CustomerProperty::find($deposit->customer_property_id);


                $checks =PartialPayment::where('user_id',$request->customer_id)->where('customerproperty_id',$request->customer_property_id)->get();
                if($checks->count() == 0)
                {
                 $pp = new PartialPayment;
                 $pp->user_id = $request->customer_id;
                   $pp->customerproperty_id = $request->customer_property_id;
                   $pp->amount = $request->amount;
                   $pp->monthly_payment = $request->monthly_payment;
                   $pp->status ='success';
                   $pp->monthly_payment =$customerproperty->monthly_payment;
                   $pp->save();
                }
                else
                {
                  foreach ($checks as $check) {
                  $pp = PartialPayment::find($check->id);
                  $pp->user_id = $request->customer_id;
                   $pp->customerproperty_id = $request->customer_property_id;
                   $pp->amount = $pp->amount + $request->amount;
                   $pp->monthly_payment = $request->monthly_payment;
                   $pp->status ='success';
                   $pp->monthly_payment =$customerproperty->monthly_payment;
                   $pp->save();

                  }
                }


    $n = (float)($pp->amount/$customerproperty->monthly_payment);
    $n = intval($n);


    $namount =$n * $customerproperty->monthly_payment;
   

  $customerproperty->total_amount_paid =  $customerproperty->total_amount_paid + $request->amount;
  $customerproperty->unpaid_balance =  $customerproperty->unpaid_balance - $request->amount;
   
   if($n >= 1)
   {
$pp->amount = $pp->amount - $namount;
$pp->save();
   }

   
    $customerproperty->no_of_remaining_installment =  $customerproperty->no_of_remaining_installment - $n;
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
         $transaction->fullname = $user->customerprofile->surname .'  '. $user->customerprofile->first_name .'  '.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->ref_id =$deposit->ref_id;
         $transaction->txn_id =$deposit->txn_id;
         $transaction->no_of_times =  $transaction->no_of_times +1;
          $transaction->amount =$transaction->amount + $request->amount;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
               $transaction->payment_method='offline';
               $transaction->save();
 }
 }
 
 elseif($btransactions->count() == 0)
 {
     $transaction = new Transaction;
      $transaction->user_id =$user->id;
       $transaction->plot_id =$plot->id;
        $transaction->customer_reg_no =$user->customerprofile->reg_no;
         $transaction->fullname = $user->customerprofile->surname .'    '. $user->customerprofile->first_name .'  '.$user->customerprofile->othername;
         
         $transaction->phone =$user->phone;
         $transaction->branch =$branch->name;
         $transaction->state = $user->customerprofile->designated_state;
         $transaction->plot_no =$plot->Plot_id;
         $transaction->location_name =$product->location_name;
         $transaction->brand =$brand->name;
         $transaction->no_of_times =1;
            $transaction->ref_id =$deposit->ref_id;
         $transaction->txn_id =$deposit->txn_id;
          $transaction->amount =$request->amount;
         $transaction->status ='success';
              $transaction->payment_type=$payment_type;
                $transaction->payment_method='offline';
               $transaction->save();
 }

 $monthlyrecords= MonthlyRecord::where('status','pending')->where('user_id',$user->id)->where('customerproperty_id',$customerproperty->id)->orderBy('created_at','ASC')->take($n)->get();
 foreach($monthlyrecords as  $mr)
 {
     $mr->status ='success';
     $mr->amount =$customerproperty->monthly_payment;
     $mr->save();
 }


 }
 $customerproperty =CustomerProperty::find($deposit->customer_property_id);
$cus=User::find($request->customer_id);
$cusp =CustomerProfile::where('user_id',$request->customer_id)->first();

 $message='Valued Customer, 
 Transaction Details. 
 PLOT: '.$plot->Plot_id.';
 LOCATION:  '.$product->location_name.'
 Payment Amt: ₦' .number_format($request->amount).'. 
 updated Total :₦'.number_format($customerproperty->total_amount_paid,2).'.
 updated Bal:  ₦'.number_format($customerproperty->unpaid_balance,2).'.
 Call: 07069072621';
 
  
   $s_data=[
                    'header'=>'',
                    'body'=>$message, 
                    'phone'=>intval($cus->phone),
      ];

     dispatch(new SendSmsJob($s_data));
}
          

 return back()->with('success_msg','Payment Made successful'); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }  
    }
    
    
    public function sendSms($recipient,$message)
    {
/*
$req_url = "https://portal.nigeriabulksms.com/api/?username=quickaccesswebapps@gmail.com&password=$500@QuickAccess&message=".$message."&sender=QuickMann&mobiles=".$recipient."";
        $response_json = file_get_contents($req_url);
        
         */
        
$url = "https://portal.nigeriabulksms.com/api/?username=quickaccesswebapps@gmail.com&password=$500@QuickAccess&message=.$message.&sender=QuickMann&mobiles=.$recipient.";
         
        

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
return $resp;

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
      public function revoke(Request $request)
    {
        
           if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif( Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         
             
               elseif(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='HOR')
             {
            
$cp =CustomerProperty::find($request->cp_id);
$user =User::find($request->user_id);
$plot =Plot::find($request->plot_id);
$fullname =$user->customerprofile->surname.' '.$user->customerprofile->first_name.' '.$user->customerprofile->othername;
//dd($fullname);
$revoke = new RevokedUser;
$revoke->full_name =$fullname;
$revoke->customer_reg_no =$user->customerprofile->reg_no;
$revoke->customer_id =$user->id;
$revoke->email =$user->email;
$revoke->phone =$user->phone;
$revoke->plot_id =$plot->id;
$revoke->customer_property_id =$cp->id;
$revoke->initial_deposit =$cp->initial_deposit;
$revoke->monthly_payment =$cp->monthly_payment;
$revoke->total_monthly_contribution =$cp->total_amount_paid - $cp->initial_deposit;
$revoke->total_amount_paid =$cp->total_amount_paid;
$revoke->outstanding_balance =$cp->unpaid_balance;
$revoke->property_price =$cp->property_price;

$revoke->save();

$cp->property_status='revoked';
$cp->save();

$product =Product::find($plot->product_id);
$product->no_of_plots = $product->no_of_plots + $plot->no_of_plots;
$product->sqm = $product->sqm  + $plot->sqm;
$product->save();

$plot->status='unsold';
$plot->save();

$months =MonthlyRecord::where('customerproperty_id',$cp->id)->where('user_id',$user->id)->where('status','pending')->get();
foreach($months as $month)
{
    $month->status ='cancel';
    $month->save();
}
$bmonths =MonthlyRecord::where('customerproperty_id',$cp->id)->where('user_id',$user->id)->get();
foreach($bmonths as $month)
{
    $month->revoke_status ='yes';
    $month->save();
}
//dd($product);


$data = array('full_name'=>$request->full_name, 'location_name'=>$product->location_name,'plot_id'=>$plot->Plot_id);


  $email =Session::put('email',$user->email);



     
  
Mail::send(['html'=>'revoke_mail'], $data, function($message) {
    
    $email=Session::get('email');
   $message->to($email, 'Quickmann')->subject
      ('Quickaccess Micro and Macro Limited');
   $message->from('noreply@quickmann.app','Quickmann');
});


Session::forget('email');

 return back()->with('success_msg','Property revoked successful from the customer'); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }
    
    public function revokeuser_index()
    {
        $revokedusers =RevokedUser::orderBy('created_at','DESC')->get();
        $count=1;
        return view('Staff/Revoked/index')->with(compact('revokedusers','count'));
    }

     public function customerpayment($id)
    {
        //
  
       
 
           if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif( Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         
             
               elseif( Auth::user()->staffprofile->status == 'active')
             {
              $count=1;
       $payments = MonthlyRecord::where('customerproperty_id',$id)->get();


 return view('Staff/Payment/show')->with(compact('payments','count')); 

 
       
         
             }
       else
       {
           return redirect('/home');
       }
    }
    public function export($type)
    {
 
      
  return Excel::download(new TransactionExport(), 'under-installment.'.$type.'');
        // Generate and return the spreadsheet
        //Excel::download('users', function ($excel) use ($userData) {
 
            // Build the spreadsheet, passing in the users array
           // $excel->sheet('sheet1', function ($sheet) use ($userData) {
               // $sheet->fromArray($userData);
            //});
 
        //})->download($type);
    }



    public function exportSold($type)
    {
     return Excel::download(new soldTransactionExport(), 'sold.'.$type.'');

    }
}
