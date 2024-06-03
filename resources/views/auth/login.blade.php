<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Saja Siji">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin dashboard, admin dashboard laravel, admin panel template, blade template, blade template laravel, bootstrap template, dashboard laravel, laravel admin, laravel admin dashboard, laravel admin panel, laravel admin template, laravel bootstrap admin template, laravel bootstrap template, laravel template"/>

		<!-- Title -->
		<title> Saja Siji </title>

		<!-- Favicon -->
		{{-- <link rel="icon" href="assets/img/brand/favicon.png" type="image/x-icon"/> --}}

		<!-- Icons css -->
		<link href="{{ asset('assets/plugins/icons/icons.css') }}" rel="stylesheet">

		<!--  bootstrap css-->
		<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

		<!--  Right-sidemenu css -->
		<link href="{{ asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">


		<!-- P-scroll bar css-->
		<link href="{{ asset('assets/plugins/perfect-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

		<!--- Style css --->
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/style-dark.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/style-transparent.css') }}" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="{{ asset('assets/css/skin-modes.css') }}" rel="stylesheet" />

		<!--- Animations css-->
		<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">

		<!-- INTERNAL Switcher css -->
		<link href="{{ asset('assets/switcher/css/switcher.css') }}" rel="stylesheet"/>
		<link href="{{ asset('assets/switcher/demo.css') }}" rel="stylesheet"/>

    </head>
	<body class="ltr error-page1">

	    <div class="" style="background: #F8F4FF">
            <div class="square-box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="page" >
            <div class="page-single">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-45 justify-content-center">
                            <div class="card-sigin mt-5 mt-md-0">
                                <!-- Demo content-->
                                <div class="main-card-signin d-md-flex">
                                    <div class="wd-100p">
                                        {{-- <div class="d-flex mb-4"><a href="index.html">
                                            <img src="assets/img/brand/favicon.png" class="sign-favicon ht-40" alt="logo"></a>
                                        </div> --}}
                                        <div class="">
                                            <div class="main-signup-header">
                                                <h2 class="text-center" style="color: #FE7A36 !important">SAJA SIJI</h2>
                                                <div class="panel panel-primary">
                                                <div class="panel-body tabs-menu-body border-0 p-3">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab5">
                                                            <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login') }}">
                                                                @csrf
                                                                <div class="mt-4">
                                                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                                                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@company.com" required="">
                                                                    @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <span class="focus-input100" data-placeholder="Email"></span>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                                                    <input type="password" name="password" id="password" placeholder="••••••••" class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                                                        @error('password')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    <span class="focus-input100" data-placeholder="Password"></span>
                                                                </div>
                                                                <button type="submit" style="background-color: #FE7A36" class="btn w-100 py-8 mb-4 rounded-2 mt-4 text-white">Sign in</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    
            </div>
        </div>

		<!-- JQuery min js -->
		<script src="assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap js -->
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!-- Ionicons js -->
		<script src="assets/plugins/ionicons/ionicons.js"></script>

		<!-- Moment js -->
		<script src="assets/plugins/moment/moment.js"></script>

		<!-- eva-icons js -->
		<script src="assets/plugins/eva-icons/eva-icons.min.js"></script>

		<!-- generate-otp js -->
		<script src="assets/js/generate-otp.js"></script>

		<!--Internal  Perfect-scrollbar js -->
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

        
		<!-- generate-otp js -->
		<script src="assets/js/generate-otp.js"></script>

    
		<!-- THEME-COLOR JS -->
		<script src="assets/js/themecolor.js"></script>

		<!-- CUSTOM JS -->
		<script src="assets/js/custom.js"></script>

		<!-- exported JS -->
		<script src="assets/js/exported.js"></script>

		<!-- Switcher js -->
		<script src="assets/switcher/js/switcher.js"></script>

    </body>

</html>
