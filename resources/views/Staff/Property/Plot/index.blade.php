@extends('adminlte::page')

@section('title', 'Plots')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-4 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>Products/Plots</h5>
<br>
  <form   method="POST" class="ajaxForm">
              {{ csrf_field() }}
              <input id="bid" type="hidden" name="" value="{{$id}}">
<input name="search" type="text" value="" id="search" class="form-control col-lg-5 offset-lg-7 mb-5 " placeholder="search by plot ID  or Price">
                    
                       
                     </form> 
<div class="table-responsive bg-white p-4">
<div class="d-flex">
<p class="mr-2"><i class="fa fa-circle text-success"></i> Available</p>
<p class="mr-2"><i class="fa fa-circle text-info"></i> Sold Out</p>
<p class="mr-2"><i class="fa fa-circle text-warning"></i> Under Installment</p>

</div>


<table class="table table-striped">
<thead>
<th>
S/N

</th>
<th>
Plot ID
</th>
<th>
Location Name
</th>
<th>
Brand
</th>
<th>
Price
</th>

<th>
SQM
</th>
<th>
No of Plots
</th>
 @if( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO'  ||  Auth::user()->staffprofile->role =='CMO')
<th>
    
Action
</th>
@endif
</thead>
<tbody class="result2"></tbody>
<tbody class="old">
@foreach($plots as $plot)
<tr>
<td>
@if($plot->status == 'sold')
<i class="fa fa-circle text-info"></i>
@elseif($plot->status == 'unsold')
<i class="fa fa-circle text-success"></i>
@else
<i class="fa fa-circle text-warning"></i>
@endif
{{ $loop->iteration + (( $plots->currentPage() - 1 ) * $plots->perPage()) }}
</td>
<td>
{{ucwords($plot->Plot_id)}}

</td>
<td>
@php
{{

    $p = DB::table('products')->find($plot->product_id);
}}
@endphp
{{ucwords($p->location_name)}}
</td>

<td>
@php
{{

    $pr = DB::table('plot_types')->find($plot->plot_type_id);
}}
@endphp
{{ucwords($pr->name)}}

</td>
<td>
{{ucwords($plot->price)}}

</td>
<td>
{{ucwords($plot->sqm)}}

</td>
<td>
{{ucwords($plot->no_of_plots)}}

</td>

<td class="d-flex bg-white">
     @if( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='CMO' )
    @if($plot->status == 'unsold')
    
<form action="{{ route('plot.show',$plot->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to sell this plot?')" 
                        class="btn btn-success btn-sm" style="margin-right: 10px;">Allocate Plot</button>
                     </form>
                     @endif
                     @endif
                      @if( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO')
                      
                      @if($plot->status=='unsold')
<form action="{{ route('plot.edit',$plot->id) }}" method="POST">
                                <input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to edit this product?')" 
                        class="btn btn-info btn-sm" style="margin-right: 10px;"><i class="fa fa-edit"></i></button>
                     </form>
<form action="{{ route('plot.destroy',$plot->id) }}" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to delete this Product?')" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
                     @endif
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

          
var bid =  $('#bid').val();
        //getting all values
       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
           url:"/get_plot_search/store",
            method: 'POST',
            data:
            {
         'id':id,
          'bid':bid,
            },
           
           beforeSend: function() {
          
       
            $(".result2").html("<p class='text-success'> Please wait fetch plot info.. </p>");
           
      
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