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
                                SKPD / UPTD Penghasil
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
						<li class="breadcrumb-item active"><a href="javascript:void(0)">E-DOMPET</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0)">SKPD</a></li>
					</ol>
                </div>
                <!-- row -->
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tabel Data</h4>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahdata">+Tambah</button>
                            </div>
                            <!-- Start Modal -->
                            <div class="modal fade" id="tambahdata">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Tambah Data</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="basic-form">
                                            <form action="/admin/agency/store" method="POST">
                                            @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Nama SKPD/UPTD :</label>
                                                    <input type="text" name="nama_agency" class="form-control input-default" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Pejabat/Kepala SKPD/UPTD :</label>
                                                    <input type="text" name="nama_pejabat" class="form-control input-default" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIP Pejabat/Kepala SKPD/UPTD :</label>
                                                    <input type="text" name="nip" class="form-control input-default" required>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">NO.</th>
                                                <th style="text-align:center;">SKPD/UPTD</th>
                                                <th style="text-align:center;">NAMA</th>
                                                <th style="text-align:center;">NIP</th>
                                                <th style="text-align:center;">JUMLAH AKUN</th>
                                                <th style="text-align:center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($view as $d)
                                            <tr>
                                                <td style="color: black; text-align:center;">{{ $loop->iteration }}</td>
                                                <td style="color: black;">{{$d->nama_agency}}</td>
                                                <td style="color: black;">{{$d->kepala_agency}}</td>
                                                <td style="color: black;">{{$d->nip_agency}}</td>
                                                <td style="color: black;">{{$d->jumlah}}</td>
                                                <td>
                                                    <div class="dropdown">
														<button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
															<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
														</button>
                                                        @csrf
														<div class="dropdown-menu">
															<a class="dropdown-item edit" href="#" id_agency="{{$d->id_agency}}"> <i class="fa fa-pencil color-muted"></i> Edit</a>
															<a class="dropdown-item hapus" href="#" data-id="{{Crypt::encrypt($d->id_agency)}}" ><i class="fa fa-trash color-muted"></i> Hapus</a>
														</div>
													</div>
                                                </td>
                                            @endforeach
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align:center;">NO.</th>
                                                <th style="text-align:center;">SKPD/UPTD</th>
                                                <th style="text-align:center;">NAMA</th>
                                                <th style="text-align:center;">NIP</th>
                                                <th style="text-align:center;">JUMLAH AKUN</th>
                                                <th style="text-align:center;">AKSI</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- Start EditModal -->
                            <div class="modal fade" id="modal-editobjek">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Edit Data</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>
                                        <div class="modal-body" id="loadeditform">
                                            <div class="basic-form">
                                            <!-- Form
                                                        Edit -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
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
    <!-- Datatable -->
    <script src="{{asset ('./vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset ('./js/plugins-init/datatables.init.js') }}"></script>

    <!-- Button Edit SPJ -->
    <script>
    $('.edit').click(function(){
        var id_agency = $(this).attr('id_agency');
        $.ajax({
                        type: 'POST',
                        url: '/admin/agency/edit',
                        cache: false,
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_agency: id_agency
                        },
                        success: function(respond) {
                            $("#loadeditform").html(respond);
                        }
                    });
         $("#modal-editobjek").modal("show");

    });
    var span = document.getElementsByClassName("close")[0];
    </script>
    <!-- END Button Edit SPJ -->

    <!-- Start Button Hapus -->
    <script>
    $('.hapus').click(function(){
        var id_agency = $(this).attr('data-id');
    Swal.fire({
      title: "Apakah Anda Yakin Data Ini Ingin Di Hapus ?",
      text: "Jika Ya Maka Data Akan Terhapus Permanen",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus Saja!"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = "/admin/agency/"+id_agency+"/hapus"
        Swal.fire({
          title: "Data Berhasil Dihapus !",
          icon: "success"
        });
      }
    });
    });
    </script>
    <!-- End Button Hapus -->

@endpush
