

<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.head')

    </head>
    <body>
        <div class="container-scroller">
            <div id="loader-wrapper">
                <div id="loader"></div>
                {{-- <div class="custom-loader"></div> --}}
                <div class="loader-section section-left"></div>
                <div class="loader-section section-right"></div>
            </div>

            @include('layouts.sidebar')

            <div class="container-fluid page-body-wrapper">

                @include('layouts.navbar')

                <div class="main-panel">

                    @yield('content')

                <!-- content-wrapper ends -->
                </div>
                @include('layouts.footer')
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        @include('layouts.foot')
    </body>
</html>
