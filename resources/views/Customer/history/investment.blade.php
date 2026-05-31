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

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Investment Overview</h5>


<div class="card  ">
    
     @if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        
           @if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

<div class="table-responsive">

<table class="table table-striped">
<thead>
    <th>
        S/N
</th>

  <th>
        Reference No.
</th>
<th>
    Amount(&#8358;)
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
<th  class="p_price">
Start Date
</th>


<th  class="p_price">
Payout Date
</th>

<th  class="i_deposit">
Status
</th>
<th  class="i_deposit">
Action
</th>

<tbody>
    @foreach($investments as $dp)

    <tr>
        <td>
          {{ $loop->iteration + (( $investments->currentPage() - 1 ) * $investments->perPage()) }}
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
@if($dp->status =="liquidated" || $dp->status=="completed" || $dp->status=="liquidation requested")
&#8358;{{$dp->profit ?? ''}}
@else
&#8358;{{$profit ?? ''}}
@endif
</td>


<td class="p_price">&#8358;{{$roi}}
</td>



<td class="p_deposit">
{{\Carbon\Carbon::parse($dp->created_at)->format('d F, Y')}}
</td>
<td class="p_deposit">
{{\Carbon\Carbon::parse($dp->created_at)->addMonth($dp->duration)->format('d F, Y')}}
</td>
<td class="p_deposit">
{{$dp->status}}
</td>
<td class="p_deposit">
@if($dp->status=="in progress")
  <button class=" small pt-1 fw-bold btn btn-sm btn-outline-primary "  data-toggle="modal" data-target="#liquidateModal{{$dp->id}}">Liquidate</button>
  @endif
</td>
</tr>



<!-- Modal -->
<div class="modal fade" id="liquidateModal{{$dp->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"  id="exampleModalLongTitle"> Liquidate Investment </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <form method="post" action="{{route('liquidate_investment',$dp->id)}}" id="investmentForm">
               
               @csrf()
               @method('PATCH')
          
        
 

    <div class="alert alert-warning">
        <h5>Important Notice:</h5>
    
        <p>If you choose to liquidate your investment before the {{setting()->investment_duration ?? 12}}-month term is complete, the {{100 - setting()->liquidation_profit_rate ?? 0}}% penalty on generated interest will apply. Carefully weigh the potential benefits and drawbacks of early withdrawal.</p>
       
    </div>

  <div class="alert alert-success">
      <p>Principal Amount: &#8358;{{number_format($dp->amount,2)}}</p>
      <p>Profit: &#8358;{{number_format($profit,2)}}</p>
      @php
      $liq = (setting()->liquidation_profit_rate * $profit)/100;
      $deduction = $profit - $liq;
      @endphp
      <p>{{100 - setting()->liquidation_profit_rate ?? 0}}% deduction &#8358; {{number_format($deduction ,2)}}</p>
      <p>Total:  &#8358;{{number_format($dp->amount +  $liq,2)}} </p>
  </div>
  
        
          <p class="lead text-danger">By clicking liquidate, you acknowledge that you have read, understood, and accepted the terms and conditions outlined. Furthermore, you take full responsibility for your decisions.</p>
        
      
         <div class="text-right">
       
        <button type="submit" class="btn btn-primary">Liquidate</button>
      </div>
          </form>
      </div>
     
    
    </div>
  </div>
</div>

@endforeach
@if($investments->count() ==0)
<tr>
    <td colspan="11" class="text-center">
        No Record Found
</td>
</tr>
@endif
</thead>

</table>



<div class="mt-3">
    {{$investments->links()}}
</div>
</div>
</div>

</div>

</div>

</div>

</section>
</main>




@endsection
