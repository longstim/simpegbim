<html>
<head>
<title>Nota Dinas Lembur</title>
  <style type="text/css">
      td {font-family:"arial"; font-size:11pt}
      th {font-family:"arial"; font-weight:bold; font-size:11pt}
      a {text-decoration:none;}
      a:hover {color:red}
      textarea {font-family:"arial"; font-size:9pt}
      input {font-family:"arial"; font-size:9pt}
  </style>
  <link REL="shortcut icon" HREF="/favicon.ico" TYPE="image/x-icon">
</head>

<body bgcolor="white"> <!--onload="window.print()">-->
<font face="arial">
<center>
   <table border="0" width="650" cellpadding="1" cellspacing="0" id="kopsurat">
      <tr>
        <td rowspan="5" cellpadding="4" ><img src="{{asset('image/logokemenperin.png')}}" width="180px"></td>
        <td align="center" style="font-size:10pt">BADAN STANDARDISASI DAN KEBIJAKAN JASA INDUSTRI</td>
      </tr>
      <tr valign="top">
          <td align="center" style="font-size:10.5pt"><b>BALAI STANDARDISASI DAN PELAYANAN JASA INDUSTRI MEDAN</b></td>
      </tr>
      <tr valign="top">
          <td align="center" style="font-size:9pt">Jl. Sisingamangaraja No. 24, Telp. (061) 7363471, 7365379, Fax. (061) 7362830</td>
      </tr>
      <tr valign="top">
          <td align="center" style="font-size:9pt">Email : bind_medan@kemenperin.go.id</td>
      </tr>
      <tr valign="top">
        <td align="center" style="font-size:12pt"><b>MEDAN – 20217</b></td>
      </tr>
  </table>
  <hr style="border:2px solid black;color:black;background-color:black;" width="750">
  <hr style="border:1px solid black;color:black;background-color:black; margin-top:-6px;" width="750" >
  <table border=0 width="650">
    <tr>
      <br>
      <td align="center"><b style="font-size:13pt"><u>SURAT TUGAS</u></b><br>
        Nomor : {{$stheader->no_surat}}<br>
      </td>
    </tr>

    <tr>
      <td>
      <br>
        <div align="justify" style="line-height: 1.5 ;">&nbsp; &nbsp; &nbsp; Dalam rangka mengikuti {{$stheader->nama_tugas}} secara {{$stheader->metode}} yang diselenggarakan oleh {{$stheader->penyelenggara}}, dengan ini kami menugaskan pejabat/staf yang namanya tercantum di bawah ini untuk melaksanakan tugas dimaksud pada tanggal {{formatTanggalIndonesia($stheader->tanggal_tugas_awal)}} @if($stheader->tanggal_tugas_awal != $stheader->tanggal_tugas_akhir) s/d {{formatTanggalIndonesia($stheader->tanggal_tugas_akhir)}} @endif : <br><br>
        </div>

        <table style="border:1px solid black; border-collapse: collapse;" width="100%" cellpadding="5" cellspacing=0>
          <thead>
            <tr align="center">
              <th width="5%" style="border:1px solid black;"><b>No.</b></th>
              <th width="25%" style="border:1px solid black;"><b>Nama</b></th>
              <th width="20%" style="border:1px solid black;"><b>NIP</b></th>
              <th width="10%" style="border:1px solid black;"><b>Gol</b></th>
              <th width="55%" style="border:1px solid black;"><b>Jabatan</b></th>
            </tr>
          </thead>
          @php
          $no = 0
          @endphp
          @foreach($stdetail as $data)
          <tr valign="top">
              <td align="center" style="border:1px solid black;">{{++$no}}</td>
              <td style="border:1px solid black;">{{$data->nama}}</td>
              <td align="center" style="border:1px solid black;">{{$data->nip}}</td>
              <td align="center" style="border:1px solid black;">{{$data->gol}}</td>
              <td style="border:1px solid black;">{{$data->jabatan}} {{($data->jenis_jabatan == 'Fungsional Tertentu') ? $data->jenjang_jabatan : ''}}</td>
          </tr>
          @endforeach
        </table>
        <br>

        <div align="justify">&nbsp; &nbsp; &nbsp; Demikian Surat Tugas ini dibuat agar dilaksanakan dengan baik dan penuh tanggung jawab.<br><br>
        </div>

        <table border=0 width="100%">
          <tr>
            <br>
            <td width="60%"></td>
            <td align="center">
              Medan, {{formatTanggalIndonesia($stheader->tanggal_surat)}}<br><br/>
              {{$stheader->jabatan_penandatangan}}<br/>
              <br><br><br><br>
              {{$stheader->nama_penandatangan}}
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</center>
</font>

</body>
</html>
