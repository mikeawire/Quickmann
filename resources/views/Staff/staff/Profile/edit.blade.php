@extends('adminlte::page')

@section('title', 'Edit Profile')
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
<h4>Profile Photo</h4>
<form class="" method="post" action="{{route('staffprofile.store')}}"  enctype="multipart/form-data">
{{ csrf_field() }}

<div class="form-group text-center">

<label  class="text-center"><img src="/images/{{$staff->staffprofile->profile_photo}}" width="200"  class="image-responsive img-fluid img-thumbnail">

</label>
</div>
<div class="form-group ">


<div class="d-flex form-group col-lg-8 offset-lg-2">
<input type="file" class="form-control @error('profile_photo') is-invalid @enderror" name="profile_photo"  >
@error('profile_photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

<button class="btn-info btn ml-3">Upload </button>
</div>

</div>
</form>


<br>

<hr>
<h4>Profile Information</h4>
<form class="" method="post" action="{{route('staffprofile.update',Auth::user()->id)}}">
{{ csrf_field() }}
<input name="_method" type="hidden" value="PUT">
<div class="row">
<div class="form-group col-lg-4">
<label >Username</label>

<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ucfirst($staff->username)}}" readonly>

                    
</div>


<div class="form-group col-lg-4">
<label >Surname</label>

<input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ucfirst($staff->staffprofile->surname)}}" readonly>

                    
</div>

<div class="form-group col-lg-4">
<label >First Name</label>

<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ucfirst($staff->staffprofile->first_name)}}" readonly>

                    
</div>
</div>
<div class="row">
<div class="form-group col-lg-4">
<label >Other Name</label>

<input type="text" class="form-control @error('othername') is-invalid @enderror" name="othername" placeholder="other names" value="{{$staff->staffprofile->othername}}">

                        @error('othername')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group col-lg-4">

<label>Marital Status</label>
<select class="form-control @error('marital_status') is-invalid @enderror" name="marital_status" placeholder="marital status">
<option value="{{$staff->staffprofile->marital_status}}">{{ucfirst($staff->staffprofile->marital_status)}}</option>
<option value="single">Single</option>
<option value="married">Married</option>
<option value="others">Others</option>
</select>
                        @error('marital_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group col-lg-4">

<label>Gender</label>
<select class="form-control @error('gender') is-invalid @enderror" name="gender" placeholder="Gender">
<option value="{{$staff->staffprofile->gender}}">{{ucfirst($staff->staffprofile->gender)}}</option>
<option value="male">Male</option>
<option value="female">Female</option>
<option value="others">others</option>
</select>
                        @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
</div>
<div class="row">

<div class="form-group col-lg-4">
    

<label >Email</label>

<input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ucfirst($staff->email)}}" readonly>

                    
</div>

<div class="form-group col-lg-4">
<label >Phone  Number</label>

<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ucfirst($staff->phone)}}" readonly>

                    
</div>
<div class="form-group col-lg-4">
<label >Second Phone Number</label>

<input type="text" class="form-control @error('second_phone_number') is-invalid @enderror" name="second_phone_number"  value="{{ucfirst($staff->staffprofile->second_phone)}}" placeholder="Second Phone Number (+234)">

                        @error('second_phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
</div>
<div class="row">
<div class="form-group col-lg-4">
<label>State.</label>
<select class="form-control @error('state') is-invalid @enderror" name="state">
<option value="{{$staff->staffprofile->state}}">{{ucfirst($staff->staffprofile->state)}}</option>
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


<div class="form-group col-lg-4">
<label>City/Town</label>
<input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ucfirst($staff->staffprofile->city)}}"  placeholder="City/Town">



                        @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group col-lg-4">
<label>Address</label>
<textarea rows="5" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address">
{{ucfirst($staff->staffprofile->address)}}
</textarea>

                        @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
</div>
<div class="container-login100-form-btn">
<button class="btn-info btn-lg">Update</button>
</div>
</form>
</div>
</div></div>
@stop
@section('footer')
   
@stop



@section('js')
    
@stop