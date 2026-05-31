@extends('adminlte::page')

@section('title', 'Brand')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-4 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>Our Branding</h5>
<br>

<table class="table table-striped bg-white col-lg-8 offset-lg-2">
<thead>
<th>
S/N
</th>
<th>
Brand Name
</th>
<th>
Action
</th>
</thead>
<tbody>
@foreach($packages as $package)
<tr>
<td>
{{ $loop->iteration + (( $packages->currentPage() - 1 ) * $packages->perPage()) }}
</td>
<td>
{{$package->name}}
</td>
<td>
<form action="{{ route('package.destroy',$package->id) }}" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to delete this Brand?')" 4
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
                     </td>

</tr>
@endforeach
</tbody>
</div></div>
@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop