<div class="sticky">
    <aside class="app-sidebar">
        <div class="main-sidebar-header active overflow-hidden">
            <a class="header-logo active" href="index.html">
                {{-- <img src="{{ asset('assets/images/logos/jooal.jpg') }}" style="height: 150px; position: relative; top: -50;" alt="logo"> --}}
                {{-- <img src="{{ asset('assets/images/logos/jooal.jpg') }}" class="main-logo  desktop-dark" alt="logo">
                <img src="{{ asset('assets/images/logos/jooal.jpg') }}" class="main-logo  mobile-logo" alt="logo">
                <img src="{{ asset('assets/images/logos/jooal.jpg') }}" class="main-logo  mobile-dark" alt="logo"> --}}
            </a>
        </div>
        <div class="main-sidemenu" style="margin-top: 70px">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" /></svg></div>
            <ul class="side-menu">
                <li class="side-item side-item-category">Main</li>
                <li class="slide">
									<a class="side-menu__item" href="{{ route('dashboard') }}"><svg
                    xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z" />
                    </svg><span class="side-menu__label">Dashboard</span></a>
								</li>
                <li class="side-item side-item-category">WEB APPS</li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('absens.index') }}">
                        <span>
                            <i class="far fa-address-card"></i>
                        </span>
                        <span class="side-menu__label" style="margin-left: 13px !important">Absen</span>
                    </a>
                </li>
                @can('inventory')
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"/></svg><span class="side-menu__label">Inventory</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Inventory</a></li>
                        <li><a class="slide-item" href="{{ route('products.index') }}">List Stock</a></li>
                        <li><a class="slide-item" href="{{ route('stock-in-products.index') }}">Stock In</a></li>
                        <li><a class="slide-item" href="{{ route('stock-out-products.index') }}">Stock Out</a></li>
                    </ul>
                </li>
                @endcan
                @can('master-data')
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('master-data.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"> <path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z" /></svg>
                        <span class="side-menu__label">Master Data</span>
                    </a>
                </li>
                @endcan
                @can('report-penjualan')
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('report-penjualan') }}">
                        <span>
                            <i class="fa fa-clipboard"></i>
                        </span>
                        <span class="side-menu__label" style="margin-left: 15px !important">Report Penjualan</span>
                    </a>
                </li>
                @endcan
                {{-- <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('restaurants.index') }}">
                        <span>
                            <i class="fa fa-clipboard"></i>
                        </span>
                        <span class="side-menu__label" style="margin-left: 15px !important">Report Stock</span>
                    </a>
                </li> --}}
                @can('report-absen')
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('report-absensi') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M19.937 8.68c-.011-.032-.02-.063-.033-.094a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.99.99 0 0 0-.05-.258zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z"></path></svg>
                        <span class="side-menu__label">Report Absensi</span>
                    </a>
                </li>
                @endcan
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('shop.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="side-menu__label" style="margin-left: 15px !important">Shop</span>
                  </a>
                </li>
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" /></svg></div>
        </div>
    </aside>
</div>
