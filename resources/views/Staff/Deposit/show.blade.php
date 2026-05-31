@extends('adminlte::page')

@section('title', 'Customers List')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
<style>
   .invoice h3,    .invoice h1,  .invoice h2,   .invoice h6,   .invoice h4,   .invoice p{color:#000;
    }
    h5{
        color:#000;
    }
   
</style>
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4 pt-2 pb-2 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif


<div class="col-lg-12 offset-lg-0 invoice">


<div class=" ">



<div class="col-lg-10 offset-lg-1 pt-5 pb-5">
  
<div class="text-center ">
<h5 class="text-dark "><b>Transaction Receipt</b></h5>
  <p  class="text-center ">{{$deposit->created_at}}</p>

<hr>
</div>
<div class="row  ">

<div class=" col-lg-6">
    <h5 class="text-dark"><b>Customer Information</b> </h5>
    <hr>
    <p><strong>Full Name: </strong>{{ucwords($customer->customerprofile->surname)}} {{ucwords($customer->customerprofile->first_name)}}
     {{ucwords($customer->customerprofile->other_name)}}</p>
    <p><strong>Phone: </strong>{{$customer->phone}}</p>
    <p><strong>Customer ID </strong>{{$customer->customerprofile->reg_no}}</p>
    <p><strong>Email: </strong>{{$customer->email}}</p>
@if($deposit->plot_id !=null)
    <div class="">
<h5 class="text-dark"><b>Product Paid For</b></h5>

<p>Location Name:<span> {{strtoupper($product->location_name)}}</span></p>
<p>Address: <span> {{strtoupper($product->address)}}</span> </p>
<p>City/Town: <span> {{strtoupper($product->town)}}</span></p>
<p>State: <span> {{strtoupper($product->state)}}</span></p>
<p>Purpose: <span> {{strtoupper($product->purpose)}}</span></p>
<p>Square Metre:<span> {{strtoupper($plot->sqm)}}SQM</span></p>
<p>No of Plots: <span> {{strtoupper($plot->no_of_plots)}}</span></p>
<p>Brand: <span> {{strtoupper($brand->name)}}</span></p>
<p>Plot ID: <span> {{strtoupper($plot->Plot_id)}}</span></p>
</div>
@endif
</div>

<div class="col-lg-6">

<div class="">
<h5 class="text-dark"><b>Transaction Detail</b></h5>
<hr>
<img src="/images/barcode.jpg" height="100">
<div class="text-lg-center">
<p class="">{{$deposit->txn_id}}</p>

</div>


</div>

<div class="">

<p><strong>Transaction ID: </strong>{{$deposit->txn_id}}</p>
<p><strong>Reference: </strong>{{$deposit->ref_id}}</p>
<p><strong>Status: </strong>{{$deposit->status}} 
@if($deposit->status =='pending')
<i class="fa fa-circle text-warning"></i>
@elseif($deposit->status =='success')
<i class="fa fa-circle text-success"></i>

@elseif($deposit->status =='cancel')
<i class="fa fa-circle text-danger"></i>
@endif</p>
<p><strong>Amount: </strong>
&#8358;{{$deposit->amount}}</p>
<p><strong>Country Code</strong> {{$deposit->country_code}}</p>
<p><strong>IP Address </strong> {{$deposit->ip_address}}</p>
<p><strong>Paid at</strong> {{$deposit->paid_at}}</p>
<p><strong>Charges</strong> 

&#8358;{{$charge=$deposit->fees}}</p>
<p><strong>Currency</strong> {{$deposit->currency}}</p>

</div>
</div>
</div>
</div>
@if($deposit->payment_method == 'online')

<div class="p-2 col-lg-10 offset-lg-1">
<h5 class="text-dark"><b>Card Details</b></h5>

<img src="/images/paystack.png" height="100">

<p><strong>Card Number </strong>************{{$deposit->last4}}</p>
<p><strong>Channel </strong>{{$deposit->channel}}</p>
<p><strong>Card Type </strong>{{$deposit->card_type}}</p>
<p><strong>Account Name </strong>{{$deposit->account_name}}</p>
<p><strong>Expiry Date</strong>{{$deposit->exp_month}}/{{$deposit->exp_year}}</p>
<p><strong>Bank</strong> {{$deposit->bank}}</p>


</div>
@else
@if($deposit->account_name !=null)

<div class="p-2 col-lg-10 offset-lg-1">
<h5 class="text-dark"><b>Depositor Details</b></h5>

@php
{{

$staffs =DB::table('staff_profiles')->where('user_id',$deposit->account_name)->get();
foreach($staffs as $staff)
{
$branch =DB::table('branches')->find($staff->branch_id);
}
}}
@endphp


<p><strong>Full Name </strong>{{ucwords($staff->surname) ?? ''}} {{ucwords($staff->first_name) ?? ''}} {{ucwords($staff->othername) ?? ''}}</p>
<p><strong>Reg No </strong>{{$staff->reg_no ?? ''}}</p>
<p><strong>Designation </strong>{{ucwords($staff->role ?? '')}}</p>
<p><strong>Branch </strong>{{ucwords($branch->name ) ?? ''}}</p>
 <p><a href="/staff/{{$deposit->account_name}}">View Profile</a></p>

</div>
@endif
@if($deposit->status =='pending' )
    @if (Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO') 
<div>

    
<form method="POST" action="{{ route('postpayment.store') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
{{ csrf_field() }}

<div class="mt-5  text-center">
           
           
        <div class="col-12 ">
           <input type="text" name="method" value="{{$deposit->card_type}}" hidden>
            <input type="text" name="quantity" value="1" hidden>
            <input type="text" name="payment_type" value="{{$deposit->payment_type}}" hidden>
             <input type="text" name="customer_id" value="{{$customer->id}}" hidden>
              <input type="text" name="customer_reg_no" value="{{$customer->customerprofile->reg_no}}" hidden>
                <input type="text" name="monthly_payment" value="{{$cp->monthly_payment}}" hidden>
            <input type="text" name="customer_property_id" value="{{$deposit->customer_property_id}}" hidden>
            <input type="text" name="plot_id" value="{{$plot->id}}" hidden>
            <input type="text" name="amount" value="{{$deposit->amount}}"  hidden>
             <input type="text" name="id" value="{{$deposit->id}}"  hidden>
  
           
           
            </div>
            <div class="col-12 p-2 mt-2 text-center">
                <button class="btn btn-success btn" type="submit" value="Confirm" onclick="return confirm('Are you sure want to confirm payment?')" >
                   Confirm   <i class="fa fa-check fa-lg"></i>
                </button>
            
        </div>
  


</div>
</form>
</div>
@endif
@endif
@endif



</div>
</div>

</div>

</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop