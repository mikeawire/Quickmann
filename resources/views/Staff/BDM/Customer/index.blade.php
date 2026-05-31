@extends('adminlte::page')

@section('title', 'DRO Customers ')
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
<h5>Customers  </h5>
<br>
<div class="table-responsive bg-white">


                    
<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Full Name</th>

<th>
Customer ID
</th>
<th>
Email
</th>
<th>
Phone
</th>


<th>
Date
</th>

<th>
Action
</th>
</thead>
<tbody>
@foreach($customers as $cp)
<tr>
<td>
  @php
{{
$user= DB::table('users')->find($cp->user_id);
}}
@endphp
{{ $loop->iteration + (( $customers->currentPage() - 1 ) * $customers->perPage()) }}

</td>

<td>
{{ucwords($cp->surname)}} {{ucwords($cp->first_name)}} {{ucwords($cp->othername)}}
</td>
<td>
{{ucwords($cp->reg_no)}}
</td>
<td>
{{ucwords($user->email)}}
</td>
<td>
{{$user->phone}}

</td>


<td>
{{$cp->created_at}}

</td>


<td class="d-flex bg-white">
  
                     
                        <form action="{{ route('customer.show',$cp->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view product details?')" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>  

                     </td>

</tr>
@endforeach
</tbody>
</table>


<div class="col-12">
{{$customers->links()}}


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