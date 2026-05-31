@extends('adminlte::page')

@section('title', 'Edit Plot')
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
<div class="col-lg-8 offset-lg-2">

<h5>Edit Plot</h5>
<br>
<form class="plot" method="post" action="{{route('plot.update',$plot->id)}}">
{{ csrf_field() }}
<input name="_method" type="hidden" value="PUT">

<div class="form-group">
<label >Plot ID.</label>
<input type="text" class="form-control @error('plot_id') is-invalid @enderror" name="plot_id" placeholder="Plot ID" value="{{$plot->Plot_id}}">

                        @error('plot_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">
<label>Select Brand.</label>
<select class="form-control @error('brand') is-invalid @enderror" name="brand">
@php
{{
$brand =DB::table('plot_types')->find($plot->plot_type_id);
}}
@endphp
<option value="{{$plot->plot_type_id}}">{{ucfirst($brand->name)}}</option>
@foreach($brands as $brand)
<option value="{{$brand->id}}">{{ucfirst($brand->name)}}</option>
@endforeach
</select>


                        @error('brand')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="form-group">
<label>Select Location Name</label>
<select class="form-control @error('location_name') is-invalid @enderror" name="location_name">
@php
{{
$product =DB::table('products')->find($plot->product_id);
}}
@endphp
<option value="{{$product->id}}">{{strtoupper($product->location_name)}} - {{$product->address}} {{$product->town}}</option>
@foreach($products as $product)
<option value="{{$product->id}}">{{strtoupper($product->location_name)}} - {{$product->address}} {{$product->town}}</option>
@endforeach
</select>


                        @error('location_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">
<label>Price</label>
<input type="text" class="form-control @error('price') is-invalid @enderror" name="price" placeholder="Price" value="{{$plot->price}}"> 

                        @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">
<label>Square Metre</label>
<input type="text" class="form-control @error('sqm') is-invalid @enderror" name="sqm" placeholder="Square Metre" value="{{$plot->sqm}}">

                        @error('sqm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">
<label>No Of Plots</label>
<input type="text" class="form-control @error('no_of_plots') is-invalid @enderror" name="no_of_plots" placeholder="no of plots"  value="{{$plot->no_of_plots}}">

                        @error('no_of_plots')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="form-group">
<label>Description</label>
<textarea rows="10" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="description">
</textarea>
{{$plot->description}}

                        @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="container-login100-form-btn">
<button class="btn-primary btn-lg">Add</button>
</div>
</form>

</div></div>
</div>
@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop