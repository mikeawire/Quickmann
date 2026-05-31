@extends('layouts.app')

@section('content')
<section class="section">
<div class="container">
    <div class="row">
    <div class="col-lg-10 offset-lg-1 profile_completion">

<div class="col-lg-8 offset-lg-2 mt-5  mb-5">



<h3>Profile Photo</h3>

<p>Kindly upload Your Profile photo (jpg, png, jpeg, gif, max. 2MB)</p>



<form  action="{{route('dashboard.update',Auth::user()->id)}}" method="post" class="mt-5"  enctype="multipart/form-data">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    <input name="type" type="hidden" value="step_four" id="type">
<div class="text-center result">
<img src="/images/{{Auth::user()->customerprofile->profile_photo}}" width="100">
</div>

   

    <div class="form-group mt-5">

<input type="file" id="profile_photo"  class="d-none form-control @error('profile_photo') is-invalid @enderror" name="profile_photo" placeholder="choose"   >
<div class="d-flex">
<input type="text" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo"    >

<button type="button"  class="btn choose">Choose</button>
</div>


                        @error('profile_photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>






</form>

</div>

    </div>
</div>

</section>
</div>
@include('includes.footer')
@endsection
