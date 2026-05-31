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
<h4 class="text-center">Pofile Completion  <span class="text-info">[Step 3]</span></h4>
</div>

<h6>Profile Photo</h6>
<hr>
</div>
<form class="form p-3 form-profile" action="{{route('profile_step3')}}" method="post"  enctype="multipart/form-data"> 
@csrf
<div class="row form-group">

<label class="col-lg-12 text-center"><img src="/images/placeholder.jpg" width="100"></label>

</div>

<div class="form-group d-flex text-center offset-lg-3">
    
<div class="">
<input class=" form-control @error('profile_photo') is-invalid @enderror" type="file" name="profile_photo" >
@error('profile_photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror	
                      

</div>




<button class="btn-success  p-2 ml-2">Upload</button>

</div>

    </form>  
    
    
    <form class="form p-3 form-profile" action="{{route('profile_step3')}}" method="post"  enctype="multipart/form-data"> 
@csrf

<div class="text-center">
    <input type="hidden" name="skip">
<button class="btn btn-secondary btn-sm  ">Skip</button>

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