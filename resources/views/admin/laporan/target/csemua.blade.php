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
                      TARGET PENERIMAAN RETRIBUSI DAEARAH <br> PEMERINTAH PROVINSI KALIMANTAN SELATAN <br> TAHUN ANGGARAN {{ Auth::guard('admin')->user()->id_tahun }}
                </span>
            </td>
        </tr>
    </table>
    <br>

    @php
        $totalTarget = 0;
        $totalPtarget = 0;
    @endphp
    <table class="tabelkolom">
    <tr>
        <th style="color: black; text-align: center; width: 25px" rowspan="2">NO</th>
        <th style="color: black; text-align: center; width: 320px" rowspan="2">NAMA SKPD / UPTD</th>
        <th style="color: black; text-align: center;" rowspan="1" colspan="2">TARGET PENERIMAAN</th>
        <th style="color: black; text-align: center; width: 100px" rowspan="2">KETERANGAN</th>
    </tr>
    <tr>
        <th style="color: black; text-align: center; width: 90px" rowspan="1">APBD</th>
        <th style="color: black; text-align: center; width: 90px" rowspan="1">APBD PERUBAHAN</th>
    </tr>
   @foreach ($view as $d)
    <tr>
        <td style="text-align:center;">{{ $loop->iteration }}</td>
        <td>{{$d->nama_agency}}</td>
        @php
            $targetData = $target->where('id_agency', $d->id_agency)->first();
        @endphp
        @if ($targetData)
            <td>Rp{{ number_format($targetData->pagu_target, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($targetData->pagu_ptarget, 0, ',', '.') }}</td>
            @php
                $totalTarget += $targetData->pagu_target;
                $totalPtarget += $targetData->pagu_ptarget;
            @endphp
            <td>Rp {{ number_format($targetData->pagu_ptarget-$targetData->pagu_target, 0, ',', '.') }}</td>
        @else
            <td>Rp-</td>
            <td>Rp-</td>
            <td></td>
        @endif
    </tr>
@endforeach
    <tfoot>
        <tr>
            <th colspan="2" style="text-align:center; color:black;" >TOTAL</th>
            <th style="text-align:center; color:black;" >Rp {{ number_format($totalTarget, 0, ',', '.') }}</th>
            <th style="text-align:center; color:black;" >Rp {{ number_format($totalPtarget, 0, ',', '.') }}</th>
            <th style="text-align:center; color:black;" >Rp {{ number_format($totalPtarget-$totalTarget, 0, ',', '.') }}</th>
        </tr>
    </tfoot>
    </table>
    <table width="100%" class="ttd" style="margin-top:100px;">
            <tr>
                <td style="text-align: center;" width="700px" colspan="4" ></td>
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
            <td style="text-align: center" colspan="4">Banjarbaru, <?php echo tgl_indo(date('Y-m-d')); ?></td>
            </tr>
            <tr>
                <td style="text-align: center" colspan="4"></td>

                <td style="text-align: center" colspan="4">Mengetahui,</td>
            </tr>
            <tr>
                <td style="text-align: center" colspan="4"></td>

                <td style="text-align: center;" colspan="4"><b>
                KEPALA BADAN PENDAPATAN DAERAH PROVINSI KALIMANTAN SELATAN
            </b></td>

            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100px" colspan="4"></td>
                <td style="text-align: center; vertical-align:bottom" colspan="4">
                <b><u>H. SUBHAN NOR YAUMIL, SE, M.Si</b></u><br>
                <span>NIP. 19710421 199803 1 009<span>
                </td>
            </tr>
        </table>
</body>
</html>
