@extends('layouts.appnew')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
     
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Appointment History</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Appointment Overview</h5>


<div class="card  ">
    
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

<div class="table-responsive">

<table class="table table-striped">
<thead>
    <th>
        S/N
</th>
  <th>
    Property
</th>
  <th>
    Subject
</th>
<th>
    Message
</th>
  <th>
   Schedule Date
</th>
  <th>
    Reschedule Date
</th>
<th  class="i_deposit">
Status
</th>
<th  class="i_deposit">
Action
</th>

<tbody>
    @foreach($app as $dp)

    <tr>
   <td>
     
          {{ $loop->iteration + (( $app->currentPage() - 1 ) * $app->perPage()) }}
          
</td>

  <td>
    {{$dp->Plot_id}}  {{$dp->location_name}} {{$dp->address}} {{$dp->town}} {{$dp->state}} 
</td>
<td>
  {{$dp->title}}   
</td>
<td class="p_deposit">

{!! nl2br($dp->message) !!}
</td>
<td class="p_deposit">
{{\Carbon\Carbon::parse($dp->schedule_date)->format('d F, Y h:ia' )}}
</td>
<td class="p_deposit">
    @if($dp->reschedule_date != null)
{{\Carbon\Carbon::parse($dp->reschedule_date)->format('d F, Y h:ia')}}
@endif
</td>

<td class="p_deposit">
{{$dp->status}}
</td>
<td >
  <div class="d-flex">                       
@if($dp->status =="awaiting reschedule approval")

<form action="{{ route('appointment.approve',$dp->app_id) }}" method="POST">
<input name="_method" type="hidden" value="PATCH">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('user.Are you sure want to approve this rescheduled appointment?')"
                        class="btn btn-success btn-sm" style="margin-right: 10px;">Acknowledge</button>
                     </form>
                            <form action="{{ route('user.appointment.decline',$dp->app_id) }}" method="POST">
<input name="_method" type="hidden" value="PATCH">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to decline this rescheduled appointment?')"
                        class="btn btn-danger btn-sm" style="margin-right: 10px;">Decline</button>
                     </form>
                     @endif
                     </div>   
</td>

@endforeach
@if($app->count() ==0)
<tr>
    <td colspan="11" class="text-center">
        No Record Found
</td>
</tr>
@endif
</thead>

</table>



<div class="mt-3">
    {{$app->links()}}
</div>
</div>
</div>

</div>

</div>

</div>

</section>
</main>




@endsection
