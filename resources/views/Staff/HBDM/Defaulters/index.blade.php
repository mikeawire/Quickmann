@extends('adminlte::page')

@section('title', 'Transaction Record')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy container pt-2">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

<div class="table-responsive bg-white p-2">


<h5 class="text-dark">Defaulters</h5>
<br>

<div class="p-3">
    
@php

{{

$page = $defaulters->currentPage();
$tp = (($page-1) * 20) + $defaulters->count();
}}
@endphp

  <p>Total Sum of money <b>&#8358;{{$counting->sum('amount_due')}}</b></p>
   <p>Total Defaulters <b>{{$counting->count()}}</b></p>

  <p>{{$tp}} of {{$counting->count()}} Result found in {{ucwords(Session::get('state2'))}} State</p>

  
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
Location Name
</th>
<th>
Plot ID
</th>

<th>
Month
</th>


<th>
Branch
</th>

<th>
State
</th>

<th>
Amount Paid (&#8358;)
</th>
<th>
Amount Due (&#8358;)
</th>
<th>
Action
</th>



<!--
<th>
Action
</th>-->
</thead>
<tbody>
@foreach($defaulters as $default)
<tr>
<td>

{{ $loop->iteration + (( $defaulters->currentPage() - 1 ) * $defaulters->perPage()) }}
@php
{{
$customers =DB::table('customer_profiles')->where('user_id',$default->user_id)->get();
$pro =DB::table('customer_properties')->find($default->customerproperty_id);
$plot =DB::table('plots')->find($pro->plot_id);
$product =DB::table('products')->find($plot->product_id);

}}
@endphp
</td>
<td>
{{ucwords($default->fullname)}}
</td>


<td>
{{ucwords($product->location_name)}}


</td>
<td>
{{ucwords($plot->Plot_id)}}


</td>
<td>
@php
{{
$date = date('F Y',strtotime($default->month));

}}
@endphp
{{ucwords($date)}}


</td>
<td>
{{ucwords($default->branch)}}


</td>
<td>
{{ucwords($default->state)}}


</td>


<td>
&#8358;{{ucwords($default->amount)}}


</td>

<td>
&#8358;{{ucwords($default->amount_due)}}

</td>



<td class="d-flex">

        <form action="{{ route('customer.show',$default->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button  
                        class="btn btn-primary btn-sm" style="margin-right: 10px;">View</button>
                     </form> 


                           <form action="{{ route('customerpayment.show',$pro->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button  
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Payment</button>
                     </form>  

                      @if(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO'  ||  Auth::user()->staffprofile->role =='HOR' ||  Auth::user()->staffprofile->role =='CMO' || Auth::user()->staffprofile->role =='FDO' || Auth::user()->staffprofile->role =='CD' )
                      <form action="{{ route('customerrevoke.store' )}}" method="POST">

                                    {{ csrf_field() }}
                                    <input type="hidden" name="cp_id" value="{{$pro->id}}">
                                     <input type="hidden" name="plot_id" value="{{$plot->id}}">
                                      <input type="hidden" name="full_name" value="{{$default->fullname}}">
                                      <input type="hidden" name="user_id" value="{{$default->user_id}}">
                                      
                        <button  onclick="return confirm('Are you Sure You To Revoke Property From Customer, Note This Can not be Undo ?')" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;">Revoke</button>
                     </form>  
                     
                     @endif

</td>







</tr>

@endforeach
<tr>

@if($defaulters->count() <=0)
<td colspan="9" class="text-align">
No Record Found
</td>
@endif
</tr>
</tbody>
</table>


<div class="col-12">
{{$defaulters->links()}}


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