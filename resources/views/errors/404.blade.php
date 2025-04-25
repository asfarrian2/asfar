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
	<title>SI-RETDA KALSEL</title>

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

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-7">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text fw-bold">404</h1>
                        <h4><i class="fa fa-exclamation-triangle text-warning"></i> Halaman Tidak Ditemukan !</h4>
                        <p>Anda mungkin salah mengetik alamat, atau halaman ini mungkin telah dipindahkan.</p>
						<div>
                            <a class="btn btn-primary" href="javascript:history.back()">
                            Back to Previous Page</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

</body>
</html>
