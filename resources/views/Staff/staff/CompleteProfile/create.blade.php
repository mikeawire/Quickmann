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
<h4 class="text-center">Pofile Completion  <span class="text-info">[Step 1]</span></h4>
</div>
<div class="text-right">

<img src="/images/placeholder.jpg" width="100">
</div>
<div class="">
<h6>Personal Information</h6>
<hr>
</div>
<form class="form p-3" action="{{route('profile_step1')}}" method="post">
@csrf
<div class="row form-group">

<label class="col-lg-4"><span class="text-danger">*</span>Surname</label>


<input class="col-lg-8 form-control @error('surname') is-invalid @enderror" type="text" name="surname"  value="{{ old('surname') }}" autocomplete="surname" autofocus>
						
                        @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>


<div class="row form-group">

<label class="col-lg-4"><span class="text-danger">*</span>First Name</label>


<input class="col-lg-8 form-control @error('first_name') is-invalid @enderror" type="text" name="first_name"  value="{{ old('first_name') }}" autocomplete="first_name" autofocus>
						
                        @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="row form-group">

<label class="col-lg-4"><span class="text-danger"></span>Other Name</label>
<input class="form-control col-lg-8" name="othername">
</div>

<div class="row form-group">

<label class="col-lg-4"><span class="text-danger"></span>Marital Status</label>

<select class="form-control col-lg-8   @error('marital_status') is-invalid @enderror" name="marital_status">
<option value="{{ old('marital_status') }}">{{ old('marital_status') }}</option>
<option value="single">Single</option>
<option value="married">Married</option>
<option value="others">others</option>
</select>
				
                        @error('marital_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
</div>

<div class="row form-group">

<label class="col-lg-4"><span class="text-danger">*</span>Gender</label>
<select name="gender" class="form-control col-lg-8  @error('gender') is-invalid @enderror">
<option value="{{ old('gender') }}">{{ old('gender') }}</option>
<option value="male">Male</option>
<option value="female">Female</option>
<option value="complicated">Complicated</option>
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