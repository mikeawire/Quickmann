@extends('adminlte::page')

@section('title', 'Deposit History')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4 pt-2 pb-2 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>Deposit History</h5>
<br>
<div class="d-flex"><div class="ml-2"><i class="fa fa-circle text-warning"></i> Pending</div><div class="ml-2"><i class="fa fa-circle text-danger"></i> Cancel</div><div class="ml-2"><i class="fa fa-circle text-success"></i> Success</div></div>
<br>
<div class="table-responsive bg-white">


<table class="table table-striped">
<thead>
<th>
S/N
</th>


<th>
Amount(&#8358;)
</th>
<th>
Reference ID
</th>
<th>
Date
</th>
<th>
Action
</th>
</thead>
<tbody>
@foreach($deposits as $deposit)
<tr>
<td>
  
{{$count++}}
@if($deposit->status =='pending')
<i class="fa fa-circle text-warning"></i>
@elseif($deposit->status =='success')
<i class="fa fa-circle text-success"></i>

@elseif($deposit->status =='cancel')
<i class="fa fa-circle text-danger"></i>
@endif
</td>


<td>

&#8358;{{$deposit->amount}}
</td>
<td>
    {{$deposit->ref_id}}

</td>
<td>
{{$deposit->created_at}}

</td>


<td class="d-flex bg-white">
<form action="{{ route('deposittxn.show',$deposit->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view Deposit History?')" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>

                     

                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12">
{{$deposits->links()}}
</div>
</div></div>

</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop