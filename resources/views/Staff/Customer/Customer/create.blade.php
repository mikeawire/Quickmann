@extends('adminlte::page')

@section('title', 'Edit Customer Registration')
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





<br>

<div class="text-center">
<h4>Customer Registration</h4>
</div>
<br>

<hr>

<form class="" method="post" action="{{route('customerreg.store')}}">
{{ csrf_field() }}

<h4>Personal Information</h4>
<div class="row">



<div class="form-group col-lg-4">
<label >Surname</label>

<input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{old('surname')}}" >

      @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror               
</div>

<div class="form-group col-lg-4">
<label >First Name</label>
   
<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{old('first_name')}}" >

      @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror               
</div>
<div class="form-group col-lg-4">
<label >Other Name</label>

<input type="text" class="form-control @error('othername') is-invalid @enderror" name="othername" placeholder="other names" value="{{old('othername')}}">

                        @error('othername')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
</div>
<div class="row">

<div class="form-group col-lg-4">

<label>Marital Status</label>
<select class="form-control @error('marital_status') is-invalid @enderror" name="marital_status" placeholder="marital status">

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
<div class="form-group col-lg-4">
<label >Date Of Birth</label>

<input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" placeholder="date of birth" value="{{old('dob')}}">

                        @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
</div>
<h4>Contact Information</h4>
<div class="row">

<div class="form-group col-lg-3">
    

<label >Email</label>

<input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" >
  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    
</div>

<div class="form-group col-lg-3">
<label >Phone  Number</label>

<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" >
  @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                    
</div>


<div class="form-group col-lg-3">
<label>State.</label>
<select class="form-control @error('state') is-invalid @enderror" name="state">

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


<div class="form-group col-lg-3">
<label>City/Town</label>
<input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{old('city')}}"  placeholder="City/Town">



                        @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group col-lg-12">
<label>Address</label>
<textarea rows="5" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address">

</textarea>

                        @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
</div>


<h4>Office Information</h4>
<div class="row">




<div class="form-group col-lg-4">
<label>Designated State.</label>
<select class="form-control @error('designated_state') is-invalid @enderror" name="designated_state">

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


                        @error('designated_state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group col-lg-4">
<label>Direct Relationship Officer</label>
<select class="form-control @error('dro') is-invalid @enderror" name="dro" placeholder="Direct Relationship Officer">

@foreach($dros as $dro)
<option value="{{$dro->user_id}}"> {{ucfirst($dro->surname)}} {{ucfirst($dro->first_name)}} {{ucfirst($dro->othername)}} ({{ucfirst($dro->state)}})
</option>
@endforeach
</select>

                        @error('dro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group col-lg-4">
<label>Portfolio Manager</label>
<select class="form-control @error('pm') is-invalid @enderror" name="pm" placeholder="Portfolio Manager">
<option></option>
@foreach($pms as $pm)
<option value="{{$pm->user_id}}"> {{ucfirst($pm->surname)}} {{ucfirst($pm->first_name)}} {{ucfirst($pm->othername)}} ({{ucfirst($pm->state)}})
</option>
@endforeach
</select>

                        @error('pm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<!--
<div class="form-group col-lg-4">
<label>Executive Assistant </label>
<select class="form-control @error('ea') is-invalid @enderror" name="ea" placeholder="Executive Assistant">
<option></option>
@foreach($eas as $ea)
<option value="{{$ea->user_id}}"> {{ucfirst($ea->surname)}} {{ucfirst($ea->first_name)}} {{ucfirst($ea->othername)}} ({{ucfirst($ea->state)}})
</option>
@endforeach
</select>

                        @error('ea')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group col-lg-4">
<label>Assistant Head of Operation </label>
<select class="form-control @error('aho') is-invalid @enderror" name="aho" placeholder="Assistant Head of Operation">
<option></option>
@foreach($ahos as $aho)
<option value="{{$aho->user_id}}"> {{ucfirst($aho->surname)}} {{ucfirst($aho->first_name)}} {{ucfirst($aho->othername)}} ({{ucfirst($aho->state)}})
</option>
@endforeach
</select>

                        @error('aho')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
-->
<div class="form-group col-lg-4">

<label>Branch</label>
<select class="form-control @error('branch') is-invalid @enderror" name="branch" placeholder="Portfolio Manager">
@foreach($branches as $branch)
<option value="{{$branch->id}}"> {{ucfirst($branch->name)}}</option>
@endforeach
</select>

                        @error('branch')
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