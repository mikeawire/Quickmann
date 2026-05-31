@extends('adminlte::page')

@section('title', 'Withdrawal list')
@section('css')

  @laravelPWA

<link rel="stylesheet" type="text/css" href="/css/style.css">
 @livewireStyles
@stop

@section('content')


@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        @if(session()->has('danger_msg'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('danger_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
<table class="table table-dark" id="otpViewTable">
    

<thead>
<th>
S/N
</th>
<th>
Customer Name
</th>
<th>
Phone Number
</th>
<th>
Amount(&#8358;)
</th>
<th>
Account Number
</th>
<th>
Account Name
</th>
<th>
Bank Name
</th>
<th>
Account Type
</th>
<th>
Status
</th>
<th>
Date
</th>
<th>
Action
</th>
</thead>

<tbody class="old">
@foreach($withdrawals as $withdrawal)
<tr>
<td>

{{ $loop->iteration + (( $withdrawals->currentPage() - 1 ) * $withdrawals->perPage()) }}
@if($withdrawal->status =='pending')
<i class="fa fa-circle text-warning"></i>
@elseif($withdrawal->status =='success')
<i class="fa fa-circle text-success"></i>

@elseif($withdrawal->status =='failed')
<i class="fa fa-circle text-danger"></i>
@endif
</td>
<td>
  {{$withdrawal->surname}}  {{$withdrawal->first_name}}
</td>
<td>
    {{$withdrawal->phone}}
</td>

<td>

&#8358;{{$withdrawal->amount}}
</td>
<td>
    {{$withdrawal->account_number}}

</td>

<td>
    {{$withdrawal->account_name}}

</td>
<td>
    {{$withdrawal->bank_name}}

</td>
<td>
    {{$withdrawal->account_type}}

</td>
<td>
    {{$withdrawal->status}}

</td>
<td>
{{\Carbon\Carbon::parse($withdrawal->created_at)->format('d F Y H:ia')}}

</td>


<td class="d-flex">
@if($withdrawal->status =="pending")
<form action="{{ route('withdrawal.approve',$withdrawal->w_id) }}" method="POST" class="bg-0">
<input name="_method" type="hidden" value="PATCH">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to approve this withdrawal request?')"
                        class="btn btn-success btn-sm" style="margin-right: 10px;">Approve</button>
                     </form>
                     
                     <form action="{{ route('withdrawal.decline',$withdrawal->w_id) }}" method="POST" class="bg-0">
<input name="_method" type="hidden" value="PATCH">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to decline this withdrawal request?')"
                        class="btn btn-danger btn-sm" style="margin-right: 10px;">Decline</button>
                     </form>
                     
                     @endif



                     </td>

</tr>
@endforeach
</tbody>
</table>
</div>
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
