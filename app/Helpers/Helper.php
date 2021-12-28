<?php
   
	function customTanggal($date,$date_format)
	{
	    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
	}
	    
	function hitungUangLembur(int $jam_lembur, string $tanggal_lembur, string $gol)
    {
        $uanglembur = 0;

        $tanggal = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggal_lembur)->format('w'); 

        $datalibur = DB::table('md_hari_libur')->where('tanggal','LIKE', $tanggal_lembur)->get();

        //dd($datalibur->count());

        if($gol=='I/a' || $gol=='I/b' || $gol=='I/c' || $gol=='I/d')
        {	
            $uanglembur = $jam_lembur * 13000;

            if($tanggal == '0' || $tanggal == '6' || $datalibur->count()>0)
            {   
                $uanglembur = $uanglembur * 2;
            }
        	
        	if($jam_lembur>=2)
        	{
        		$uanglembur = $uanglembur + 35000;
        	}
        }
        else if($gol=='II/a' || $gol=='II/b' || $gol=='II/c' || $gol=='II/d')
        {
            $uanglembur = $jam_lembur * 17000;

            if($tanggal == '0' || $tanggal == '6' || $datalibur->count()>0)
            {
                $uanglembur = $uanglembur * 2;
            }

            if($jam_lembur>=2)
        	{
        		$uanglembur = $uanglembur + 35000;
        	}
        }
        else if($gol=='III/a' || $gol=='III/b' || $gol=='III/c' || $gol=='III/d')
        {
            $uanglembur = $jam_lembur * 20000;

            if($tanggal == '0' || $tanggal == '6' || $datalibur->count()>0)
            {
                $uanglembur = $uanglembur * 2;
            }

            if($jam_lembur>=2)
        	{
        		$uanglembur = $uanglembur + 37000;
        	}
        }
        else if($gol=='IV/a' || $gol=='IV/b' || $gol=='IV/c' || $gol=='IV/d' ||  $gol=='IV/e')
        {
            $uanglembur = $jam_lembur * 25000;

            if($tanggal == '0' || $tanggal == '6' || $datalibur->count()>0)
            {
                $uanglembur = $uanglembur * 2;
            }

            if($jam_lembur>=2)
        	{
        		$uanglembur = $uanglembur + 41000;
        	}
        }

        return $uanglembur;
    }

    function formatRupiah($angka)
    { 
    	$hasil = "Rp ".number_format($angka,0, ',' , '.'); 

    	return $hasil; 
	}

    function getJamLembur($id_detail, $tanggal)
    {

        $datajamlembur = DB::table('td_lembur_detail_jam')
              ->where([
                          ['id_detail', '=', $id_detail],
                          ['tanggal_lembur', '=', $tanggal],
                      ])
              ->first();


        return $datajamlembur;
    }

    function getNamaHariIni()
    {

        $hari = date ("D");

        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;

            case 'Mon':         
                $hari_ini = "Senin";
            break;

            case 'Tue':
                $hari_ini = "Selasa";
            break;

            case 'Wed':
                $hari_ini = "Rabu";
            break;

            case 'Thu':
                $hari_ini = "Kamis";
            break;

            case 'Fri':
                $hari_ini = "Jumat";
            break;

            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";     
            break;
        }

        return $hari_ini;
    }
?>
