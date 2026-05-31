@extends('layouts.appnew')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
    
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>

          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<section>

<div class="container-fluid">

<div class="row">

<div class="col-lg-12  home">


<div class="card  p-lg-5">
        @if (count($errors) > 0)
            <div class="alert alert-danger  alert-dismissible fade show mt-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                </button>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif
    @if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">

                {{ session()->get('success_msg') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                </button>
                </div>
                @endif
    <div class="p-2 text-center regno  mt-5">
    <h4>My Profile</h4>
    <br>
<h6 >Customer ID.<br><span> [{{Auth::user()->customerprofile->reg_no}}]</span></h6>

    </div>
<div class="text-center mt-5">
<img src="/images/{{Auth::user()->customerprofile->profile_photo}}" width="150" height="150" class="image-responsive">

<div class="p-2 text-center"><button type="button" class=" btn-0 btn  " data-toggle="modal" data-target="#exampleModal2" data-whatever="@getbootstrap" ><i class="fa fa-edit"></i></button>
</div></div>





<div class="text-center mt-5">
    <p class="text-success"><strong><i> {{strtoupper(Auth::user()->customerprofile->surname)}} {{strtoupper(Auth::user()->customerprofile->first_name)}} {{strtoupper(Auth::user()->customerprofile->othername)}}</i></strong>
</div>

<div class="col-lg-8 offset-lg-2 col-sm-10 offset-sm-1 mt-5">

<h6><strong><i class="fa fa-user mr-2"></i>{{strtoupper('personal information')}} <a href="/editpersonalinfo" class="ml-2"><i class="fa fa-edit"></i></a></strong>  <a  class="ml-5" href="/customerprofile/create">Change Password</a></h6>
</div>

<div class=" menu col-lg-8 offset-lg-2 col-sm-10 offset-sm-1  mb-2 mt-2">
<p><strong>Userame</strong><i> {{strtoupper(Auth::user()->username)}} </i><p>
<p><strong> Full Name</strong><i> {{strtoupper(Auth::user()->customerprofile->surname)}} {{strtoupper(Auth::user()->customerprofile->first_name)}} {{strtoupper(Auth::user()->customerprofile->othername)}}</i><p>


<p><strong>Gender</strong><i> {{strtoupper(Auth::user()->customerprofile->gender)}} </i><p>
<p><strong>Marital Status</strong><i> {{strtoupper(Auth::user()->customerprofile->marital_status)}} </i><p>
<p><strong>Date of Birth</strong><i> {{strtoupper(Auth::user()->customerprofile->dob)}} </i><p>


</div>


<div class="col-lg-8 offset-lg-2 col-sm-10 offset-sm-1 mt-5">

<h6><strong><i class="fa fa-phone mr-2"></i>{{strtoupper('Contact information')}}  <a href="/editcontactinfo" class="ml-2"><i class="fa fa-edit"></i></a></strong></h6>
</div>
<div class=" menu col-lg-8 offset-lg-2 col-sm-10 offset-sm-1  mb-2 mt-2">
<p><strong>Email</strong><i> {{strtolower(Auth::user()->email)}}</i><p>

<p><strong>Phone Number</strong><i> {{strtoupper(Auth::user()->phone)}} </i><p>
<p><strong>Address</strong><i> {{strtoupper(Auth::user()->customerprofile->address)}} </i><p>
<p><strong>City</strong><i> {{strtoupper(Auth::user()->customerprofile->city)}} </i><p>
<p><strong>State</strong><i> {{strtoupper(Auth::user()->customerprofile->state)}} </i><p>


</div>



<div class="col-lg-8 offset-lg-2 col-sm-10 offset-sm-1 mt-5">

<h6><strong><i class="fa fa-child mr-2"></i>{{strtoupper('Next of Kin information')}}  <a href="/editnextkininfo" class="ml-2"><i class="fa fa-edit"></i></a> </strong></h6>
</div>
<div class=" menu col-lg-8 offset-lg-2 col-sm-10 offset-sm-1  mb-2 mt-2">
<p><strong>Full Name</strong><i> {{strtoupper(Auth::user()->customerprofile->next_of_kin_name)}}<p>

<p><strong>Email</strong><i> {{strtolower(Auth::user()->customerprofile->next_of_kin_email)}} </i><p>
<p><strong>Gender</strong><i> {{strtoupper(Auth::user()->customerprofile->next_of_kin_gender)}} </i><p>
<p><strong>Phone</strong> Number<i> {{strtoupper(Auth::user()->customerprofile->next_of_kin_phone)}} </i><p>
<p><strong>Address</strong><i> {{strtoupper(Auth::user()->customerprofile->next_of_kin_address)}} </i><p>
<p><strong>City</strong><i> {{strtoupper(Auth::user()->customerprofile->next_of_kin_city)}} </i><p>
<p><strong>State</strong><i> {{strtoupper(Auth::user()->customerprofile->next_of_kin_state)}} </i><p>
<p><strong>Relationship</strong><i> {{strtoupper(Auth::user()->customerprofile->next_of_kin_relationship)}} </i><p>


</div>

</div>

</div>

</div>

</div>

</section>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <div class="col-12 text-center">
               <h3 >Change Photo</h3>
           </div>
      </div>
      <div class="modal-body bg-white">

       <div class="row">
           <div class="col-12">


<form  action="{{route('dashboard.update',Auth::user()->id)}}" method="post" class="mt-5"  enctype="multipart/form-data">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    <input name="type" type="hidden" value="step_six" id="type">
<div class="text-center result">
    <p>Click on Photo </p>
    <br>
<img src="/images/{{Auth::user()->customerprofile->profile_photo}}" width="70%" class="choose">
</div>



    <div class="form-group ">

<input type="file" id="profile_photo"  class="d-none form-control @error('profile_photo') is-invalid @enderror" name="profile_photo" placeholder="choose"   >
<div class="d-flex">
<input type="hidden" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo"    >

</div>


                        @error('profile_photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>






</form>
           </div>
        </div>
      </div>
      <div class="modal-footer">



        <button type="button" class="btn btn-default close_btn" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
</main>

@endsection
