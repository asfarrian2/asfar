<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SI-Predra">
    <meta name="author" content="Bapenda Provinsi Kalimantan Selatan">

	<!-- PAGE TITLE HERE -->
	<title>SI-PREDRA</title>

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/profile/Default Picture Profile.png') }}" />

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- tabler icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="./css/page-auth.css" rel="stylesheet">

</head>

<body>
    <div class="page-wrapper">
        <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="card auth-card mx-3 mb-0">
                    <div class="card-body">
                        {{-- logo --}}
                        <a href="{{ route('login') }}" class="text-nowrap text-center d-block py-3 w-100 mb-2">
                            <img src="{{asset ('images/logo-login-2.png') }}" alt="Logo" width="200px">
                        </a>

                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                            <i class="ti ti-circle-x align-self-start fs-5 me-2"></i>
                            <div>
                                <strong>Gagal!</strong> Username atau Password salah. Cek kembali Username dan Password Anda.
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        {{-- form login --}}
                        <form action="/opt_login" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off">
                                <label>
                                    <i class="ti ti-user"></i>
                                    <span class="border-start ps-3">Username</span>
                                </label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                                <label>
                                    <i class="ti ti-lock"></i>
                                    <span class="border-start ps-3">Password</span>
                                </label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="" id="" class="form-control">
                                   <option class="border-start " value="">Pilih Tahun</option>
                                    @for ($tahun = date('Y'); $tahun >= date('Y') - 0; $tahun--)
                                    <option class="border-start ps-3" value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endfor
                                </select>
                                <label>
                                    <i class="ti ti-calendar"></i>
                                    <span class="border-start ps-3">Password</span>
                                </label>
                            </div>

                            {{-- button login --}}
                            <button type="submit" class="btn btn-primary w-100 mt-3 mb-5">LOGIN</button>

                            {{-- copyright --}}
                            <div class="text-center mb-2">
                                &copy; 2024 - <a href="https://pustakakoding.com/" target="_blank" class="text-brand text-decoration-none fw-semibold">Pustaka Koding</a>.
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"> </script>
</body>

</html>
