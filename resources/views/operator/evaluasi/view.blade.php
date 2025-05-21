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
                <!-- Start Modal -->
                <div class="modal fade" id="tambahdata">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Input Evaluasi</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="basic-form">
                                <form action="/opt/evaluasi/store" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Faktor Pendukung :</label>
                                        <input type="text" placeholder="Faktor Penghubung ..." name="fpendukung" class="form-control input-default" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Faktor Penghambat :</label>
                                        <input type="text" placeholder="Faktor Penghambat ..." name="fpenghambat" class="form-control input-default" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tindak Lanjut :</label>
                                        <input type="text" placeholder="Tindak Lanjut ..." name="tindaklanjut" class="form-control input-default" required>
                                        @if ($status ==! NULL)
                                        <input type="hidden" value="{{ $status->id_triwulan }}" name="id_tw" class="form-control input-default" required>
                                        @endif
                                    </div>
                               </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->

                 <!-- Start EditModal -->
                <div class="modal fade" id="modal-edit">
                   <div class="modal-dialog modal-dialog-centered" role="document">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h3 class="modal-title">Edit Evaluasi</h3>
                               <button type="button" class="btn-close" data-bs-dismiss="modal">
                               </button>
                           </div>
                           <div class="modal-body" id="loadedit">
                               <div class="basic-form">
                               <!-- Form
                                           Edit -->
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
                <!-- End Edit Modal -->

                <!-- row -->
                 <div class="row">
                     <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                     <form action="/opt/evaluasi/" method="GET" data-parsley-validate>
                                    <div class="mb-3 row">
                                        <label class="form-label">Bulan :</label>
                                        <select class="input-default  form-control" name="triwulan" id="triwulan">
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
                    @if(Request::get('triwulan'))
                     <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-news">
                                @if ($status->status_triwulan == 1)
                                <i class="fa fa-pencil" style="font-size: 30px;"> </i>
                                <h5 class="text-info d-inline"> | Lakukan Penginputan Evaluasi</h5>
									<div class="media pt-3 pb-3">
										<div class="media-body">
											<p class="mb-0"> Apabila Penginputan Telah Selesai, Klik Tombol Posting Untuk Melakukan Proses Penyimpanan Data.</p>
										</div>
									</div>
                                @else
                                <i class="fa fa-warning" style="font-size: 30px;"> </i>
                                <h5 class="text-info d-inline"> | Penginputan Evaluasi Ditutup</h5>
									<div class="media pt-3 pb-3">
										<div class="media-body">
											<p class="mb-0"> Silahkan hubungi Admin untuk bisa kembali melakukan proses input data Evaluasi pada triwulan ini.</p>
										</div>
									</div>
                                @endif
                                    <div class="mb-3 row">
                                        @if ($evaluasi ==! null && $evaluasi->status_evaluasi == 0)
                                        <a type="button" class="btn btn-info posting" data-id="{{Crypt::encrypt($evaluasi->id_evaluasi)}}" >
                                            POSTING
                                        </a>
                                        @elseif ($evaluasi ==! null && $evaluasi->status_evaluasi == 1)
                                         <a type="button" class="btn btn-success terposting">
                                            TERPOSTING <i class="fa fa-check"></i>
                                        </a>
                                        @endif
                                        </div>
									</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(Request::get('triwulan'))
                        <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tabel Evaluasi</h4>
                                <div>
                                    @if ($status->status_triwulan == 1 && $evaluasi == NULL)
                                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahdata">+ Input Evaluasi</button>
                                    @elseif ($status->status_triwulan == 1 && $evaluasi ==! NULL && $evaluasi->status_evaluasi ==! 1)
                                    <a class="btn btn-warning mb-2 edit" type="button" data-id="{{Crypt::encrypt($evaluasi->id_evaluasi)}}"><i class="fa fa-pencil"></i> Edit Evaluasi</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive-sm ">
                                        <thead>
                                            <th style="color: black; text-align:center;" width="40px">NO</th>
                                            <th style="color: black; text-align:center;" width="200px">INDIKATOR</th>
                                            <th style="color: black; text-align:center;">URAIAN</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="color: black; text-align:center;">1</td>
                                                <td style="color: black;">Faktor Pendukung</td>
                                                @if ($evaluasi == null)
                                                <td></td>
                                                @else
                                                <td style="color: black;">{{ $evaluasi->fpendukung }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td style="color: black; text-align:center;">2</td>
                                                <td style="color: black;">Faktor Penghambat</td>
                                                @if ($evaluasi == null)
                                                <td></td>
                                                @else
                                                <td style="color: black;">{{ $evaluasi->fpenghambat }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td style="color: black; text-align:center;">3</td>
                                                <td style="color: black;">Tindak Lanjut yang Diperlukan</td>
                                                @if ($evaluasi == null)
                                                <td></td>
                                                @else
                                                <td style="color: black;">{{ $evaluasi->tindaklanjut }}</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
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
    var id_evaluasi = $(this).attr('data-id');
    $.ajax({
            type: 'POST',
            url: '/opt/evaluasi/edit',
            cache: false,
            data: {
                _token: "{{ csrf_token() }}",
                id_evaluasi: id_evaluasi
                },
                 success: function(respond) {
                            $("#loadedit").html(respond);
                }
            });
     $("#modal-edit").modal("show");
});
var span = document.getElementsByClassName("close")[0];
</script>
<!-- END Button Edit Pagu Target -->


<!-- Begin Alert Button Off -->
<script>
    $('.off').click(function() {
  Swal.fire({
    icon: 'error',
    title: 'Proses Gagal',
    text: 'Data tidak dapat diproses karena target belum ditetapkan',
    confirmButtonText: 'OK'
  })
})
</script>
<!-- End Alert Button Off -->

<!-- Begin Alert Button Terposting -->
<script>
    $('.terposting').click(function() {
  Swal.fire({
    icon: 'success',
    title: 'Data Telah Terposting',
    text: 'Evaluasi Telah Disimpan',
    confirmButtonText: 'OK'
  })
})
</script>
<!-- End Alert Button Terposting -->

<!-- Start Button posting -->
<script>
$('.posting').click(function(){
    var id_evaluasi = $(this).attr('data-id');
Swal.fire({
  title: "Apakah Anda Yakin Ingin Memposting Evaluasi Triwulan Ini ?",
  text: "Jika Ya Maka Data Akan Diposting dan Tidak Bisa Lagi Melakukan Pengeditan Data",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Ya, Posting Saja!"
}).then((result) => {
  if (result.isConfirmed) {
    window.location = "/opt/evaluasi/"+id_evaluasi+"/posting"
  }
});
});
</script>
<!-- End Button Posting -->

@endpush
