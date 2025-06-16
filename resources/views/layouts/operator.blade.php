<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="SI-RETDA" />
	<meta name="author" content="Badan Pendapatan Daerah Provinsi Kalimantan Selatan" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="SI-RETDA" />
	<meta property="og:title" content="Sistem Informasi Pendapatan Retribusi Daerah Provinsi Kalimantan Selatan" />
	<meta property="og:description" content="Sistem Informasi Pendapatan Retribusi Daerah Provinsi Kalimantan Selatan" />
    <meta property="og:image" content="{{ url('/images/profile/cover website.png') }}" />
	<meta name="format-detection" content="telephone=no">

	<!-- PAGE TITLE HERE -->
	<title>SI-RETDA KALSEL {{ Auth::guard('operator')->user()->id_tahun }}</title>

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('images/profile/Default Picture Profile.png') }}" />

	<link href="{{ asset('vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('vendor/nouislider/nouislider.min.css') }}">
     <!-- Datatable -->
     <link href="{{ asset ('./vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
     <!-- Sweat Alert -->
     <link href="{{ asset ('./vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
	<!-- Style css -->
    <link href="{{ asset ('./vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="waviy">
		   <span style="--i:1">S</span>
		   <span style="--i:2">I</span>
		   <span style="--i:3">-</span>
		   <span style="--i:4">R</span>
		   <span style="--i:5">E</span>
		   <span style="--i:6">T</span>
		   <span style="--i:7">D</span>
		   <span style="--i:8">A</span>
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="/opt/dashboard" class="brand-logo">
                <img src="{{asset ('./images/logo-utama.png') }}">
                <img src="{{asset ('./images/logo-text-3.png') }}" class="brand-title" width="124px" height="33px">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        @yield('header')

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="dlabnav">
            <div class="dlabnav-scroll">
				<ul class="metismenu" id="menu">
					<li class="dropdown header-profile">
						<a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
							<img src="{{ asset('images/profile/opt.png') }}" width="20" alt=""/>
							<div class="header-info ms-3">
								<span class="font-w600 ">Operator {{ Auth::guard('operator')->user()->nama_opt }}</span>
								<small class="text-start font-w400">Prov. Kalimantan Selatan</small>
                                <small class="text-start font-w400">T.A. {{ Auth::guard('operator')->user()->id_tahun }}</small>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a href="./email-inbox.html" class="dropdown-item ai-icon">
                            <i class="fa fa-key" style="font-size: 20px; color:darkslateblue;"> </i><span class="ms-0">Ganti Password </span>
							</a>
							<a href="/logout" class="dropdown-item ai-icon">
                            <i class="fa fa-sign-out" style="font-size: 20px; color:red;"> </i><span class="ms-0">Logout </span>
							</a>
						</div>
					</li>
                    <li><a href="/opt/dashboard" class="ai-icon" aria-expanded="false">
							<i class="flaticon-025-dashboard"></i>
							<span class="nav-text">Dashboard</span>
						</a>
					</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-055-minimize"></i>
							<span class="nav-text">Target</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="/opt/targetapbd">APBD</a></li>
                            <li><a href="/opt/targetapbdp">APBD Perubahan</a></li>
                            <li><a href="./form-wizard.html">RPJMD</a></li>
                        </ul>
                    </li>
                    <li><a href="/opt/realisasi" aria-expanded="false" @if(Request::is('opt/realisasi*')) style="background-color: #eefaf9;" @endif>
							<i class="flaticon-041-graph" @if(Request::is('opt/realisasi*')) style="color: #5bcfc5;" @endif></i>
							<span class="nav-text" @if(Request::is('opt/realisasi*')) style="color: #5bcfc5;" @endif>Realisasi</span>
						</a>
                    </li>
                    <li><a href="/opt/evaluasi" aria-expanded="false" @if(Request::is('opt/evaluasi*')) style="background-color: #eefaf9;" @endif>
							<i class="flaticon-017-clipboard" @if(Request::is('opt/evaluasi*')) style="color: #5bcfc5;" @endif></i>
							<span class="nav-text" @if(Request::is('opt/evaluasi*')) style="color: #5bcfc5;" @endif>Evaluasi</span>
						</a>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-072-printer"></i>
							<span class="nav-text">Laporan</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="/opt/laporan/realisasi">Realisasi</a></li>
                            <li><a href="/opt/laporan/evaluasi">Evaluasi</a></li>
                        </ul>
                    </li>
                </ul>
				<div class="copyright">
					<p><strong>Dashboard Informasi Pendapatan Daerah<br>Provinsi Kalimantan Selatan</strong> © 2025 BAPENDA Prov. Kalsel</p>
				</div>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
        @yield('content')


        <!--**********************************
            Footer start
        ***********************************-->

        <div class="footer">

            <div class="copyright">
                <p>Copyright Asfar © Designed &amp; Developed by <a href="https://dexignlab.com/" target="_blank">Badan Pendapatan Daerah Provinsi Kalimantan Selatan</a> 2025</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->




	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('./vendor/global/global.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('myscript')
	<script src="{{ asset('./vendor/chart.js/Chart.bundle.min.js') }}"></script>
	<script src="{{ asset('./vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>

    <script src="{{ asset('./js/custom.min.js') }}"></script>
	<script src="{{ asset('./js/dlabnav-init.js') }}"></script>
    <script src="{{ asset('./vendor/uang/jquery.mask.min.js') }}"></script>

</body>
</html>
