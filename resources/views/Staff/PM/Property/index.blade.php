@extends('adminlte::page')

@section('title', 'PMO Customers product List')
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
<h5>Customers List</h5>
<br>
<div class="table-responsive bg-white">


                    
<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Location Name
</th>
<th>
Plot ID
</th>
<th>
Product Price (&#8358;)
</th>
<th>
Amount Paid (&#8358;)
</th>

<th>
Outstanding Balance (&#8358;)
</th>

<th>
Date
</th>

<th>
Action
</th>
</thead>
<tbody>
@foreach($customerproperties as $cp)
<tr>
<td>
  @php
{{

$plot = DB::table('plots')->find($cp->plot_id);
$product = DB::table('products')->find($plot->product_id);

}}
@endphp
@if($plot->status =='pending')

<i class="fa fa-circle text-warning"></i>
@elseif($plot->status =='sold')

<i class="fa fa-circle text-success"></i>
@endif
{{ $loop->iteration + (( $customerproperties->currentPage() - 1 ) * $customerproperties->perPage()) }}

</td>
<td>
{{ucwords($product->location_name)}}
</td>
<td>
{{$plot->Plot_id}}

</td>
<td>
&#8358;{{$cp->property_price}}

</td>

<td>
&#8358;{{$cp->total_amount_paid}}

</td>
<td>
&#8358;{{$cp->unpaid_balance}}

</td>

<td>
{{$cp->created_at}}

</td>


<td class="d-flex bg-white">
  
                     
                        <form action="{{ route('pmcustomerproduct.productdetails',$cp->plot_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view product details?')" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>  
                     
                       

                     </td>

</tr>
@endforeach
</tbody>
</table>


<div class="col-12">
{{$customerproperties->links()}}


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