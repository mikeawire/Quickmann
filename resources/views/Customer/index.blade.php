@extends('layouts.appnew')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
      
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard | Customer ID: <br><span> [{{Auth::user()->customerprofile->reg_no}}]</span></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            @if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
          <div class="row">

            <!-- Sales Card -->
               
    @php
     $ads = \App\Ad::where('status',1)->orderBy('created_at','DESC')->get();
  
    @endphp
    @if($ads->count() > 0)
<div class="col-xxl-12 col-md-12 mb-3">
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    @foreach($ads as $x => $ad)
    <div class="carousel-item @if($x == 0) active @endif">
        <a href="{{$ad->url}}">
      <img class="d-block w-100" src="{{$ad->image}}"
      alt="{{$ad->url}}">
            </a>
    </div>
    @endforeach
   
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
 </div>
 
 @endif
 
      <div class="col-xxl-12 col-md-12">
              <div class="card info-card sales-card">


                <div class="card-body">
                  <h5 class="card-title"> Upcomming<span> Appointment</span></h5>

                  <div class="">
                   
                    <div class="">
                   @php 
                   $app = \App\Appointment::
                   join('customer_properties','customer_properties.id','appointments.property_id')
                   ->join('plots','customer_properties.plot_id','plots.id')
                   ->join('products','products.id','plots.product_id')
                   ->where('appointments.user_id', auth()->user()->id)
                   ->where(function ($query) {
                       $query->where('appointments.schedule_date', '>=', now())
                           ->orWhere('appointments.reschedule_date', '>=', now());
                   })
                   ->whereIn('appointments.status',['pending','awaiting reschedule approval','approved'])
                   ->select('products.location_name','plots.Plot_id','customer_properties.id as prop_id','appointments.*')
                   ->orderBy('appointments.schedule_date', 'ASC')
                   ->first();

                   @endphp
                   <div class="row">
                    <div class="ps-3 col-lg-6">
                      @if($app)
                      <p>Date: @if($app->reschedule_date != null) {{$app->reschedule_date ?? ''}} @else {{$app->schedule_date ?? ''}}@endif</p>
                      <p>Title: {{$app->title ?? ''}}</p>
                      <p>Location :{{$app->Plot_id}} {{$app->location_name}}</p>
                      <p>Status: <strong>{{$app->status ?? ''}}</strong></p>
                      @else
                      <p>No Appointment</p>
                      @endif
                    </div>
                    <div class="col-lg-6 text-right">
                         <button type="button" class=" small pt-1 fw-bold btn btn-sm btn-primary"  data-toggle="modal" data-target="#appointmentModal">
                          Book Appointment</button> 
                    </div>
                    </div>
                  </div>
                </div>
  </div>
              </div>
            </div><!-- End Sales Card -->
            
             <div class="col-xxl-6 col-md-4">
              <div class="card info-card sales-card">


                <div class="card-body">
                  <h5 class="card-title">Wallet <span> Balance</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="fa fa-dollar text-info"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{auth()->user()->customerProfile->wallet_balance ?? 0}}</h6>
                       <button type="button" class=" small pt-1 fw-bold btn btn-sm btn-outline-success rounded-circle"  data-toggle="modal" data-target="#topUpModal">Top Up</button> 

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            
            
         
            
            
            
                <div class="col-xxl-6 col-md-4">
              <div class="card info-card sales-card">


                <div class="card-body">
                  <h5 class="card-title">Unapproved <span> Withdrawal</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="fa fa-list-alt text-warning"></i>
                    </div>
                    <div class="ps-3">
                        @php
                        $amount=\App\Withdrawal::where('user_id',auth()->user()->id)->where('status','pending')->sum('amount');
                        @endphp
                      <h6>{{number_format($amount,2) ?? 0.00}}</h6>
                       <button class=" small pt-1 fw-bold btn btn-sm btn-outline-warning rounded-circle"  data-toggle="modal" data-target="#withdrawalModal">Withdraw</button> 
                 

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            
                <div class="col-xxl-6 col-md-4">
              <div class="card info-card sales-card">


                <div class="card-body">
                  <h5 class="card-title">Active <span> Investment</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="fa fa-credit-card text-danger"></i>
                    </div>
                    <div class="ps-3">
                          @php
                        $inv_amount=\App\Investment::where('user_id',auth()->user()->id)->where('status','in progress')->sum('amount');
                        @endphp
                      <h6>{{$inv_amount}}</h6>
                       <button class=" small pt-1 fw-bold btn btn-sm btn-outline-success rounded-circle"  data-toggle="modal" data-target="#investmentModal">Invest </button> 
                   

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            <div class="col-xxl-6 col-md-4">
              <div class="card info-card sales-card">


                <div class="card-body">
                  <h5 class="card-title">Property <span> Bought</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart4"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$customerproperty->count()}}</h6>
                      {{-- <span class="text-success small pt-1 fw-bold">products</span> <span class="text-muted small pt-2 ps-1">History</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-6 col-md-4">
              <div class="card info-card revenue-card">


                <div class="card-body">
                  <h5 class="card-title">Total Duration of Payment <span> (Months)</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    @php
                    {{
        $bmonths =DB::table('monthly_records')->where('user_id',Auth::user()->id)->where('revoke_status','no')->orderBy('created_at','ASC')->get();


                    }}
                    @endphp





                    <div class="ps-3">
                      <h6> {{$bmonths->count()}}</h6>


                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-6 col-xl-4">

              <div class="card info-card customers-card">



                <div class="card-body">
                  <h5 class="card-title">Remaining <span>  Months</span></h5>
                  @php
            {{

$months =DB::table('monthly_records')->where('status','!=','success')->where('user_id',Auth::user()->id)->where('revoke_status','no')->orderBy('created_at','ASC')->get();
            }}
            @endphp
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-calendar2-plus-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$months->count()}}</h6>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            {{-- <!-- Reports -->
            <div class="col-12">
              <div class="card">



                <div class="card-body">
                  <h5 class="card-title">Check Payment <span>History</span></h5>
                  <p>for further information on payment recieved</p>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-calendar2-plus-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$months->count()}}</h6>

                    </div>
                  </div>

                </div>

              </div>
            </div><!-- End Reports --> --}}

            <!-- Recent Sales -->
            {{-- <div class="col-12">
              <div class="card recent-sales overflow-auto">

                   <div class="card-body">
                  <h5 class="card-title">payment  <span>History</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Product</th>
                        {{-- <th scope="col">Price</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#">#2457</a></th>
                        <td>Brandon Jacob</td>
                        <td><a href="#" class="text-primary">{{$customerproperty->count()}}</a></td>

                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2147</a></th>
                        <td>Bridie Kessler</td>
                        <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                        <td>$47</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2049</a></th>
                        <td>Ashleigh Langosh</td>
                        <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                        <td>$147</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2644</a></th>
                        <td>Angus Grady</td>
                        <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                        <td>$67</td>
                        <td><span class="badge bg-danger">Rejected</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2644</a></th>
                        <td>Raheem Lehner</td>
                        <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                        <td>$165</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Top Selling <span>| Today</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Sold</th>
                        <th scope="col">Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                        <td>$64</td>
                        <td class="fw-bold">124</td>
                        <td>$5,828</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-2.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                        <td>$46</td>
                        <td class="fw-bold">98</td>
                        <td>$4,508</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-3.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                        <td>$59</td>
                        <td class="fw-bold">74</td>
                        <td>$4,366</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-4.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                        <td>$32</td>
                        <td class="fw-bold">63</td>
                        <td>$2,016</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-5.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                        <td>$79</td>
                        <td class="fw-bold">41</td>
                        <td>$3,239</td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling --> --}}

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">



        </div>
        <!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->
{{-- <div class="container-fluid">

<div class="row">
<div class="col-lg-12 offset-lg-0  home">


<div class="card  ">


    <div class="p-2 text-center regno mt-5 ">

<h6 >Customer ID.<br><span> [{{Auth::user()->customerprofile->reg_no}}]</span></h6>

    </div>
<div class="text-center mt-5">
<img src="/images/{{Auth::user()->customerprofile->profile_photo}}" width="150" height="150" class="image-responsive">



</div>
<div class="text-center mt-5">
    <p class="text-success"><strong>Welcome:<i> {{strtoupper(Auth::user()->customerprofile->surname)}} {{strtoupper(Auth::user()->customerprofile->first_name)}} {{strtoupper(Auth::user()->customerprofile->othername)}}</i></strong>
</div>
<div class="col-lg-6 offset-lg-3 col-md-10 offset-md-2">

<div class="row bg-warning">
<div class=" col-8 bg-info p-3">
<p class="text-white">Property Bought</p>
</div>
<div class="col-4 p-3">
<h2>{{$customerproperty->count()}}</h2>
</div>
</div>

<div class="row bg-warning">
<div class=" col-8 bg-info p-3">
<p class="text-white">Total Duration of Payment (month)</p>
</div>
 @php
            {{
$bmonths =DB::table('monthly_records')->where('user_id',Auth::user()->id)->where('revoke_status','no')->orderBy('created_at','ASC')->get();


            }}
            @endphp

<div class="col-4 p-3">


<h2>{{$bmonths->count()}}</h2>
</div>
</div>
<div class="row bg-warning">
<div class=" col-8 bg-info p-3">
<p class="text-white">Remaining Months</p>
</div>
 @php
            {{

$months =DB::table('monthly_records')->where('status','!=','success')->where('user_id',Auth::user()->id)->where('revoke_status','no')->orderBy('created_at','ASC')->get();
            }}
            @endphp

<div class="col-4 p-3">


<h2>{{$months->count()}}</h2>
</div>
</div>
<div class="row bg-warning">
<div class=" col-8 bg-info p-3">
<p class="text-white">Total Month Paid</p>
</div>
 @php
            {{


$months =DB::table('monthly_records')->where('status','=','success')->where('user_id',Auth::user()->id)->where('revoke_status','no')->orderBy('created_at','ASC')->get();
            }}
            @endphp

<div class="col-4 p-3">


<h2>{{$months->count()}}</h2>
</div>
</div>


</div>
</div>



<div class="col-lg-8 offset-lg-2 mt-5">

<h6><strong><i class="fa fa-bars mr-2"></i>{{strtoupper('Main menu options')}}</strong></h6>
</div>
<div class="  col-lg-8 offset-lg-2 p-2 mb-2 mt-2">
    <div class="row">
<div class="col-lg-3 main_menu">
<div class="card">

<p><a href="/dashboard"><strong><i class="fa fa-home mr-2"></i></strong><h1>Home</h1></a><p>
</div>

</div>




<div class="col-lg-3 main_menu">
<div class="card">

<p><a href="/shelterproduct"><strong><i class="fa fa-list-alt mr-2"></i></strong><h1>Shelter Products</h1></a><p>
</div>

</div>


<div class="col-lg-3 main_menu">
<div class="card">


<p><a href="/pay"><strong><i class="fa fa-credit-card mr-2"></i></strong><h1>Payment History</h1></a><p>
</div>

</div>


<div class="col-lg-3 main_menu">
<div class="card">


<p><a href="/findproperty" class=""><strong><i class="fa fa-search mr-2"></i><h1>Find Property</h1></strong></a><p>
</div>

</div>

    </div>





</div>
</div>

</div>

</div>

</div> --}}

</section>

          </main>
          
          
          
          
          
<!-- Modal -->
<div class="modal fade" id="topUpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Topup Your Wallet </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <form method="post" action="javascript:void(0)" id="topupForm">
        <div class="form-group">
           
            <input type="number" step="any" class="form-control" name="amount" placeholder="Enter Amount (NGN)" >
            
             <input type="hidden" name="email" value="{{Auth::user()->email}}"> {{-- required --}}
            <input type="text" name="first_name" value="{{Auth::user()->customerprofile->first_name}}" hidden>
            <input type="text" name="last_name" value="{{Auth::user()->customerprofile->surname}}" hidden>
            <input type="text" name="phone" value="{{Auth::user()->phone}}" hidden>
            <input type="text" name="quantity" value="1" hidden>
            <input type="text" name="payment_type" value="topup" hidden>
            
               <input type="hidden" name="currency" value="NGN">
            <input type="hidden" name="metadata"
            value="{{ json_encode($array = ['surname' =>Auth::user()->customerprofile->surname,'first_name' =>Auth::user()->customerprofile->first_name,'reg_id' =>Auth::user()->customerprofile->reg_no]) }}" > 
        </div>
        <p class="text-danger">Ensure your browser have redirect enabled before you proceed</p>
         <div class="text-right">
       
        <button type="submit" class="btn btn-primary">Proceed</button>
      </div>
          </form>
      </div>
     
    
    </div>
  </div>
</div>

@php 
$cps = \App\Models\CustomerProperty::join('plots','customer_properties.plot_id','plots.id')
->join('products','products.id','plots.product_id')
->where('customer_properties.customer_id',auth()->user()->id)
->select('products.location_name','plots.Plot_id','customer_properties.id as prop_id')
->get();
@endphp
          
<!-- Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>Appointment/Site Visitation </strong> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <form method="post" action="javascript:void(0)" id="appointmentForm">
        <div class="form-group">
        <label for="title">Title</label>
       <input type="text" step="any" class="form-control" name="title" placeholder="Title " >
          
       </div>
       <div class="form-group">
        <label for="title">Message</label>
       <textarea class="form-control" name="appointment_message" placeholder="Message " rows="6"></textarea>
          
       </div>
       <div class="form-group">
        <label for="title">Date</label>
       <input type="datetime-local" class="form-control" name="schedule_date" placeholder="Title " >
          
       </div>
       <div class="form-group">
        <label for="title">Property</label>
       <select class="form-control" name="property" placeholder="Property " >
        <option value="">--SELECT--</option>
        @foreach($cps as $cp)
        <option value="{{$cp->prop_id}}">{{$cp->Plot_id}} {{$cp->location_name}}</option>
        @endforeach
       </select>
          
       </div>
         <div class="text-right">
       
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
          </form>
      </div>
     
    
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="withdrawalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"  id="exampleModalLongTitle">Place A Withdraw  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <form method="post" action="javascript:void(0)" id="withdrawalForm">
            <div class="form-group">
            <label class="fw-bold">Account Name</label>
           <input type="text" name="account_name" class="form-control" placeholder="Account Name">
        </div>
        <div class="form-group">
            <label  class="fw-bold">Account Number</label>
           <input type="number" name="account_number" class="form-control" placeholder="Account Number">
        </div>
        
            <div class="form-group">
            <label  class="fw-bold">Bank Name</label>
           <input type="text" name="bank_name" class="form-control" placeholder="Bank Name">
        </div>
        
         <div class="form-group">
            <label  class="fw-bold">Account Type</label>
           <select name="account_type" class="form-control">
               <option value="">--SELECT--</option>
               <option value="savings">Savings</option>
               <option value="current">Current</option>
               </select>
        </div>
        
        
         <div class="form-group">
            <label  class="fw-bold">Amount</label>
           <input type="number" name="withdrawal_amount" id="amount" min="1" class="form-control" placeholder="Amount">
        </div>
      
         <div class="text-right">
       
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
          </form>
      </div>
     
    
    </div>
  </div>
</div>






<!-- Modal -->
<div class="modal fade" id="investmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"  id="exampleModalLongTitle"> Create An Investment </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <form method="post" action="javascript:void(0)" id="investmentForm">
          
        
      
         <div class="jumbotron mt-4">
        <h1 class="display-4">Disclaimer: Important Investment Information</h1>
        <p>Before proceeding with any investment, it is crucial that you fully understand the terms and conditions associated with it. Please carefully read and consider the following disclaimer regarding the investment opportunity you are about to explore.</p>
    </div>

    <div class="alert alert-info">
        <h5>Investment Terms:</h5>
        <p><strong>Interest Rate:</strong> The investment you are considering offers an interest rate of {{setting()->investment_rate ?? 0}}% per month on the principal amount.</p>
        <p><strong>Investment Duration:</strong> This investment is set to last for a duration of {{setting()->investment_duration ?? 12}} months.</p>
        <p><strong>Liquidation Penalty:</strong> In the event that you choose to liquidate your investment before the {{setting()->investment_duration ?? 12}}-month duration has elapsed, you will incur a penalty. Specifically, you will lose {{100 - setting()->liquidation_profit_rate ?? 50}}% of the generated interest.</p>
    </div>

    <div class="alert alert-warning">
        <h5>Important Considerations:</h5>
    
        <p><strong>Duration:</strong> As mentioned, this investment has a fixed term of {{setting()->investment_duration ?? 12}} months. Be sure to assess your financial situation and liquidity needs to ensure that you can commit to this term.</p>
        <p><strong>Liquidation:</strong> If you choose to liquidate your investment before the {{setting()->investment_duration ?? 12}}-month term is complete, the {{100 - setting()->liquidation_profit_rate ?? 50}}% penalty on generated interest will apply. Carefully weigh the potential benefits and drawbacks of early withdrawal.</p>
        <p><strong>Financial Advice:</strong> Before making any investment decisions, we strongly recommend seeking advice from a qualified financial advisor. They can help you evaluate whether this investment aligns with your financial goals and risk tolerance.</p>
        <p><strong>Transparency:</strong> Please make sure to ask any questions you have about this investment to ensure complete clarity and understanding. It is crucial to have a thorough comprehension of the terms and conditions before proceeding.</p>
    </div>

  
   <div class="form-group">
            <label  class="fw-bold">Enter Amount</label>
           <input type="number" name="investment_amount" id="investment_amount" min="1" class="form-control" placeholder="Amount" onKeyup="calculateInvestment()">
        </div>
        
        <div id="cal">
            
        </div>
        
          <p class="lead text-danger">By clicking invest, you acknowledge that you have read, understood, and accepted the terms and conditions outlined in this disclaimer. Furthermore, you take full responsibility for your investment decisions.</p>
        
      
         <div class="text-right">
       
        <button type="submit" class="btn btn-primary">Invest</button>
      </div>
          </form>
      </div>
     
    
    </div>
  </div>
</div>



@endsection

@section('js')

<script>


function calculateInvestment()
{
    var amount = document.getElementById("investment_amount").value;
    let duration = "{{setting()->investment_duration ?? 12}}";
    let r= '{{setting()->investment_rate ?? 0}}'
    let rate = r/100;
    
    var interest;
    
    interest = amount * rate * 12;
    let returns = parseFloat(amount) + interest
    if(amount > 0)
    {
        
        document.getElementById("cal").innerHTML = "<p> Interest: " + interest+ "  </p><p>Expected Returns: " + returns +" </p><p>Duration: "+ duration +"months" ;
        
    }
    console.log(interest)
}
  document.getElementById('topupForm').addEventListener('submit', async (event) => {
  event.preventDefault();
  const form = document.getElementById('topupForm');
  const formData = new FormData(form);
  const formDataObject = {};

  for (const [name, value] of formData) {
    formDataObject[name] = value;
  }

  const data =formDataObject;


    const url ="{{route('topup')}}"
    
    postData(url, data,false);
  });
  
  
  
    document.getElementById('withdrawalForm').addEventListener('submit', async (event) => {
  event.preventDefault();
  const form = document.getElementById('withdrawalForm');
  const formData = new FormData(form);
  const formDataObject = {};

  for (const [name, value] of formData) {
    formDataObject[name] = value;
  }

  const data =formDataObject;


    const url ="{{route('withdraw')}}"
    
    postData(url, data,true);
  });


  document.getElementById('appointmentForm').addEventListener('submit', async (event) => {
  event.preventDefault();
  const form = document.getElementById('appointmentForm');
  const formData = new FormData(form);
  const formDataObject = {};

  for (const [name, value] of formData) {
    formDataObject[name] = value;
  }

  const data =formDataObject;


    const url ="{{route('schedule_appointment')}}"
    
    postData(url, data,true);
  });
  
  
  
    document.getElementById('investmentForm').addEventListener('submit', async (event) => {
  event.preventDefault();
  const form = document.getElementById('investmentForm');
  const formData = new FormData(form);
  const formDataObject = {};

  for (const [name, value] of formData) {
    formDataObject[name] = value;
  }

  const data =formDataObject;


    const url ="{{route('create_investment')}}"
    
    postData(url, data,true);
  });
  
  
  
    function removeErrorMessages() {
  const errorMessages = document.querySelectorAll('.error-message');
  
  // Loop through each element with the 'error-message' class and remove them
  errorMessages.forEach(errorMessage => errorMessage.remove());
}

    


  async function postData(url, data , reload) {
    
    try {
      removeErrorMessages()
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // Replace with your actual CSRF token
        },
        body: JSON.stringify(data)
      });

      const responseData = await response.json();
      if (!response.ok) {
        if (response.status == 422) {
          validationResponse(responseData.data.errors);
        } else {
           alert(responseData.message)
        }

      } else {
         if(response.status==200)
         {
             
             
             window.location.href=responseData.url
            
         }
        
        if(reload)
        {
              alert(responseData.message)
          window.location.reload()
        }

      }
    } catch (error) {
        //errorToastr("error occured")
    }
  }
  </script>
  
  
    <script>
  function validationResponse(errors) {
  // Clear previous error messages
  const errorSpans = document.querySelectorAll('.error-message');
  errorSpans.forEach(span => span.remove());

  const fieldNames = Object.keys(errors);

  fieldNames.forEach(fieldName => {
    const inputField = document.querySelector(`form [name="${fieldName}"], form [name="${fieldName}[]"]`);
    const passInput = document.querySelector(".auth-pass-inputgroup"); // Change getElementsByClassName to querySelector

    
    if (inputField) {
      const errorMessage = errors[fieldName];
      
      const errorSpan = document.createElement('span');
      errorSpan.className = 'error-message text-danger';
      errorSpan.innerText = errorMessage;
      
      if (fieldName === "password") {
        passInput.insertAdjacentElement('afterend', errorSpan);
      } else {
        inputField.insertAdjacentElement('afterend', errorSpan);
      }
    }
  });
}
        </script>
@endsection
