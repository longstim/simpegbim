<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Redirect;
use Auth;

class PegawaiController extends Controller
{
    public function __construct()
  	{
        $this->middleware('auth');
  	}

  	public function index()
   	{
   		  return view('pages.pegawai.daftarpegawai');
   	}

   	public function daftarpegawai()
   	{
        $pegawai=DB::table('md_pegawai')->where('status','=','aktif')
              	  ->leftjoin('td_jabatan_pegawai', 'md_pegawai.id', '=', 'td_jabatan_pegawai.id_pegawai')
              	  ->leftjoin('md_jabatan', 'td_jabatan_pegawai.id_jabatan', '=', 'md_jabatan.id')
              	  ->leftjoin('md_jenjang_jabatan', 'td_jabatan_pegawai.id_jenjang_jabatan', '=', 'md_jenjang_jabatan.id')
              	  ->leftjoin('md_jenis_jabatan', 'md_jabatan.jenis_jabatan', '=', 'md_jenis_jabatan.id')
              	  ->leftjoin('td_pangkat_pegawai', 'md_pegawai.id', '=', 'td_pangkat_pegawai.id_pegawai')
              	  ->leftjoin('md_pangkat', 'td_pangkat_pegawai.id_pangkat', '=', 'md_pangkat.id')
                  ->select('md_pegawai.*', 'md_jabatan.jabatan AS jabatan', 'md_jenjang_jabatan.jenjang_jabatan AS jenjangjabatan', 'md_jenis_jabatan.jenis_jabatan AS jenisjabatan', 'md_pangkat.pangkat AS pangkat', 'md_pangkat.golongan AS golongan')
                    ->orderByRaw("FIELD(md_pegawai.jenis_pegawai , 'PNS', 'CPNS', 'PPNPN') asc")
                  ->orderBy('md_jenis_jabatan.id', 'desc')
                  ->orderBy('md_jabatan.id','asc')
                  ->orderBy('md_jenjang_jabatan.id','desc')
                  ->orderBy('md_pangkat.id','desc')
                  ->get();
        return view('pages.pegawai.daftarpegawai', compact('pegawai'));
   	}

    public function profilpegawai($id_pegawai)
    {
        $pegawai=DB::table('md_pegawai')->where('md_pegawai.id','=',$id_pegawai)
                  ->leftjoin('td_jabatan_pegawai', 'md_pegawai.id', '=', 'td_jabatan_pegawai.id_pegawai')
                  ->leftjoin('md_jabatan', 'td_jabatan_pegawai.id_jabatan', '=', 'md_jabatan.id')
                  ->leftjoin('md_jenjang_jabatan', 'td_jabatan_pegawai.id_jenjang_jabatan', '=', 'md_jenjang_jabatan.id')
                  ->leftjoin('md_jenis_jabatan', 'md_jabatan.jenis_jabatan', '=', 'md_jenis_jabatan.id')
                  ->leftjoin('td_pangkat_pegawai', 'md_pegawai.id', '=', 'td_pangkat_pegawai.id_pegawai')
                  ->leftjoin('md_pangkat', 'td_pangkat_pegawai.id_pangkat', '=', 'md_pangkat.id')
                  ->select('md_pegawai.*', DB::raw('DATE_FORMAT(md_pegawai.tanggal_lahir, "%d-%m-%Y") AS tanggallahir'), 'md_jabatan.jabatan AS jabatan', 'md_jenjang_jabatan.jenjang_jabatan AS jenjangjabatan', 'md_jenis_jabatan.jenis_jabatan AS jenisjabatan', 'md_pangkat.pangkat AS pangkat', 'md_pangkat.golongan AS golongan')
                  ->first();

        $jabatan = DB::table('td_jabatan_pegawai')->where('td_jabatan_pegawai.id_pegawai','=',$id_pegawai)
                  ->leftjoin('md_jabatan', 'td_jabatan_pegawai.id_jabatan', '=', 'md_jabatan.id')
                  ->leftjoin('md_jenjang_jabatan', 'td_jabatan_pegawai.id_jenjang_jabatan', '=', 'md_jenjang_jabatan.id')
                  ->leftjoin('md_jenis_jabatan', 'md_jabatan.jenis_jabatan', '=', 'md_jenis_jabatan.id')
                  ->select('td_jabatan_pegawai.*', 'md_jabatan.jabatan AS jabatan', 'md_jenjang_jabatan.jenjang_jabatan AS jenjangjabatan', 'md_jenis_jabatan.jenis_jabatan AS jenisjabatan')
                  ->get();

        $pangkat = DB::table('td_pangkat_pegawai')->where('td_pangkat_pegawai.id_pegawai','=',$id_pegawai)
                  ->leftjoin('md_pangkat', 'td_pangkat_pegawai.id_pangkat', '=', 'md_pangkat.id')
                  ->select('td_pangkat_pegawai.*', 'md_pangkat.pangkat AS pangkat', 'md_pangkat.golongan AS golongan')
                  ->get();

        $pendidikan = DB::table('td_pendidikan_pegawai')
                  ->where('td_pendidikan_pegawai.id_pegawai','=',$id_pegawai)
                  ->get();

        return view('pages.pegawai.profilpegawai', compact('pegawai', 'jabatan', 'pangkat', 'pendidikan'));
    }

    public function lapjabatanfungsional()
    {

      $datajabfung=DB::select("select md_jabatan.jabatan, count(*) as jumlah from td_jabatan_pegawai 
        inner join md_jabatan on td_jabatan_pegawai.id_jabatan = md_jabatan.id
        inner join md_jenis_jabatan on md_jabatan.jenis_jabatan = md_jenis_jabatan.id
        inner join md_pegawai on td_jabatan_pegawai.id_pegawai = md_pegawai.id
        where md_pegawai.status = 'aktif' AND md_jenis_jabatan.jenis_jabatan = 'Fungsional Tertentu' AND (md_pegawai.jenis_pegawai = 'PNS' OR md_pegawai.jenis_pegawai = 'CPNS')
        group by md_jabatan.jabatan");

      //dd($datajabfung);

      $pegawai=DB::table('md_pegawai')
                  ->where('status','=','aktif')
                  ->where('md_jenis_jabatan.jenis_jabatan', '=', 'Fungsional Tertentu')
                  ->leftjoin('td_jabatan_pegawai', 'md_pegawai.id', '=', 'td_jabatan_pegawai.id_pegawai')
                  ->leftjoin('md_jabatan', 'td_jabatan_pegawai.id_jabatan', '=', 'md_jabatan.id')
                  ->leftjoin('md_jenjang_jabatan', 'td_jabatan_pegawai.id_jenjang_jabatan', '=', 'md_jenjang_jabatan.id')
                  ->leftjoin('md_jenis_jabatan', 'md_jabatan.jenis_jabatan', '=', 'md_jenis_jabatan.id')
                  ->leftjoin('td_pangkat_pegawai', 'md_pegawai.id', '=', 'td_pangkat_pegawai.id_pegawai')
                  ->leftjoin('md_pangkat', 'td_pangkat_pegawai.id_pangkat', '=', 'md_pangkat.id')
                  ->select('md_pegawai.*', 'md_jabatan.jabatan AS jabatan', 'md_jenjang_jabatan.jenjang_jabatan AS jenjangjabatan', 'md_jenis_jabatan.jenis_jabatan AS jenisjabatan', 'md_pangkat.pangkat AS pangkat', 'md_pangkat.golongan AS golongan')
                  ->orderBy('md_jabatan.id','asc')
                  ->orderBy('md_jenjang_jabatan.id','desc')
                  ->orderBy('md_pangkat.id','desc')
                  ->orderByRaw("FIELD(md_pegawai.jenis_pegawai , 'PNS', 'CPNS', 'PPNPN') asc")
                  ->get();

        return view('pages.laporan.lap_jabatanfungsional', compact('datajabfung', 'pegawai'));
    }

    public function lappangkatgol()
    {

      $datagol=DB::select("select md_pangkat.golongan, count(*) as jumlah from td_pangkat_pegawai 
        inner join md_pangkat on td_pangkat_pegawai.id_pangkat = md_pangkat.id
        inner join md_pegawai on td_pangkat_pegawai.id_pegawai = md_pegawai.id
        where md_pegawai.status = 'aktif' AND (md_pegawai.jenis_pegawai = 'PNS' OR    md_pegawai.jenis_pegawai = 'CPNS')
          group by md_pangkat.golongan;");

        return view('pages.laporan.lap_pangkatgol', compact('datagol'));
    }
}
