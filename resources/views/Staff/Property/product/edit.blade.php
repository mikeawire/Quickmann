@extends('adminlte::page')

@section('title', 'Add Product')
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
<div class="col-lg-8 offset-lg-2 product_add">


<h5>Add Product</h5>
<br>
<form class="" method="post" action="{{route('product.update',$product->id)}}">

{{ csrf_field() }}
<input name="_method" type="hidden" value="PUT">
<div class="form-group">
<label >Location Name</label>

<input type="text" class="form-control @error('location_name') is-invalid @enderror" name="location_name" placeholder="Location Name" value="{{$product->location_name}}">

                        @error('location_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">

<label>Purpose</label>
<select class="form-control @error('purpose') is-invalid @enderror" name="purpose" placeholder="Purpose" >
<option value="{{$product->purpose}}">{{$product->purpose}}</option>
<option value="residential">Residential</option>
<option value="farm land">Farm Land</option>
<option value="commercial">Commercial</option>
</select>
                        @error('purpose')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">
<label>Select State.</label>
<select class="form-control @error('state') is-invalid @enderror" name="state">
<option value="{{$product->state}}">{{$product->state}}</option>
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
<label>City/Town</label>
<input type="text" class="form-control @error('town') is-invalid @enderror" name="town"  placeholder="City/Town" value="{{$product->town}}">



                        @error('town')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="form-group">
<label>Address</label>
<textarea rows="5" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address">
{{$product->address}}
</textarea>

                        @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="container-login100-form-btn">
<button class="btn-primary btn-lg">Update</button>
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