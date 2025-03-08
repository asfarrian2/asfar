<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Non ASN Balatkop</title>
    <meta name="description" content="Pastikan Data Biodata/Profil Diri dan Input Data SK (Surat Keputusan) dengan Benar">
    <meta name="keywords" content="Data NON-ASN Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel" />

	<!-- PAGE TITLE HERE -->
	<title>E-Dompet 2025</title>

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <link href="./css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="index.html"><img src="{{asset ('images/logo-login-2.png') }}" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4">Selamat Datang</h4>
                                    <!-- Begin Alret -->
                                    @csrf
                                    @php
                                    $messagewarning = Session::get('warning');
                                    @endphp
                                    @if (Session::get('warning'))
                                    <div class="col-xl-12">
                                        <div class="alert alert-danger left-icon-big alert-dismissible fade show">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                                            </button>
                                            <div class="media">
                                                <div class="alert-left-icon-big">
                                                    <span><i class="mdi mdi-alert"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mt-1 mb-2">Login Gagal !</h5>
                                                    <p class="mb-0">{{ $messagewarning }}.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Alret -->
                                    @endif
                                    <form action="/opt_login"  method="post">
                                    @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Username</strong></label>
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tahun :</label>
                                            <select class="default-select  form-control wide mt-3" name="tahun" >
                                            <option value="">Pilih Tahun</option>
                                            @for ($tahun = date('Y'); $tahun >= date('Y') - 0; $tahun--)
                                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                                            @endfor
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info btn-block">LOGIN</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/custom.min.js"></script>
    <script src="./js/dlabnav-init.js"></script>

</body>
</html>
