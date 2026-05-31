@extends('adminlte::page')

@section('title', 'Branch')
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
        
        @if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>Our Branches</h5>
<br>

<table class="table table-striped bg-white col-lg-8 offset-lg-2">
<thead>
<th>
S/N
</th>
<th>
Branch Name
</th>
<th>
Action
</th>
</thead>
<tbody>
@foreach($branches as $branch)
<tr>
<td>
{{ $loop->iteration + (( $branches->currentPage() - 1 ) * $branches->perPage()) }}
</td>
<td>
{{$branch->name}}
</td>
<td class="d-flex">
    <form action="{{ route('branch.edit',$branch->id) }}" method="POST">
                                <input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to delete this Branch?')" 4
                        class="btn btn-info btn-sm" style="margin-right: 10px;"><i class="fa fa-edit"></i></button>
                     </form>
<form action="{{ route('branch.destroy',$branch->id) }}" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to delete this Branch?')" 4
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