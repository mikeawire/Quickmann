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