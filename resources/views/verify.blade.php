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

				<form class="login100-form validate-form loginForm" action="{{route('register_customer.update',1)}}" method="POST">
                @csrf
                <input name="_method" type="hidden" value="PUT">

	<span class="login100-form-title">
				Enter 	Verification Code


                    </span>


        @php
        {{
            $phone = Session::get('phone');
        }}
        @endphp


        <label class="mb-3 text-white">We sent a code  to this number

        @if($phone != null)
       {{$phone}}
        @endif


</label>


					@if(session()->has('warning_msg'))
            <div class="alert alert-warning alert-dismissible fade show text-danger text-center " role="alert" style="color:yellow; font-size:10px;">
                {{ session()->get('warning_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>

            @else

        @endif


					<div class="wrap-input100 validate-input" data-validate = "otp code required">


                <input class="input100 form-control @error('phone_number') is-invalid @enderror" type="hidden" name="phone_number"  value="{{$phone}}" autocomplete="phone_number" >


						<input class="input100 form-control @error('otp') is-invalid @enderror" type="text" name="otp" placeholder="Enter Code"  value="{{ old('otp') }}" autocomplete="otp" >





					</div>
					<div class="">

@error('otp')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		@enderror
</div>


             		<div class="container-login100-form-btn">

						<button class="login100-form-btn ">
					Verify
						</button>
					</div>

                    <div class="card">
                        <label class="mb-3 text-white">You didn't get the otp_code? Chat with Quickmann Support centre Now. <a href="https://api.whatsapp.com/send?phone=+234 806 857 8321&text=I%20need%20my%20QuickMann%20Access%20Code."> CLICK HERE</a>
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
