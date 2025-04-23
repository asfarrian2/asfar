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
						<li class="breadcrumb-item"><a href="#">Realisasi</a></li>
					</ol>
                </div>
                <!-- row -->
                 <div class="row">
                     <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="/opt/realisasi" method="GET" data-parsley-validate>
                                    @csrf
                                    <div class="mb-3 row">
                                        <label class="form-label">Bulan :</label>
                                        <select class="input-default  form-control" name="bulan" id="SelectJr">
                                        <option value="">Pilih Bulan</option>
                                        @foreach ($bulan as $d)
                                        <option  {{ Request('bulan') == $d->id_bulan ? 'selected' : '' }}
                                        value="{{ $d->id_bulan }}">{{$d->nama_bulan }}</option>
                                        @endforeach
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


                    @if(Request::get('bulan'))
                     <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-news">
                                @if ($filter->status_bulan == 1)
                                <i class="fa fa-pencil" style="font-size: 30px;"> </i>
                                <h5 class="text-info d-inline"> | Lakukan Penginputan Realisasi Bulanan</h5>
									<div class="media pt-3 pb-3">
										<div class="media-body">
											<p class="mb-0"> Apabila Penginputan Telah Selesai, Klik Tombol Posting Untuk Melakukan Proses Penyimpanan Data.</p>
										</div>
									</div>
                                    <div class="mb-3 row">
                                    @if($count == 0)
                                    <a type="button" class="btn btn-primary posting" data-id="{{Crypt::encrypt($filter->id_bulan)}}" >
                                        POSTING
                                     </a>
                                     @else
                                     <a type="button" class="btn btn-success terposting" >
                                        TELAH DIPOSTING <i class="fa fa-check"></i>
                                     </a>
                                     @endif
                                    </div>
                                @else
                                <i class="fa fa-warning" style="font-size: 30px;"> </i>
                                <h5 class="text-info d-inline"> | Input Realisasi Ditutup</h5>
									<div class="media pt-3 pb-3">
										<div class="media-body">
											<p class="mb-0"> Silahkan hubungi Admin untuk bisa kembali melakukan proses input data Realisasi pada bulan ini.</p>
										</div>
									</div>
                                @endif
                                </div>
                            </div>
                    @else
                    <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-news">
                                <i src="images/profile/5.jpg" alt="image" class="fa fa-pencil" style="font-size: 30px;"> </i> <h5 class="text-info d-inline"> | Realisasi Penerimaan Retribusi Daerah</h5>
									<div class="media pt-3 pb-3">
										<div class="media-body">
											<p class="mb-0"> Pilih bulan terlebih dahulu untuk melakukan proses input data Realisasi Penerimaan Retribusi Daerah. </p>
										</div>
									</div>
                                </div>
                            </div>
                    @endif

                            <!-- Start EditModal -->
                            <div class="modal fade" id="modal-tambah">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Input Realisasi</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>
                                        <div class="modal-body" id="loadtambah">
                                            <div class="basic-form">
                                            <!-- Form
                                                        Tambah -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Edit Modal -->

                             <!-- Start EditModal -->
                             <div class="modal fade" id="modal-edit">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Edit Data</h3>
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

                             <!-- Start Edit Target Modal -->
                            <div class="modal fade" id="modal-edittarget">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Edit Pagu Target</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>
                                        <div class="modal-body" id="loadedittarget">
                                            <div class="basic-form">
                                            <!-- Form
                                                        Edit -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Edit Target Modal -->

                             <!-- Start Edit Rincian Modal -->
                             <div class="modal fade" id="modal-editrincian">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Edit Rincian</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>
                                        <div class="modal-body" id="loadeditrincian">
                                            <div class="basic-form">
                                            <!-- Form
                                                        Edit -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Edit Target Modal -->
                        </div>
                    </div>
                </div>
                @if(Request::get('bulan'))

                 <!-- row -->
                 <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rincian</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive-sm ">
                                        <thead>
                                            <tr>
                                                <th style="color: black;" rowspan="2">KODE AKUN</th>
                                                <th style="color: black;" rowspan="2">JENIS / SUB / OBJEK / RINCIAN</th>
                                                <th style="color: black;" rowspan="2">TARGET</th>
                                                <th style="color: black; text-align: center;" rowspan="1" colspan="3">REALISASI</th>
                                                <th style="color: black;" rowspan="2">AKSI</th>
                                            </tr>
                                            <tr>
                                            <th style="color: black; text-align: center;" rowspan="1">s.d. BULAN <br>SEBELUMNYA</th>
                                            <th style="color: black; text-align: center;" rowspan="1">BULAN INI</th>
                                            <th style="color: black; text-align: center;" rowspan="1">s.d. BULAN<br>SEKARANG</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($rincian as $kode_jr => $jr)
                                        <tr>
                                            <td style="color: black;"><b>{{$kode_jr}}</b></td>
                                            <td style="color: black;"><b>{{$jr->first()->first()->first()->nama_jr}}</b></td>
                                            @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                            @else <!-- Jika Menampilkan APBD Perubahan -->
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                            @endif
                                            <!-- End -->
                                            @if ($jr->first()->first()->first()->id_bulan == Request('bulan'))
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi'), 0, ',', '.') }}</b></td>
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                            @else
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                            <td style="color: black;"><b>Rp0</b></td>
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                            @endif
                                            <td></td>
                                        </tr>
                                        @foreach ($jr as $kode_sr => $sr)
                                            <tr>
                                                <td style="color: black;"><b>{{$kode_sr}}</b></td>
                                                <td style="color: black;"><b>{{$sr->first()->first()->nama_sr}}</b></td>
                                                @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                                @else  <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                                @endif  <!-- END -->

                                                @if ($sr->first()->first()->id_bulan == Request('bulan'))
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp0</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                                @endif
                                                <td style="color: black;"></td>
                                            </tr>
                                            @foreach ($sr as $kode_ojk => $ojk)
                                            <tr>
                                                <td style="color: black;"><b>{{$kode_ojk}}</b></td>
                                                <td style="color: black;"><b>{{$ojk->first()->nama_ojk}}</td>
                                                @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                                @else <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                                @endif

                                                @if ($ojk->first()->id_bulan == Request('bulan'))
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp0</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                                @endif
                                                <td style="color: black;"></td>
                                            </tr>
                                            @foreach ($ojk as $d)
                                            <tr>
                                                <td style="color: black;"></td>
                                                <td style="color: black;">- {{$d->uraian_rtarget}}</td>
                                                @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_rtarget ,0,',','.')?></td>
                                                @else <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_prtarget ,0,',','.')?></td>
                                                @endif

                                                @if ($d->id_bulan == Request('bulan'))
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_sebelumnya ,0,',','.')?></td>
                                                <td style="color: green;">Rp<?php echo number_format($d->pagu_realisasi ,0,',','.')?></td>
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_sekarang ,0,',','.')?></td>
                                                @else
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_sebelumnya ,0,',','.')?></td>
                                                <td style="color: black;">Belum Ada Realisasi</td>
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_sekarang ,0,',','.')?></td>
                                                @endif
                                                <td>
                                                @if($view->status_target < 1 or $filter->status_bulan == 0 or $count > 0)
                                                        <!-- Blank -->
                                                 @else

                                                    <div class="dropdown">
														<button type="button" class="btn btn-warning dark sharp" data-bs-toggle="dropdown">
															<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
														</button>
                                                        @csrf
														<div class="dropdown-menu">
                                                        @if($d->pagu_realisasi !== NULL && $d->id_bulan == Request('bulan'))
                                                            <a class="dropdown-item edit" href="#" data-id="{{Crypt::encrypt($d->id_realisasi)}}">
                                                                <i class="fa fa-pencil color-muted"></i> Edit
                                                            </a>
                                                        @else
                                                            <a class="dropdown-item tambah" href="#" data-id="{{Crypt::encrypt($d->id_rtarget)}}" data-bulan="{{Crypt::encrypt(Request('bulan'))}}">
                                                                <i class="fa fa-plus color-muted"></i> Tambah
                                                            </a>
                                                        @endif
														</div>
													</div>
                                                    @endif
                                                </td>
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" style="text-align:center; color:black;" >TOTAL</th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($jumlah ,0,',','.')?></th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($total_sebelumnya ,0,',','.')?></th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($total ,0,',','.')?></th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($total_sekarang ,0,',','.')?></th>
                                            </tr>
                                        </tfoot>
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

<!-- Button Tambah Realisasi -->
<script>
    $('.tambah').click(function(){
        var id_rtarget = $(this).attr('data-id');
        var id_bulan = $(this).attr('data-bulan'); // perubahan disini
        $.ajax({
            type: 'POST',
            url: '/opt/realisasi/tambah',
            cache: false,
            data: {
                _token: "{{ csrf_token() }}",
                id_rtarget: id_rtarget,
                id_bulan: id_bulan // tambahan disini
            },
            success: function(respond) {
                $("#loadtambah").html(respond);
                $('.pagu').mask("#.##0", { reverse:true });
            }
        });
        $("#modal-tambah").modal("show");
    });
    var span = document.getElementsByClassName("close")[0];
</script>
<!-- END Button Edit Pagu Target -->

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

<!-- Begin Alert Button Terposting -->
<script>
    $('.terposting').click(function() {
  Swal.fire({
    icon: 'success',
    title: 'Data Telah Terposting',
    text: 'Pagu Target Telah Ditetapkan',
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
