@extends('adminlte::page')

@section('title', 'Staff Profile')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy pt-2 pb-2 container">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

<div class="table- bg-white p-4 col-lg-12 offset-lg-0 ">
<h5 class="text-center text-dark"><b>Staff Profile</b></h5>
@php
{{
$branch =DB::table('branches')->find($staff->staffprofile->branch_id);
}}
@endphp
<div class="text-center text-warning">

<h4><i>{{ucwords($branch->name)}} Branch Office  {{ucwords($staff->staffprofile->designated_state)}} State</i></h4>

</div>
<br>
    <h4>Personal Info</h4>
    <hr>
    <div class="row">
<div class="col-8">
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
<div class="col-lg-4 text-center mb-3 mt-3 p-2">
    @if($staff->staffprofile->profile_photo == null)
    <img src="/images/placeholder.jpg" width="100" height="100;"> 
    @else
    <img src="/images/{{$staff->staffprofile->profile_photo}}" width="100" height="100"> 
    @endif
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



@elseif($staff->staffprofile->role =='FDO')   

Front Desk Officer ({{ucwords($staff->staffprofile->role)}})
@elseif($staff->staffprofile->role =='OA')   

Office Administrator ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='EA')   

Excutive Assistant ({{ucwords($staff->staffprofile->role)}})


@elseif($staff->staffprofile->role =='CA')   

Content Developer ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='AHO')   

Assistant Head of Operation  ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='ABDO')   

Assistant Business Development Officer ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='ABDM')   

Assistant Business Development Manager ({{ucwords($staff->staffprofile->role)}})

@elseif($staff->staffprofile->role =='HOR')   

Head of Recovery ({{ucwords($staff->staffprofile->role)}})
@elseif($staff->staffprofile->role =='AO')   

Account Officer ({{ucwords($staff->staffprofile->role)}})




@endif

</i></p>



</div>
@php
{{
$branch =DB::table('branches')->find($staff->staffprofile->branch_id);
}}
@endphp
<div class="">

<p><b>Designated State:</b><i> {{ucwords($staff->staffprofile->designated_state)}}</i></p>

<p><b>Branch:</b><i> {{ucwords($branch->name)}}</i></p>

</div>

    </div>
</div>

<form action="{{ route('pendingstaffreg.update',$staff->staffprofile->id) }}" method="POST" class="text-right">
<input name="_method" type="hidden" value="PUT">
                                    {{ csrf_field() }}
                                  
                                    @if($staff->staffprofile->status =='active')
                        <button 
                        class="btn btn-success btn-sm" disabled style="margin-right: 10px;">
                        
                        Approved <i class="fa fa-check"></i></button>
                        
                        @elseif($staff->staffprofile->status =='inactive')

                        <button onclick="return confirm('Are you sure want to approve this staff ?')" 

class="btn btn-primary btn-sm" style="margin-right: 10px;">

Approve</button>
@endif
                     </form>
                 
</div>

</div>

@stop
@section('footer')
   
@stop


@section('css')
   
@stop

@section('js')
    
@stop