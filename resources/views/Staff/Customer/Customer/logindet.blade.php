@extends('adminlte::page')

@section('title', 'Edit Customer Profile')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  <style type="text/css">
     input, select, textarea
     {
      border: 1px solid #000;

     }

      input, select, 
     {
     height: 50px;
      
     }
     form
     {
      padding: 20px;
     }
   </style>

   @laravelPWA
@stop

@section('content')
<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-4">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<div class="col-lg-12 offset-lg-0 bg-white">


<h5>Edit Profile</h5>


<br>

<div class="text-center">
<h4>Edit Login Information</h4>
</div>
<br>

<hr>

<form class="" method="post" action="{{route('customerreg.update',$customer->id)}}">
{{ csrf_field() }}
<input name="_method" type="hidden" value="PUT">
<h4>Change Password and Username</h4>
<div class="row">
<div class="form-group col-lg-4">
<label >Username</label>

<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ucfirst($customer->username)}}" >

     @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                
</div>


<div class="form-group col-lg-4">
<label >Password</label>

<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="" >

                     @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group col-lg-4">
<label >Confirm Password</label>

<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="" >

                    
</div>
</div>



<div class="container-login100-form-btn">
<button class="btn-info btn-lg">Update</button>
</div>
</form>


</div>

</div>
</div>


</div></div>
@stop
@section('footer')
   
@stop



@section('js')
    
@stop