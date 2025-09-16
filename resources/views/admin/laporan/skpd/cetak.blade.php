<!DOCTYPE html>
<html>
<head>
    <title>SI-RETDA KALSEL {{ Auth::guard('admin')->user()->id_tahun }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/profile/Default Picture Profile.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <style>
            body {
        height: auto;
    }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            font-weight: bold;
        }

        .ttd {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;

        }

        .tabelkolom {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelkolom tr th {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            border: 1px solid #131212;
            padding: 8px;
            font-size: 11px;
            background-color:rgb(165, 219, 255);
        }

        .tabelkolom tr td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            border: 1px solid #131212;
            padding: 5px;
            font-size: 10px;
        }

        .foto {
            width: 40px;
            height: 30px;

        }
    </style>

</head>
<body>
<br>
<table style="width: 100%">
        <tr>
            <td style="text-align: center;" colspan="7">
                <span id="title">
                      LAPORAN REALISASI PENERIMAAN RETRIBUSI DAEARAH <br> PEMERINTAH PROVINSI KALIMANTAN SELATAN <br> TAHUN ANGGARAN {{ Auth::guard('admin')->user()->id_tahun }}
                </span>
            </td>
        </tr>
    </table>
    <br>

    <table>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; height:30px;">SKPD/UPTD</td>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">: {{ strtoupper($agency->nama_agency) }}</td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">BULAN</td>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">: {{ strtoupper($filter->nama_bulan) }}</td>
    </tr>
    </table>

    @php
        $totalTarget = 0;
    @endphp
    <table class="tabelkolom" style="width: 100%; margin: auto;">
        <thead>
            <tr>
                <th style="color: black; text-align: center;" rowspan="2">KODE AKUN</th>
                <th style="color: black; text-align: center;" rowspan="2">JENIS / SUB / OBJEK / RINCIAN</th>
                <th style="color: black; text-align: center;" rowspan="2">TARGET</th>
                <th style="color: black; text-align: center;" rowspan="1" colspan="4">REALISASI</th>
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
            <td style="color: black;">Rp<?php echo number_format($d->pagu_realisasi ,0,',','.')?></td>
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
    <table width="100%" class="ttd" style="margin-top:100px;">
            <tr>
                <td style="text-align: center; width: 300px;" colspan="3"></td>
                <?php
                    function tgl_indo($tanggal){
                    	$bulan = array (
		            1 =>   'Januari',
		            'Februari',
		            'Maret',
		            'April',
		            'Mei',
		            'Juni',
		            'Juli',
		            'Agustus',
		            'September',
		            'Oktober',
		            'November',
		            'Desember'
	            );
	            $pecahkan = explode('-', $tanggal);

	            // variabel pecahkan 0 = tanggal
	            // variabel pecahkan 1 = bulan
	            // variabel pecahkan 2 = tahun

	        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
            } ?>
            <td style="text-align: center" colspan="3">Banjarbaru, <?php echo tgl_indo(date('Y-m-d')); ?></td>
            </tr>
            <tr>
                <td style="text-align: center;" colspan="3"></td>

                <td style="text-align: center" colspan="3">Mengetahui,</td>
            </tr>
            <tr>
                <td style="text-align: center;" colspan="3"></td>

                <td style="text-align: center;" colspan="3"><b>
                KEPALA BADAN PENDAPATAN DAERAH<br>PROVINSI KALIMANTAN SELATAN
            </b></td>

            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" colspan="3" height="100px"></td>
                <td style="text-align: center; vertical-align:bottom" colspan="3">
                <b><u>H. SUBHAN NOR YAUMIL, SE, M.Si</b></u><br>
                <span>NIP. 19710421 199803 1 009<span>
                </td>
            </tr>
        </table>
</body>
</html>
