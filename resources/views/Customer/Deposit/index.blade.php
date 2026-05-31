@extends('layouts.appnew')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
     
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Payment History</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Payment Overview</h5>


<div class="card  ">

<div class="table-responsive">

<table class="table table-striped">
<thead>
    <th>
        S/N
</th>


<th>
    Amount(&#8358;)
</th>

<th  class="p_price">
Reference ID
</th>

<th  class="i_deposit">
Date
</th>


<th  class="p_price">
   Action
</th>
<tbody>
    @foreach($deposits as $dp)

    <tr>
        <td>
          {{ $loop->iteration + (( $deposits->currentPage() - 1 ) * $deposits->perPage()) }}
</td>



<td class="i_deposit">
&#8358;{{$dp->amount}}
</td>

<td class="p_price">{{$dp->ref_id}}
</td>

<td class="p_deposit">
{{$dp->created_at}}
</td>
<td  class="p_price">

<form action="{{ route('pay.show',$dp->id) }}" method="POST">
<input name="_method" type="hidden" value="GET">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to view Payment details?')"
                        class="btn btn-success btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
                     </form>

</td>
</tr>

@endforeach
@if($deposits->count() ==0)
<tr>
    <td colspan="7">
        No Record Found
</td>
</tr>
@endif
</thead>

</table>



<div class="mt-3">
    {{$deposits->links()}}
</div>
</div>
</div>

</div>

</div>

</div>

</section>
</main>

@endsection
