@extends('layouts.app')

@section('content')
<section class="section">
<div class="container">
    <div class="row">
<div class="col-lg-10 offset-lg-1 profile_completion">

<div class="col-lg-8 offset-lg-2 mt-5  mb-5">



<h3>Personal Information</h3>

<p>Kindly fill information correctly</p>
<form  action="{{route('dashboard.update',Auth::user()->id)}}" method="post">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    <input name="type" type="hidden" value="step_one">
<div class="form-group">
<label >Surname</label>
<input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{Auth::user()->customerprofile->surname}}"  readonly>

                        @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group">
<label >{{ ucwords('first name') }}</label>
<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{Auth::user()->customerprofile->first_name}}"  readonly>

                        @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">
<label >{{ ucwords('other  name') }}</label>
<input type="text" class="form-control @error('othername') is-invalid @enderror" name="othername" value="{{Auth::user()->customerprofile->othername}} "  readonly>

                        @error('othername')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">
<label >{{ ucwords('Date of Birth') }}</label>
<input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{Auth::user()->customerprofile->dob}}">

                        @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group">

<label class=""><span class="text-danger"></span>{{ ucwords('Marital Status ') }}</label>

<select class="form-control    @error('marital_status') is-invalid @enderror" name="marital_status">
<option value="{{ Auth::user()->customerprofile->marital_status }}">{{ Auth::user()->customerprofile->marital_status }}</option>
<option value="single">Single</option>
<option value="married">Married</option>
<option value="others">others</option>
</select>
				
                        @error('marital_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">

<label class=""><span class="text-danger">*</span> {{ ucwords('Gender ') }}</label>
<select name="gender" class="form-control  @error('gender') is-invalid @enderror">
<option value="{{ Auth::user()->customerprofile->gender}}">{{ Auth::user()->customerprofile->gender}}</option>
<option value="male">Male</option>
<option value="female">Female</option>
<option value="complicated">Complicated</option>
</select>

@error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group text-center">
<button class="btn  p-2">Next</button>

</div>
</form>

</div>
</div>
    </div>
</div>

</section>
</div>
@include('includes.footer')
@endsection
