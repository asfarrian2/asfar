<!DOCTYPE html>
<html>
<head>
    <title>SI-RETDA KALSEL {{ Auth::guard('operator')->user()->id_tahun }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/profile/Default Picture Profile.png') }}" />
    <style>
            body {
        height: auto;
    }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
        }

        .tabeldatakaryawan tr td {
            padding: 5px;
        }

        .tabelrealisasi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelrealisasi tr th {
            border: 1px solid #131212;
            padding: 8px;
            font-size: 11px;
            background-color:rgb(165, 219, 255);
        }

        .tabelrealisasi tr td {
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
<table style="width: 100%">
        <tr>
            <td style="text-align: center;" colspan="10">
                <span id="title">
                      LAPORAN EVALUASI PENERIMAAN RETRIBUSI DAEARAH <br> TAHUN ANGGARAN 2025 <br> {{ strtoupper($triwulan->nama_triwulan) }}
                </span>
            </td>
        </tr>
    </table>
    <br><br>

<table>
        <tr>
            <td>
                Unit Kerja
            </td>
            <td>
                :
            </td>
            <td>
                {{ $agency->nama_agency }}
            </td>
        </tr>
</table>
    <table class="tabelrealisasi">
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
                <td style="color: black;">{{$d->persen_realisasi}}%</td>
            @endforeach
            @endforeach
            @endforeach
            @endforeach
            </tr>
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
                    <th style="text-align:center; color:black;"><?php echo round(($total_sekarang / $jumlah) * 100, 2); ?>%</th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td style="text-align:right" colspan="3">Faktor Pendukung :</td>
                    @if ($evaluasi ==! NULL)
                    <td colspan="7">{{ $evaluasi->fpendukung }}</td>
                    @else
                    <td colspan="7"></td>
                    @endif
                </tr>
                <tr>
                    <td style="text-align:right" colspan="3">Faktor Penghambat :</td>
                     @if ($evaluasi ==! NULL)
                    <td colspan="7">{{ $evaluasi->fpenghambat }}</td>
                    @else
                    <td colspan="7"></td>
                    @endif
                </tr>
                <tr>
                    <td style="text-align:right" colspan="3">Tindak Lanjut :</td>
                     @if ($evaluasi ==! NULL)
                    <td colspan="7">{{ $evaluasi->tindaklanjut }}</td>
                    @else
                    <td colspan="7"></td>
                    @endif
                </tr>
            </tbody>
    </table>
    <table width="100%" style="margin-top:100px;">
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
            <td style="text-align: center" colspan="3">Pelaihari, <?php echo tgl_indo(date('Y-m-d')); ?></td>
            </tr>
            <tr>
                <td style="text-align: center" colspan="4"></td>

                <td style="text-align: center" colspan="3">Mengetahui,</td>
            </tr>
            <tr>
                <td style="text-align: center" colspan="4"></td>

                <td style="text-align: center;" colspan="3"><b>
                KEPALA {{ strtoupper($agency->nama_agency)}}
            </b></td>

            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100px" colspan="4"></td>
                <td style="text-align: center; vertical-align:bottom" colspan="3">
                <b><u>{{ $agency->kepala_agency }}</b></u><br>
                <span>NIP. {{ $agency->nip_agency }}<span>
                </td>
            </tr>
        </table>
</body>
</html>
