@extends('adminlte::page')

@section('title', 'Revoked Fund')
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
<h5>Revoked Fund</h5>
<br>
<div class="table-responsive bg-white p-3">


<table class="table table-striped" id="revokeTable">
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
Phone
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
Total Amount Paid
</th>
<th>
Product Fee
</th>
<th>
Outstanding Balance 
</th>

<th>
Action
</th>
</thead>

<tbody class="old">
@foreach($revokedusers as $ru)
<tr>
    @php
    {{
     $plot=DB::table('plots')->find($ru->plot_id);
    
    $product=DB::table('products')->find($plot->product_id);
    
     $brand=DB::table('plot_types')->find($plot->plot_type_id);
     
       $customers=DB::table('customer_properties')->where('plot_id',$plot->id)->get() ;
    }}
    @endphp
<td>
{{$count++}}
</td>
<td>
{{$ru->full_name}}
</td>
<td>
{{$ru->customer_reg_no}}
</td>
<td>
{{$ru->phone}}
</td>
<td>
{{$ru->email}}
</td>
<td>
{{ucwords($product->location_name)}}
</td>


<td>
{{ucwords($plot->Plot_id)}}
</td>

<td>
&#8358;{{ucwords($ru->total_amount_paid)}}

</td>
<td>
&#8358;{{ucwords($ru->property_price)}}

</td>
<td>
&#8358;{{ucwords($ru->outstanding_balance)}}

</td>
<td class="d-flex bg-white">
<form action="{{ route('customer.show',$ru->customer_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view customer profile ?')" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>
                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12">

</div>
</div></div>

</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop


@section('js')



    <script>
        $('#revokeTable').DataTable({
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