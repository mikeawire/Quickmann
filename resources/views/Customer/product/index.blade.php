@extends('layouts.appnew')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
    
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Products Details</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Shelter Informations</h5>
                   <div class="card ">
                    <div class="table-responsive p-3">
                    <h5>Products Details</h5>
                    <table class="table table-striped">
                    <thead>
                        <th>
                            S/N
                    </th>
                    <th class="location">
                        Location Name
                    </th>
                    <th>
                        Plot ID
                    </th>
                    <th class="p_type">
                        Payment Mode
                    </th>

                    <th>
                        Initial Deposit (&#8358;)
                    </th>

                    <th  class="p_price">
                       Product  Fee (&#8358;)
                    </th>

                    <th  class="p_price">
                       Amount Paid (&#8358;)
                    </th>

                    <th  class="p_price">
                       Balance (&#8358;)
                    </th>

                    <th>
                       Action
                    </th>
                    <tbody>
                        @foreach($customerproperties as $cp)

                        <tr>
                            <td>
                              {{ $loop->iteration + (( $customerproperties->currentPage() - 1 ) * $customerproperties->perPage()) }}
                    </td>
                    @php
                    {{
                    $plot=DB::table('plots')->find($cp->plot_id);
                    $product=DB::table('products')->find($plot->product_id);
                    }}
                    @endphp
                    <td class="location">
                    {{strtoupper($product->location_name)}}
                    </td>

                    <td class="plot_id">
                    {{$plot->Plot_id}}
                    </td>
                    <td class="p_type">
                    {{ucwords($cp->payment_type)}}
                    </td>

                    <td class="i_deposit">
                    &#8358;{{$cp->initial_deposit}}
                    </td>

                    <td class="p_price">
                    &#8358;{{$cp->property_price}}
                    </td>


                    <td class="p_price">
                    &#8358;{{$cp->total_amount_paid}}
                    </td>

                    <td class="p_price">
                    &#8358;{{$cp->unpaid_balance}}
                    </td>
                    <td class="d-flex">

                    <form action="{{ route('shelterproduct.show',$cp->id) }}" method="POST">
                    <input name="_method" type="hidden" value="GET">
                                                        {{ csrf_field() }}

                                            <button
                                            class="btn btn-success btn-sm" style="margin-right: 10px;">PayNow</button>
                                         </form>

                                         <form action="{{ route('shelterproduct.show',$cp->id) }}" method="POST">
                    <input name="_method" type="hidden" value="GET">
                                                        {{ csrf_field() }}

                                            <button
                                            class="btn btn-info btn-sm" style="margin-right: 10px;">View</button>
                                         </form>


                                            <form action="{{ route('record.show',$cp->id) }}" method="POST">
                    <input name="_method" type="hidden" value="GET">
                                                        {{ csrf_field() }}

                                            <button
                                            class="btn btn-primary btn-sm" style="margin-right: 10px;">Record</button>
                                         </form>

                    </td>
                    </tr>

                    @endforeach
                    @if($customerproperties->count() ==0)
                    <tr>
                        <td colspan="7">
                            No Record Found
                    </td>
                    </tr>
                    @endif
                    </thead>

                    </table>



                    <div class="mt-3">
                        {{$customerproperties->links()}}
                    </div>
                    </div>
                    </div>

                    </div>

                    </div>

                    </div>

                    </section>


              </div>
            </div>
          </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
                  </main>











@endsection
