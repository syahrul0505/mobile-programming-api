<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="icon" href="{{ asset('assets/images/logos/jooal.jpg') }}" type="image/x-icon"/>
<!-- ICONS CSS -->
<link href="{{ asset('assets/plugins/icons/icons.css') }}" rel="stylesheet">
<!-- BOOTSTRAP CSS -->
<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<!-- RIGHT-SIDEMENU CSS -->
<link href="{{ asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">
<!-- P-SCROLL BAR CSS -->
<link href="{{ asset('assets/plugins/perfect-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />
<!-- INTERNAL Select2 css -->
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

<!-- INTERNAL Data table css -->
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}"  rel="stylesheet">
<link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    
<!-- STYLES CSS -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/style-dark.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/style-transparent.css') }}" rel="stylesheet">

<!-- SKIN-MODES CSS -->
<link href="{{ asset('assets/css/skin-modes.css') }}" rel="stylesheet" />

<!-- ANIMATION CSS -->
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">

<!-- SWITCHER CSS -->
<link href="{{ asset('assets/switcher/css/switcher.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/switcher/demo.css') }}" rel="stylesheet"/>

{{-- Juery Confirm --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" integrity="sha512-0V10q+b1Iumz67sVDL8LPFZEEavo6H/nBSyghr7mm9JEQkOAm91HNoZQRvQdjennBb/oEuW+8oZHVpIKq+d25g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Toastify --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

{{-- DataTable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

{{-- Select 2 --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
{{-- Date Picker --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

    <title>Jooal </title>
</head>

<body>
    <div id="main-wrapper">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-12">
                        <h2 class="text-center">Jooal</h2>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xxl-3">
                        <div class="card mb-0" style="border-radius: 20px;">
                            <div class="card-body px-4 py-1" style="border-radius: 20px;">
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
									<button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2 mt-4">Sign in</button>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <!-- JQUERY JS -->
{{-- <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- BOOTSTRAP JS -->
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- MOMENT JS -->
<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>

<!-- STICKY JS -->
<script src="{{ asset('assets/js/sticky.js') }}"></script>

<!-- Chart-circle js -->
<script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script>

<!-- Internal Chart.Bundle js-->
<script src="{{ asset('assets/plugins/chartjs/Chart.bundle.min.js') }}"></script>

<!-- Moment js -->
<script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>

<!-- INTERNAL Apexchart js -->
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>

<!--Internal Sparkline js -->
<script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

<!--Internal  index js -->
<script src="{{ asset('assets/js/index.js') }}"></script>

<!-- Chart-circle js -->
<script src="{{ asset('assets/js/chart-circle.js') }}"></script>

<!-- Internal Data tables -->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/table-data.js') }}"></script>

<!-- INTERNAL Select2 js -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>

<!-- EVA-ICONS JS -->
<script src="{{ asset('assets/plugins/eva-icons/eva-icons.min.js') }}"></script>

<!-- THEME-COLOR JS -->
<script src="{{ asset('assets/js/themecolor.js') }}"></script>

<!-- CUSTOM JS -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- exported JS -->
<script src="{{ asset('assets/js/exported.js') }}"></script>

<!-- Jquery Confirm -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Toastify --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


</body>

</html>
