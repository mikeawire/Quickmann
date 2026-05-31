@extends('adminlte::page')

@section('title', 'Outstanding Balance')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4 pt-2 pb-2 container ">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif








<div class="row arriers bg-white">
    
    <div class="col-12">
        <h5><strong>Customer Information</strong></h5>
      <p><b>Full Name:<span> {{strtoupper($customer->customerprofile->surname)}} {{strtoupper($customer->customerprofile->first_name)}}  {{strtoupper($customer->customerprofile->othername)}} </b></span></p>
   <p><b>Email:<span> {{$customer->email}} </b></span></p>
<p><b>Phone Number:<span> {{strtoupper($customer->phone)}} </b></span></p>
<p><b>Address:<span> {{strtoupper($customer->customerprofile->address)}} {{strtoupper($customer->customerprofile->city)}}  {{strtoupper($customer->customerprofile->state)}}  </b></span></p>
<p><b>Customer ID:<span> {{strtoupper($customer->customerprofile->reg_no)}}  </b></span></p>
    </div>

<div class="col-lg-6 ">


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


</div>

<div class="col-lg-6 ">
<h5>{{ucwords('Financial Record')}} <span>({{ucwords($cp->payment_status)}})</span></h5>
<div class="">
<p class="p_amount">Product Amount: <span> &#8358;{{strtoupper($plot->price)}}</span></p>
<p class="i_payment">Initial Payment<span> &#8358;{{strtoupper($cp->initial_deposit)}}</span></p>
<p class="m_payment">Monthly Payment<span> &#8358;{{strtoupper($cp->monthly_payment)}}</span></p>
<p class="t_amount">Total Amount Paid: <span> &#8358;{{strtoupper($cp->total_amount_paid)}}</span></p>
<p class="unpaid">Unpaid Balance<span> &#8358;{{strtoupper($cp->unpaid_balance)}}</span></p>
</div>

</div>


</div>
</div>
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