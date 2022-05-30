
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
			<b>Daftar Pelatihan Pegawai {{getNamaUNOR()}}<br>
		</h3>
	</font> 
	<table border=1 cellpadding=2 cellspacing=0>
		<tr align=center>
			<td class="h">No</td>
			<td class="h" width=150>Nama</td>
			<td class="h" width=100>NIP</td>
			<td class="h" width=250>Nama Tugas</td>
			<td class="h" width=100>Jenis Tugas</td>
			<td class="h" width=250>Penyelenggara</td>
			<td class="h" width=150>Tanggal</td>
		</tr>
		@php
        $no = 0;
        $temp_nip = "";
        @endphp
		@foreach($pelatihan as $data)
			<tr>
				@php
        		  if($data->nip == $temp_nip)
        		  {
        		@endphp
        				<td border=0></td>
        				<td border=0></td>
        				<td border=0></td>
        		@php
        		  }
        		  else
        		  {
        		@endphp		
        				<td align="center">{{++$no}}</td>
        		  		<td>{{$data->nama_pegawai}}</td>
						<td>{{$data->nip}}</td>
				@php
        		  }
        		@endphp

				<td>{{$data->nama_tugas}}</td>
				<td>{{$data->jenis_tugas}}</td>
				<td>{{$data->penyelenggara}}</td>
				<td>{{formatTanggalIndonesia($data->tanggal_tugas_awal)}} @if($data->tanggal_tugas_awal != $data->tanggal_tugas_akhir) s/d {{formatTanggalIndonesia($data->tanggal_tugas_akhir)}} @endif</td>
			</tr>
			@php
    			$temp_nip = $data->nip;
        	@endphp	
		@endforeach
	</table>