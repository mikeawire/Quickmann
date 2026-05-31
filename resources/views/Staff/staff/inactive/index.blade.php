<!DOCTYPE html>
<html lang="en">
<head>
	<title>Account Inactive</title>
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
	    
		<div class="">
		    
			<div class="bg-light opacity-1 col-lg-8 offset-lg-2 lg-vh-100  p-3" style="min-height:100vh;">
	<div class="">			
<div class="mb-3">
<h4 class="text-center"> <span class="text-info"></span></h4>
</div>
<div class="text-center">
    
  <p class="text-success">Customer ID</p>
  <p  class="text-warning">[{{Auth::user()->staffprofile->reg_no}}]</p>  
    
</div>
<div class="text-center p-5">

<img src="/images/placeholder.jpg" width="200">
</div>
<div class="text-center p-5">
<h3>Welcome: <i class="text-success">{{Auth::user()->staffprofile->surname}} {{Auth::user()->staffprofile->first_name}} {{Auth::user()->staffprofile->othername}}</i>  </h3>
<br>
<p>(
 @if(Auth::user()->staffprofile->role =='MD')   

Managing Director ({{ucwords(Auth::user()->staffprofile->role)}})
@elseif(Auth::user()->staffprofile->role =='COO')   

Chief Operation Officer ({{ucwords(Auth::user()->staffprofile->role)}})

@elseif(Auth::user()->staffprofile->role =='CFO')   

Chief Financial Officer ({{ucwords(Auth::user()->staffprofile->role)}})
@elseif(Auth::user()->staffprofile->role =='HDBM')   

Head Business Development Manager ({{ucwords(Auth::user()->staffprofile->role)}})
@elseif(Auth::user()->staffprofile->role =='BDM')   

Business Development Manager ({{ucwords(Auth::user()->staffprofile->role)}})

@elseif(Auth::user()->staffprofile->role =='DRO')   

Direct Relationship Officer ({{ucwords(Auth::user()->staffprofile->role)}})
@elseif(Auth::user()->staffprofile->role =='BDO')   

Business Development Officer  ({{ucwords(Auth::user()->staffprofile->role)}})

@elseif(Auth::user()->staffprofile->role =='PM')   

Portfolio Manager ({{ucwords(Auth::user()->staffprofile->role)}})


@elseif(Auth::user()->staffprofile->role =='TSO')   

Technical Support Officer ({{ucwords(Auth::user()->staffprofile->role)}})

@elseif(Auth::user()->staffprofile->role =='SO')   

Site Officer ({{ucwords(Auth::user()->staffprofile->role)}})

@elseif(Auth::user()->staffprofile->role =='CMO')   

Customer Management Officer ({{ucwords(Auth::user()->staffprofile->role)}})

@elseif(Auth::user()->staffprofile->role =='HRM')   

Human Relation Manager ({{ucwords(Auth::user()->staffprofile->role)}})




@endif)</p>



</div>

<div class="text-center p-5">
<h2 class="text-danger">Your Account 
 is Yet to be approve </h2>
<br>
<h6>Contact Human Resources Manager or the Managing Director For Final Approval</h6>

<div class="text-center p-3">
    
          <a class="text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    
 
</div>


</div>
</div>
        
              
       
        






				

					
			</div>
		</div>
	</div>
		</div>
	

	
<!--===============================================================================================-->	
	<script src="/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor/bootstrap/js/popper.js"></script>
	<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		});
	</script>
<!--===============================================================================================-->
	<script src="/js/main.js"></script>

</body>
</html>