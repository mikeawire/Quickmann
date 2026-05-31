@extends('layouts.appnew')

@section('content')
<main id="main" class="main">

    <div class="pagetitle ">
    
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Change Password</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<section class="section">
<div class="container">
    <div class="row">
<div class="col-lg-12 profile_completion">

<div class="col-lg-12 mt-5  mb-5">

    <div class="clearfix">...</div>

<h3>Change Password</h3>

<p>Enter Password and Confirm Password</p>
<form  action="{{route('customerprofile.store')}}" method="post">
    {{ csrf_field() }}

    @if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

    <input name="type" type="hidden" value="step_one">
<div class="form-group">
<label >Password</label>
<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value=""  >

                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group">
<label >{{ ucwords('confirm password') }}</label>
<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value=""  >

                        @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group text-center">
<button class="btn  p-2">Update</button>

</div>
</form>

</div>
</div>
    </div>
</div>

</section>
</main>

@endsection

