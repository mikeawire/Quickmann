<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  @laravelPWA
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor2/bootstrap/css/bootstrap.min.css">
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



<!-- Fonts -->



</head>
<body>
		   <div class="overlay">
	<div class="limiter">
	    
		<div class="container-login100">
		     
		<div class="search-btn-container"  >
	<a href="/findproperty"><button class="login100-form-btn " type="button">Find   Shelter</button></a>
	<!--<button class="login100-form-btn login-btn" type="button">Login</button>-->
	</div>
			<div class="wrap-login100">

		
		
				<div class="login100-pic ">
				
			<div class="search-btn-container-mobile text-center"  >
			<button class="login100-form-btn login-btn " type="button">Login</button>
		
	<button class="login100-form-btn property-btn " style="font-size"16px; type="button">Find Shelter</button>
	</div>
					<img src="images/bg-3.jpeg" alt="IMG" class="js-tilt" data-tilt >
					<br>
					<div class="text-center p-t-125 customer_login">
						<a class="txt2 btn-dark btn-lg"  href="{{ route('register_customer.create') }}">
						Customer Registration
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</div>

				<form class="login100-form " method="POST" action="{{ route('login') }}" id="login-form">
                        @csrf
					<span class="login100-form-title">
						General Login
					</span>
					<div class="text-center p-b-125 d-lg-none">
						<a class="txt2 btn-dark btn-lg"  href="{{ route('register_customer.create') }}">
						Customer Registration
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Valid username is required: ">
						<input class="input100 form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="username"  value="{{ old('username') }}" autocomplete="username" autofocus>
						
                        @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input  type="password" placeholder="Password" class="input100 form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							 Password?
						</a>
					</div>

			

					<div class="text-center p-t-60">
						<a class="txt2 btn-info btn-lg  "  href="{{ route('register') }}">
						Staff Registration
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>

				<!---kkkk--->
				
				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}" id="property_search">
                        @csrf
					<span class="login100-form-title">
						
					
					Quickmann <br> <i class="fa fa-calculator "  ></i> 
					</span>

					<label class="text-white"><span class="text-danger">Step 1: </span>Select State</label>
					<div class="wrap-input100 validate-input" data-validate = "Select State">
						<select  class="input100 form-control @error('mode_of_payment') is-invalid @enderror"  name="mode_of_payment" 
							autocomplete="mode_of_payment"autofocus  style="height:50px;">
						
					
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
                        @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-tag" aria-hidden="true"></i>
						</span>
					</div>

				

					<label class="text-white"><span class="text-danger">Step 2: </span>Select Price  Range</label>
					<div class="wrap-input100 validate-input" data-validate = "Select price range">

						<select  class="input100 form-control @error('price_range') is-invalid @enderror"  name="price_range" 
							autocomplete="mode_of_payment"autofocus style="height:50px;" >
							<option  value="{{ old('price_range') }}">Select Price Range</option>
							<option value="a"> &#8358;500,000  - &#8358;1,000,000 </option>
							<option value="b">&#8358;500,000  - &#8358;1,000,000 </option>
</select>
                        @error('price_range')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-credit-card" aria-hidden="true"></i>
						</span>
					</div>		
					<label class="text-white"><span class="text-danger">Step 3: </span>Select Mode of Payment</label>
					<div class="wrap-input100 validate-input" data-validate = "Select mode of payment">
						<select  class="input100 form-control @error('mode_of_payment') is-invalid @enderror"  name="mode_of_payment" 
							autocomplete="mode_of_payment"autofocus style="height:50px;" >
							<option  value="{{ old('mode_of_payment') }}">Mode of payment</option>
							<option value="outright">Outright Payment</option>
							<option value="installation">Installation</option>
</select>
                        @error('mode_of_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-credit-card" aria-hidden="true"></i>
						</span>
					</div>

					<label class="text-white"><span class="text-danger">Step 4: </span>Enter Monthly payment</label>
					<div class="wrap-input100 validate-input" data-validate = "Monthly Installation required:eg. (&#8358; 200,000)">
						<input  type="text" placeholder="&#8358;100,000" class="input100 form-control @error('installation') is-invalid @enderror" name="installation"  autocomplete="installation">
                        @error('installation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-money" aria-hidden="true"></i>
						</span>
					</div>
					<label class="text-white"><span class="text-danger">Step 5: </span>Enter Initial Payment</label>
					<div class="wrap-input100 validate-input" data-validate = "Initial Payment required: eg. (&#8358; 200,000)">
						<input  type="text" placeholder="&#8358;300,000" class="input100 form-control @error('initial_payment') is-invalid @enderror" name="initial_payment"  autocomplete="initial_payment">
                        @error('initial_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-money" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Search
						</button>
					</div>

				</form>
			</div>
		</div>
		<section class="footer">
	<div class="container">
	<p>&copy; Copyright Quick Access 2020 Alright Reserved</p>
	</div>
	
	</section>
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