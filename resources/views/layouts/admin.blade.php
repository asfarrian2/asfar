<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Dompet : Payment Admin Template" />
	<meta property="og:title" content="Dompet : Payment Admin Template" />
	<meta property="og:description" content="Dompet : Payment Admin Template" />
	<meta property="og:image" content="https://dompet.dexignlab.com/xhtml/social-image.png" />
	<meta name="format-detection" content="telephone=no">

	<!-- PAGE TITLE HERE -->
	<title>SI-PREDRA 2025</title>

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
		   <span style="--i:1">L</span>
		   <span style="--i:2">o</span>
		   <span style="--i:3">a</span>
		   <span style="--i:4">d</span>
		   <span style="--i:5">i</span>
		   <span style="--i:6">n</span>
		   <span style="--i:7">g</span>
		   <span style="--i:8">.</span>
		   <span style="--i:9">.</span>
		   <span style="--i:10">.</span>
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
            <a href="/" class="brand-logo">
                <img src="{{asset ('./images/logo-utama.png') }}">
                <img src="{{asset ('./images/logo-text-2.png') }}" class="brand-title" width="124px" height="33px">
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
							<img src="{{ asset('images/profile/avatar.png') }}" width="20" alt=""/>
							<div class="header-info ms-3">
								<span class="font-w600 ">ADMIN BAPENDA</span>
								<small class="text-start font-w400">Prov. Kalimantan Selatan</small>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a href="./email-inbox.html" class="dropdown-item ai-icon">
								<svg id="icon-keys" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
								<span class="ms-2">Ganti Password </span>
							</a>
							<a href="/logout" class="dropdown-item ai-icon">
								<svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
								<span class="ms-2">Logout </span>
							</a>
						</div>
					</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-025-dashboard"></i>
							<span class="nav-text">Dashboard</span>
						</a>
                        <ul aria-expanded="false">
							<li><a href="/admin/dashboardAll">All</a></li>
							<li><a href="index-2.html">Target</a></li>
							<li><a href="my-wallet.html">Pendapatan</a></li>
							<li><a href="/admin/skpd">SKPD/UPTD</a></li>
						</ul>
                    </li>
                    <li><a href="widget-basic.html" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-calculator"></i>
							<span class="nav-text">Monitoring</span>
						</a>
					</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-043-menu"></i>
							<span class="nav-text">Master Data</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="/admin/jenisretribusi">Jenis Retribusi</a></li>
                            <li><a href="/admin/subretribusi">Sub Retribusi</a></li>
                            <li><a href="/admin/objekretribusi">Objek Retribusi</a></li>
                            <li><a href="table-datatable-basic.html">Konfigurasi</a></li>
                        </ul>
                    </li>
                    <li><a href="/admin/agency" class="ai-icon" aria-expanded="false">
							<i class="flaticon-093-waving"></i>
							<span class="nav-text">SKPD/UPTD</span>
						</a>
					</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-user-8"></i>
							<span class="nav-text">Akun</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="/admin/operator">Operator</a></li>
							<li><a href="./post-details.html">User</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-072-printer"></i>
							<span class="nav-text">Laporan</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="./form-element.html">Semua</a></li>
                            <li><a href="./form-wizard.html">SKPD/UPTD</a></li>
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

</body>
</html>
