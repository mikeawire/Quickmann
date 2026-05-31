@extends('layouts.app')

@section('content')
<section class="section">
<div class="container">
    <div class="row">
    <div class="col-lg-10 offset-lg-1 profile_completion">

<div class="col-lg-8 offset-lg-2 mt-5  mb-5">



<h3>Profile Photo</h3>



<div class="text-center result mt-5">
<img src="/images/{{Auth::user()->customerprofile->profile_photo}}" width="200">
</div>

<div class="d-flex text-center justify-content-center">

<form  action="{{route('dashboard.update',Auth::user()->id)}}" method="post" class="mt-5 mr-2">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    <input name="type" type="hidden" value="change" id="type">
   






<div class="form-group text-center">

<button class="btn-dark changebtn p-2" style="background:#000;">Change</button>

</div>
</form>
<form  action="{{route('dashboard.update',Auth::user()->id)}}" method="post" class="mt-5">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    <input name="type" type="hidden" value="save" id="type">
   






<div class="form-group text-center">

<button class="btn-success  p-2">Save</button>

</div>
</form>
</div>
</div>
</div>

    </div>
</div>

</section>
</div>
@include('includes.footer')
@endsection
