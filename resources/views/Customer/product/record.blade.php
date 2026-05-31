@extends('layouts.appnew')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
     
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Payment Records</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<section>
<div class="container-fluid">

<div class="row">
<div class="col-lg-12  home">


<div class="p-3 ">

<div class="table-responsive bg-white">
<h5>{{ucwords('Payment Reords')}}</h5>
<table class="table table-striped">
<thead>
    <th>
        S/N
</th>
<th class="">
   Month
</th>



<th  class="">
   Amount (&#8358;)
</th>

<th  class="">
   Status
</th>

<tbody>
    @foreach($records as $record)

    <tr>
        <td>
            {{$count++}}
</td>
@php
{{
$date = date('F Y',strtotime($record->month));

}}
@endphp
<td class="">
{{strtoupper($date)}}
</td>




<td class="">
&#8358;{{$record->amount}}
</td>





<td class="">
@if($record->status == 'success')
<i class="fa fa-check text-success" style="font-size:32px;"></i>
@endif
</td>

</tr>

@endforeach
@if($records->count() ==0)
<tr>
    <td colspan="3">
        No Record Found
</td>
</tr>
@endif
</thead>

</table>



</div>
</div>

</div>

</div>

</div>

</section>
</main>

@endsection
