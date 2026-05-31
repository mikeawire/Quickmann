@extends('layouts.appnew')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
     
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Payment Details</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<section>
<div class="container-fluid">

<div class="row">
<div class="col-lg-12  home">


<div class="card  ">



<div class="col-lg-12 pt-5 pb-5">
<div class="text-center">
<h5>Transaction Receipt</h5>
<hr>
</div>
<div class="row  ">

<div class=" col-lg-6">
    <h5>Customer Information </h5>
    <hr>
    <p><strong>Full Name: </strong>{{ucwords(Auth::user()->customerprofile->surname)}} {{ucwords(Auth::user()->customerprofile->first_name)}}
     {{ucwords(Auth::user()->customerprofile->other_name)}}</p>
    <p><strong>Phone: </strong>{{Auth::user()->phone}}</p>
    <p><strong>Customer ID </strong>{{Auth::user()->customerprofile->reg_no}}</p>
    <p><strong>Email: </strong>{{Auth::user()->email}}</p>

    <div class="">
<h5>Product Paid For</h5>

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
</div>
<div class="col-lg-6">

<div class="">
<h5>Transaction Detail</h5>
<hr>
<img src="/images/barcode.jpg" height="100">
<div class="text-lg-center">
<p class="">{{$deposit->txn_id}}</p>

</div>


</div>

<div class="">

<p><strong>Transaction ID: </strong>{{$deposit->txn_id}}</p>
<p><strong>Reference: </strong>{{$deposit->ref_id}}</p>
<p><strong>Status: </strong>{{$deposit->status}}</p>
<p><strong>Amount: </strong>
&#8358;{{$deposit->amount}}</p>
<p><strong>Country Code</strong> {{$deposit->country_code}}</p>
<p><strong>IP Address </strong> {{$deposit->ip_address}}</p>
<p><strong>Paid at</strong> {{$deposit->paid_at}}</p>
<p><strong>Charges </strong>


&#8358;{{$charge=$deposit->fees}}</p>
<p><strong>Payment Method:</strong> {{ucwords($deposit->payment_method)}}</p>
<p><strong>Payment Type:</strong> {{ucwords($deposit->payment_type)}}</p>
<p><strong>Currency</strong> {{$deposit->currency}}</p>

</div>
</div>
</div>
</div>

@if($deposit->payment_method =="online")
<div class="p-2 col-lg-10 offset-lg-1">
<h5>Card Details</h5>

<img src="/images/paystack.png" height="100">

<p><strong>Card Number </strong>************{{$deposit->last4}}</p>
<p><strong>Channel </strong>{{$deposit->channel}}</p>
<p><strong>Card Type </strong>{{$deposit->card_type}}</p>
<p><strong>Account Name </strong>{{$deposit->account_name}}</p>
<p><strong>Expiry Date</strong>{{$deposit->exp_month}}/{{$deposit->exp_year}}</p>
<p><strong>Bank</strong> {{$deposit->bank}}</p>


</div>
@endif


</div>


</div>

</div>
</div>

</section>
</main>

@endsection
