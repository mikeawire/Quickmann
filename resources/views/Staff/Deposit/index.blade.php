@extends('adminlte::page')

@section('title', 'Customers List')
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
<br>
<h5>Deposit History</h5>
<br>
<div class="d-flex"><div class="ml-2"><i class="fa fa-circle text-warning"></i> Pending</div><div class="ml-2"><i class="fa fa-circle text-danger"></i> Cancel</div><div class="ml-2"><i class="fa fa-circle text-success"></i> Success</div></div>
<br>
 <form   method="POST" class="ajaxForm">
              {{ csrf_field() }}

<input name="search" type="text" value="" id="search" class="form-control col-lg-5 offset-lg-7 mb-5 " placeholder="search by customer ID">


                     </form>
<div class="table-responsive bg-white">

<table class="table table-striped">
<thead>
<th>
S/N
</th>
<th>
Customer Name
</th>

<th>
Amount(&#8358;)
</th>
<th>
Reference ID
</th>
<th>
Date
</th>
<th>
Action
</th>
</thead>
<tbody class="result2"></tbody>
<tbody class="old">
@foreach($deposits as $deposit)
<tr>
<td>

{{ $loop->iteration + (( $deposits->currentPage() - 1 ) * $deposits->perPage()) }}
@if($deposit->status =='pending')
<i class="fa fa-circle text-warning"></i>
@elseif($deposit->status =='success')
<i class="fa fa-circle text-success"></i>

@elseif($deposit->status =='cancel')
<i class="fa fa-circle text-danger"></i>
@endif
</td>
<td>
    @php
    {{
    $customer=DB::table('users')->find($deposit->customer_id);

    $cusps =DB::table('customer_profiles')->where('user_id',$deposit->customer_id)->get();

    }}
    @endphp
     @foreach($cusps as $cusp)



{{ucwords($cusp->surname)}} {{ucwords($cusp->first_name)}} {{ucwords($cusp->othername)}}

@endforeach
</td>

<td>

&#8358;{{$deposit->amount}}
</td>
<td>
    {{$deposit->ref_id}}

</td>
<td>
{{$deposit->created_at}}

</td>


<td class="d-flex bg-white">
<form action="{{ route('deposittxn.show',$deposit->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to view Deposit History?')"
                        class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>



                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12">
{{$deposits->links()}}
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
           url:"/get_deposit_search/store",
            method: 'POST',
            data:
            {
         'id':id,

            },

           beforeSend: function() {


            $(".result2").html("<p class='text-success'> Please wait fetch deposit info.. </p>");


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
