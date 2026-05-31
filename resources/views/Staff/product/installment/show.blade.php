@extends('adminlte::page')

@section('title', 'Product')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4  pt-2 pb-2 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<div class="col-12 bg-white  p-2 p-lg-4">
    
    <div class="row sold_product">
        
        <div class="col-lg-6">
            <h3>Beneficiary</h3>
            <h6>Full Name: <span>
                {{ucwords($user->customerprofile->surname)}}
                 {{ucwords($user->customerprofile->first_name)}}
                  {{ucwords($user->customerprofile->othername)}}</span></h6>
            
            <h6>Customer ID:<span> {{ucwords($user->customerprofile->reg_no)}}</span></h6>
             <h6>Email:<span> {{ucwords($user->email)}}</span></h6>
              <h6>Phone Number:<span> {{ucwords($user->phone)}}</span></h6>
            <h6><span><a href="/customer/{{$user->id}}">View Profile</a></span></h6>
                 
                          @foreach($staffs as $staff)
                          <h6>DRO: {{$staff->surname}} {{$staff->first_name}} {{$staff->othername}} ({{$staff->designated_state}})</h6>
                            <h6><span><a href="/staff/{{$staff->user_id}}">View D.R.O. Profile</a></span></h6>
                          @endforeach
        </div>
        
         <div class="col-lg-6">
            <h3>Property Details</h3>
            <h6>Location Name:<span>
                {{ucwords($product->location_name)}}
            </span></h6>
            
            <h6>Plot ID:<span> {{ucwords($plot->Plot_id)}}</span></h6>
             <h6>Address:<span> {{ucwords($product->address)}} {{ucwords($product->town)}} {{ucwords($product->state)}}</span></h6>
             
              <h6>Brand:<span> {{ucwords($brand->name)}}</span></h6>
                    <h6>Square Metre:<span> {{ucwords($plot->sqm)}}</span></h6>
                          <h6>Brand:<span> {{ucwords($plot->no_of_plots)}}</span></h6>
                     
        
        </div>
    </div>
    
    
    <div class="row  sold_product">
         
        <div class="col-lg-6">
            <h3 class="text-center ">Financial Statement</h3> 
               <div class="row">
                          <div class="col-lg-4">
     <div class="card   bg-dark text-center p-2">
        
         <p>Property   Fee</p>
     <p>&#8358;{{$plot->price}}</p>
    </div></div>
                <div class="col-lg-4">
     <div class="card   bg-info text-center p-2">
        
         <p>Initial Deposit</p>
     <p>&#8358;{{$cp->initial_deposit}}</p>
    </div></div>
                   <div class="col-lg-4">
    <div class="card bg-primary  text-center p-2">
        @php
{{
$py= $plot->price- $cp->initial_deposit;
}}
@endphp
         <p>Total Amount Payable</p>
     <p>&#8358;{{$py}}</p> 
    </div>        
</div>

    
    <div class="col-lg-4">
     <div class="card   bg-dark text-center p-2">
        
         <p>Total Amount Paid</p>
     <p>&#8358;{{$cp->total_amount_paid}}</p> 
    </div></div>

    <div class="col-lg-4">
     <div class="card   bg-info text-center p-2">
        
         <p>Monthly Payment</p>
     <p>&#8358;{{$cp->monthly_payment}}</p>
    </div></div>

     <div class="col-lg-4">
     <div class="card   bg-warning text-center p-2">
        
         <p>Balance</p>
     <p>&#8358;{{$cp->unpaid_balance}}</p> 
    </div></div>
        </div>
        </div>
         <div class="col-lg-6">
           @if( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO')
         <h4 class="sold_product_dp"><i><a href="/depositrecord/{{$cp->id}}">See Payment History</a></i></h4> 
        @endif
       @if(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='EA' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='PM')
       @if($cp->unpaid_balance < $cp->monthly_payment)
        <div>
             <h5 style="color: #000;" class="p-2"><b>Method I</b>: Full Payment</h5>
<form method="POST" action="{{ route('postpayment.store') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
{{ csrf_field() }}

<div class="mt-5  text-center">
@php
            {{
$amount= $cp->unpaid_balance *100;

$months =DB::table('monthly_records')->where('status','!=','success')->where('customerproperty_id',$cp->id)->where('user_id',$user->id)->orderBy('created_at','ASC')->take(1)->get();
            }}
            @endphp
            
            <h5 class="text-dark">Next Due Payment
            
            @foreach($months as $month)
            @php
{{
$date = date('F Y',strtotime($month->month));

}}
@endphp
            ({{$date}})
            
            @endforeach</h5> 
           
            <h3> &#8358;{{$cp->monthly_payment}}</h3>
        <div class="col-12 ">
           <input type="text" name="mode" value="complete" hidden>
            <input type="text" name="quantity" value="1" hidden>
            <input type="text" name="payment_type" value="installment" hidden>
             <input type="text" name="customer_id" value="{{$user->id}}" hidden>
              <input type="text" name="customer_reg_no" value="{{$user->customerprofile->reg_no}}" hidden>
                <input type="text" name="monthly_payment" value="{{$cp->monthly_payment}}" hidden>
            <input type="text" name="customer_property_id" value="{{$cp->id}}" hidden>
            <input type="text" name="plot_id" value="{{$cp->plot_id}}" hidden>
  <select name="amount" class="form-control">
  
     
     <option value="{{$cp->unpaid_balance }}" >&#8358;{{$cp->unpaid_balance }}</option>
    
  </select>
 
           
           
            </div>
            <div class="col-12 p-2 mt-2 text-center">
                <button class="btn btn-success btn" type="submit" value="Pay Now!" onclick="return confirm('Are you sure want to make payment?')" >
                    <i class="fa fa-plus-circle fa-lg"></i> PayNow!
                </button>
            
        </div>
  


</div>
</form>
@else
        <h5 style="color: #000;" class="p-2"><b>Method I</b>: Full Payment</h5>        
<form method="POST" action="{{ route('postpayment.store') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
{{ csrf_field() }}

<div class="mt-5  text-center">
@php
            {{
$amount= $cp->unpaid_balance *100;

$months =DB::table('monthly_records')->where('status','!=','success')->where('customerproperty_id',$cp->id)->where('user_id',$user->id)->orderBy('created_at','ASC')->take(1)->get();
            }}
            @endphp
            
            <h5 class="text-dark">Next Due Payment
            
            @foreach($months as $month)
            @php
{{
$date = date('F Y',strtotime($month->month));

}}
@endphp
            ({{$date}})
            
            @endforeach</h5> 
           
            <h3> &#8358;{{$cp->monthly_payment}}</h3>
        <div class="col-12 ">

         <input type="text" name="mode" value="complete" hidden>
          
            <input type="text" name="quantity" value="1" hidden>
            <input type="text" name="payment_type" value="installment" hidden>
             <input type="text" name="customer_id" value="{{$user->id}}" hidden>
              <input type="text" name="customer_reg_no" value="{{$user->customerprofile->reg_no}}" hidden>
                <input type="text" name="monthly_payment" value="{{$cp->monthly_payment}}" hidden>
            <input type="text" name="customer_property_id" value="{{$cp->id}}" hidden>
            <input type="text" name="plot_id" value="{{$cp->plot_id}}" hidden>
  <select name="amount" class="form-control">
     @for($x=1; $x<=$cp->no_of_remaining_installment; $x++)
     
     @php
     {{
     $i =$x * $cp->monthly_payment;
       $z =$x * $cp->monthly_payment;
       }}
     @endphp
     
     <option value="{{$z}}" >&#8358;{{$i}} ({{$x}} Month(s))</option>
     @endfor
  </select>
 
           
           
            </div>
            <div class="col-12 p-2 mt-2 text-center">
                <button class="btn btn-success btn" type="submit" value="Pay Now!" onclick="return confirm('Are you sure want to make payment?')" >
                    <i class="fa fa-plus-circle fa-lg"></i> PayNow!
                </button>
            
        </div>
  


</div>
</form>
        </div>
        @endif
        @endif
        </div>
  @if(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='EA' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='PM')
         <div class="row">
         <div class="col-lg-8 offset-lg-2">
         <h5 style="color: #000;" class="p-2"><b>Method II</b>: Partial Payment</h5>
            
<form method="POST" action="{{ route('postpayment.store') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
{{ csrf_field() }}

<div class="mt-5  text-center">
@php
            {{
$amount= $cp->unpaid_balance *100;

$months =DB::table('monthly_records')->where('status','!=','success')->where('customerproperty_id',$cp->id)->where('user_id',$user->id)->orderBy('created_at','ASC')->take(1)->get();
            }}
            @endphp
            
            <h5 class="text-dark">Next Due Payment
            
            @foreach($months as $month)
            @php
{{
$date = date('F Y',strtotime($month->month));

}}
@endphp
            ({{$date}})
            
            @endforeach</h5> 
           
            <h3> &#8358;{{$cp->monthly_payment}}</h3>
        <div class="col-12 ">
            <input type="text" name="mode" value="partial" hidden>

            <input type="text" name="quantity" value="1" hidden>
            <input type="text" name="payment_type" value="installment" hidden>
             <input type="text" name="customer_id" value="{{$user->id}}" hidden>
              <input type="text" name="customer_reg_no" value="{{$user->customerprofile->reg_no}}" hidden>
                <input type="text" name="monthly_payment" value="{{$cp->monthly_payment}}" hidden>
            <input type="text" name="customer_property_id" value="{{$cp->id}}" hidden>
            <input type="text" name="plot_id" value="{{$cp->plot_id}}" hidden>
 
  <input type="text" name="amount" class="form-control" placeholder="Enter Any Amount">
 
           
           
            </div>
            <div class="col-12 p-2 mt-2 text-center">
                <button class="btn btn-success btn" type="submit" value="Pay Now!" onclick="return confirm('Are you sure want to make payment?')" >
                    <i class="fa fa-plus-circle fa-lg"></i> PayNow!
                </button>
            
        </div>
  


</div>
</form>
</div>
</div>
@endif
    </div>
    
</div>
</div></div>

</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop