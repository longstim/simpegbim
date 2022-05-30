
<HTML>
<HEAD>
<TITLE></TITLE>
<style type="text/css">
	td {font-size:9pt; font-family:"Arial"}
	td.h {background-color:#99CCFF; font-weight:bold}
	td {font-family:"arial"; font-size:12px}
	th {font-family:"arial"; font-weight:bold; font-size:12px}
	a {text-decoration:none;}
	a:hover {color:red}
	textarea {font-family:"arial"; font-size:9pt}
	input {font-family:"arial"; font-size:9pt}
</style>
<link REL="shortcut icon" HREF="/favicon.ico" TYPE="image/x-icon">
</HEAD>

<body bgcolor="white">
	<font face="arial">
	<font size=3 >
		<center>
		<h3>
			<b>Daftar Absen Pegawai Balai Riset dan Standardisasi Industri Medan<br>
			Bulan {{$data['bulan']}} 
		</h3>
	</font> 
	<table border=1 cellpadding=2 cellspacing=0>
		<tr align=center>
			<td class="h" rowspan="2">No</td>
			<td class="h" rowspan="2" width=150>NIP</td>
			<td class="h" rowspan="2" width=250>NAMA</td>
			<td class="h" rowspan="2" width=50>Ket</td>
			<td colspan=31 class="h">Tanggal</td>
		</tr>
		<tr>
			@php
          	$i = 0
          	@endphp
			@foreach($tanggal as $data)
				<td class="h" align="center">{{$tanggal[$i++]}}</td>
			@endforeach
		</tr>
		@php
        $no = 0
        @endphp
		@foreach($pegawai as $data)
			<tr>
				<td rowspan="2" align="center">{{++$no}}</td>
				<td rowspan="2" align="center">{{$data->nip}}</td>
				<td rowspan="2">{{$data->nama}}</td>
				<td align="center"><b>M</b></td>
			
				@php
	          	$i = 0;
				foreach($tanggal as $tgl)
				{					
		          	$jamMasuk ="";

					foreach($absen as $abs)
					{

						$tanggalabsen = strtotime($abs->tanggal);
						$newTglMasuk = date("j", $tanggalabsen);

						$timestamp = strtotime($abs->waktu_masuk);

						if($data->nip==$abs->username AND $tanggal[$i]==$newTglMasuk)
						{
							$jamMasuk = date("H:i", $timestamp);
						}
					}


					foreach($daftartidakmasukkerja as $tmk)
		            {
		            	$tanggaltmk= strtotime($tmk->tanggal_absen);
						$newTglTMK= date("j", $tanggaltmk);

						if($data->nip==$tmk->username AND $tanggal[$i]==$newTglTMK)
						{
							$jamMasuk = $tmk->status;
						}
		            }

					if(empty($jamMasuk))
					{
					@endphp
						<td align="center">-</td>
					@php
					}
					else
					{
					@endphp
						<td align="center">{{$jamMasuk}}</td>
					@php
					}
					$i++;
				}
			@endphp
			</tr>
			<tr>
				<td align="center"><b>P</b></td>
				
				@php
	          	$i = 0;
	          	@endphp
				@foreach($tanggal as $tgl)
					@php
		          	$jamPulang ="";
		          	@endphp
					@foreach($absen as $abs)
						@php
							
							$tanggalabsen = strtotime($abs->tanggal);
							$newTglPulang = date("j", $tanggalabsen);

							$timestamp = strtotime($abs->waktu_pulang);

							if($data->nip==$abs->username AND $tanggal[$i]==$newTglPulang)
							{
								$jamPulang = date("H:i", $timestamp);
							}
						@endphp
					@endforeach
					@php
					if(empty($jamPulang))
					{
					@endphp
						<td align="center">-</td>
					@php
					}
					else
					{
					@endphp
						<td align="center">{{$jamPulang}}</td>
					@php
					}
					$i++;
					@endphp
				@endforeach		
			</tr>

		@endforeach
			
	</table>