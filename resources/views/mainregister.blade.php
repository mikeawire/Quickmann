<!DOCTYPE html>
<html lang="en">
<head>
	<title>Customer Registration</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  @laravelPWA
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
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
		
				<form class="login100-form validate-form loginForm" action="{{route('register')}}" method="POST">
                @csrf
                @php   
                {{
            $user_id = Session::get('user_id');
            $user=DB::table('users')->find($user_id);

            $customers =DB::table('customer_profiles')->where('user_id',$user_id)->get();

        }}
        @endphp

	<span class="login100-form-title">
				Create Username and Password

                <p class="text-white p-t-30"> 
                    if you are      
@foreach($customers as $customer)
        <i>{{ucfirst($customer->surname)}}   {{ucfirst($customer->first_name)}}   {{ucwords($customer->othername)}}</i>

        @endforeach
    </p>

					</span>

                 
     
 

					@if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show text-white text-center " role="alert">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
      
					<div class="wrap-input100 validate-input" data-validate = "Username is required">
				
						<input class="input100 form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="username"  value="{{ old('username') }}" autocomplete="username" >
						
                       
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
						<button class="login100-form-btn ">
					Create
						</button>
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