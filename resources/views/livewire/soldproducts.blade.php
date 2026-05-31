<div>
  

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
<h5>Products Sold</h5>
<br>
 <a href="/export_sold/xls" class="btn btn-sm btn-primary">Excel</a>
     <a href="/export_sold/csv" class="btn btn-sm btn-info">CSV</a>
      <!--<a href="/export_sold/pdf" class="btn btn-sm btn-danger">PDF</a>-->
          <a href="/export_sold/xlsx" class="btn btn-sm btn-warning">XLSX</a>
  <form   method="POST" class="ajaxForm">
              {{ csrf_field() }}
          
<input name="search" type="text" value="" id="search" wire:model="search" class="form-control col-lg-5 offset-lg-7 mb-5 " placeholder="search by plot ID  or Price">
                    
                       
                     </form> 
<div class="table-responsive bg-white">


<table class="table table-striped">
<thead>
<th>
S/N
</th>

<th>
Customer ID
</th>
<th>
Location Name
</th>
<th>
Address
</th>

<th>
State
</th>
<th>
Plot ID
</th>
<th>
SQM
</th>
<th>
No of Plots
</th>
<th>
Purpose
</th>

<th>
Price
</th>
<th>
Action
</th>
</thead>
<tbody class="result2"></tbody>
<tbody class="old">
@foreach($plots as $plot)
<tr>
    @php
    {{
    $product=DB::table('products')->find($plot->product_id);
    
     $brand=DB::table('plot_types')->find($plot->plot_type_id);
     
     
    }}
    @endphp
<td>
{{ $loop->iteration + (( $plots->currentPage() - 1 ) * $plots->perPage()) }}
</td>
<td>


{{$plot->customer_reg_no}}

</td>
<td>
{{ucwords($product->location_name)}}
</td>
<td>
{{ucwords($product->address)}} {{ucwords($product->town)}}

</td>
<td>

{{ucwords($product->state)}}
</td>
<td>
{{ucwords($plot->Plot_id)}}

</td>
<td>
{{ucwords($plot->sqm)}}

</td>
<td>
{{ucwords($plot->no_of_plots)}}

</td>
<td>
{{ucwords($product->purpose)}}

</td>
<td>
{{ucwords($plot->price)}}

</td>
<td class="d-flex bg-white">
<form action="{{ route('sales.show',$plot->nplot_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view sales details?')" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>
  <form action="/customerpayment/{{$plot->cp_id}}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view payment details?')" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;">Payment Record</button>
                     </form>
                     


                     
                     
                     
                      @if(Auth::user()->staffprofile->role =='MD'|| Auth::user()->staffprofile->role =='HBDM' || Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='COO'  ||  Auth::user()->staffprofile->role =='HOR' ||  Auth::user()->staffprofile->role =='CMO' || Auth::user()->staffprofile->role =='FDO' || Auth::user()->staffprofile->role =='CD' )
                       
                      <form action="{{ route('customerrevoke.store' )}}" method="POST">

                                    {{ csrf_field() }}
                                    
                               

<input type="hidden" name="cp_id" value="
{{$plot->cp_id}}">


                                    
                                     <input type="hidden" name="plot_id" value="{{$plot->nplot_id}}">
                                     
                                    
                                  
                                      <input type="hidden" name="user_id" value="{{$plot->customer_id}}">
                                 
                        <button  onclick="return confirm('Are you Sure You To Revoke Property From Customer, Note This Can not be Undo ?')" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;">Revoke</button>
                     </form>  
                    
                     
                     @endif
                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12">
{{$plots->links()}}
</div>
</div></div>

</div></div>
<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>
