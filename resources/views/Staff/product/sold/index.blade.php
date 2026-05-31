@extends('adminlte::page')

@section('title', 'Product Sold')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
   @livewireStyles
@stop

@section('content')
<livewire:soldproducts/>
@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
 @livewireScripts

 
@stop