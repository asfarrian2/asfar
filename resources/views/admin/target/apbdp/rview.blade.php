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
                                Rincian Target
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
						<li class="breadcrumb-item active"><a href="/admin/dashboardAll">SI-RETDA</a></li>
                        <li class="breadcrumb-item active"><a href="/admin/targetapbdp">Target APBD P</a></li>
						<li class="breadcrumb-item"><a href="#">Rincian Target</a></li>
					</ol>
                </div>
                <!-- row -->
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" style="color: purple;">{{ $view->nama_agency }}</h4>
                            </div>

                             <!-- Main Balance -->
				            <div class="card-header flex-wrap border-0 pb-0 align-items-end">
				            	<div class="mb-3 me-3">
				            		<h5 class="fs-20 text-black font-w500">Pagu Target APBD P {{ Auth::guard('admin')->user()->id_tahun }}</h5>
                                    @if($view)
                                    <span class="text-num text-black fs-36 font-w500">Rp<?php echo number_format($view->pagu_ptarget ,0,',','.')?></span>
                                    @else
                                    <span class="text-num text-black fs-36 font-w500">Rp0</span>
                                    @endif
				            	</div>
				            	<div class="me-3 mb-3">

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
                                @if($view->status_target == 0)
                                <a type="button" class="btn btn-warning">PROSES <span class="btn-icon-end">
                                        <i class="fa fa-rotate-right"></i></span>
                                </a>
                                @elseif($view->status_target == 1)
                                <a type="button" class="btn btn-success terposting">Terposting <span class="btn-icon-end">
                                        <i class="fa fa-check"></i></span>
                                </a>
                                @endif
                                </span>
                            </div>
                            <div><br></div>
                            <!-- End Mainbalance -->
                        </div>
                    </div>
                </div>
                @if($view)
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
                                                <th rowspan="2" style="color: black; text-align:center;">KODE AKUN</th>
                                                <th rowspan="2" style="color: black; text-align:center;">JENIS / SUB / OBJEK / RINCIAN</th>
                                                <th colspan="2" style="color: black; text-align:center;" >PAGU</th>
                                                <th rowspan="2" style="color: black;">BERKURANG / <br>BERTAMBAH</th>

                                            </tr>
                                            <tr>
                                                <th style="color: black;">SEBELUM</th>
                                                <th style="color: black;">SESUDAH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($rincian as $kode_jr => $jr)
                                        <tr>
                                            <td style="color: black;"><b>{{$kode_jr}}</b></td>
                                            <td style="color: black;"><b>{{$jr->first()->first()->first()->nama_jr}}</b></td>
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                            <td style="color: black;"><b>Rp{{ number_format($jr->flatten()->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                            <td style="color: black;"><b>Rp{{ number_format(($jr->flatten()->sum('pagu_prtarget'))-($jr->flatten()->sum('pagu_rtarget')), 0, ',', '.') }}</b></td>
                                        </tr>
                                        @foreach ($jr as $kode_sr => $sr)
                                            <tr>
                                                <td style="color: black;"><b>{{$kode_sr}}</b></td>
                                                <td style="color: black;"><b>{{$sr->first()->first()->nama_sr}}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($sr->flatten()->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format(($sr->flatten()->sum('pagu_prtarget'))-($sr->flatten()->sum('pagu_rtarget')), 0, ',', '.') }}</b></td>
                                            </tr>
                                            @foreach ($sr as $kode_ojk => $ojk)
                                            <tr>
                                                <td style="color: black;"><b>{{$kode_ojk}}</b></td>
                                                <td style="color: black;"><b>{{$ojk->first()->nama_ojk}}</td>
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->sum('pagu_rtarget'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format($ojk->sum('pagu_prtarget'), 0, ',', '.') }}</b></td>
                                                <td style="color: black;"><b>Rp{{ number_format(($ojk->sum('pagu_prtarget'))-($ojk->sum('pagu_rtarget')), 0, ',', '.') }}</b></td>
                                            </tr>
                                            @foreach ($ojk as $d)
                                            <tr>
                                                <td style="color: black;"></td>
                                                <td style="color: black;">- {{$d->uraian_rtarget}}</td>
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_rtarget ,0,',','.')?></td>
                                                <td style="color: black;">Rp<?php echo number_format($d->pagu_prtarget ,0,',','.')?></td>
                                                <td style="color: black;">Rp<?php echo number_format(($d->pagu_prtarget)-($d->pagu_rtarget) ,0,',','.')?></td>
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" style="text-align:center; color:black;" >TOTAL PAGU</th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($jumlah ,0,',','.')?></th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($jumlahp ,0,',','.')?></th>
                                                <th style="text-align:center; color:black;">Rp<?php echo number_format($jumlahp-$jumlah ,0,',','.')?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
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
@endpush
