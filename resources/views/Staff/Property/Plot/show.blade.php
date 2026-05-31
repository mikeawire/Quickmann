@extends('adminlte::page')

@section('title', 'Sell Plots')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-4 container">

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
<h5>Sell Plots</h5>
<br>
<div class=" bg-white p-2">

<div class="row sale_plot">

<div class="col-lg-4">
<h4>Plot Description</h4>
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
<p>Amount: <span> &#8358;{{strtoupper($plot->price)}}</span></p>


</div>
</div>
<div class="col-lg-8">

<div class="">
<h4>Kindly Fill Information Correctly</h4>


        

<form method="post" action="{{route('saleproperty.store')}}">
{{ csrf_field() }}
<div class="form-group">
<div class="row">

<div class="col-lg-12">
    <label >Customer Name</label>
<select  class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" placeholder="Customer ID" style="line-height:1.3em; font-style:normal; font-family:arial;">
    @foreach($customers as $customer)
    <option value="{{$customer->reg_no}}">{{$customer->surname}} {{$customer->first_name}} {{$customer->othername}} ({{$customer->designated_state}})</option>
    @endforeach
</select>
<!--
<input type="text" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" value="{{old('customer_id')}}"  placeholder="Customer ID">

                        @error('customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                -->
</div>
<!--
<div class="col-lg-6">

<label >Customer Name</label>



<input type="text"  id="customer_name"  class="form-control  " name="customer_name" value="{{old('customer_name')}}" readonly>
<div class="result"></div>
                    

</div>-->
</div>


<div class="form-group">
<div class="row">




<input type="hidden" class="form-control @error('plot_id') is-invalid @enderror" name="plot_id" value="{{$plot->id}}" >

<div class="col-lg-12">
<label >D.R.O </label>
<select  class="form-control @error('dro_id') is-invalid @enderror" name="dro_id"  style="line-height:1.3em; font-style:normal; font-family:arial;">
   @foreach($staffs as $staff)
    <option value="{{$staff->user_id}}">{{$staff->surname}} {{$staff->first_name}} {{$staff->othername}} ({{$staff->designated_state}})</option>
    @endforeach
</select>


                        @error('dro_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              
</div>
                       
</div>
  
</div>
</div>


<div class="form-group">
<div class="row">

<div class="col-lg-6">

<label >Payment Mode</label>
<select class="form-control @error('payment_mode') is-invalid @enderror" name="payment_mode" >
<option value="">Select</option>
<option value="outright">Outright</option>
<option value="installment">Installment</option>
</select>
                        @error('payment_mode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="col-lg-6">

<label >Initial Payment ( &#8358;)</label>
<input type="text" class="form-control @error('initial_payment') is-invalid @enderror" name="initial_payment" placeholder="Initial Payment ( &#8358;)">

                        @error('initial_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

</div>
</div>

<div class="form-group">


<label >Monthly Payment (&#8358;)</label>
<input type="text" class="form-control @error('monthly_payment') is-invalid @enderror" name="monthly_payment" placeholder="Monthly Payment ( &#8358;)">

                        @error('monthly_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

</div>

<div class="form-group">

<button type="submit">Process</button>

</div>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="gobackproduct"><a href="/product/{{$product->id}}">Go Back</a></div>
</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop


@section('js')

<script>
    
$(document).ready(function(){


    
    $('#customer_id').keyup(function(){
        
var id =  $('#customer_id').val();
  

        //getting all values
       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/get_customer",
            method: 'POST',
            data:{
                
               'id':id,   
            },
            
           beforeSend: function() {
          
       
            $(".result").html("<p class='text-success'> Please wait fetch customer info.. </p>");
           
      
        },  

        // on success response
        
        success:function(response) {
           if(response == '')
           {
            $(".result").html('User not found');  
           }
           else
           {

            $("#customer_name").val(response);
            $(".result").hide();
           
           }
            
            
           
           // reset form fields

       
         
        },

        // error response
        error:function(e) {
            
            $(".result").html("Some error encountered.");
        }
            
        });
     

    });

   

});
</script>
    <!--dro search-->else


    <script>
    
$(document).ready(function(){


    
    $('#dro_id').keyup(function(){
        
var id =  $('#dro_id').val();
  

        //getting all values
       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/get_dro",
            method: 'POST',
            data:{
                
               'id':id,   
            },
            
           beforeSend: function() {
          
       
            $(".result2").html("<p class='text-success'> Please wait fetch customer info.. </p>");
           
      
        },  

        // on success response
        
        success:function(response) {
           if(response == '')
           {
            $(".result2").html('Dro not found');  
           }
           else
           {

            $("#dro_name").val(response);
            $(".result2").hide();
           
           }
            
            
           
           // reset form fields

       
         
        },

        // error response
        error:function(e) {
            
            $(".result2").html("Some error encountered.");
        }
            
        });
     

    });

   

});
</script>
@stop