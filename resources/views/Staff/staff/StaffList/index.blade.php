@extends('adminlte::page')

@section('title', 'Staff List')
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
        
        @if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>Staff List</h5>
<br>

             <form   method="POST" class="ajaxForm">
              {{ csrf_field() }}
<input name="search" type="text" value="" id="search" class="form-control col-lg-5 offset-lg-7 mb-5 " placeholder="search by surname, designated state or staff ID ">
                    
                       
                     </form>  
<div class="table-responsive bg-white">


<table class="table table-striped">
<thead>
<th>
S/N
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
Branch
</th>
<th>
State
</th>
<th>
Position
</th>
<th>
Action
</th>
</thead>
<tbody class="result2"></tbody>
<tbody class="old">
@foreach($staffs as $staff)
<tr>
<td>
{{ $loop->iteration + (( $staffs->currentPage() - 1 ) * $staffs->perPage()) }}
</td>

<td>
{{ucwords($staff->staffprofile->surname)}} {{ucwords($staff->staffprofile->first_name)}} {{ucwords($staff->staffprofile->othername)}}

</td>
<td>
{{ucwords($staff->phone)}}

</td>
<td>
{{ucwords($staff->email)}}

</td>
@php
{{
$branch =DB::table('branches')->find($staff->staffprofile->branch_id);
}}
@endphp
<td>
{{ucwords($branch->name)}}

</td>
<td>
{{ucwords($staff->staffprofile->designated_state)}}

</td>
<td>
{{strtoupper($staff->staffprofile->role)}}

</td>

<td class="d-flex bg-white">
<form action="{{ route('staff.show',$staff->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to view staff Profile?')" 
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>

       @if(Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM')              
<form action="{{ route('staff.edit',$staff->staffprofile->user_id) }}" method="POST" class="ml-3">

{{ csrf_field() }}


<input name="_method" type="hidden" value="GET">
<button onclick="return confirm('Are you sure want to edit this staff Profile ?')" 

class="btn btn-info btn-sm" style="margin-right: 10px;">

<i class="fa fa-edit"></i></button>

</form>
       
       <form action="{{ route('staff.destroy',$staff->staffprofile->id) }}" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                    
                        <button onclick="return confirm('Are you sure want to delete Staff?')" 
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
                     @endif
                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12 old">
{{$staffs->links()}}
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
           url:"/get_staff_search/store",
            method: 'POST',
            data:
            {
         'id':id,
            },
           
           beforeSend: function() {
          
       
            $(".result2").html("<p class='text-success'> Please wait fetch staff info.. </p>");
           
      
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