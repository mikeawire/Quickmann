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
    <div class="col-lg-8 bg-white p-3 offset-lg-2">
        <h3>Search for Staff Monthly Sales Performance</h3>
    <form action="{{route('staff_performance.search')}}" method="post" >
        @csrf
       


        <div class="form-group">
         
          <label for="month">
                 Month
                  </label>
             
    <select id="month" name="month" class="form-control @error('month') is-invalid @enderror"  value="{{old('month')}}">
    <option value="01" @if(date('m') == "01") selected @endif>January</option>
    <option value="02"  @if(date('m') == "02") selected @endif>February</option>
    <option value="03"  @if(date('m') == "03") selected @endif>March</option>
    <option value="04" @if(date('m') == "04") selected @endif>April</option>
    <option value="05"  @if(date('m') == "05") selected @endif>May</option>
    <option value="06"  @if(date('m') == "06") selected @endif>June</option>
    <option value="07"  @if(date('m') == "07") selected @endif>July</option>
    <option value="08"  @if(date('m') == "08") selected @endif>August</option>
    <option value="09"  @if(date('m') == "09") selected @endif>September</option>
    <option value="10"  @if(date('m') == "10") selected @endif>October</option>
    <option value="11"  @if(date('m') == "11") selected @endif>November</option>
    <option value="12"  @if(date('m') == "12") selected @endif>December</option>
</select>
                @error('month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
           
          
        </div>


        <div class="form-group">
            <label for="status">Year </label>
            
@php
    $currentYear = now()->year;
    $startYear = $currentYear - 20;
    $endYear = $currentYear + 4;
@endphp

<select name="year" id="year"  class="form-control @error('year') is-invalid @enderror"  value="{{old('year')}}">
    @for ($year = $startYear; $year <= $endYear; $year++)
        <option value="{{ $year }}" @if(date('Y') == $year) selected @endif>{{ $year }}</option>
    @endfor
</select>
            @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>



        

        <div class="form-group">
            <button type="submit" class="btn btn-success">Search</button>
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