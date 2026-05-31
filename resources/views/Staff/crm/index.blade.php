@extends('adminlte::page')

@section('title', 'Payment Record')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-lg-4 pt-4 pb-2 container">

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

<div class="row p-3">
    <div class="col-12">
        <h3>Manage {{ucwords(strtolower($cus->surname))}} {{ucwords(strtolower($cus->first_name))}} Follow Up Messages</h3>
   
      <div class="d-flex justify-content-end">
      <button class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#exampleModalCenter">Send Via Email</button>
      <button class="btn btn-info ml-3 btn-sm"   data-toggle="modal" data-target="#exampleBModalCenter">Send Via Sms</button>
      </div>


      <div class="row">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                   
                    <th>Message</th>
                    <th>Platform</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($outbox as $otb)
                     <tr>
                     <td>
                        @if($otb->email_platform ==1)
                        <strong>Header: {{$otb->subject ?? ''}}</strong>
                            <br>
                            Body:  {!! nl2br($otb->email_body) ?? ''!!}
                         @endif
                         @if($otb->sms_platform ==1)
                           Body: {!! nl2br($otb->sms_body) ?? ''!!}
                           @endif
                        </td>
                        <td>@if($otb->email_platform ==1)
                            Email
                            @endif
                        @if($otb->sms_platform ==1)
                        SMS
                         @endif
                        </td>
                       

                        <td>
                        @if($otb->status ==1)
                        Sent
                        @else
                        Draft
                        @endif
                        </td>
                        <td>
                            {{date('d-m-Y H:i',strtotime($otb->created_at))}}
                        </td>

                        <td>
                            <div class="d-flex">
                                
                        <form action="/send-followup/{{$otb->id}}" method="post" >
                           @csrf  
                           @method('put')
                        @if($otb->status ==1)
                       
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to resend email to this customer ') ">Resend</button>
                        @else
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to resend sms to this customer ') ">Send</button>
                        @endif
                       </form>

                       <form action="/delete-followup/{{$otb->id}}" method="post" >
                           @csrf  
                           @method('delete')
                       
                       
                        <button type="submit" class="btn btn-danger ml-3" onclick="return confirm('Are you sure you want to delete thois message') ">Delete</button>
                        
                       </form>
                            </div>
                        </td>

                     </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
      </div>

</div>
</div>

  
</div>
</div>




<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Send Email Follow Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/create-email-followup" method="post" >
        @csrf
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="hidden" value="{{$user->id}}" name="user_id">
            <input type="text" name="subject" id="subject" required value="" class="form-control @error('subject') is-invalid @enderror">
            @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>

     
        <div class="form-group">
            <label for="email_body">Email Body  hint: variables include {last_name}, {first_name} </label>
            <textarea rows="10" name="email_body" id="email_body" required class="form-control @error('email_body') is-invalid @enderror"></textarea>
            @error('email_body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>
      

        <div class="form-group">
            <label for="status">Status </label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">--SELECT--</option>
                <option value="0" >Draft</option>
                <option value="1" >Send</option>
            </select>
            @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
      </div>
     
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleBModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Send SMS Follow Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/create-sms-followup" method="post" >
        @csrf
        <input type="hidden" value="{{$user->id}}" name="user_id">


        <div class="form-group">
            <label for="sms_body">SMS Body  hint: variables include {last_name}, {first_name} </label>
            <textarea rows="10" name="sms_body" id="sms_body" required class="form-control @error('sms_body') is-invalid @enderror"></textarea>
            @error('sms_body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>

      

        <div class="form-group">
            <label for="status">Status </label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">--SELECT--</option>
                <option value="0" >Draft</option>
                <option value="1" >Send</option>
            </select>
            @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
      </div>
     
    </div>
  </div>
</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    <script>
        // Get a reference to your modal element
var modal = document.getElementById('exampleBModalCenter'); // Replace 'yourModalId' with the actual ID of your modal

// Remove the backdrop
modal.classList.remove('modal-backdrop'); // This removes the backdrop class



    </script>
@stop