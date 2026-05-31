@extends('adminlte::page')

@section('title', 'Add Branch')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
 
<div class="row ">
<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4  pt-2 pb-2 container" >
<h5>Add Branch</h5>
<br>

<div class="col-lg-6  offset-lg-3 package_page">


<form method="post" action="{{route('branch.store')}}">
{{ csrf_field() }}
<div class="form-group">
<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Branch Name">

                        @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="container-login100-form-btn">
<button class="login100-form-btn">Add</button>
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