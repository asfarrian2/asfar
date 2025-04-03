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
						<li class="breadcrumb-item active"><a href="/opt/dashboard">SI-RETDA</a></li>
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
                                 @if($view)
                                 @csrf
                                 <button type="button" class="btn btn-warning mb-2 edit1" data-id="{{Crypt::encrypt($view->id_target)}}">✎ Edit Pagu Target</button>
                                 @else
                                 <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahdata">+ Tetapkan Pagu Target</button>
                                 @endif
                            </div>
                            <!-- Start Modal -->
                            <div class="modal fade" id="tambahdata">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Tetapkan Target</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="basic-form">
                                            <form action="/opt/targetapbd/store" method="POST" enctype="multipart/form-data">
                                            @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Pagu Target (Rp) :</label>
                                                    <input type="text" placeholder="0" name="pagutarget" id="pagu" class="form-control input-default pagu" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Surat Usul Target :</label>
                                                    <input type="file" accept="application/pdf" name="dokumen" maxsize="1024" class="form-control input-default" required>
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

                            <!-- Start Modal Create Rincian-->
                            <div class="modal fade" id="tambahrincian">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Tambahkan Rincian</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="basic-form">
                                            <form action="/opt/rtargetapbd/store" method="POST">
                                            @csrf
                                                @if($view)
                                                <input type="hidden" placeholder="0" name="target" id="target" value="{{ $view->id_target }}"  class="form-control input-default" required>
                                                @else
                                                @endif
                                                <!-- ... -->
                                                <div class="mb-3">
                                                    <label class="form-label">Uraian Target :</label>
                                                    <input type="text" placeholder="Masukkan Uraian" name="uraianrincian" class="form-control input-default" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Pagu Target (Rp) :</label>
                                                    <input type="text" placeholder="0" name="pagurtarget" class="form-control input-default pagu" required>
                                                </div>
                                                @if($view)
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Retribusi :</label>
                                                    <select class="input-default  form-control" name="jenis" id="SelectJr">
                                                    <option value="">Pilih Jenis Retribusi</option>
                                                    @foreach ($jenis as $d)
                                                    <option value="{{ $d->id_jr }}">{{$d->kode_jr }} - {{$d->nama_jr }} </option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                @else
                                                @endif
                                                <div class="mb-3">
                                                    <label class="form-label">Sub Retribusi :</label>
                                                    <select class="input-default  form-control" name="sub" id="SelectSr">
                                                    <option value="">Pilih Sub Retribusi</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Objek Retribusi :</label>
                                                    <select class="input-default  form-control" name="objek" id="ojk" >
                                                    <option value="">Pilih Objek Retribusi</option>
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
                            <!-- End Modal Create Rincian -->

                             <!-- Main Balance -->
				            <div class="card-header flex-wrap border-0 pb-0 align-items-end">
				            	<div class="mb-3 me-3">
				            		<h5 class="fs-20 text-black font-w500">Pagu Target</h5>
                                    @if($view)
                                    <span class="text-num text-black fs-36 font-w500">Rp<?php echo number_format($view->pagu_target ,0,',','.')?></span>
                                    @else
                                    <span class="text-num text-black fs-36 font-w500">Rp0</span>
                                    @endif
				            	</div>
				            	<div class="me-3 mb-3">
				            		<p class="fs-14 mb-1">RINCIAN</p>
                                    @if($view)
                                    <button type="button" class="btn btn-rounded btn-primary" data-bs-toggle="modal" data-bs-target="#tambahrincian"><span
                                        class="btn-icon-start text-primary"><i class="fa fa-plus color-primary"></i>
                                    </span>Buat Rincian</button>
                                    @else
                                    <button type="button" class="btn btn-rounded btn-dark off" ><span
                                        class="btn-icon-start text-dark"><i class="fa fa-plus color-dark"></i>
                                    </span>Buat Rincian</button>
                                    @endif
				            	</div>
				            	<div class="me-3 mb-3">
				            		<p class="fs-14 mb-1">SURAT USUL TARGET</p>
                                    @if($view)
                                    <a type="button" class="btn btn-rounded btn-info" href="{{ asset('upload/dokumen/targetapbd/'.$view->surat_apbd) }}" target="_blank"><span
                                        class="btn-icon-start text-info"><i class="fa fa-download color-info"></i>
                                    </span>Download Dokumen</a>
                                    @else
                                    <button type="button" class="btn btn-rounded btn-dark off"><span
                                        class="btn-icon-start text-dark"><i class="fa fa-upload color-dark"></i>
                                    </span>Download Dokumen</button>
                                    @endif
				            	</div>
				            	<span class="fs-20 text-black font-w500 me-3 mb-3">
                                @if($view)
                                <button type="button" class="btn btn-success ">POSTING <span class="btn-icon-end">
                                        <i class="fa fa-check"></i></span>
                                </button>
                                @else
                                @endif
                                </span>
                            </div>
                            <div><br></div>
                            <!-- End Mainbalance -->
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
    var id_rtarget = $(this).attr('data-id');
    $.ajax({
                    type: 'POST',
                    url: '/opt/rtargetapbd/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_rtarget: id_rtarget
                    },
                    success: function(respond) {
                        $("#loadeditrincian").html(respond);
                        $('.pagu').mask("#.##0", {
                            reverse:true
                        });
                        $("#SelectJre").on('change', function(){
                            var id_jr = $(this).val();
                           //console.log(id_wajibpajak);
                           if (id_jr) {
                            $.ajax({
                                url: '/opt/filtersub/'+id_jr,
                                type: 'GET',
                                data: {
                                    '_token': '{{ csrf_token() }}'
                                },
                                dataType: 'json',
                                success: function (data){
                                    //console.log(data);
                                     if (data) {
                                        $("#SelectSre").empty();
                                        $("#ojke").empty();
                                        $('#ojke').append('<option value=""> Pilih Objek Retribusi </option>');
                                        $('#SelectSre').append('<option value=""> Pilih Sub Retribusi </option>');
                                        $.each(data, function(key, sub){
                                            $('select[name="sub"]').append(
                                                '<Option value="'+sub.id_sr+'">'+sub.kode_sr+' '+sub.nama_sr+'</Option>'
                                            )
                                        });
                                     }else{
                                        $("#SelectSre").empty();
                                        $("#ojke").empty();
                                     }
                                }
                            });
                           } else {
                            $("#SelectSre").empty();
                            $('#SelectSre').append('<option value=""> Pilih Sub Retribusi </option>');
                            $("#ojke").empty();
                            $('#ojke').append('<option value=""> Pilih Objek Retribusi </option>');
                           }
                        });
                        $("#SelectSre").on('change', function(){
        var id_sr = $(this).val();
       //console.log(id_wajibpajak);
       if (id_sr) {
        $.ajax({
            url: '/opt/filterojk/'+id_sr,
            type: 'GET',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (data){
                //console.log(data);
                 if (data) {
                    $("#ojke").empty();
                    $('#ojke').append('<option value=""> Pilih Objek Retribusi </option>');
                    $.each(data, function(key, ojk){
                        $('select[name="objek"]').append(
                            '<Option value="'+ojk.id_ojk+'">'+ojk.kode_ojk+' '+ojk.nama_ojk+'</Option>'
                        )
                    });
                 }else{
                    $("#ojke").empty();
                 }
            }
        });
       } else {
        $("#ojke").empty();
        $('#ojke').append('<option value=""> Pilih Objek Retribusi </option>');
       }
    });
                        ////////////////////////////
                    }
                });
     $("#modal-editrincian").modal("show");
});
var span = document.getElementsByClassName("close")[0];
</script>
<!-- END Button Edit -->

<!-- Button Edit Pagu Target -->
<script>
$('.edit1').click(function(){
    var id_target = $(this).attr('data-id');
    $.ajax({
                    type: 'POST',
                    url: '/opt/targetapbd/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_target: id_target
                    },
                    success: function(respond) {
                        $("#loadedittarget").html(respond);
                        $('.pagu').mask("#.##0", {
                            reverse:true
                        });
                    }
                });
     $("#modal-edittarget").modal("show");
});
var span = document.getElementsByClassName("close")[0];
</script>
<!-- END Button Edit Pagu Target -->

<!-- Start Button Hapus -->
<script>
$('.hapus').click(function(){
    var id_rtarget = $(this).attr('data-id');
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
    window.location = "/opt/rtargetapbd/"+id_rtarget+"/hapus"
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
    $("#SelectSr").on('change', function(){
        var id_sr = $(this).val();
       //console.log(id_wajibpajak);
       if (id_sr) {
        $.ajax({
            url: '/opt/filterojk/'+id_sr,
            type: 'GET',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (data){
                //console.log(data);
                 if (data) {
                    $("#ojk").empty();
                    $('#ojk').append('<option value=""> Pilih Objek Retribusi </option>');
                    $.each(data, function(key, ojk){
                        $('select[name="objek"]').append(
                            '<Option value="'+ojk.id_ojk+'">'+ojk.kode_ojk+' '+ojk.nama_ojk+'</Option>'
                        )
                    });
                 }else{
                    $("#ojk").empty();
                 }
            }
        });
       } else {
        $("#ojk").empty();
        $('#ojk').append('<option value=""> Pilih Objek Retribusi </option>');
       }
    });
});
</script>
<!-- End Select1 -->

<!-- Select2 -->
<script>
$(document).ready(function(){
    $("#SelectJr").on('change', function(){
        var id_jr = $(this).val();
       //console.log(id_wajibpajak);
       if (id_jr) {
        $.ajax({
            url: '/opt/filtersub/'+id_jr,
            type: 'GET',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (data){
                //console.log(data);
                 if (data) {
                    $("#SelectSr").empty();
                    $("#ojk").empty();
                    $('#ojk').append('<option value=""> Pilih Objek Retribusi </option>');
                    $('#SelectSr').append('<option value=""> Pilih Sub Retribusi </option>');
                    $.each(data, function(key, sub){
                        $('select[name="sub"]').append(
                            '<Option value="'+sub.id_sr+'">'+sub.kode_sr+' '+sub.nama_sr+'</Option>'
                        )
                    });
                 }else{
                    $("#SelectSr").empty();
                    $("#ojk").empty();
                 }
            }
        });
       } else {
        $("#SelectSr").empty();
        $('#SelectSr').append('<option value=""> Pilih Sub Retribusi </option>');
        $("#ojk").empty();
        $('#ojk').append('<option value=""> Pilih Objek Retribusi </option>');
       }
    });
});
</script>
<!-- End Select2 -->

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

<!-- Begin Rupiah Pagu Target -->
<script>
    $(document).ready(function(){
        $('.pagu').mask("#.##0", {
            reverse:true
        });
    });
</script>
<!-- End Rupiah Pagu Target -->

@endpush
