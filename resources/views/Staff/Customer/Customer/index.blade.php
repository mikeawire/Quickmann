@extends('adminlte::page')

@section('title', 'Customers List')
@section('css')

  @laravelPWA

<link rel="stylesheet" type="text/css" href="/css/style.css">
 @livewireStyles
@stop

@section('content')

<livewire:customerslist/>


@stop
@section('footer')

@stop


@section('css')

@stop

@section('js')
 @livewireScripts




@stop
