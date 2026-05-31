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
<h4 class="text-center">Pofile Completion  <span class="text-info">[Step 2]</span></h4>
</div>
<div class="text-right">

<img src="/images/placeholder.jpg" width="100">
</div>
<div class="">
<h6>Contact Information</h6>
<hr>
</div>
<form class="form p-3 form-profile" action="{{route('profile_step2')}}" method="post">
@csrf
<div class="row form-group">

<label class="col-lg-4"><span class="text-danger">*</span>Second Phone Number</label>


<input class="col-lg-8 form-control @error('phone') is-invalid @enderror" type="text" name="phone" placeholder="+234"  value="{{ old('phone') }}" autocomplete="phone" autofocus required>
						
                        @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>
<div class="row form-group">

<label class="col-lg-4"><span class="text-danger"></span>Address Line </label>

<textarea rows="4" class="form-control col-lg-8   @error('address') is-invalid @enderror" name="address" >{{ old('address') }}</textarea>
				
                        @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="row form-group">

<label class="col-lg-4"><span class="text-danger">*</span>city</label>


<input  class="col-lg-8 form-control @error('city') is-invalid @enderror" type="text" name="city"  value="{{ old('city') }}" autocomplete="city" autofocus required>
						
                        @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>





<div class="row form-group">

<label class="col-lg-4"><span class="text-danger">*</span>State</label>
<select  class="col-lg-8 form-control @error('state') is-invalid @enderror"  name="state" 
							autocomplete="state"autofocus  style="height:50px;">
						
					
							<option value="" selected="selected">- Select State-</option>
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

@error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="row form-group">
<button class="btn-success col-lg-8 offset-lg-4 p-2">Next</button>

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