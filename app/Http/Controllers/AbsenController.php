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
use DateInterval;
use DatePeriod;

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

        $username = Auth::user()->username;
        $role = Auth::user()->role;

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

        if($role == "admin")
        {  

            $absen = DB::select('select username, Cast(waktu_login as Date) as "tanggal", MIN(waktu_login) as "waktu_masuk", MAX(waktu_login) as "waktu_pulang" from td_login_history where Month(waktu_login)="'.$bulan.'" and Year(waktu_login)="'.$tahun.'" group by username, Cast(waktu_login as Date)');  
        }
        else
        {
            $absen = DB::select('select username, Cast(waktu_login as Date) as "tanggal", MIN(waktu_login) as "waktu_masuk", MAX(waktu_login) as "waktu_pulang" from td_login_history where username = "'.$username.'" and Month(waktu_login)="'.$bulan.'" and Year(waktu_login)="'.$tahun.'" group by username, Cast(waktu_login as Date)');
        }

        $daftartidakmasukkerja = DB::select('select * from td_status_tidakmasukkerja where Month(tanggal_absen)="'.$bulan.'" and Year(tanggal_absen)="'.$tahun.'"'); 

        $tanggal[]="";

        $hari = cal_days_in_month($kalender, $bulan, $tahun);
  
        for($i=0;$i<$hari;$i++)
        {
            $tanggal[$i] = $i+1;
        }

        $i=0;

        $dateObj = DateTime::createFromFormat('!m', $bulan);  
        $monthName = $dateObj->format('F');

        $data = [
          'bulan'  => $monthName." ".$tahun,
        ];

      	
        if($role == "admin")
        {
            if($request->input('jenispegawai')=="PNS")
            {
                $pegawai=DB::table('md_pegawai')
                  ->where('jenis_pegawai', '=', 'PNS')
                  ->orWhere('jenis_pegawai', '=', 'CPNS')
                  ->select('md_pegawai.*')
                  ->orderBy('nama','asc')
                  ->get();
            }
            else
            {
                $pegawai=DB::table('md_pegawai')
                  ->where('jenis_pegawai', '=', 'PPNPN')
                  ->select('md_pegawai.*')
                  ->orderBy('nama','asc')
                  ->get();
            }

        }
        else
        {
            $pegawai=DB::table('md_pegawai')
                  ->where('nip', '=', $username)
                  ->select('md_pegawai.*')
                  ->orderBy('id','asc')
                  ->get();
        }

        return view('pages.absen.daftarabsen', compact('data','absen', 'daftartidakmasukkerja', 'tanggal','pegawai'));
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

    public function prosesabsen($radius, $radworkshop, $radlogam)
    {
       //dd($radius);

        if($radius <= 500.0 || $radworkshop <= 500.0 || $radlogam <= 1000.0)
        {
            $ipAddr=\Request::ip();
            $macAddr = substr(exec('getmac'), 0, 17);

            $data = array(
                'username' => Auth::user()->username,
                'waktu_login' => Carbon::now()->toDateTimeString(),
                'ip_address' => $ipAddr,
                'mac_address' => $macAddr,
                );

                $insertID = DB::table('td_login_history')->insertGetId($data);


            return Redirect::to('formabsen')->with('message', 'Absen berhasil');
        }
        else
        {

            return Redirect::to('formabsen')->with('message', 'Absen gagal. Anda berada di luar jangkauan/radius untuk absensi Baristand Industri Medan');
        }
    }

    public function inputabsenseries()
    {
        $pegawai=DB::table('md_pegawai')->get();

        return view('pages.absen.form_inputabsenseries',compact('pegawai'));
    }

    public function prosesabsenseries(Request $request)
    {

        $tanggalMulai = $request->input('tanggal_mulai');
        $newTanggalMulai = Carbon::createFromFormat('d/m/Y', $tanggalMulai)->format('Y-m-d');
        $pdTanggalMulai = new DateTime($newTanggalMulai);

        $tanggalSelesai= $request->input('tanggal_selesai');
        $newTanggalSelesai = Carbon::createFromFormat('d/m/Y', $tanggalSelesai)->format('Y-m-d');
        $pdTanggalSelesai = new DateTime($newTanggalSelesai);
        $pdTanggalSelesai->modify('+1 day');

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($pdTanggalMulai, $interval, $pdTanggalSelesai);

        foreach ($period as $dt=>$value) 
        {  
            $data = array
            (
                'username' => $request->input('nama'),
                'tanggal_absen' => $value->format('Y-m-d'),
                'status' => $request->input('status'),
                'keterangan' => $request->input('keterangan'),
            );

            $insertID = DB::table('td_status_tidakmasukkerja')->insertGetId($data);
        }

        return Redirect::back()->with('message','Berhasil menyimpan data');
    }

    public function tampildaftarabsenpegawai(Request $request)
    {
        $pegawai=DB::table('md_pegawai')->get();

        return view('pages.absen.pilihabsenpegawai',compact('pegawai'));
    }

    public function prosesdaftarabsenpegawai(Request $request)
    {
        setlocale(LC_ALL, 'IND');
        //$bulan  = Carbon::parse(now())->formatLocalized('%B %Y');

        $bulanVal = $request->input('bulan');
        $tahunVal = $request->input('tahun');
       
        $username = $request->input('username');

      
        if($username=="")
        {
            $username=Auth::user()->username;
        }

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

        $absen = DB::select('select username, Cast(waktu_login as Date) as "tanggal", MIN(waktu_login) as "waktu_masuk", MAX(waktu_login) as "waktu_pulang" from td_login_history where username = "'.$username.'" and Month(waktu_login)="'.$bulan.'" and Year(waktu_login)="'.$tahun.'" group by username, Cast(waktu_login as Date)');
   

        $daftartidakmasukkerja = DB::select('select * from td_status_tidakmasukkerja where username ="'.$username.'" and Month(tanggal_absen)="'.$bulan.'" and Year(tanggal_absen)="'.$tahun.'"'); 

        $tanggal[]="";

        $hari = cal_days_in_month($kalender, $bulan, $tahun);
  
        for($i=0;$i<$hari;$i++)
        {
            $tanggal[$i] = $i+1;
        }

        $pegawai=DB::table('md_pegawai')
                  ->where('nip', '=', $username)
                  ->select('md_pegawai.*')
                  ->orderBy('id','asc')
                  ->get();

        $dateObj = DateTime::createFromFormat('!m', $bulan);  
        $monthName = $dateObj->format('F');

        $data = [
          'bulan'  => $monthName." ".$tahun,
        ];

        return view('pages.absen.daftarabsen', compact('data','absen', 'daftartidakmasukkerja', 'tanggal','pegawai'));
    }

}
