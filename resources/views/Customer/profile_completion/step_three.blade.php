@extends('layouts.app')

@section('content')
<section class="section">
<div class="container">
    <div class="row">
    <div class="col-lg-10 offset-lg-1 profile_completion">

<div class="col-lg-8 offset-lg-2 mt-5  mb-5">
<h3>Next of Kin Information</h3>


<p>Kindly fill information correctly </p>
<form  action="{{route('dashboard.update',Auth::user()->id)}}" method="post">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    <input name="type" type="hidden" value="step_three">

    <div class="form-group">
<label >Full Name</label>
<input type="text" class="form-control @error('names') is-invalid @enderror" name="names" value="{{Auth::user()->customerprofile->names}}"  >

                        @error('names')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>




<div class="form-group">

<label >Phone Number</label>
<input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{old('phone_number')}}"  >

                        @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group">
<label >{{ ucwords('Email') }}</label>
<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">

                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">

<label class=""><span class="text-danger"></span> {{ ucwords('Gender ') }}</label>
<select name="gender" class="form-control  @error('gender') is-invalid @enderror">
<option value="{{ old('gender')}}">Select Gender</option>
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
<div class="form-group">
<label >{{ ucwords('Address') }}</label>
<textarea class="form-control @error('address') is-invalid @enderror" name="address"  >
{{old('address')}}
</textarea>

                        @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">
<label >{{ ucwords('city') }}</label>
<input type="text" class="form-control @error('city') is-invalid @enderror" name="city"  value="{{old('city')}}"  >

                        @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">

<label class=""><span class="text-danger">*</span> {{ ucwords('State ') }}</label>
<select  class=" form-control @error('state') is-invalid @enderror"  name="state" 
							autocomplete="state"autofocus  >
						
					
							<option value="" selected="selected">- Select State-</option>
                            
              <option value="Abuja FCT">Abuja FCT</option>
              <option value="Abia">Abia</option>
              <option value="Adamawa">Adamawa</option>
              <option value="Akwa Ibom">Akwa Ibom</option>
              <option value="Anambra">Anambra</option>
              <option value="Bauchi">Bauchi</option>
              <option value="Bayelsa">Bayelsa</option>
              <option value="Benue">Benue</option>
              <option value="Borno">Borno</option>
              <option value="Cross River">Cross River</option>
              <option value="Delta">Delta</option>
              <option value="Ebonyi">Ebonyi</option>
              <option value="Edo">Edo</option>
              <option value="Ekiti">Ekiti</option>
              <option value="Enugu">Enugu</option>
              <option value="Gombe">Gombe</option>
              <option value="Imo">Imo</option>
              <option value="Jigawa">Jigawa</option>
              <option value="Kaduna">Kaduna</option>
              <option value="Kano">Kano</option>
              <option value="Katsina">Katsina</option>
              <option value="Kebbi">Kebbi</option>
              <option value="Kogi">Kogi</option>
              <option value="Kwara">Kwara</option>
              <option value="Lagos">Lagos</option>
              <option value="Nassarawa">Nassarawa</option>
              <option value="Niger">Niger</option>
              <option value="Ogun">Ogun</option>
              <option value="Ondo">Ondo</option>
              <option value="Osun">Osun</option>
              <option value="Oyo">Oyo</option>
              <option value="Plateau">Plateau</option>
              <option value="Rivers">Rivers</option>
              <option value="Sokoto">Sokoto</option>
              <option value="Taraba">Taraba</option>
              <option value="Yobe">Yobe</option>
              <option value="Zamfara">Zamfara</option>
     <option value="Outside Nigeria">Outside Nigeria</option>
</select>


@error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">

<label >Relationship</label>
<input type="text" class="form-control @error('relationship') is-invalid @enderror" name="relationship" value="{{old('relationship')}}"  >

                        @error('relationship')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group text-center">
<button class="btn p-2">Next</button>

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
