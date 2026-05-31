@extends('adminlte::page')

@section('title', 'Product Sold')
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
<h5>Product Sold</h5>
<br>
<div class="p-lg-4 mb-3 col-lg-5 offset-lg-7">
   <form action="{{ route('hbdmsales.store') }}" method="post">
   {{ csrf_field() }}
<div class="d-flex">
<select  class=" form-control @error('state') is-invalid @enderror"  name="state" 
                            autocomplete="state"autofocus  style="height:50px;">
                        
                    
                            <option value="" >Select State</option>
              <option value="Abuja FCT">Abuja FCT</option>
              <option value="Abia">Abia</option>
              <option value="Adamawa">Adamawa</option>
              <option value="Akwa Ibom">Akwa Ibom</option>
              <option value="Anambra">Anambra</option>
              <option value="Bauchi">Bauchi</option>
              <option value="Bayelsa">Bayelsa</option>
              <option value="Benue">Benue</option>
              <option value="Borno">Borno</option>
              <option value="Cross River">Cross River</option>
              <option value="Delta">Delta</option>
              <option value="Ebonyi">Ebonyi</option>
              <option value="Edo">Edo</option>
              <option value="Ekiti">Ekiti</option>
              <option value="Enugu">Enugu</option>
              <option value="Gombe">Gombe</option>
              <option value="Imo">Imo</option>
              <option value="Jigawa">Jigawa</option>
              <option value="Kaduna">Kaduna</option>
              <option value="Kano">Kano</option>
              <option value="Katsina">Katsina</option>
              <option value="Kebbi">Kebbi</option>
              <option value="Kogi">Kogi</option>
              <option value="Kwara">Kwara</option>
              <option value="Lagos">Lagos</option>
              <option value="Nassarawa">Nassarawa</option>
              <option value="Niger">Niger</option>
              <option value="Ogun">Ogun</option>
              <option value="Ondo">Ondo</option>
              <option value="Osun">Osun</option>
              <option value="Oyo">Oyo</option>
              <option value="Plateau">Plateau</option>
              <option value="Rivers">Rivers</option>
              <option value="Sokoto">Sokoto</option>
              <option value="Taraba">Taraba</option>
              <option value="Yobe">Yobe</option>
              <option value="Zamfara">Zamfara</option>
     <option value="Outside Nigeria">Outside Nigeria</option>
</select>

                                 
                                    
                        <button 
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Search</button>
                        </div>
                     </form>
</div>
<div class="table-responsive bg-white">


                    
<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Customer
</th>

<th>
Location Name
</th>
<th>
Plot ID
</th>

<th>
Product Fee (&#8358;)
</th>
<th>
Initial Deposit (&#8358;)
</th>
<th>
Amount Paid (&#8358;)
</th>

<th>
Balance (&#8358;)
</th>
<th>
Branch
</th>

<th>
State
</th>

<!--
<th>
Action
</th>-->
</thead>
<tbody>
@foreach($sales as $sale)
<tr>
<td>
  @php
{{


$user = DB::table('users')->find($sale->customer_id);
$branch = DB::table('branches')->find($sale->branch_id);

$customers = DB::table('customer_profiles')->where('user_id',$user->id)->get();

$plot = DB::table('plots')->find($sale->plot_id);
$product = DB::table('products')->find($plot->product_id);



}}
@endphp

{{ $loop->iteration + (( $sales->currentPage() - 1 ) * $sales->perPage()) }}

</td>
<td>
@foreach($customers as $customer)
{{ucwords($customer->surname)}} {{ucwords($customer->othername)}} {{ucwords($customer->first_name)}}
@endforeach
</td>

<td>
{{ucwords($product->location_name)}}


</td>

<td>
{{ucwords($plot->Plot_id)}}


</td>


<td>
&#8358;{{ucwords($sale->property_price)}}


</td>

<td>
&#8358;{{ucwords($sale->initial_deposit)}}

</td>
<td>
&#8358;{{ucwords($sale->total_amount_paid)}}

</td>
<td>
&#8358;{{ucwords($sale->unpaid_balance)}}


</td>

<td>
{{ucwords($branch->name)}}

</td>


<td>
{{ucwords($sale->state)}}

</td>



  <!--   

<td class="d-flex bg-white">
  
                     
                   <form action="{{ route('hbdmsales.show',$sale->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button 
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Records</i></button>
                     </form>
                     

                     </td>
-->
</tr>
@endforeach
</tbody>
</table>


<div class="col-12">
{{$sales->links()}}


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