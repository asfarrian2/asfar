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
            <td style="text-align: center;" colspan="10">
                <span id="title">
                      LAPORAN REALISASI PENERIMAAN RETRIBUSI DAEARAH <br> PEMERINTAH PROVINSI KALIMANTAN SELATAN <br> TAHUN ANGGARAN {{ Auth::guard('admin')->user()->id_tahun }}
                </span>
            </td>
        </tr>
    </table>
    <br>

    <table style="width: 100%; margin: auto;">
    <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">BULAN: {{ strtoupper($pilih_bulan->nama_bulan) }}</td>
    </table>

    @php
        $totalTarget = 0;
    @endphp
    <table class="tabelkolom" style="width: 100%; margin: auto;">
        <thead>
            <tr>
                <th style="color: black; text-align: center;" rowspan="2">NO</th>
                <th style="color: black; text-align: center;" rowspan="2">DINAS / UPTD</th>
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
            @foreach ($target as $d)
            <tr>
                <td style="color: black; text-align:center;">{{ $loop->iteration }}</td>
                <td style="color: black;">{{ $d->nama_agency }}</td>
                @if ($pilih_bulan->tipe_bulan == 1)
                <td style="color: black;">Rp{{ number_format($d->pagu_target, 0, ',', '.') }}</td>
                @else
                <td style="color: black;">Rp{{ number_format($d->pagu_ptarget, 0, ',', '.') }}</td>
                @endif
                <td style="color: black;">Rp{{ number_format($realisasi_sebelumnya[$d->id_target], 0, ',', '.') }}</td>
                @if ($realisasi_bulan[$d->id_target] ==! NULL)
                <td style="color: black;">Rp{{ number_format($realisasi_bulan[$d->id_target], 0, ',', '.') }}</td>
                @else
                <td style="color: red;">Tidak Ada Laporan</td>
                @endif
                <td style="color: black;">Rp{{ number_format($realisasi_sekarang[$d->id_target], 0, ',', '.') }}</td>
                @if ($pilih_bulan->tipe_bulan == 1)
                <td style="color: black;">{{ number_format($realisasi_sekarang[$d->id_target] / $d->pagu_target * 100, 2) }}%</td>
                @else
                <td style="color: black;">{{ number_format($realisasi_sekarang[$d->id_target] / $d->pagu_ptarget * 100, 2) }}%</td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th style="color:black; text-align:center;" colspan="2">JUMLAH</th>
                @if ($pilih_bulan->tipe_bulan == 1)
                <th style="color: black;">Rp{{ number_format($target->sum('pagu_target'), 0, ',', '.') }}</th>
                @else
                <th style="color: black;">Rp{{ number_format($target->sum('pagu_ptarget'), 0, ',', '.') }}</th>
                @endif
                @php
                $sum_bulan = array_sum($realisasi_bulan);
                $sum_sebelumnya = array_sum($realisasi_sebelumnya);
                $sum_sekarang = array_sum($realisasi_sekarang);
                @endphp
                <th style="color: black;">Rp{{ number_format($sum_sebelumnya, 0, ',', '.') }}</th>
                <th style="color: black;">Rp{{ number_format($sum_bulan, 0, ',', '.') }}</th>
                <th style="color: black;">Rp{{ number_format($sum_sekarang, 0, ',', '.') }}</th>
                @if ($pilih_bulan->tipe_bulan == 1)
                <th style="color: black;">{{ number_format($sum_sekarang / $target->sum('pagu_target') * 100, 2)}}%</th>
                @else
                <th style="color: black;">{{ number_format($sum_sekarang / $target->sum('pagu_ptarget') * 100, 2)}}%</th>
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
            <td style="text-align: center">Banjarbaru, <?php echo tgl_indo(date('Y-m-d')); ?></td>
            </tr>
            <tr>
                <td style="text-align: center;" colspan="3"></td>

                <td style="text-align: center">Mengetahui,</td>
            </tr>
            <tr>
                <td style="text-align: center;" colspan="3"></td>

                <td style="text-align: center;"><b>
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
