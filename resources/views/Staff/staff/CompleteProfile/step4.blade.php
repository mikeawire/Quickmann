<!DOCTYPE html>
<html lang="en">
<head>
	<title>Staff Registration</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    @laravelPWA
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor2/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/vendor2/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor2/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/css/util.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">
    
<!--===============================================================================================-->
</head>
<body>
		<div class="overlay">
	<div class="limiter">
	    
		<div class="">
		    
			<div class="bg-light opacity-1 col-lg-8 offset-lg-2 lg-vh-100  p-3" style="min-height:100vh;">
	<div class="">			
<div class="mb-3">
<h4 class="text-center">Pofile Completion  <span class="text-info">[Step 4]</span></h4>
</div>

<h6>Ofice Details</h6>
<hr>
</div>
<form class="form p-3 form-profile" action="{{route('profile_step4')}}" method="post" > 
@csrf
<div class="row form-group">

<label class="col-lg-12 text-center"><img src="/images/{{Auth::user()->staffprofile->profile_photo ?? 'placeholder.jpg'}}" width="100"></label>

</div>
                     

<div class="row form-group">
@php
{{
$branches =DB::table('branches')->get();
$bra =DB::table('branches')->find(Auth::user()->staffprofile->branch_id);
}}
@endphp
<label class="col-lg-4 offset-lg-4"><span class="text-danger">*</span>Branch</label>
<select  class="col-lg-4 offset-lg-4 form-control @error('branch') is-invalid @enderror"  name="branch" 
							autocomplete="branch"autofocus  style="height:50px;">
    <option value="{{$bra->id ?? ''}}" >{{$bra->name ?? ''}}
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

<label class="col-lg-4 offset-lg-4"><span class="text-danger">*</span>Designated State</label>
<select  class="col-lg-4 offset-lg-4 form-control @error('state') is-invalid @enderror"  name="state" 
							autocomplete="state"autofocus  style="height:50px;">
						
					
							<option value{{Auth::user()->staffprofile->designated_state}}">{{Auth::user()->staffprofile->designated_state}}</option>
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
<div class="form-group d-flex text-center offset-lg-4 col-lg-4">

                      




<button class="btn-success  col-12 p-2 ml-2">Finish</button>

</div>

    </form>  

</div>
        
              
       
        






				

					
			</div>
		</div>
	</div>
		</div>
	

	
<!--===============================================================================================-->	
	<script src="/vendor2/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor2/bootstrap/js/popper.js"></script>
	<script src="/vendor2/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor2/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor2/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		});
	</script>
<!--===============================================================================================-->
	<script src="/js/main.js"></script>

</body>
</html>