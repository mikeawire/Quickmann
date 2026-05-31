@extends('adminlte::page')

@section('title', 'Payment Record')
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
    <div class="col-12">
        <h3>Customer Birthday Template</h3>
    <form action="" method="post" >
        @csrf
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" value="{{$cus_birthday->subject ??''}}" class="form-control @error('subject') is-invalid @enderror">
            @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>

     
        <div class="form-group">
            <label for="email_body">Email Body  hint: variables include {last_name}, {first_name} </label>
            <textarea rows="10" name="email_body" id="email_body" class="form-control @error('email_body') is-invalid @enderror">{{$cus_birthday->email_body ??''}}</textarea>
            @error('email_body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>


        <div class="form-group">
            <label for="sms_body">SMS Body  hint: variables include {last_name}, {first_name} </label>
            <textarea rows="10" name="sms_body" id="sms_body" class="form-control @error('sms_body') is-invalid @enderror">{{$cus_birthday->sms_body ??''}}</textarea>
            @error('sms_body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>

        <div class="form-group">
            <h3 >Platform </h3>
          <div class="">
          <label for="email">
                 Email
              <input type="checkbox" value="1" name="email_platform"   @if($cus_birthday && $cus_birthday->email_platform == 1) checked @endif>
            </label>
          </div>
           <div class="">
           <label for="sms">
                SMS
              <input type="checkbox" value="1" name="sms_platform"  @if($cus_birthday && $cus_birthday->sms_platform == 1) checked @endif>
            </label>
           </div>
        </div>

        <div class="form-group">
            <label for="status">Status </label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                <option value="">--SELECT--</option>
                <option value="0" @if($cus_birthday && $cus_birthday->status == 0) selected @endif>Inactive</option>
                <option value="1" @if($cus_birthday && $cus_birthday->status ===1) selected @endif>Active</option>
            </select>
            @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Save</button>
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