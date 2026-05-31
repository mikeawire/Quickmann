@extends('adminlte::page')

@section('title', 'Create Ads')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4 pt-4 pb-2 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

<div class="row p-3">
    <div class="col-lg-6 bg-white p-3 offset-lg-3">
        <h3>Edit Ads</h3>
    <form action="{{route('ads.update',$ad->id)}}" method="post" enctype="multipart/form-data" >
        @csrf
        <div class="form-group">
          <img src="{{$ad->image ?? ''}}" width="100%">
        </div>


        <div class="form-group">
         
          <label for="email">
                 Url
                  </label>
              <input type="text"   class="form-control @error('url') is-invalid @enderror"  value="{{$ad->url}}" name="url" >
                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
           
          
        </div>


        <div class="form-group">
            <label for="status">Status </label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"  value="{{old('status')}}">
                <option value="">--SELECT--</option>
                <option value="0" @if($ad->status ==0) selected @endif >Inactive</option>
                <option value="1"   @if($ad->status ==1) selected @endif >Active</option>
            </select>
            @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>

      @method('PATCH')

        

        <div class="form-group">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
</div>
</div>

  
</div>
</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop