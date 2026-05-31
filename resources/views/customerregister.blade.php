<!DOCTYPE html>
<html lang="en">
<head>
	   <title>{{ config('app.name', 'Quickmann App') }} Customer Registration</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  @laravelPWA
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/images/bg-3.jpeg"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/css/util.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">
<!--===============================================================================================-->
</head>
<body>
		<div class="overlay">
	<div class="limiter">
	    
		<div class="container-login100">
		    
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="/images/bg-3.jpeg" alt="IMG" >
				</div>
		
				<form class="login100-form validate-form loginForm" action="{{route('register_customer.store')}}" method="POST">
                @csrf
					
	             <span class="login100-form-title">
					Customer Registration Portal
					</span>

<!--suucess msg-->
					@if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show text-white text-center " role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                    @endif
				<!--suucess msg end -->

					<div class="wrap-input100 validate-input" data-validate = "Valid phone number is required:+234">
				
						<input class="input100 form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" placeholder="Enter phone number (+234)"  value="{{ old('phone_number') }}" autocomplete="phone_number" >
						
                       
                        <span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-phone" aria-hidden="true"></i>
						</span>
						
					
					</div>
					
					<div class="">

           @error('phone_number')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
	     	@enderror
</div>


             		<div class="container-login100-form-btn">
						<button class="login100-form-btn ">
						Register
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Already 
						</span>
						<a class="txt2" href="/">
                        a Customer Login?
						</a>
					</div>

				
				</form>
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