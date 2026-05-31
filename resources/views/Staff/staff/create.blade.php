@extends('adminlte::page')

@section('title', 'Add Staff')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
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
<div class="col-lg-6 offset-lg-3 mt-5">


<h5>Add Staff</h5>
<br>
<form class="plot" method="post" action="{{route('staffreg.store')}}">
{{ csrf_field() }}
<div class="form-group">
<label >Email</label>

<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="email" value="{{old('email')}}">

                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">

<label>Phone</label>
<input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" name="phone" placeholder="Phone Number">


                        @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">

<label>Branch</label>
<select name="branch" class="form-control @error('branch') is-invalid @enderror">
    
    <option value="">Select branch</option>
    @foreach($branches as $branch)
    <option value="{{$branch->id}}">{{$branch->name}}</option>
    @endforeach
    </select>


                        @error('branch')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>



<div class="form-group">

<label>Designated State</label>



<select  class=" form-control @error('designated_state') is-invalid @enderror"  name="designated_state" 
							autocomplete="state"autofocus  style="height:50px;">
						
					
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


                        @error('designated_state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

<div class="container-login100-form-btn">
<button class="btn-primary btn-lg">Add Staff</button>
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