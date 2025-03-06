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
                                Target APBD
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
						<li class="breadcrumb-item active"><a href="/opt/dashboard">SI-PREDRA</a></li>
						<li class="breadcrumb-item"><a href="#">Target APBD</a></li>
					</ol>
                </div>
                <!-- row -->
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Target APBD {{ Auth::guard('operator')->user()->id_tahun }}</h4>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahdata">+Tetapkan Target</button>
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
                                            <form action="/admin/objekretribusi/store" method="POST">
                                            @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Kode Akun :</label>
                                                    <input type="text" pattern="[0-9\.]+" name="kode" class="form-control input-default" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Akun :</label>
                                                    <input type="text" name="nama" class="form-control input-default" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Sub Retribusi :</label>
                                                    <select class="input-select  form-control" name="sub" id="sub" required>
                                                    <option value="">Pilih Sub Retribusi</option>
                                                    </select>
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

                             <!-- Main Balance -->
				            <div class="card-header flex-wrap border-0 pb-0 align-items-end">
				            	<div class="mb-3 me-3">
				            		<h5 class="fs-20 text-black font-w500">Pagu Target</h5>
				            		<span class="text-num text-black fs-36 font-w500">Rp15.000.000</span>
				            	</div>
				            	<div class="me-3 mb-3">
				            		<p class="fs-14 mb-1">RINCIAN</p>
                                    <button type="button" class="btn btn-rounded btn-info"><span
                                        class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                    </span>Tetapkan Rincian</button>
				            	</div>
				            	<div class="me-3 mb-3">
				            		<p class="fs-14 mb-1">SURAT USUL TARGET</p>
                                    <button type="button" class="btn btn-rounded btn-warning"><span
                                        class="btn-icon-start text-warning"><i class="fa fa-upload color-warning"></i>
                                    </span>Upload Dokumen</button>
				            	</div>
				            	<span class="fs-20 text-black font-w500 me-3 mb-3">
                                <button type="button" class="btn btn-success ">POSTING <span class="btn-icon-end">
                                        <i class="fa fa-check"></i></span>
                                </button>
                                </span>
                            </div>
                            <div><br></div>
                            <!-- End Mainbalance -->

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
                            <!-- End Edit Modal -->
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

    <!-- Button Edit -->
    <script>
    $('.edit').click(function(){
        var id_ojk = $(this).attr('data-id');
        $.ajax({
                        type: 'POST',
                        url: '/admin/objekretribusi/edit',
                        cache: false,
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_ojk: id_ojk
                        },
                        success: function(respond) {
                            $("#loadeditform").html(respond);
                            $("#select2").on('change', function(){
            var id_jr = $(this).val();
           //console.log(id_wajibpajak);
           if (id_jr) {
            $.ajax({
                url: '/admin/filtersub/'+id_jr,
                type: 'GET',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (data){
                    //console.log(data);
                     if (data) {
                        $("#sub2").empty();
                        $('#sub2').append('<option value=""> Pilih Sub Retribusi </option>');
                        $.each(data, function(key, sub){
                            $('select[name="sub2"]').append(
                                '<Option value="'+sub.id_sr+'">'+sub.kode_sr+' '+sub.nama_sr+'</Option>'
                            )
                        });
                     }else{
                        $("#sub2").empty();
                     }
                }
            });
           } else {
            $("#sub2").empty();
            $('#sub2').append('<option value=""> Pilih Sub Retribusi </option>');
           }
        });

                        }
                    });
         $("#modal-editobjek").modal("show");

    });
    var span = document.getElementsByClassName("close")[0];
    </script>
    <!-- END Button Edit -->

    <!-- Start Button Hapus -->
    <script>
    $('.hapus').click(function(){
        var id_jr = $(this).attr('data-id');
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
        window.location = "/admin/jenisretribusi/"+id_jr+"/hapus"
        Swal.fire({
          title: "Data Berhasil Dihapus !",
          icon: "success"
        });
      }
    });
    });
    </script>
    <!-- End Button Hapus -->

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

    <!-- Select1 -->
    <script>
    $(document).ready(function(){
        $("#selectJen").on('change', function(){
            var id_jr = $(this).val();
           //console.log(id_wajibpajak);
           if (id_jr) {
            $.ajax({
                url: '/admin/filtersub/'+id_jr,
                type: 'GET',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (data){
                    //console.log(data);
                     if (data) {
                        $("#sub").empty();
                        $('#sub').append('<option value=""> Pilih Sub Retribusi </option>');
                        $.each(data, function(key, sub){
                            $('select[name="sub"]').append(
                                '<Option value="'+sub.id_sr+'">'+sub.kode_sr+' '+sub.nama_sr+'</Option>'
                            )
                        });
                     }else{
                        $("#sub").empty();
                     }
                }
            });
           } else {
            $("#sub").empty();
            $('#sub').append('<option value=""> Pilih Sub Retribusi </option>');
           }
        });
    });

    </script>
    <!-- End Select1 -->

        <!-- Select2 -->
    <script>
    $(document).ready(function(){

    });

    </script>
    <!-- End Select2 -->

@endpush
