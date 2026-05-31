<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

   <!-- Template Main CSS File -->
   <link href="{{asset ('assets/css/style.css')}}" rel="stylesheet">
   <title>{{ config('app.name', 'Quickmann App') }}</title>
   @laravelPWA

 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CSRF Token -->
 <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{asset ('assets/img/logo.jpeg')}}" rel="icon">
  <link href="{{asset ('assets/img/logo.jpeg')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset ('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset ('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset ('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset ('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset ('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset ('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset ('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">



<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<!-- Fonts -->
<link rel="shortcut icon" href="/images/bg-3.jpeg">
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css " rel="stylesheet/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Bootstrap 4.5 CSS-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="/css/customer.css">


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="{{asset ('assets/img/logo.jpeg')}}" alt="" width="28px" height="40px">
        {{-- <span class="d-none d-lg-block">QuickMann</span> --}}
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">0</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 0 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>

            </ul>
            <!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">0</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 0 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            {{-- <img src="{{asset ('assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle"> --}}
            <img src="/images/{{Auth::user()->customerprofile->profile_photo}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"> {{strtoupper(Auth::user()->customerprofile->surname)}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{strtoupper(Auth::user()->customerprofile->first_name)}} {{strtoupper(Auth::user()->customerprofile->othername)}}</h6>
              <span>{{strtoupper(Auth::user()->customerprofile->city)}}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/customerprofile">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/customerprofile/create">
                <i class="bi bi-key"></i>
                <span>Change Password</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="https://wa.me/+2348035714001">
                <i class="bi bi-question-circle"></i>
                <span>Need Help? Chat Now!</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link "  href="/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard </span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">


      <li class="nav-heading">Profile Menu</li>
         <li class="nav-item">
        <a class="nav-link collapsed" href="/appointments">
          <i class="bi bi-calendar"></i>
          <span>Appointments</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/shelterproduct">
          <i class="bi bi-stack"></i>
          <span>Check Products</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/pay">
          <i class="bi bi-bank"></i>
          <span>Payment History</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/findproperty">
          <i class="bi bi-search"></i>
          <span>Search Products</span>
        </a>
      </li><!-- End Contact Page Nav -->
      
       <li class="nav-item">
        <a class="nav-link collapsed" href="/internal-transfer">
          <i class="bi bi-currency-dollar"></i>
          <span>Transfer</span>
        </a>
      </li>
      
      
       <li class="nav-item">
        <a class="nav-link collapsed" href="/transaction-history">
          <i class="bi bi-piggy-bank"></i>
          <span>Transaction History</span>
        </a>
      </li>
        
       <li class="nav-item">
        <a class="nav-link collapsed" href="/investment-history">
          <i class="bi bi-cash"></i>
          <span>Investment History</span>
        </a>
      </li>
      

      {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav --> --}}

      <li class="nav-item">
        <a class="nav-link collapsed" href="/logout">
          <i class="bi bi-power"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->


  <main class="py-4">
    @yield('content')
    
</main>

<!--<script  type="text/javascript">  var config = {    phone :" 2348060320082",    call :"Need Help?",    position :"ww-right",    size : "ww-normal",    text : "Hi, I need help with my QuickMann account.",    type: "ww-standard",    brand: "QuickMann",    subtitle: "",    welcome: ""  };  var proto = document.location.protocol, host = "cloudfront.net", url = proto + "//d3kzab8jj16n2f." + host;    var s = document.createElement("script"); s.type = "text/javascript"; s.async = true; s.src = url + "/v2/main.js";    s.onload = function () { tmWidgetInit(config) };    var x = document.getElementsByTagName("script")[0]; x.parentNode.insertBefore(s, x);</script>-->

@include('includes.footer')

@yield('js')


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset ('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset ('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset ('assets/vendor/chart.js/chart.min.js')}}"></script>
  <script src="{{asset ('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset ('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset ('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset ('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset ('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset ('assets/js/main.js')}}"></script>

  <script src="https://apps.elfsight.com/p/platform.js" defer></script>
<div class="elfsight-app-c0a7800a-6bfb-4669-9621-c7a3ff05c980"></div>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6545caa8a84dd54dc48863f1/1hec9v8nk';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</body>

</html>
