@extends('adminlte::page')

@section('title', 'Transaction Record')
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
<h5>Payment Record  </h5>
<br>
<div class="table-responsive bg-white">
<div class="p-3">
  <p>{{$transactions->count()}} Result found in {{ucwords(Session::get('state'))}} State</p>
  
</div>

                    
<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Customer Name
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
Location Name
</th>
<th>
Plot ID
</th>

<th>
Brand
</th>


<th>
Branch
</th>

<th>
State
</th>

<th>
Amount (&#8358;)
</th>
<th>
Txn ID
</th>

<th>
Channel
</th>
<th>Times
</th>

<th>
Date
</th>
<!--
<th>
Action
</th>-->
</thead>
<tbody>
@foreach($transactions as $tran)
<tr>
<td>


{{ $loop->iteration + (( $transactions->currentPage() - 1 ) * $transactions->perPage()) }}

</td>
<td>
{{ucwords($tran->fullname)}}
</td>

<td>
{{ucwords($tran->customer_reg_no)}}


</td>
<td>
{{ucwords($tran->phone)}}


</td>
<td>
{{ucwords($tran->email)}}


</td>
<td>
{{ucwords($tran->location_name)}}


</td>
<td>
{{ucwords($tran->plot_no)}}


</td>
<td>
{{ucwords($tran->Brand)}}


</td>
<td>
{{ucwords($tran->branch)}}


</td>
<td>
{{ucwords($tran->state)}}


</td>


<td>
&#8358;{{ucwords($tran->amount)}}


</td>

<td>
{{ucwords($tran->txn_id)}}

</td>
<td>
{{ucwords($tran->payment_method)}}

</td>
<td>
{{ucwords($tran->no_of_times)}}


</td>
<td>
{{ucwords($tran->updated_at)}}

</td>





  <!--   

<td class="d-flex bg-white">
  
                     
                   <form action="{{ route('hbdmsales.show',$tran->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button 
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Records</i></button>
                     </form>
                     

                     </td>
-->
</tr>
@endforeach

@if($transactions->count() <=0)
<td colspan="9" class="text-align">
No Record Found
</td>
@endif
</tbody>
</table>


<div class="col-12">
{{$transactions->links()}}


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