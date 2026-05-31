@extends('adminlte::page')

@section('title', 'Business Development Officer')
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
<h5>Business Development Officer</h5>
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
@foreach($bdos as $bdo)
<tr>
<td>
  @php
{{


$user = DB::table('users')->find($bdo->user_id);
$branch = DB::table('branches')->find($bdo->branch_id);


}}
@endphp

{{ $loop->iteration + (( $bdos->currentPage() - 1 ) * $bdos->perPage()) }}

</td>
<td>
{{ucwords($bdo->surname)}} {{ucwords($bdo->othername)}}
{{ucwords($bdo->first_name)}}
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
{{ucwords($bdo->designated_state)}}

</td>





<td class="d-flex bg-white">
  
                     
                        <form action="{{ route('hbdmbdolist.show',$bdo->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button 
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Profile</i></button>
                     </form>
                     
                                            <form action="{{ route('bdmdrohbdm.show',$bdo->designated_state) }}" method="POST">
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
{{$bdos->links()}}


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