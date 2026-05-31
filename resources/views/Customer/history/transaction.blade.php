@extends('layouts.appnew')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
     
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Transaction History</li>
        </ol>
      </nav>
  </div><!-- End Page Title -->
{{--
      @php
                            try {
                                echo '<code>* * * * * ' . PHP_BINDIR . '/php  ' . base_path() . '/artisan schedule:run >> /dev/null 2>&1</code>';
                            } catch (\Throwable $th) {
                                echo '<code>* * * * * /php' . base_path() . '/artisan schedule:run >> /dev/null 2>&1</code>';
                            }
                        @endphp
                        
                      
--}}
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Transaction Overview</h5>


<div class="card  ">

<div class="table-responsive">

<table class="table table-striped">
<thead>
    <th>
        S/N
</th>


<th>
    Amount(&#8358;)
</th>

<th  class="p_price">
Type
</th>

<th  class="p_price">
Credit/Debit
</th>

<th  class="i_deposit">
Status
</th>

<th  class="i_deposit">
Description
</th>
<th  class="i_deposit">
Date
</th>


<tbody>
    @foreach($transactions as $dp)

    <tr>
        <td>
          {{ $loop->iteration + (( $transactions->currentPage() - 1 ) * $transactions->perPage()) }}
</td>



<td class="i_deposit">
&#8358;{{$dp->amount}}
</td>

<td class="p_price">{{$dp->type}}
</td>

<td class="p_deposit">
{{$dp->cd}}
</td>

<td class="p_deposit">
{{$dp->status}}
</td>
<td class="p_deposit">
@php

if($dp->type ==="deposit")
{
 $des="wallet topup via paystack";
}

@endphp

{!!$dp->description ?? ''!!}
</td>

<td class="p_deposit">
{{$dp->created_at}}
</td>
</tr>

@endforeach
@if($transactions->count() ==0)
<tr>
    <td colspan="7">
        No Record Found
</td>
</tr>
@endif
</thead>

</table>



<div class="mt-3">
    {{$transactions->links()}}
</div>
</div>
</div>

</div>

</div>

</div>

</section>
</main>

@endsection
