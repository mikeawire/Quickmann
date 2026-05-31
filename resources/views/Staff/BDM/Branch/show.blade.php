@extends('adminlte::page')

@section('title', 'Customer Profile')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-Llg-4 pt-2 pb-2 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

<br>
@php
{{
$branch =DB::table('branches')->find($customer->customerprofile->branch_id);
}}
@endphp
<div class="table- bg-white p-4 col-lg-12  ">
    <div class="text-center p-3">
    <h5 class="text-dark mb-2">Customer Profile</h5>
    <p style="color: orange; font-style: italic; font-weight: bolder; font-size: 18px;">{{$branch->name}} Branch Office {{$customer->customerprofile->designated_state}} State</p>

    </div>
    <h4>Personal Info</h4>
    <hr>
    <div class="row">
<div class="col-lg-8">
<div class="">

<p><b>Username:</b> <i>{{ucwords($customer->username)}}</i></p>
</div>
<div class="">

<p><b>Surname:</b> <i>{{ucwords($customer->customerprofile->surname)}}</i></p>
</div>

<div class="">

<p><b>First Name: </b><i>{{ucwords($customer->customerprofile->first_name)}}</i></p>
</div>


<div class="">

<p><b>Other Names:</b><i> {{ucwords($customer->customerprofile->othername)}}</i></p>
</div>

<div class="">

<p><b>Reg. No.</b><i> {{ucwords($customer->customerprofile->reg_no)}}</i></p>
</div>
<div class="">

<p><b>Gender:</b><i> {{ucwords($customer->customerprofile->gender)}}</i></p>
</div>
<div class="">

<p><b>Marital Status:</b><i> {{ucwords($customer->customerprofile->marital_status)}}</i></p>
</div>
</div>

<div class="col-lg-4 text-center mb-3 mt-3 p-2">
    @if($customer->customerprofile->profile_photo == null)
    <img src="/images/placeholder.jpg" width="100" height="100;"> 
    @else
    <img src="/images/{{$customer->customerprofile->profile_photo}}" width="100" height="100"> 
    @endif
</div>

    </div>
    <h4>Contact Info</h4>
    <hr>
<div class="row">
    <div class="col-12">
    <div class="">

<p><b>Email:</b><i> {{ucwords($customer->email)}}</i></p>
</div>
<div class="">

<p><b>Phone Numbers:</b><i> {{ucwords($customer->phone)}}, {{ucwords($customer->customerprofile->second_phone)}}</i></p>
</div>
<div class="">

<p><b>Address:</b><i> {{ucwords($customer->customerprofile->address)}}</i></p>
</div>
<div class="">

<p><b>City:</b><i> {{ucwords($customer->customerprofile->city)}}</i></p>
</div>
<div class="">

<p><b>State:</b><i> {{ucwords($customer->customerprofile->state)}}</i></p>


</div>

    </div>
</div>
<h4>Next of Kin</h4>
    <hr>
<div class="row">
    <div class="col-12">
    <div class="">

<p><b>Names:</b><i> {{ucwords($customer->customerprofile->next_of_kin_name)}}</i></p>


</div>

<div class="">

<p><b>Email:</b><i> {{ucwords($customer->customerprofile->next_of_kin_email)}}</i></p>


</div>
<div class="">

<p><b>Phone Number:</b><i> {{ucwords($customer->customerprofile->next_of_kin_phone)}}</i></p>


</div>
<div class="">

<p><b>Address:</b><i> {{ucwords($customer->customerprofile->next_of_kin_address)}}</i></p>


</div>
    </div>
</div>



<h4>Shelter Products Details</h4>
@php
{{
$count=1;
$cps =DB::table('customer_properties')->where('customer_id',$customer->id)->get();

}}
@endphp

    <hr>
    @foreach($cps as $cp)
<div class="row">
    <div class="col-12 card p-3">
    <div class="">

<p><b>S/N:</b><i> {{$count++}}</i></p>


</div>
@php
{{

$plot =DB::table('plots')->find($cp->plot_id);
$product =DB::table('products')->find($plot->product_id);
$brand =DB::table('plot_types')->find($plot->plot_type_id);

$py =$cp->property_price -$cp->initial_deposit;

}}
@endphp

<div class="">

<p><b>Location Name</b><i> {{ucwords($product->location_name)}}</i></p>


</div>
<div class="">

<p><b>Address:</b><i>  {{ucwords($product->address)}},  {{ucwords($product->town)}}  {{ucwords($product->state)}}</i></p>


</div>
<div class="">

<p><b>Plot ID</b><i> {{ucwords($plot->Plot_id)}}</i></p>


</div>

<div class="">

<p><b>Brand</b><i> {{ucwords($brand->name)}}</i></p>


</div>

<div class="">

<p><b>Product Feee:</b><i>  <b style="color: blue;">&#8358;{{ucwords($cp->property_price)}}</b></i></p>


</div>

<div class="">

<p><b>Initail Deposit:</b><i>  <b style="color: green;">&#8358;{{ucwords($cp->initial_deposit)}}</b></i></p>


</div>

<div class="">

<p><b>Monthly Payment:</b><i>  <b style="color: black;">&#8358;{{ucwords($cp->monthly_payment)}}</b></i></p>



</div>
<div class="">

<p><b>Amount Payable:</b><i>  <b style="color: blue;">&#8358;{{ucwords($py)}}</b></i></p>


</div>

<div class="">

<p><b>Amount Paid:</b><i>  <b style="color: green;">&#8358;{{ucwords($cp->total_amount_paid)}}</b></i></p>


</div>

<div class="">

<p><b>Balance:</b><i>  <b style="color: gold;">&#8358;{{ucwords($cp->unpaid_balance)}}</b></i></p>


</div>
    </div>
</div>

      @endforeach           
</div>

</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop