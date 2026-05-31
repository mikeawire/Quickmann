@extends('layouts.appnew')

@section('content')
<main id="main" class="main">

    <div class="pagetitle ">
    
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Edit Next Of Kin Infomation</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<section class="section">
<div class="container">
    <div class="row">
    <div class="col-lg-12 profile_completion">

<div class="col-lg-12 mt-5  mb-5">
<h3>Next of Kin Information</h3>


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
    <input name="type" type="hidden" value="step_three">

    <div class="form-group">
<label >Full Name</label>
<input type="text" class="form-control @error('names') is-invalid @enderror" name="names" value="{{Auth::user()->customerprofile->next_of_kin_name}}"  >

                        @error('names')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>




<div class="form-group">

<label >Phone Number</label>
<input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{Auth::user()->customerprofile->next_of_kin_phone}}"   >

                        @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group">
<label >{{ ucwords('Email') }}</label>
<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{Auth::user()->customerprofile->next_of_kin_email}}" >

                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">

<label class=""><span class="text-danger"></span> {{ ucwords('Gender ') }}</label>
<select name="gender" class="form-control  @error('gender') is-invalid @enderror">
<option value="{{Auth::user()->customerprofile->next_of_kin_gender}}" >{{Auth::user()->customerprofile->next_of_kin_gender}} </option>
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
{{Auth::user()->customerprofile->next_of_kin_address}}
</textarea>

                        @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">
<label >{{ ucwords('city') }}</label>
<input type="text" class="form-control @error('city') is-invalid @enderror" name="city"  value="{{Auth::user()->customerprofile->next_of_kin_city}}"   >

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


							<option value="{{Auth::user()->customerprofile->next_of_kin_state}}" >{{Auth::user()->customerprofile->next_of_kin_state}}</option>

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
<input type="text" class="form-control @error('relationship') is-invalid @enderror" name="relationship" value="{{Auth::user()->customerprofile->next_of_kin_relationship}}"   >

                        @error('relationship')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group text-center">
<button class="btn p-2">Save</button>

</div>
</form>

</div>

    </div>
</div>

</div>

</section>
</main>

@endsection

