<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Title -->
<title> SAJA SIJI </title>

<!-- FAVICON -->
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

{{-- date picker --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Select 2 --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
{{-- Date Picker --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
<style>
  .popup-badge {
    width: 18px;
    height: 18px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 13px;
    right: 6px;
}
/* Demo Styles */
.bg-cs-blue{
  background-color: #78797a;
}
.bg-card-abu{
  background-color: #04576e !important;
}
/* .bg-card-foot{
  background-color: #04576e;
} */
.bg-card-blue {
    background-color: #14838d !important;
}
.bg-card-orange {
    background-color: #ED7D31 !important;
}
.paginate_button{
  margin-top: -5px !important;
}

.buttons-excel{
    background-color: #51f55e !important;
    color: white;
  }
  .buttons-pdf{
    background-color: red !important;
    color: white;
  }
#content {
  margin: 0 auto;
  padding-bottom: 50px;
  width: 80%;
  max-width: 978px;
}

h1 {
  font-size: 40px;
}

.rounded-20{
    border-radius: 20px !important;
}
.rounded-t-20{
    border-radius: 20px 20px 0 0 !important;
}
.rounded-b-20{
    border-radius:0 0 20px 20px !important;
}
.bg-gray-800{
    background: #0d0f14 !important;
  }
/* The Loader */

#loader-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 10;
  overflow: hidden;

  // Modernizr no-js fallback
  .no-js & {
    display: none;
  }
}


#loader {
z-index: 50;
  display: block;
  position: relative;
  left: 50%;
  top: 50%;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: #16a085;
  animation: spin 1.7s linear infinite;

  &:before {
    content: "";
    position: absolute;
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 5px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #e74c3c;
    animation: spin-reverse .6s linear infinite;
  }

  &:after {
    content: "";
    position: absolute;
    top: 15px;
    left: 15px;
    right: 15px;
    bottom: 15px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #f9c922;
    animation: spin 1s linear infinite;
  }
}

#loader-wrapper .loader-section {
  position: fixed;
  top: 0;
  width: 51%;
  height: 100%;
  background: #222;
  z-index: 10;
}

#loader-wrapper .loader-section.section-left {
  left: 0;
}

#loader-wrapper .loader-section.section-right {
  right: 0;
}

/* Loaded styles */

.loaded #loader-wrapper .loader-section.section-left {
  transform: translateX(-100%);
  transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
}

.loaded #loader-wrapper .loader-section.section-right {
  transform: translateX(100%);
  transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
}

.loaded #loader {
  opacity: 0;
  transition: all 0.3s ease-out;
}

.loaded #loader-wrapper {
  visibility: hidden;
  transform: translateY(-100%);
  transition: all 0.3s 1s ease-out;
}

.nav-pills .nav-link.active.custom, .nav-pills .show>.nav-link{
    background: transparent !important;
}

.nav-pills .nav-link.custom{
    color: white;
    background: #1b9abc !important;
    border: 1px solid #1b9abc !important;
    border-radius: 0 !important;
}
</style>
@yield('style')

