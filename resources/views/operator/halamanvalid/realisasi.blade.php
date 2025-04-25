@extends('layouts.operator')

@section('header')

		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
							<div class="dashboard_bar">
                                Realisasi Penerimaan Retribusi Daerah
                            </div>
                        </div>
                    </div>
				</nav>
			</div>
		</div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
@endsection

@section('content')
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
                 <div class="col-xl-12">
                    <div class="card text-white bg-warning">
                        <div class="card-header">
                            <h5 class="card-title text-white">Informasi</h5>
                        </div>
                        <div class="card-body mb-0">
                            <p class="card-text">Halaman tidak dapat diakses, pastikan proses input data Target Pendapatan Retribusi Daerah telah selesai untuk dapat melakukan akses pada halaman ini. </p><a href="/opt/targetapbd" class="btn bg-white text-info btn-card">
                                Input Data Target APBD Retribusi Daerah</a>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-white">
                            Terima Kasih
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

@endsection

@push('myscript')
    <!-- Chart ChartJS plugin files -->
    <script src="{{ asset ('assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset ('assets/js/plugins-init/chartjs-init.js') }}"></script>
    <script src="{{ asset ('assets/js/custom.min.js') }}"></script>
	<script src="{{ asset ('assets/js/dlabnav-init.js') }}"></script>

@endpush
