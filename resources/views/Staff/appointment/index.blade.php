@extends('adminlte::page')

@section('title', 'Withdrawal list')
@section('css')

  @laravelPWA

<link rel="stylesheet" type="text/css" href="/css/style.css">
 @livewireStyles
@stop

@section('content')


@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        @if(session()->has('danger_msg'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('danger_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
           <div class="table-responsive">
<table class="table table-dark" id="otpViewTable">
    

<thead>
<th>
S/N
</th>
<th>
Customer Name
</th>
<th>
    Phone
</th>
<th>
Property Location
</th>
<th>
Schedule Date
</th>
<th >
Reschedule Date
</th>
<th>
  Message
</th>
<th>
  Status
</th>
<th>
Action
</th>
</thead>
  <tbody class="old">
  


    @foreach($app as $dp)

    <tr>
 <td>
     
          {{ $loop->iteration + (( $app->currentPage() - 1 ) * $app->perPage()) }}
          
</td>
<td>
    {{$dp->surname}} {{$dp->first_name}}  {{$dp->othername}}
</td>
    <td>
    {{$dp->phone}} 
</td>
  <td>
    {{$dp->Plot_id}}  {{$dp->location_name}} {{$dp->address}} {{$dp->town}} {{$dp->state}} 
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
<strong>{{$dp->title}} </strong>
<br>
{!! nl2br($dp->message) !!}
</td>
<td class="p_deposit">
{{$dp->status}}
</td>
<td class="d-flex">
                            
@if($dp->status =="pending")
<button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#rescheduleModal{{$dp->app_id}}">
    Reschedule
</button>
<form action="{{ route('appointment.approve',$dp->app_id) }}" method="POST">
<input name="_method" type="hidden" value="PATCH">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to approve this appointment?')"
                        class="btn btn-success btn-sm" style="margin-right: 10px;">Approve</button>
                     </form>
                            <form action="{{ route('appointment.decline',$dp->app_id) }}" method="POST">
<input name="_method" type="hidden" value="PATCH">
                                    {{ csrf_field() }}

                        <button onclick="return confirm('Are you sure want to decline this appointment?')"
                        class="btn btn-danger btn-sm" style="margin-right: 10px;">Decline</button>
                     </form>
                     @endif
</td>
</tr>



<!-- Modal -->
<div class="modal fade" id="rescheduleModal{{$dp->app_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"  aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"  id="exampleModalLongTitle">Reschedule Appointment </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <form method="post" action="{{route('appointment.reschedule',$dp->app_id)}}" >
               
               @csrf()
               @method('PATCH')
          
        
    <div class="form-group">
        <label for="title">Date</label>
       <input type="datetime-local" class="form-control rescheduleDate" name="reschedule_date" required placeholder="Title " >
          
       </div>

         <div class="text-right">
       
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
          </form>
      </div>
     
    
    </div>
  </div>
</div>
@endforeach
</tbody>
</table>
</div>
@stop
@section('footer')

@stop


@section('css')

@stop

@section('js')
 @livewireScripts



 <script>
        $('#otpViewTable').DataTable({
           processing: true,

           "pageLength": 10,
           "paging": true,

           "searching": true,
           "ordering": true,
           "bLengthChange": true,
           "responsive": true,
           "lengthChange": true,
           "autoWidth": false,








        });
    </script>
    
    
    
<script>
 
const elements = document.getElementsByClassName('rescheduleDate');

// Get the current date and time
const today = new Date();
const year = today.getFullYear();
const month = (today.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
const day = today.getDate().toString().padStart(2, '0');
const hours = today.getHours().toString().padStart(2, '0');
const minutes = today.getMinutes().toString().padStart(2, '0');

// Format the date in a way that datetime-local input accepts (YYYY-MM-DDThh:mm)
const currentDate = `${year}-${month}-${day}T${hours}:${minutes}`;

// Loop through all elements with the class name 'rescheduleDate' and set the min attribute for each
for (let i = 0; i < elements.length; i++) {
  elements[i].min = currentDate;
}
</script>


@stop
