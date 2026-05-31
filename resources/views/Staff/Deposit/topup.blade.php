@extends('adminlte::page')

@section('title', 'Customers List')
@section('css')

  @laravelPWA

<link rel="stylesheet" type="text/css" href="/css/style.css">
 @livewireStyles
@stop

@section('content')


<table class="table table-dark" id="otpViewTable">
    

<thead>
<th>
S/N
</th>
<th>
Customer Name
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

<tbody class="old">
@foreach($deposits as $deposit)
<tr>
<td>

{{ $loop->iteration + (( $deposits->currentPage() - 1 ) * $deposits->perPage()) }}
@if($deposit->status =='pending')
<i class="fa fa-circle text-warning"></i>
@elseif($deposit->status =='success')
<i class="fa fa-circle text-success"></i>

@elseif($deposit->status =='cancel')
<i class="fa fa-circle text-danger"></i>
@endif
</td>
<td>
    @php
    {{
    $customer=DB::table('users')->find($deposit->customer_id);

    $cusps =DB::table('customer_profiles')->where('user_id',$deposit->customer_id)->get();

    }}
    @endphp
     @foreach($cusps as $cusp)



{{ucwords($cusp->surname)}} {{ucwords($cusp->first_name)}} {{ucwords($cusp->othername)}}

@endforeach
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
<form action="{{ route('deposittxn.show',$deposit->id) }}" method="POST" class="bg-0">
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
@stop
@section('footer')

@stop


@section('css')

@stop

@section('js')
 @livewireScripts



 <script>
        $('#otpViewTable').DataTable({
           processing: true,

           "pageLength": 10,
           "paging": true,

           "searching": true,
           "ordering": true,
           "bLengthChange": true,
           "responsive": true,
           "lengthChange": true,
           "autoWidth": false,








        });
    </script>


@stop
