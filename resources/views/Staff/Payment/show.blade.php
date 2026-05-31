@extends('adminlte::page')

@section('title', 'Payment Record')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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


<div class="row">
<div class="col-lg-8 offset-lg-2 bg-white  p-3">
<h5 class="text-dark">Monthly Record</h5>
<br>

<div class="card p-2">
<div class="d-lg-flex text-dark p-2 justify-content-between text-center">
<b><P>Month</P></b><b><p>Amount Due (&#8358;)</p></b><b> <p>Amount Paid (&#8358;)</p></b><b> <p>Status</p></b>
</div>
</div>
@foreach($payments as $pay)
<div class="card p-2">
<div class="d-lg-flex text-dark p-2 justify-content-between">
@php
{{
$date = date('F Y',strtotime($pay->month));

}}
@endphp
<P  class="text-center">{{$date}}</P> <p  class="text-center">&#8358;{{$pay->amount_due}}</p><p class="text-center">&#8358;{{$pay->amount}}</p>
<p class="text-center">@if($pay->status =='pending')

<i class="fa fa-circle text-warning" style="font-size: 22px;"></i>


@elseif($pay->status =='success')
<i class="fa fa-check text-success" style="font-size: 22px;"></i>
@elseif($pay->status =='cancel')
<i class="fa fa-remove text-danger" style="font-size: 22px;"></i>
</p>
@endif
</div>
</div>

@endforeach
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