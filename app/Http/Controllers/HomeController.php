<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jlhpegawai = DB::table('md_pegawai')
                        ->where('status','=','aktif')
                        ->count();

        $jlhpns = DB::table('md_pegawai')
                        ->where('jenis_pegawai','=','pns')
                        ->where('status','=','aktif')
                        ->count();

        $jlhcpns = DB::table('md_pegawai')
                    ->where('jenis_pegawai','=','cpns')
                    ->where('status','=','aktif')
                    ->count();

        $jlhppnpn = DB::table('md_pegawai')
                    ->where('jenis_pegawai','=','ppnpn')
                    ->where('status','=','aktif')
                    ->count();

        $data = [
          'jlhpegawai' => $jlhpegawai,
          'jlhpns' => $jlhpns,
          'jlhcpns' => $jlhcpns,
          'jlhppnpn' => $jlhppnpn,
        ];

        //Jumlah Golongan
        $gol1 = DB::table('td_pangkat_pegawai')
                    ->where('t2.status', '=', 'aktif')
                    ->Where(function($query) {
                        $query->where('t1.golongan', '=', 'I/a')
                            ->orwhere('t1.golongan', '=', 'I/b')
                            ->orwhere('t1.golongan', '=', 'I/c')
                            ->orwhere('t1.golongan', '=', 'I/d');
                    })
                    ->leftjoin('md_pangkat AS t1', 'td_pangkat_pegawai.id_pangkat', '=', 't1.id')
                    ->leftjoin('md_pegawai AS t2', 'td_pangkat_pegawai.id_pegawai', '=', 't2.id')
                    ->count();

        $gol2 = DB::table('td_pangkat_pegawai')
                    ->where('t2.status', '=', 'aktif')
                    ->Where(function($query) {
                        $query->where('t1.golongan', '=', 'II/a')
                            ->orwhere('t1.golongan', '=', 'II/b')
                            ->orwhere('t1.golongan', '=', 'II/c')
                            ->orwhere('t1.golongan', '=', 'II/d');
                    })
                    ->leftjoin('md_pangkat AS t1', 'td_pangkat_pegawai.id_pangkat', '=', 't1.id')
                    ->leftjoin('md_pegawai AS t2', 'td_pangkat_pegawai.id_pegawai', '=', 't2.id')
                    ->count();

        $gol3 = DB::table('td_pangkat_pegawai')
                    ->where('t2.status', '=', 'aktif')
                    ->Where(function($query) {
                        $query->where('t1.golongan', '=', 'III/a')
                            ->orwhere('t1.golongan', '=', 'III/b')
                            ->orwhere('t1.golongan', '=', 'III/c')
                            ->orwhere('t1.golongan', '=', 'III/d');
                    })
                    ->leftjoin('md_pangkat AS t1', 'td_pangkat_pegawai.id_pangkat', '=', 't1.id')
                    ->leftjoin('md_pegawai AS t2', 'td_pangkat_pegawai.id_pegawai', '=', 't2.id')
                    ->count();

        $gol4 = DB::table('td_pangkat_pegawai')
                    ->where('t2.status', '=', 'aktif')
                    ->where(function($query) {
                        $query->where('t1.golongan', '=', 'IV/a')
                            ->orwhere('t1.golongan', '=', 'IV/b')
                            ->orwhere('t1.golongan', '=', 'IV/c')
                            ->orwhere('t1.golongan', '=', 'IV/d')
                            ->orwhere('t1.golongan', '=', 'IV/e');
                    })
                    ->leftjoin('md_pangkat AS t1', 'td_pangkat_pegawai.id_pangkat', '=', 't1.id')
                    ->leftjoin('md_pegawai AS t2', 'td_pangkat_pegawai.id_pegawai', '=', 't2.id')
                    ->count();

        $datagol = [
              'gol1' => $gol1,
              'gol2' => $gol2,
              'gol3' => $gol3,
              'gol4' => $gol4,
        ];


        $lk = DB::table('md_pegawai')
                ->where('status', '=', 'aktif')
                ->where('jenis_kelamin', '=', 'Laki-laki')
                ->where(function($query) {
                    $query->where('jenis_pegawai', '=', 'PNS')
                        ->orwhere('jenis_pegawai', '=', 'CPNS');
                })
                ->count();

        $pr = DB::table('md_pegawai')
                ->where('status', '=', 'aktif')
                ->where('jenis_kelamin', '=', 'Perempuan')
                ->where(function($query) {
                    $query->where('jenis_pegawai', '=', 'PNS')
                        ->orwhere('jenis_pegawai', '=', 'CPNS');
                })
                ->count();

        $datajk = [
              'lk' => $lk,
              'pr' => $pr,
        ];


        $struktural = DB::table('td_jabatan_pegawai')
                ->where('t3.status', '=', 'aktif')
                ->where('t2.jenis_jabatan', '=', 'Struktural')
                ->where(function($query) {
                    $query->where('jenis_pegawai', '=', 'PNS')
                        ->orwhere('jenis_pegawai', '=', 'CPNS');
                })
                ->leftjoin('md_jabatan AS t1', 'td_jabatan_pegawai.id_jabatan', '=', 't1.id')
                ->leftjoin('md_jenis_jabatan AS t2', 't1.jenis_jabatan', '=', 't2.id')
                ->leftjoin('md_pegawai AS t3', 'td_jabatan_pegawai.id_pegawai', '=', 't3.id')
                ->count();

        $fungsional = DB::table('td_jabatan_pegawai')
                 ->where('t3.status', '=', 'aktif')
                ->where('t2.jenis_jabatan', '=', 'Fungsional Tertentu')
                ->where(function($query) {
                    $query->where('jenis_pegawai', '=', 'PNS')
                        ->orwhere('jenis_pegawai', '=', 'CPNS');
                })
                ->leftjoin('md_jabatan AS t1', 'td_jabatan_pegawai.id_jabatan', '=', 't1.id')
                ->leftjoin('md_jenis_jabatan AS t2', 't1.jenis_jabatan', '=', 't2.id')
                ->leftjoin('md_pegawai AS t3', 'td_jabatan_pegawai.id_pegawai', '=', 't3.id')
                ->count();

        $pelaksana = DB::table('td_jabatan_pegawai')
                ->where('t3.status', '=', 'aktif')
                ->where('t2.jenis_jabatan', '=', 'Fungsional Umum')
                ->where(function($query) {
                    $query->where('jenis_pegawai', '=', 'PNS')
                        ->orwhere('jenis_pegawai', '=', 'CPNS');
                })
                ->leftjoin('md_jabatan AS t1', 'td_jabatan_pegawai.id_jabatan', '=', 't1.id')
                ->leftjoin('md_jenis_jabatan AS t2', 't1.jenis_jabatan', '=', 't2.id')
                ->leftjoin('md_pegawai AS t3', 'td_jabatan_pegawai.id_pegawai', '=', 't3.id')
                ->count();

        $datajabatan = [
              'struktural' => $struktural,
              'fungsional' => $fungsional,
              'pelaksana' => $pelaksana,
        ];

        //Jumlah Pendidikan
        $sd = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'SD')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();

        $smp = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'SMP')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();

        $sma = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'SMA')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();

        $d1 = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'Diploma I')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();

        $d2 = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'Diploma II')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();

        $d3 = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'Diploma III')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();

        $s1 = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'Sarjana')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();

        $s2 = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'Magister')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();

        $s3 = DB::table('td_pendidikan_pegawai')
                    ->where('t1.status', '=', 'aktif')
                    ->where('td_pendidikan_pegawai.tingkat', '=', 'Doktor')
                    ->where(function($query) {
                    $query->where('t1.jenis_pegawai', '=', 'PNS')
                          ->orwhere('t1.jenis_pegawai', '=', 'CPNS');
                    })
                    ->leftjoin('md_pegawai AS t1', 'td_pendidikan_pegawai.id_pegawai', '=', 't1.id')
                    ->count();


        $datapendidikan = [
              'sd' => $sd,
              'smp' => $smp,
              'sma' => $sma,
              'd1' => $d1,
              'd2' => $d2,
              'd3' => $d3,
              's1' => $s1,
              's2' => $s2,
              's3' => $s3,
        ];
        
        return view('home', compact('data', 'datagol', 'datajk', 'datajabatan', 'datapendidikan'));
    }
}
