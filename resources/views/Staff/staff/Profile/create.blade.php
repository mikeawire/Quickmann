@extends('adminlte::page')

@section('title', 'Change Password')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
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
<div class="col-lg-6 offset-lg-3">


<h5>Change Password</h5>
<hr>

<br>




<form class="plot" method="post" action="{{route('staff.store')}}">
{{ csrf_field() }}

<div class="form-group">
<label >Password</label>

<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" >

@error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror               
</div>


<div class="form-group">
<label >Confirm Password</label>

<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" >

                    
</div>

<div class="container-login100-form-btn">
<button class="btn-info btn-lg">Change</button>
</div>
</form>
</div>
</div></div>
@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop