@extends('adminlte::page')

@section('title', 'Direct Relationship Officer')
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
<h5>Direct Relationship Officer</h5>
<br>
<div class="table-responsive bg-white">


                    
<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Full Name
</th>
<th>
Email
</th>
<th>
Phone No.
</th>


<th>
Branch
</th>


<th>
Action
</th>
</thead>
<tbody>
@foreach($dros as $dro)
<tr>
<td>
  @php
{{


$user = DB::table('users')->find($dro->user_id);
$branch = DB::table('branches')->find($dro->branch_id);

}}
@endphp

{{ $loop->iteration + (( $dros->currentPage() - 1 ) * $dros->perPage()) }}

</td>
<td>
{{ucwords($dro->surname)}} {{ucwords($dro->othername)}}
{{ucwords($dro->first_name)}}
</td>
<td>
{{ucwords($user->email)}}

</td>
<td>
{{ucwords($user->phone)}}


</td>


<td>
{{ucwords($branch->name)}}

</td>




<td class="d-flex bg-white">
  
                     
                        <form action="{{ route('bdmdroprofile.show',$dro->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view profile?')" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Profile</i></button>
                     </form>
                     
                                            <form action="{{ route('bdmdrocustomer.show',$dro->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to Your Customers?')" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Customers</i></button>
                     </form>  

                     </td>

</tr>
@endforeach
</tbody>
</table>


<div class="col-12">
{{$dros->links()}}


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