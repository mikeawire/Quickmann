@extends('layouts.app')

@section('content')



<section>
<div class="container-fluid">

<div class="row">
<div class="col-lg-12 offset-lg-0  home">


<div class="card  ">

<div class="table-responsive">



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
<thead>
    <th>
        S/N
</th>
<th class="location">
    Location Name
</th>
<th>
    Address
</th>

<th>
   Purpose
</th>


<th>
  SQM
</th>


<th>
  No of olots
</th>

<th>
  Total Products Found
</th>







<th>
   Action
</th>
<tbody>


    @foreach($plots as $cp)
@php
{{
$state =Session::get('state');
$product= DB::table('products')->find($cp->product_id);
$products= DB::table('products')->where('id',$cp->product_id)->where('state',$state)->get();

if(Session::get('price_range') =='a')
{
  $bplots=DB::table('plots')->where('product_id',$cp->product_id)->where('status','unsold')->where('price','<=', 500000)->get();  
}
elseif(Session::get('price_range') =='b')
{
  $bplots=DB::table('plots')->where('product_id',$cp->product_id)->where('status','unsold')->where('price','>=', 500000)->where('price','<=', 1000000)->get();  
}
elseif(Session::get('price_range') =='c')
{
  $bplots=DB::table('plots')->where('product_id',$cp->product_id)->where('status','unsold')->where('price','>=', 1000000)->where('price','<=', 1500000)->get();  
}
elseif(Session::get('price_range') =='d')
{
  $bplots=DB::table('plots')->where('product_id',$cp->product_id)->where('status','unsold')->where('price','>=', 1500000)->where('price','<=', 3000000)->get();  
}
elseif(Session::get('price_range') =='e')
{
  $bplots=DB::table('plots')->where('product_id',$cp->product_id)->where('status','unsold')->where('price','>=', 3000000)->get();  
}
elseif(Session::get('price_range') =='f')
{
  $bplots=DB::table('plots')->where('product_id',$cp->product_id)->where('status','unsold')->get();  
}
}}
@endphp

@if($product->state == $state)
    <tr>
        <td>
         {{ $loop->iteration + (( $plots->currentPage() - 1 ) * $plots->perPage()) }}
</td>

<td class="location">
{{strtoupper($product->location_name)}}
</td>

<td class="plot_id">
{{ucwords($cp->address)}} {{ucwords($product->town)}}, {{ucwords($product->state)}}
</td>

<td class="plot_id">
{{ucwords($product->purpose)}} 
</td>




<td class="plot_id">
{{ucwords($bplots->sum('sqm'))}} 
</td>
<td class="plot_id">
{{ucwords($bplots->sum('no_of_plots'))}} 
</td>

<td class="plot_id">
{{ucwords($bplots->count())}} 
</td>
<td>

<form action="{{ route('findproperty.show',$cp->product_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view property details?')" 
                        class="btn btn-success btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>

</td>
</tr>
@endif    
@endforeach

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
