@extends('adminlte::page')

@section('title', 'Staff Profile')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/style.css">
  @laravelPWA
@stop

@section('content')

<div class="row  ">

<div class="col-lg-12 offset-lg-0 container-body bg-navy p-4 container ">

@if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
<h5>Edit Staff Profile</h5>
<br>
<div class="table- bg-white p-4 col-lg-8 offset-lg-2  mt-5">
   
  

<form action="{{ route('staff.update',$staff->staffprofile->id) }}" method="POST" class="">
<input name="_method" type="hidden" value="PUT">
                                    {{ csrf_field() }}
                                  
                          

<div class="row form-group">

<label class="col-lg-4"><span class="text-danger">*</span>Branch</label>
<select  class="col-lg-8 form-control @error('branch') is-invalid @enderror"  name="branch" 
							autocomplete="branch"autofocus  style="height:50px;">
    	<option value="{{$branch->id}}" >{{$branch->name}}
						@foreach($branches as $branch)
					
							<option value="{{$branch->id}}" >{{$branch->name}}
							</option>
             @endforeach
</select>

@error('branch')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
          

<div class="row form-group">

<label class="col-lg-4"><span class="text-danger">*</span>Designated State</label>
<select  class="col-lg-8 form-control @error('state') is-invalid @enderror"  name="state" 
							autocomplete="state"autofocus  style="height:50px;">
						
					
							<option value="{{$staff->staffprofile->designated_state}}" >{{$staff->staffprofile->designated_state}}</option>
              <option value="Abuja FCT">Abuja FCT</option>
              <option value="Abia">Abia</option>
              <option value="Adamawa">Adamawa</option>
              <option value="Akwa Ibom">Akwa Ibom</option>
              <option value="Anambra">Anambra</option>
              <option value="Bauchi">Bauchi</option>
              <option value="Bayelsa">Bayelsa</option>
              <option value="Benue">Benue</option>
              <option value="Borno">Borno</option>
              <option value="Cross River">Cross River</option>
              <option value="Delta">Delta</option>
              <option value="Ebonyi">Ebonyi</option>
              <option value="Edo">Edo</option>
              <option value="Ekiti">Ekiti</option>
              <option value="Enugu">Enugu</option>
              <option value="Gombe">Gombe</option>
              <option value="Imo">Imo</option>
              <option value="Jigawa">Jigawa</option>
              <option value="Kaduna">Kaduna</option>
              <option value="Kano">Kano</option>
              <option value="Katsina">Katsina</option>
              <option value="Kebbi">Kebbi</option>
              <option value="Kogi">Kogi</option>
              <option value="Kwara">Kwara</option>
              <option value="Lagos">Lagos</option>
              <option value="Nassarawa">Nassarawa</option>
              <option value="Niger">Niger</option>
              <option value="Ogun">Ogun</option>
              <option value="Ondo">Ondo</option>
              <option value="Osun">Osun</option>
              <option value="Oyo">Oyo</option>
              <option value="Plateau">Plateau</option>
              <option value="Rivers">Rivers</option>
              <option value="Sokoto">Sokoto</option>
              <option value="Taraba">Taraba</option>
              <option value="Yobe">Yobe</option>
              <option value="Zamfara">Zamfara</option>
     <option value="Outside Nigeria">Outside Nigeria</option>
</select>

@error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
                    

<div class="row form-group">
<label class="col-lg-4"><span class="text-danger">*</span>Position </label>
						<select  class="form-control col-lg-8 @error('position') is-invalid @enderror"  name="position" 
							autocomplete="position"autofocus  style="height:50px;">
						
							<option value="{{$staff->staffprofile->role}}" >
 @if($staff->staffprofile->role =='MD')   

Managing Director 
@elseif($staff->staffprofile->role =='COO')   

Chief Operation Officer 

@elseif($staff->staffprofile->role =='CFO')   

Chief Financial Officer 
@elseif($staff->staffprofile->role =='HDBM')   

Head Business Development Manager
@elseif($staff->staffprofile->role =='BDM')   

Business Development Manager 

@elseif($staff->staffprofile->role =='DRO')   

Direct Relationship Officer 
@elseif($staff->staffprofile->role =='BDO')   

Business Development Officer  

@elseif($staff->staffprofile->role =='PM')   

Portfolio Manager 


@elseif($staff->staffprofile->role =='TSO')   

Technical Support Officer 

@elseif($staff->staffprofile->role =='SO')   

Site Officer 

@elseif($staff->staffprofile->role =='CMO')   

Customer Management Officer

@elseif($staff->staffprofile->role =='HRM')   

Human Relation Manager



@elseif($staff->staffprofile->role =='FDO')   

Front Desk Officer
@elseif($staff->staffprofile->role =='CD')   

Content Developer

@elseif($staff->staffprofile->role =='HOR')   

Head of Recovery 

@elseif($staff->staffprofile->role =='OA')   

Office Administrator 

@elseif($staff->staffprofile->role =='EA')   

Excutive Assistant 

@elseif($staff->staffprofile->role =='CA')   

Content Developer 

@elseif($staff->staffprofile->role =='AHO')   

Assistant Head of Operation  

@elseif($staff->staffprofile->role =='ABDO')   

Assistant Business Development Officer 

@elseif($staff->staffprofile->role =='ABDM')   

Assistant Business Development Manager 
@elseif($staff->staffprofile->role =='AO')   
Account Officer



@endif</option>
              <option value="MD">Managing Director</option>
              <option value="COO">Chief operation officer </option>
              <option value="CFO">Chief financial officer</option>
              <option value="HBDM">Head Business Development Manager </option>
              <option value="BDM">Business Development Manager</option>
              <option value="DRO">Direct Relationship Officer</option>
              <option value="BDO">Business Development Officer</option>
              <option value="PM">Portfolio Manager</option>
              <option value="TSO">Technical Support Officer</option>
              <option value="SO">Site Officer</option>
              <option value="CMO">Customer Management Officer</option>
              <option value="HRM">Human Relation Manager </option>
              <option value="CD">Content Developer </option>
                <option value="OA">Office Administrator </option>
                 <option value="FDO">Front Desk Officer </option>
                  <option value="EA">Excutive Assistant </option>
                   <option value="AHO">Assistant Head of Operation </option>
                  <option value="ABDO">Assistant Business Development Officer</option>
                   <option value="ABDM">Assistant Business Development Manager</option>
                     <option value="AO">Account Officer</option>
            <option value="HOR">Head of Recovery</option>
</select>
                   
					
                    
                    </div>
                    <div class="row form-group">

                        <button onclick="return confirm('Are you sure want to update  staff info ?')" 

class="btn btn-info btn-sm col-lg-8 offset-lg-4" style="margin-right: 10px;">

Update</button>

                     </form>
                 
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