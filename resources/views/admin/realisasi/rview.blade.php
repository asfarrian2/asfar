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
					<strong>Sukses!</strong> {{ $messagesuccess }}.
					<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
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
						<li class="breadcrumb-item active"><a href="#" onclick="history.back()">Realisasi</a></li>
                        <li class="breadcrumb-item">{{ $agency->nama_agency }}</li>
					</ol>
                </div>

                 <!-- row -->
                 <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rincian Realisasi Penerimaan Retribusi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive-sm ">
                                        <thead>
                                            <tr>
                                                <th style="color: black;" rowspan="2">KODE AKUN</th>
                                                <th style="color: black;" rowspan="2">JENIS / SUB / OBJEK / RINCIAN</th>
                                                <th style="color: black;" rowspan="2">TARGET</th>
                                                <th style="color: black; text-align: center;" rowspan="1" colspan="4">REALISASI <br> BULAN {{ strtoupper($filter->nama_bulan) }}</th>
                                            </tr>
                                            <tr>
                                            <th style="color: black; text-align: center;" rowspan="1">s.d. BULAN <br>SEBELUMNYA</th>
                                            <th style="color: black; text-align: center;" rowspan="1">BULAN INI</th>
                                            <th style="color: black; text-align: center;" rowspan="1">s.d. BULAN<br>SEKARANG</th>
                                            <th style="color: black; text-align: center;" rowspan="1">%</th>
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
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi'), 0, ',', '.') }}</b></td>
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                             @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                             <td style="color: black;"><b>{{ number_format($jr->flatten()->sum('pagu_realisasi_sekarang') / $jr->flatten()->sum('pagu_rtarget') * 100,2) }}% </b></td>
                                             @else  <!-- Jika Menampilkan APBD Perubahan -->
                                             <td style="color: black;"><b>{{ number_format($jr->flatten()->sum('pagu_realisasi_sekarang') / $jr->flatten()->sum('pagu_prtarget') * 100,2) }}% </b></td>
                                             @endif
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
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                                @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>{{ number_format($sr->flatten()->sum('pagu_realisasi_sekarang') / $sr->flatten()->sum('pagu_rtarget') * 100,2) }}% </b></td>
                                                @else  <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>{{ number_format($sr->flatten()->sum('pagu_realisasi_sekarang') / $sr->flatten()->sum('pagu_prtarget') * 100,2) }}% </b></td>
                                                @endif
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
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                                @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>{{ number_format($ojk->flatten()->sum('pagu_realisasi_sekarang') / $ojk->flatten()->sum('pagu_rtarget') * 100,2) }}% </b></td>
                                                @else  <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>{{ number_format($ojk->flatten()->sum('pagu_realisasi_sekarang') / $ojk->flatten()->sum('pagu_prtarget') * 100,2) }}% </b></td>
                                                @endif
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
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_sebelumnya ,0,',','.')?></td>
                                                <td style="color: green;">Rp<?php echo number_format($d->pagu_realisasi ,0,',','.')?></td>
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_sekarang ,0,',','.')?></td>
                                                 @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;">{{ number_format($d->pagu_realisasi_sekarang / $d->pagu_rtarget * 100,2) }}%</td>
                                                @else  <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;">{{ number_format($d->pagu_realisasi_sekarang / $d->pagu_rtarget * 100,2) }}% </td>
                                                @endif
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" style="text-align:center; color:black;" >TOTAL</th>
                                                @if ($filter->tipe_bulan == 1)
                                                <td style="color: black;"><b>Rp{{ number_format($rincian->flatten()->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp{{ number_format($rincian->flatten()->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                                @endif
                                                <td style="color: black;"><b>Rp{{ number_format($rincian->flatten()->sum('pagu_realisasi_sebelumnya'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($rincian->flatten()->sum('pagu_realisasi'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($rincian->flatten()->sum('pagu_realisasi_sekarang'), 0, ',', '.') }}</b></td>
                                                @if($filter->tipe_bulan == 1) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>{{ number_format($rincian->flatten()->sum('pagu_realisasi_sekarang') / $rincian->flatten()->sum('pagu_rtarget') * 100,2) }}% </b></td>
                                                @else  <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>{{ number_format($rincian->flatten()->sum('pagu_realisasi_sekarang') / $rincian->flatten()->sum('pagu_prtarget') * 100,2) }}% </b></td>
                                                @endif
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
