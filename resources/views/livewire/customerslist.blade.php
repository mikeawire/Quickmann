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

@if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>Customers List</h5>
<br>
<div>




 <input type="text" id="search" wire:model="search" class="form-control mt-3 mb-4" placeholder="search by surname, first name, othername, email, phone number">



</div>
<div class="table-responsive bg-white">

@if( Auth::user()->staffprofile->role =='PM' ||Auth::user()->staffprofile->role =='DRO' || Auth::user()->staffprofile->role =='AHO' ||Auth::user()->staffprofile->role =='EA'
          )


<table class="table table-striped old">
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
<tbody  >

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

                        <form action="{{ route('pmcustomerproduct.product',$customer->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to view customer Profile?')"
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Product</button>
                     </form>

                     </td>

</tr>
@endforeach
</tbody>
</table>
@else


<table class="table table-striped old">
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
<tbody>
@foreach($customers as $customer)
<tr>
<td>

{{ $loop->iteration + (( $customers->currentPage() - 1 ) * $customers->perPage()) }}
</td>
<td>
{{ucwords($customer->username)}}
</td>
<td>
{{ucwords($customer->surname)}} {{ucwords($customer->first_name)}} {{ucwords($customer->othername)}}

</td>
<td>
{{ucwords($customer->phone)}}

</td>
<td>
{{ucwords($customer->email)}}

</td>


<td class="d-flex bg-white">


                       <form action="{{ route('customer.show',$customer->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to view customer Profile?')"
                        class="btn btn-info btn-sm" style="margin-right: 10px;">Profile</button>
                     </form>

                     @if( Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='MD'
          )
          
          
          <form action="/customer-followup/{{$customer->user_id}}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}

                        <button
                        class="btn btn-success btn-sm" style="margin-right: 10px;">Follow up</button>
                     </form>
                         <form action="{{ route('customer.edit',$customer->user_id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to edit customer Profile?')"
                        class="btn btn-primary btn-sm" style="margin-right: 10px;">edit</button>
                     </form>

                            <form action="{{ route('customer.destroy',$customer->user_id) }}" method="POST">
<input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to delete customer?')"
                        class="btn btn-danger btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                     </form>
@endif
                     </td>

</tr>
@endforeach
</tbody>
</table>

<div class="col-12 old">
{{$customers->links()}}


</div>

<div id="new">

</div>

@endif
</div></div>

</div>
</div>
