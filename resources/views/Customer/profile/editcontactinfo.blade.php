@extends('layouts.appnew')

@section('content')

<main id="main" class="main">

    <div class="pagetitle ">
    
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Edit Contact Infomation</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<section class="section">
<div class="container">
    <div class="row">
    <div class="col-lg-12  profile_completion">

<div class="col-lg-12  mt-5  mb-5">
<h3>Contact Information</h3>

<p>Kindly fill information correctly </p>
<form  action="{{route('customerprofile.update',Auth::user()->id)}}" method="post">
    {{ csrf_field() }}

    @if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
    <input name="_method" type="hidden" value="PUT">
    <input name="type" type="hidden" value="step_two">
<div class="form-group">
<label >Phone Number</label>
<input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{Auth::user()->phone}}"  readonly>

                        @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group">
<label >{{ ucwords('Email') }}</label>
<input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{Auth::user()->email}}" >

                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">
<label >{{ ucwords('Address') }}</label>
<textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="5" >

{{Auth::user()->customerprofile->address}}
</textarea>

                        @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">
<label >{{ ucwords('city') }}</label>
<input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{Auth::user()->customerprofile->city}}"  >

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


							<option value="{{Auth::user()->customerprofile->state}}"> {{Auth::user()->customerprofile->state}}</option>
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

<div class="form-group text-center">
<button class="btn  p-2">Save</button>

</div>
</form>

</div>

</div>

    </div>
</div>

</section>
</main>

@endsection

