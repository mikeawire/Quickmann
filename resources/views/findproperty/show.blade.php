@extends('layouts.app')

@section('content')



<section>
<div class="container-fluid">

<div class="row">
<div class="col-lg-12 offset-lg-0  home">


<div class="card  ">

<div class="table-responsive">


<h6 class="text-center">{{$plots->count()}} {{ucwords('shelter products')}} Found</h6>


<div class="d-lg-flex search_header w-100">
@php
    {{
        $initial_payment =Session::get('initial_payment');

        $monthly_payment =Session::get('monthly_payment');
        $mode_of_payment =Session::get('mode_of_payment');
     
    }}
    @endphp
    <p>
Initial Payment:
&#8358;{{$initial_payment}}</p>

<p>
Monthly Payment:
&#8358;{{$monthly_payment}}</p>

<p>
Mode of Payment:
{{ucwords($mode_of_payment)}}</p>
</div>
<table class="table table-striped">
<thead class="bg-light">
    <th>
        S/N
</th>
<th >
    Location Name
</th>
<th >
   Brand
</th>
<th >
    Plot ID
</th>


<th>
    Product Price (&#8358;)
</th>

<th>
    Area (SQM)
</th>


<th >
   No of Plots
</th>


<th >
   No of Installment
</th>
<tbody>
@if($plots->count() ==0)
<tr>
    <td colspan="7">
        No Record Found
</td>
</tr>
@else
    @foreach($plots as $plot)
@php
{{
$product =DB::table('products')->find($plot->product_id);
$brand =DB::table('plot_types')->find($plot->plot_type_id);
$inp =Session::get('initial_payment');
$y =$plot->price - $inp;
$x = Session::get('monthly_payment');
$no = round($y/$x);
if($no < 1)
{
$no =0;
}
}}
@endphp

    <tr>
        <td>
          {{ $loop->iteration + (( $plots->currentPage() - 1 ) * $plots->perPage()) }}
</td>

<td class="location">
{{ucwords($product->location_name)}}
</td>


<td class="plot_id">
{{ucwords($brand->name)}}
</td>
<td class=" location">
{{$plot->Plot_id}} 
</td>



<td class="plot_id">
&#8358;{{$plot->price}}
</td>

<td class=" location">
{{$plot->sqm}} 
</td>



<td class="plot_id">
{{$plot->no_of_plots}}
</td>
<td class=" location">
   
{{$no}} installment

</td>
</tr>

@endforeach
@endif
</thead>

</table>



<div class="mt-3">
    {{$plots->links()}}
</div>
</div>
</div>

</div>

</div>

</div>

</section>
</div>
@include('includes.footer')
@endsection
