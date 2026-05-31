@extends('adminlte::page')

@section('title', 'My Customers')
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
        
@if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>My Customers</h5>
<br>

<div class="table-responsive bg-white">

<div class="row">
 <!--
<div class="col-6">
   
<table class=" col-6">
@foreach($bcustomers as $bcustomer)
<tr>
    <td>{{ $x++}}

</td>
<td>{{$bcustomer->user_id}}</td>



</tr>

        @endforeach  
        </table>
        </div>
        <div class="col-6">
<table class=" ">
        @foreach($users as $user)


<tr>
<td>{{$y++}}

</td>
<td>{{$user->id}}</td>
<td>{{$user->phone}}</td>
</tr>

        @endforeach  
        </table>
        </div>
        </div>
    -->    
<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Username
</th>
<th>
Full Name
</th>
<th>
Phone Number
</th>
<th>
Email
</th>

<th>
Action
</th>
</thead>
<tbody class="result2">
    
</tbody>
<tbody  class="old">

@foreach($customers as $customer)
<tr>
<td>
  @php
{{

$user = DB::table('users')->find($customer->user_id);

}}
@endphp
{{ $loop->iteration + (( $customers->currentPage() - 1 ) * $customers->perPage()) }}

</td>
<td>
{{ucwords($user->username ) ?? ''}}
</td>
<td>
{{ucwords($customer->surname)}} {{ucwords($customer->first_name)}} {{ucwords($customer->othername)}}

</td>
<td>
{{ucwords($user->phone) ?? ''}}

</td>
<td>
{{ucwords($user->email) ?? ''}}

</td>


<td class="d-flex bg-white">
  

        <form action="{{ route('customer.show',$customer->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view customer Profile?')" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;">Profile</button>
                     </form>  
                     
                   
                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12 old">
{{$customers->links()}}


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
           url:"/get_customer_search/store",
            method: 'POST',
            data:
            {
         'id':id,
            },
           
           beforeSend: function() {
          
       
            $(".result2").html("<p class='text-success'> Please wait fetch customer info.. </p>");
           
      
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