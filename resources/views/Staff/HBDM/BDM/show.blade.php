@extends('adminlte::page')

@section('title', 'BDM Profile')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

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
<h5>BDM Profile</h5>
<br>
<div class="table- bg-white p-4 col-lg-8 offset-lg-2 ">
    <h4>Personal Info</h4>
    <hr>
    <div class="row">
<div class="col-lg-8">
<div class="">

<p><b>Username:</b> <i>{{ucwords($staff->username)}}</i></p>
</div>
<div class="">

<p><b>Surname:</b> <i>{{ucwords($staff->staffprofile->surname)}}</i></p>
</div>

<div class="">

<p><b>First Name: </b><i>{{ucwords($staff->staffprofile->first_name)}}</i></p>
</div>


<div class="">

<p><b>Other Names:</b><i> {{ucwords($staff->staffprofile->othername)}}</i></p>
</div>

<div class="">

<p><b>Reg. No.</b><i> {{ucwords($staff->staffprofile->reg_no)}}</i></p>
</div>
<div class="">

<p><b>Gender:</b><i> {{ucwords($staff->staffprofile->gender)}}</i></p>
</div>
<div class="">

<p><b>Marital Status:</b><i> {{ucwords($staff->staffprofile->marital_status)}}</i></p>
</div>
</div>

<div class="col-lg-4 p-2 text-center mb-3 mt-3">
    <img src="/images/{{$staff->staffprofile->profile_photo}}" width="100" height="100;"> 
</div>

    </div>
    <h4>Contact Info</h4>
    <hr>
<div class="row">
    <div class="col-12">
    <div class="">

<p><b>Email:</b><i> {{ucwords($staff->email)}}</i></p>
</div>
<div class="">

<p><b>Phone Numbers:</b><i> {{ucwords($staff->phone)}}, {{ucwords($staff->staffprofile->second_phone)}}</i></p>
</div>
<div class="">

<p><b>Address:</b><i> {{ucwords($staff->staffprofile->address)}}</i></p>
</div>
<div class="">

<p><b>City:</b><i> {{ucwords($staff->staffprofile->city)}}</i></p>
</div>
<div class="">

<p><b>State:</b><i> {{ucwords($staff->staffprofile->state)}}</i></p>


</div>

    </div>
</div>
<h4>Other Info</h4>
    <hr>
<div class="row">
    <div class="col-12">
    <div class="">

<p><b>Position:</b><i>
 @if($staff->staffprofile->role =='MD')   

Managing Director ({{ucwords($staff->staffprofile->role)}})
@elseif($staff->staffprofile->role =='COO')   

Chief Operation Officer ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='CFO')   

Chief Financial Officer ({{ucwords($staff->staffprofile->role)}})
@elseif($staff->staffprofile->role =='HDBM')   

Head Business Development Manager ({{ucwords($staff->staffprofile->role)}})
@elseif($staff->staffprofile->role =='BDM')   

Business Development Manager ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='DRO')   

Direct Relationship Officer ({{ucwords($staff->staffprofile->role)}})
@elseif($staff->staffprofile->role =='BDO')   

Business Development Officer  ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='PM')   

Portfolio Manager ({{ucwords($staff->staffprofile->role)}})


@elseif($staff->staffprofile->role =='TSO')   

Technical Support Officer ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='SO')   

Site Officer ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='CMO')   

Customer Management Officer ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='HRM')   

Human Relation Manager ({{ucwords($staff->staffprofile->role)}})




@endif

</i></p>



</div>

<div class="">

<p><b>Designated State:</b><i> {{ucwords($staff->staffprofile->designated_state)}}</i></p>



</div>
  @php
{{



$branch = DB::table('branches')->find($staff->staffprofile->branch_id);


}}
@endphp

<div class="">

<p><b>Branch:</b><i> {{ucwords($branch->name)}}</i></p>



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