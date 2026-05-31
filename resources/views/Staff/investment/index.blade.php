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
    Phone
</th>
<th>
Ref No
</th>
<th>
Investment Amount(&#8358;)
</th>
<th>
   Rate (% per month)
</th>
<th>
   Duration (months)
</th>
<th>
  Accumulated   Profit 
</th>
<th>
   Expected ROI
</th>
<th >
Start Date
</th>


<th>
Payout Date
</th>
<th >
Liquidated Date
</th>

<th>
Status
</th>
</thead>
  <tbody class="old">
  


    @foreach($investments as $dp)

    <tr>
 <td>
     
          {{ $loop->iteration + (( $investments->currentPage() - 1 ) * $investments->perPage()) }}
          
          @if($dp->status =='in progress')
<i class="fa fa-circle text-warning"></i>
@elseif($dp->status =='completed')
<i class="fa fa-circle text-success"></i>

@elseif($dp->status =='liquidated')
<i class="fa fa-circle text-danger"></i>

@elseif($dp->status =='liquidation requested')
<i class="fa fa-circle text-primary"></i>
@endif
</td>
<td>
  {{$dp->surname}}  {{$dp->first_name}}
</td>
<td>
    {{$dp->phone}}
</td>


<td class="p_price">{{$dp->ref}}
</td>
<td class="i_deposit">
&#8358;{{$dp->amount}}
</td>

<td class="p_price">{{$dp->rate}}
</td>
<td class="p_price">{{$dp->duration}}
</td>

@php
$roi = ($dp->rate/100) * $dp->amount * $dp->duration;
$createdAt = $dp->created_at; 

$currentDate = \Carbon\Carbon::now();

$monthsDifference = $createdAt->diffInMonths($currentDate);

if($monthsDifference > $dp->duration )
{ $monthsDifference=$dp->duration;
}

$profit = ($dp->rate/100) *  $dp->amount  * $monthsDifference;


@endphp

<td class="p_deposit">
@if($dp->status =="liquidated" || $dp->status=="completed")
&#8358;{{$dp->profit ?? ''}}
@else
&#8358;{{$profit ?? ''}}
@endif
</td>


<td class="p_price">&#8358;{{$roi}}
</td>



<td class="p_deposit">
{{\Carbon\Carbon::parse($dp->inv_created_at)->format('d F, Y')}}
</td>
<td class="p_deposit">
{{\Carbon\Carbon::parse($dp->inv_created_at)->addMonth($dp->duration)->format('d F, Y')}}
</td>
<td class="p_deposit">
@if($dp->liquidation_date !=null)
{{\Carbon\Carbon::parse($dp->liquidation_date)->format('d F, Y')}}
@endif
</td>
<td class="p_deposit">
{{$dp->status}}
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
