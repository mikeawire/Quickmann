@extends('adminlte::page')

@section('title', 'General Setting')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4 pt-4 pb-2 container">

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

<div class="row p-3">
    <div class="col-12">
        <h3>General Setting</h3>
        <div class="card bg-white p-3">
          
      
    <form action="" method="post" >
        @csrf
          <h3>Investment Settings</h3>
          <hr/>
         <div class="row">
               <div class="form-group col-lg-6">
            <label for="investment_rate">Investment Rate (%)</label>
            <input type="number" step="any" name="investment_rate" id="investment_rate" value="{{$setting->investment_rate ??''}}" class="form-control @error('investment_rate') is-invalid @enderror">
            @error('investment_rate')
           <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong></span>
        @enderror
        </div>
        
                       <div class="form-group col-lg-6">
            <label for="investment_duration">Investment Duration (month)</label>
            <input type="number" step="any" name="investment_duration" id="investment_duration" value="{{$setting->investment_duration ??''}}" class="form-control @error('investment_rate') is-invalid @enderror">
            @error('investment_duration')
           <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong></span>
        @enderror
        </div>
        
                  <div class="form-group col-lg-6">
            <label for="liquidation_profit_rate">Investment Liquidation Profit Rate</label>
            <input type="number" step="any" name="liquidation_profit_rate" id="investment_duration" value="{{$setting->liquidation_profit_rate ??''}}" class="form-control @error('liquidation_profit_rate') is-invalid @enderror">
            @error('liquidation_profit_rate')
           <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong></span>
        @enderror
        </div>
        
        
                  <div class="form-group col-lg-6">
            <label for="liquidation_profit_rate">liquidation request email	</label>
            <input type="text" name="liquidation_request_email" id="liquidation_request_email" value="{{$setting->liquidation_request_email ??''}}" class="form-control @error('liquidation_request_email') is-invalid @enderror">
            @error('liquidation_request_email')
           <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong></span>
        @enderror
        </div>
         </div>


        <div class="form-group">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</div>
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