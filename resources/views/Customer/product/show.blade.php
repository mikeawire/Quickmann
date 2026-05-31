@extends('layouts.appnew')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
     
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Property Details</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<section>
<div class="container-fluid">

<div class="row">
<div class="col-lg-12 shelter">


<div class="card  ">

<div class="col-lg-12">
@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        @if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

<div class="row">

<div class="header1">
    @if($cp->property_status =='preown' )
<h6>This property is still under installment and can be revoke from you if you default on your monthly payment</h6>
@elseif($cp->property_status =='own')
<h6>Congratulation, You have sole completed all neccessary payment, this property sole belong to you and can not be revoke from you</h6>
@else
<h6>Property have been revoke from you </h6>
    @endif
</div>
<div class="col-lg-6 main">


<h5>{{ucwords('shelter product Details')}}</h5>

<div class="">
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
@foreach($dros as $dro)
<div class="dro">
    <h4>For More Information Contact Your Direct Relationship Officer (D.R.O) </h4>
    <div class="main">
       <p>Name:{{ucwords($dro->surname)}} {{ucwords($dro->first_name)}} {{ucwords($dro->othername)}}</p>
    @php
    {{
    $drop =DB::table('users')->find($dro->user_id);
    }}

    @endphp
     <p>Phone:{{ucwords($drop->phone)}}</p>
      <p>Email:{{ucwords($drop->email)}}</p>

        <h4> <a  href="/droprofile/{{$dro->user_id}}">View Profile
</a></h4>

    </div>




</div>
@endforeach

</div>

<div class="col-lg-6 main">
<h5>{{ucwords('Financial Record')}} <span>({{ucwords($cp->payment_status)}})</span></h5>
<div class="">
    <p class="i_payment">Initial Deposit<span> &#8358;{{strtoupper($cp->initial_deposit)}}</span></p>
<p class="p_amount">Product Fee: <span> &#8358;{{strtoupper($plot->price)}}</span></p>

<p class="m_payment">Monthly Payment<span> &#8358;{{strtoupper($cp->monthly_payment)}}</span></p>
@php
{{
$d=$plot->price - $cp->initial_deposit;
}}
@endphp
<p class="unpaid">Total Amount Payable: <span> &#8358;{{strtoupper($d)}}</span></p>
<p class="t_amount">Total Amount Paid: <span> &#8358;{{strtoupper($cp->total_amount_paid)}}</span></p>
<p class="unpaid">Remaining Balance<span> &#8358;{{strtoupper($cp->unpaid_balance)}}</span></p>
</div>
@if($cp->unpaid_balance ==0)

@else
<div class="pt-4">


<form method="POST" action="{{ route('pay.store') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
{{ csrf_field() }}


<div class="mt-5  text-center">
@php
            {{
$amount= $cp->unpaid_balance *100;

$months =DB::table('monthly_records')->where('status','!=','success')->where('customerproperty_id',$cp->id)->where('user_id',Auth::user()->id)->orderBy('created_at','ASC')->take(1)->get();
            }}
            @endphp

            <h5>Next Due Payment
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

            <input type="hidden" name="email" value="{{Auth::user()->email}}"> {{-- required --}}
            <input type="text" name="first_name" value="{{Auth::user()->customerprofile->first_name}}" hidden>
            <input type="text" name="last_name" value="{{Auth::user()->customerprofile->surname}}" hidden>
            <input type="text" name="phone" value="{{Auth::user()->phone}}" hidden>
            <input type="text" name="quantity" value="1" hidden>
            <input type="text" name="payment_type" value="installment" hidden>
            <input type="text" name="property_id" value="{{$cp->id}}" hidden>
            <input type="text" name="plot_id" value="{{$cp->plot_id}}" hidden>
  <select name="amount" class="form-control">
     @for($x=1; $x<=$cp->no_of_remaining_installment; $x++)

     @php
     {{
     $i =$x * $cp->monthly_payment;
       $z =$x * $cp->monthly_payment * 100;
       }}
     @endphp

     <option value="{{$z}}" >&#8358;{{$i}} ({{$x}} Month(s))</option>
     @endfor
  </select>

            <input type="hidden" name="currency" value="NGN">
            <input type="hidden" name="metadata"
            value="{{ json_encode($array = ['surname' =>Auth::user()->customerprofile->surname,'first_name' =>Auth::user()->customerprofile->first_name,'reg_id' =>Auth::user()->customerprofile->reg_no]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
            <input type="hidden" name="reference" value="{{Paystack::genTranxRef() }}"> {{-- required --}}

            </div>
             <div class="text-center mt-3 mb-3">
      <button class="btn btn-success btn"  value="wallet" 
      name="wallet"
      onclick="return confirm('Are you sure want to make payment?')" >
                   Pay With Wallet!
     </button>
                </div>
            <div class="text-center">

<img src="/images/paystack.png" width="100%">
</div>
            <div class="col-12 p-2 mt-2 text-center">
                
                <button class="btn btn-success btn" type="submit" value="Pay Now!" onclick="return confirm('Are you sure want to make payment?')" >
                    <i class="fa fa-plus-circle fa-lg"></i> PayNow!
                </button>


             

        </div>



</div>
</form>



@endif
</div>
</div>
</div>
</div>

</div>

</div>

</div>

</section>
    </main>

@endsection
