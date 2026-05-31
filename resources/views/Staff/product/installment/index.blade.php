@extends('adminlte::page')

@section('title', 'Product Under Installment')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
    @livewireStyles
@stop

@section('content')

<livewire:installmentsales/>

@stop
@section('footer')
   
@stop


@section('css')
  
@stop



@section('js')
    
  @livewireScripts
@stop