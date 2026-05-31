<!DOCTYPE html>
<html lang="en">
<head>
	   <title>{{ config('app.name', 'Quickmann App') }} Staff Registration</title>
	       @laravelPWA
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/bg-3.jpeg"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
		<div class="overlay">
	<div class="limiter">
	    
		<div class="container-login100">
		    
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/bg-3.jpeg" alt="IMG" >
				</div>
		
				<form class="login100-form validate-form" method="POST" action="{{ route('registerstaff') }}">
                        @csrf
				
	<span class="login100-form-title">
					Staff Registration


					</span>


					@if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show text-white text-center " role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
				

					<div class="wrap-input100 validate-input" data-validate = "Valid name is required">
				
						<input class="input100 form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="Username"  value="{{ old('username') }}" autocomplete="name" autofocus>
						
                       
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
						
					
					</div>
					<div class="">

@error('username')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		@enderror
</div>


					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100 form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email"  value="{{ old('email') }}" autocomplete="email" autofocus>
						
                    
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					
					
					</div>
					<div class="">
						@error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

						</div>
					<div class="wrap-input100 validate-input" data-validate = "Select Position">
						<select  class="input100 form-control @error('position') is-invalid @enderror"  name="position" 
							autocomplete="position"autofocus  style="height:50px;">
						
					
							<option value="" selected="selected">- Select Position-</option>
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
                   <option value="HOR">Head of Recovery </option>
                   <option value="AO">Account Officer</option>
            
</select>
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-tag" aria-hidden="true"></i>
						</span>
					
                    
					</div>
					<div class="">
						@error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
						</div>
                    <div class="wrap-input100 validate-input" data-validate = "Valid Access Code is required">
						<input class="input100 form-control @error('access_code') is-invalid @enderror" type="text" name="access_code" placeholder="Access Code"  value="{{ old('access_code') }}" autocomplete="access_code" autofocus>
						
                       
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-key" aria-hidden="true"></i>
						</span>
					
					</div>
					<div class="">

@error('access_code')
			<span class="invalid-feedback" role="alert">
				<strong >{{ $message }}</strong>
			</span>
		@enderror
</div>

                    <div class="wrap-input100 validate-input" data-validate = "Confirmed Password is required">
					 <input id="access_code_confirm" type="text" class="form-control input100 " name="access_code_confirmation"  placeholder="Confirm Access Code" autocomplete="new-access_code">
                          
			
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-key" aria-hidden="true"></i>
						</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input  type="password" placeholder="Password" class="input100 form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                     
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					
					
					</div>
					<div class="">
						@error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

						</div>
					

					<div class="wrap-input100 validate-input" data-validate = "Confirmed Password is required">
					 <input id="password-confirm" type="password" class="form-control input100 " name="password_confirmation"  placeholder="Confirm Password" autocomplete="new-password">
                          
			
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
             		<div class="container-login100-form-btn">
						<button class="login100-form-btn">
						Register
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Already 
						</span>
						<a class="txt2" href="/">
                        a Staff Login?
						</a>
					</div>

				
				</form>
			</div>
		</div>
	</div>
		</div>
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		});
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>