@extends('adminlte::page')

@section('title', 'Business Development Manager')
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
<h5>Business Development Manager</h5>
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
State
</th>


<th>
Action
</th>
</thead>
<tbody>
@foreach($bdms as $bdm)
<tr>
<td>
  @php
{{


$user = DB::table('users')->find($bdm->user_id);
$branch = DB::table('branches')->find($bdm->branch_id);


}}
@endphp

{{ $loop->iteration + (( $bdms->currentPage() - 1 ) * $bdms->perPage()) }}

</td>
<td>
{{ucwords($bdm->surname)}} {{ucwords($bdm->othername)}}
{{ucwords($bdm->first_name)}}
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


<td>
{{ucwords($bdm->designated_state)}}

</td>





<td class="d-flex bg-white">
  
                     
                        <form action="{{ route('hbdmbdmlist.show',$bdm->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button 
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Profile</i></button>
                     </form>
                     
                                            <form action="{{ route('bdmdrohbdm.show',$bdm->designated_state) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button class="btn btn-info btn-sm" style="margin-right: 10px;">DROs</i></button>
                     </form>  

                     </td>

</tr>
@endforeach
</tbody>
</table>


<div class="col-12">
{{$bdms->links()}}


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