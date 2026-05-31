@extends('adminlte::page')

@section('title', 'Unapprove Staff')
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
<h5>Unapprove Staff</h5>
<br>
<div class="table-responsive bg-white">


<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Username
</th>
<th>
Full Name
</th>
<th>
Phone Number
</th>
<th>
Email
</th>
<th>
Position
</th>
<th>
Action
</th>
</thead>
<tbody>
@foreach($staffs as $staff)
<tr>
<td>
    @php
    {{
$user=DB::table('users')->find($staff->user_id);
    }}
    @endphp
{{ $loop->iteration + (( $staffs->currentPage() - 1 ) * $staffs->perPage()) }}
</td>
<td>
{{ucwords($user->username)}}
</td>
<td>
{{ucwords($staff->surname)}} {{ucwords($staff->first_name)}} {{ucwords($staff->othername)}}

</td>
<td>
{{ucwords($user->phone)}}

</td>
<td>
{{ucwords($user->email)}}

</td>
<td>
{{strtoupper($staff->role)}}

</td>

<td class="d-flex bg-white">
<form action="{{ route('pendingstaffreg.show',$staff->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view staff Profile?')" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>
                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12">
{{$staffs->links()}}
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