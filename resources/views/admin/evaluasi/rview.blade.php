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
						<li class="breadcrumb-item active"><a href="# "onclick="history.back()">Evaluasi</a></li>
                        <li class="breadcrumb-item"><a href="#">{{$evaluasi->nama_agency}}</a></li>
					</ol>
                </div>

                <!-- row -->
                 <div class="row">
                     <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$evaluasi->nama_agency}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="/admin/evaluasi/" method="GET" data-parsley-validate>
                                    <div class="mb-3 row">
                                        <table>
                                            <tr><td style="color: black; vertical-align:top;" width="100px">Faktor Pendukung</td><td style="color: black; vertical-align:top;">:</td><td style="color: black; vertical-align:top;"> {{ $evaluasi->fpendukung }}</td></tr>
                                            <tr><td height="10px"></td></tr>
                                            <tr><td style="color: black; vertical-align:top;">Faktor Penghambat</td><td style="color: black; vertical-align:top;" width="20px">:</td><td style="color: black; vertical-align:top;"> {{ $evaluasi->fpenghambat }}</td></tr>
                                            <tr><td height="10px"></td></tr>
                                            <tr><td style="color: black; vertical-align:top;">Tindak Lanjut</td><td style="color: black; vertical-align:top;">:</td><td style="color: black; vertical-align:top;"> {{ $evaluasi->tindaklanjut }}  </td></tr>
                                        </table>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- row -->
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rincian Realisasi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive-sm ">
                                        <thead>
                                            <tr>
                                                <th style="color: black;" rowspan="2" colspan="2">KODE AKUN</th>
                                                <th style="color: black;" rowspan="2">JENIS / SUB / OBJEK / RINCIAN</th>
                                                <th style="color: black;" rowspan="2">TARGET</th>
                                                <th style="color: black; text-align: center; width: 120px" rowspan="1" colspan="6">REALISASI</th>
                                            </tr>
                                            <tr>
                                                <th style="color: black; text-align: center;" rowspan="1">TW I</th>
                                                <th style="color: black; text-align: center;" rowspan="1">TW 2</th>
                                                <th style="color: black; text-align: center;" rowspan="1">TW 3</th>
                                                <th style="color: black; text-align: center;" rowspan="1">TW 4</th>
                                                <th style="color: black; text-align: center;" rowspan="1">TOTAL</th>
                                                <th style="color: black; text-align: center;" rowspan="1">%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rincian as $kode_jr => $jr)
                                            <tr>
                                                <td style="color: black; height: 30px;" colspan="2"><b>{{$kode_jr}}</b></td>
                                                <td style="color: black;"><b>{{$jr->first()->first()->first()->nama_jr}}</b></td>
                                                @if($nilai_triwulan < 4) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                                @else <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                                @endif
                                                <!-- End -->
                                                <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_tw1'), 0, ',', '.') }}</b></td>
                                                @if ($nilai_triwulan > 1)
                                                <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_tw2'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                @if ($nilai_triwulan > 2)
                                                <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_tw3'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                @if ($nilai_triwulan > 3)
                                                <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_realisasi_tw4'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_totaltw'), 0, ',', '.') }}</b></td>
                                                @if($nilai_triwulan < 4) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>{{ round(($jr->flatten()->sum('pagu_totaltw') / ($jr->flatten()->sum('pagu_rtarget'))) * 100, 2) }}%</b></td>
                                                @else <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>{{ round(($jr->flatten()->sum('pagu_totaltw') / ($jr->flatten()->sum('pagu_prtarget'))) * 100, 2) }}%</b></td>
                                                @endif
                                            </tr>
                                            @foreach ($jr as $kode_sr => $sr)
                                            <tr>
                                                <td style="color: black; height: 30px; "colspan="2"><b>{{$kode_sr}}</b></td>
                                                <td style="color: black;"><b>{{$sr->first()->first()->nama_sr}}</b></td>
                                                @if($nilai_triwulan < 4) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                                @else  <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                                @endif  <!-- END -->
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_tw1'), 0, ',', '.') }}</b></td>
                                                @if ($nilai_triwulan > 1)
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_tw2'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                @if ($nilai_triwulan > 2)
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_tw3'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                 @if ($nilai_triwulan > 3)
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_realisasi_tw4'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_totaltw'), 0, ',', '.') }}</b></td>
                                                 @if($nilai_triwulan < 4) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>{{ round(($sr->flatten()->sum('pagu_totaltw') / ($sr->flatten()->sum('pagu_rtarget'))) * 100, 2) }}%</b></td>
                                                @else <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>{{ round(($sr->flatten()->sum('pagu_totaltw') / ($sr->flatten()->sum('pagu_prtarget'))) * 100, 2) }}%</b></td>
                                                @endif
                                            </tr>
                                            @foreach ($sr as $kode_ojk => $ojk)
                                            <tr>
                                                <td style="color: black; height: 30px;" colspan="2"><b>{{$kode_ojk}}</b></td>
                                                <td style="color: black;"><b>{{$ojk->first()->nama_ojk}}</td>
                                                @if($nilai_triwulan < 4) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                                @else <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                                @endif
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_tw1'), 0, ',', '.') }}</b></td>
                                                @if ($nilai_triwulan > 1)
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_tw2'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                @if ($nilai_triwulan > 2)
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_tw3'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                @if ($nilai_triwulan > 3)
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_realisasi_tw4'), 0, ',', '.') }}</b></td>
                                                @else
                                                <td style="color: black;"><b>Rp0</b></td>
                                                @endif
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->flatten()->sum('pagu_totaltw'), 0, ',', '.') }}</b></td>
                                                @if($nilai_triwulan < 4) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;"><b>{{ round(($ojk->flatten()->sum('pagu_totaltw') / ($ojk->flatten()->sum('pagu_rtarget'))) * 100, 2) }}%</b></td>
                                                @else <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;"><b>{{ round(($ojk->flatten()->sum('pagu_totaltw') / ($ojk->flatten()->sum('pagu_prtarget'))) * 100, 2) }}%</b></td>
                                                @endif
                                            </tr>
                                            @foreach ($ojk as $d)
                                            <tr>
                                                <td style="color: black; height: 30px;" colspan="2"></td>
                                                <td style="color: black;">- {{$d->uraian_rtarget}}</td>
                                                @if($nilai_triwulan < 4) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_rtarget ,0,',','.')?></td>
                                                @else <!-- Jika Menampilkan APBD Perubahan -->
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_prtarget ,0,',','.')?></td>
                                                @endif
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_tw1 ,0,',','.')?></td>
                                                @if ($nilai_triwulan > 1)
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_tw2 ,0,',','.')?></td>
                                                @else
                                                <td style="color: black;">Rp0</td>
                                                @endif
                                                @if ($nilai_triwulan > 2)
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_tw3 ,0,',','.')?></td>
                                                @else
                                                <td style="color: black;">Rp0</td>
                                                @endif
                                                @if ($nilai_triwulan > 3)
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi_tw4 ,0,',','.')?></td>
                                                @else
                                                <td style="color: black;">Rp0</td>
                                                @endif
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_totaltw ,0,',','.')?></td>
                                                @if($nilai_triwulan < 4) <!-- Jika Menampilkan APBD Murni -->
                                                <td style="color: black;">{{$d->pagu_totaltw / $d->pagu_rtarget * 100}}%</td>
                                                @else
                                                <td style="color: black;">{{$d->pagu_totaltw / $d->pagu_prtarget * 100}}%</td>
                                                @endif
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" style="text-align:center; color:black;" >TOTAL</th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($jumlah ,0,',','.')?></th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($total_tw1 ,0,',','.')?></th>
                                                @if ($nilai_triwulan > 1)
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($total_tw2 ,0,',','.')?></th>
                                                @else
                                                <th style="text-align:center; color:black;">Rp0</th>
                                                @endif
                                                @if ($nilai_triwulan > 2)
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($total_tw3 ,0,',','.')?></th>
                                                @else
                                                <th style="text-align:center; color:black;">Rp0</th>
                                                @endif
                                                @if ($nilai_triwulan > 3)
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($total_tw4 ,0,',','.')?></th>
                                                @else
                                                <th style="text-align:center; color:black;">Rp0</th>
                                                @endif
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($total_sekarang ,0,',','.')?></th>
                                                <th style="text-align:center; color:black;"><?php echo number_format(round(($total_sekarang / $jumlah) * 100), 2, ',', '.'); ?>%</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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

@endpush
