@extends('adminlte::page')

@section('title', 'Product Location')
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
<h5>Products Location</h5>
<br>
  <form   method="POST" class="ajaxForm">
              {{ csrf_field() }}
<input name="search" type="text" value="" id="search" class="form-control col-lg-5 offset-lg-7 mb-5 " placeholder="search by location name, city or state">
                    
                       
                     </form> 
<div class="table-responsive bg-white">

<div class="cl=ol-lg-5 offset-lg-7 p-3">
   
    
</div>
<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Location Name
</th>
<th>
Address
</th>

<th>
City/Town
</th>
<th>
State
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
Action
</th>
</thead>
<tbody class="result2"></tbody>
<tbody class="old">
@foreach($products as $product)
<tr>
<td>
{{ $loop->iteration + (( $products->currentPage() - 1 ) * $products->perPage()) }}
</td>
<td>
{{ucwords($product->location_name)}}
</td>
<td>
{{ucwords($product->address)}}

</td>
<td>
{{ucwords($product->town)}}

</td>
<td>
{{ucwords($product->state)}}

</td>
<td>
{{ucwords($product->sqm)}}

</td>
<td>
{{ucwords($product->no_of_plots)}}

</td>
<td>
{{ucwords($product->purpose)}}

</td>
<td class="d-flex bg-white">
<form action="{{ route('product.show',$product->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view this product?')" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>
                     
                     @if( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO')
<form action="{{ route('product.edit',$product->id) }}" method="POST">
                                <input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to edit this product?')" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;"><i class="fa fa-edit"></i></button>
                     </form>
<form action="{{ route('product.destroy',$product->id) }}" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to delete this Product?')" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
                     
                     @endif
                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12">
{{$products->links()}}
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
    
$(document).ready(function(){


    
    $('#search').keyup(function(){
        
var id =  $('#search').val();

  
        //getting all values
       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
           url:"/get_stock_search/store",
            method: 'POST',
            data:
            {
         'id':id,
            },
           
           beforeSend: function() {
          
       
            $(".result2").html("<p class='text-success'> Please wait fetch product info.. </p>");
           
      
        },  

        // on success response
        
        success:function(response) {
           if(response == '')
           {
            $(".result2").html(' not found');  
           }
           else
           {
                $('.old').hide();
            $(".result2").html(response);
           
           
           }
            
            
           
           // reset form fields

       
         
        },

        // error response
        error:function(e) {
            
            $(".result2").html("Some error encountered.");
        }
            
        });
     

    });

   

});
</script>
@stop