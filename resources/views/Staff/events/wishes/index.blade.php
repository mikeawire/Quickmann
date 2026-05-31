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

<div class="row p-3">
    <div class="col-12">
        <h3>Notification Schedules</h3>
        <div class="d-flex justify-content-end p-4">
          <a href="/create-wish" class="btn btn-primary">Create New Wish</a>
        </div>
<div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <th>Subject</th>
            <th>Category</th>
            <th>Schedule Date</th>
            <th>Email Platform</th>
            <th>Sms Platform</th>
            <th>Status</th>
            <th>Action</th>
          </thead>
          <tbody>
            @foreach($wishes as $wish)
            <tr>
                <td>{{$wish->subject ?? ''}}</td>
                <td>{{ucwords($wish->user_type) ?? ''}}</td>
                <td>{{$wish->date ?? ''}}</td>
                <td>@if($wish->email_platform ==1) Enabled @else Disabled @endif</td>
                <td>@if($wish->sms_platform ==1) Enabled @else Disabled @endif</td>
                <td>@if($wish->status ==1) Active @else Inactive @endif</td>
                <td>
                    <div class="d-flex">
                        <a href="/edit-wish/{{$wish->id}}" class="btn btn-sm btn-info mr-2 ">Edit</a>
                        <form action="/delete-wish/{{$wish->id}}" method="post">
    @method('delete')
    @csrf
    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this template?')">Delete</button>
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

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop