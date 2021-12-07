<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use DateTime;

class AbsenController extends Controller
{
    public function __construct()
  	{
        $this->middleware('auth');
  	}

    public function pilihabsen()
    {
        return view('pages.absen.pilihabsen');
    }

  	public function daftarabsen(Request $request)
   	{
        setlocale(LC_ALL, 'IND');
	    //$bulan  = Carbon::parse(now())->formatLocalized('%B %Y');

        $bulanVal = $request->input('bulan');
        $tahunVal = $request->input('tahun');

        $kalender = CAL_GREGORIAN;

        if(empty($bulanVal) || empty($tahunVal))
        {
            $bulan = date('m');
            $tahun = date('Y');
        }
        else
        {
            $bulan = $bulanVal;
            $tahun = $tahunVal;
        }

        $hari = cal_days_in_month($kalender, $bulan, $tahun);

      	$absen = DB::select('select username, Cast(waktu_login as Date) as "tanggal", MIN(waktu_login) as "waktu_masuk", MAX(waktu_login) as "waktu_pulang" from td_login_history where Month(waktu_login)="'.$bulan.'" and Year(waktu_login)="'.$tahun.'" group by username, Cast(waktu_login as Date)');

        $dateObj = DateTime::createFromFormat('!m', $bulan);  
        $monthName = $dateObj->format('F');

        $data = [
          'bulan'  => $monthName." ".$tahun,
        ];



      	$tanggal[]="";
  
      	for($i=0;$i<$hari;$i++)
      	{
      		$tanggal[$i] = $i+1;
      	}

      	$pegawai=DB::table('md_pegawai')
                  ->where('jenis_pegawai','=','PPNPN')
                  ->select('md_pegawai.*')
                  ->orderBy('id','asc')
                  ->get();

        return view('pages.absen.daftarabsen', compact('data','absen','tanggal','pegawai'));
   	}
}
