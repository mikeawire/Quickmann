@extends('adminlte::page')

@section('title', 'Customers List')
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
<h5>Customers List</h5>
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
Customer ID
</th>
<th>
Phone Number
</th>
<th>
Email
</th>

<th>
Action
</th>
</thead>
<tbody>
@foreach($customers as $customer)
<tr>
<td>
  
{{ $loop->iteration + (( $customers->currentPage() - 1 ) * $customers->perPage()) }}
</td>
<td>
     @php 
    {{
    $user =DB::table('users')->find($customer->user_id);
    }}
    @endphp
{{ucwords($user->username)}}
</td>
<td>
{{ucwords($customer->surname)}} {{ucwords($customer->first_name)}} {{ucwords($customer->othername)}}

</td>
<td>
{{ucwords($customer->reg_no)}}

</td>
<td>
   
{{ucwords($user->phone)}}

</td>
<td>
{{ucwords($user->email)}}

</td>


<td class="d-flex bg-white">


                       <form action="{{ route('bdmcustomers.show',$customer->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view customer Profile?')" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Profile</button>
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