@extends('layouts.admin')

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
                                Evaluasi Penerimaan Retribusi Daerah
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
            <div class="container-fluid">
        <!-- Start Pemberitahuan -->
        @csrf
        @php
        $messagesuccess = Session::get('success');
        $messagewarning = Session::get('warning');
        @endphp
        @if (Session::get('success'))
                <div class="alert alert-success solid alert-dismissible fade show">
					<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
					<strong>Sukses!</strong> {{ $messagesuccess }}.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                    </button>
                </div>
        @endif
        @if (Session::get('warning'))
                <div class="alert alert-danger solid alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24 " height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <strong>Gagal!</strong> {{ $messagewarning }}.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                    </button>
                </div>
        @endif
                <!-- End Pemberitahuan -->
				<div class="row page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="/opt/dashboard">SI-RETDA</a></li>
						<li class="breadcrumb-item"><a href="#">Evaluasi</a></li>
					</ol>
                </div>
                <!-- row -->
                 <div class="row">
                     <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="/admin/evaluasi/" method="GET" data-parsley-validate>
                                    <div class="mb-3 row">
                                        <label class="form-label">Triwulan :</label>
                                        <select class="input-default  form-control" name="triwulan" id="bulan" required>
                                        @if(Request::has('triwulan'))
                                        <option value="">Pilih Triwulan</option>
                                        @foreach ($triwulan as $d)
                                        <option  {{  Crypt::decrypt(Request('triwulan')) == $d->id_triwulan ? 'selected' : '' }}
                                        value="{{ Crypt::encrypt($d->id_triwulan) }}">{{$d->nama_triwulan }}</option>
                                        @endforeach
                                        @else
                                        <option value="">Pilih Triwulan</option>
                                        @foreach ($triwulan as $d)
                                            <option value="{{ Crypt::encrypt($d->id_triwulan) }}">{{$d->nama_triwulan }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    <div class="mb-3 row">
                                        <button type="submit" class="btn btn-secondary">Pilih</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="widget-stat card bg-info">
							<div class="card-body p-4">
								<div class="media">
									<span class="me-3">
										<i class="flaticon-381-calendar-1"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">REALIASI {{ strtoupper($pilih_triwulan->nama_triwulan) }} T.A. {{ Auth::guard('admin')->user()->id_tahun }}</p>
										<h3 class="text-white"><small>Rp</small>{{number_format($totalrealisasi, 0, ',', '.')}}</h3>
										<div class="progress mb-2 bg-primary">
                                            @php
                                            $persen = $totalrealisasi / $totaltarget * 100;
                                            @endphp
                                            <div class="progress-bar progress-animated bg-white" style="width: <?php echo $persen ?>%"></div>
                                        </div>
                                        <span class="badge light badge-dark">{{ number_format($persen, 2)}} %</span>
										<small>Dari Target: <b>Rp {{number_format($totaltarget, 0, ',', '.')}}</b></small>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>

                @if(Request::get('triwulan'))
                 <!-- row -->
                 <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Evaluasi {{ $pilih_triwulan->nama_triwulan }} T.A. {{ Auth::guard('admin')->user()->id_tahun }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th style="color: black;" rowspan="1" width="25px">NO</th>
                                                <th style="color: black; text-align:center;" rowspan="1" width="140px">DINAS / UPTD / <br> TARGET / REALISASI</th>
                                                <th style="color: black; text-align: center;" rowspan="1" colspan="1" width="600px">EVALUASI</th>
                                                <th style="color: black;" rowspan="1">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($target as $d)
                                            <tr>
                                                <td style="color: black; text-align:center; vertical-align:top;">{{ $loop->iteration }}</td>
                                                <td style="color:darkorchid; vertical-align:top;">{{ $d->nama_agency }}<br>
                                                    <table>
                                                        <tr><td style="color: black; vertical-align:top;" width="10px">Target <br> Realisasi <br>Persentasi</td>
                                                        <td style="color: black; vertical-align:top;">: Rp{{number_format($d->pagu_target, 0, ',', '.')}}
                                                            <br>
                                                            : Rp {{ number_format($realisasi[$d->id_target], 0, ',', '.') }}
                                                            <br>
                                                            : {{ number_format($realisasi[$d->id_target] / $d->pagu_target * 100, 2) }}%</td></tr>
                                                    </table>
                                                </td>
                                                @php
                                                    $evaluasiData = $evaluasi->where('id_agency', $d->id_agency)->first();
                                                @endphp
                                                @if ($evaluasiData)
                                                <td>
                                                    <table>
                                                        <tr><td style="color: black; vertical-align:top;" width="10px">Faktor Pendukung</td><td style="color: black; vertical-align:top;">:</td><td style="color: black; vertical-align:top;"> {{ $evaluasiData->fpendukung }}</td></tr>
                                                        <tr><td style="color: black; vertical-align:top;">Faktor Penghambat</td><td style="color: black; vertical-align:top;">:</td><td style="color: black; vertical-align:top;"> {{ $evaluasiData->fpenghambat }}</td></tr>
                                                        <tr><td style="color: black; vertical-align:top;">Tindak Lanjut</td><td style="color: black; vertical-align:top;">:</td><td style="color: black; vertical-align:top;"> {{ $evaluasiData->tindaklanjut }}</td></tr>
                                                    </table>
                                                </td>
                                                @else
                                                        <td style="color:red; text-align:center;">Tidak Ada Laporan</td>
                                                        @endif
                                                <td>
                                                @if ($evaluasiData)
                                                <div class="dropdown">
														<button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
															<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
														</button>
                                                        @csrf
														<div class="dropdown-menu">
                                                            <a class="dropdown-item reset" href="#" data-id="{{Crypt::encrypt($evaluasiData->id_evaluasi)}}" ><i class="fa fa-eye color-muted"></i> Lihat</a>
                                                            <a class="dropdown-item reset" href="#" data-id="{{Crypt::encrypt($evaluasiData->id_evaluasi)}}" ><i class="fa fa-ban color-muted"></i> Batalkan</a>
														</div>
													</div>
                                                @else
                                                @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    @endif
                </div>
            </div>

        <!--**********************************
            Content body end
        ***********************************-->

@endsection

@push('myscript')
<!-- Datatable -->
<script src="{{asset ('./vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset ('./js/plugins-init/datatables.init.js') }}"></script>

<!-- Button Edit Pagu Target -->
<script>
$('.edit').click(function(){
    var id_realisasi = $(this).attr('data-id');
    $.ajax({
                    type: 'POST',
                    url: '/opt/realisasi/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_realisasi: id_realisasi
                    },
                    success: function(respond) {
                        $("#loadedit").html(respond);
                        $('.pagu').mask("#.##0", {
                            reverse:true
                        });
                    }
                });
     $("#modal-edit").modal("show");
});
var span = document.getElementsByClassName("close")[0];
</script>
<!-- END Button Edit Pagu Target -->


<!-- Start Button Status -->
<script>
$('.status').click(function(){
    var id_sr = $(this).attr('data-id');
Swal.fire({
  title: "Apakah Anda Yakin Mengubah Status Data Ini ?",
  text: "Jika Ya Maka Status Data Akan Berubah",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Ya, Ubah Status!"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "/admin/subretribusi/"+id_sr+"/status"
  }
});
});
</script>
<!-- End Button Status -->

<!-- Begin Alert Button Terposting -->
<script>
    $('.terposting').click(function() {
  Swal.fire({
    icon: 'success',
    title: 'Data Telah Terposting',
    text: 'Pagu Realisasi Telah Disimpan',
    confirmButtonText: 'OK'
  })
})
</script>
<!-- End Alert Button Terposting -->

<!-- Begin Rupiah Pagu Target -->
<script>
    $(document).ready(function(){
        $('.pagu').mask("#.##0", {
            reverse:true
        });
    });
</script>
<!-- End Rupiah Pagu Target -->

<!-- Start Button posting -->
<script>
$('.posting').click(function(){
    var id_bulan = $(this).attr('data-id');
Swal.fire({
  title: "Apakah Anda Yakin Ingin Memposting Data Realisasi Bulan Ini ?",
  text: "Jika Ya Maka Data Akan Diposting dan Tidak Bisa Lagi Melakukan Pengeditan Data",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Ya, Posting Saja!"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "/opt/realisasi/"+id_bulan+"/posting"
  }
});
});
</script>
<!-- End Button Posting -->

@endpush
