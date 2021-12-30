<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use DateTime;
use Location;

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
                  ->select('md_pegawai.*')
                  ->orderBy('id','asc')
                  ->get();

        return view('pages.absen.daftarabsen', compact('data','absen','tanggal','pegawai'));
   	}

    public function getLocationbyIP(Request $request)
    {
        $ip = $request->ip(); /*Dynamic IP address */
        //$ip = '162.159.24.227'; /* Static IP address */
        $currentUserInfo = Location::get($ip);
          
        return view('pages.absen.location', compact('currentUserInfo'));
    }

    public function formabsen()
    {
        
        $username = Auth::user()->username;
        $tanggal = date("Y-m-d");

        $logg = DB::table('users')->where('username', '=', $username)->first();

        $absen = DB::select('select username AS nip, Cast(waktu_login as Date) as "tanggal", MIN(waktu_login) as "waktu_masuk", MAX(waktu_login) as "waktu_pulang" from td_login_history where username = "'.$username.'" and Date(waktu_login)="'.$tanggal.'" group by username, Cast(waktu_login as Date)');


        $result["nama"] = "-";
        $result["nip"] = "-";
        $result["waktu_masuk"] = "-";
        $result["waktu_pulang"] = "-";

        if(!empty($logg))
        {
            $result["nama"] = $logg->name;
            $result["nip"] = $logg->username;
        }

        $hari_ini=getNamaHariIni();
        $tglHari_ini = date("d-m-Y");
        $result["tanggal"] = $hari_ini.", ".$tglHari_ini;     

        if(!empty($absen))
        {
            $timestampmasuk = strtotime($absen[0]->waktu_masuk);
            $timestamppulang = strtotime($absen[0]->waktu_pulang);

            $result["waktu_masuk"] = date("H:i", $timestampmasuk);
            $result["waktu_pulang"] = date("H:i", $timestamppulang);
        }

        return view('pages.absen.form_absen', ['absen'=>$result]);
    }

    public function prosesabsen($radius, $radworkshop)
    {
       //dd($radius);

        if($radius <= 500.0 || $radworkshop <= 500.0)
        {
            $data = array(
                'username' => Auth::user()->username,
                'waktu_login' => Carbon::now()->toDateTimeString(),
                );

                $insertID = DB::table('td_login_history')->insertGetId($data);


            return Redirect::to('formabsen')->with('message', 'Absen berhasil');
        }
        else
        {

            return Redirect::to('formabsen')->with('message', 'Absen gagal. Anda tidak sedang berada di lokasi Kantor Baristand Industri Medan');
        }
    }
}
