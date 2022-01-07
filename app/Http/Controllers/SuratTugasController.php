<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;

class SuratTugasController extends Controller
{
    public function __construct()
  	{
        $this->middleware('auth');
  	}

  	public function daftarsurattugas()
   	{
        $stheader=DB::table('td_surattugas_header')
                  ->orderBy('td_surattugas_header.tanggal_surat','desc')
                  ->get();
        return view('pages.surattugas.daftarsurattugas', compact('stheader'));
   	}

    public function tambahsurattugas()
    {
        $lemburheader=DB::table('td_lembur_header')->get();
        $lemburdetail=DB::table('td_lembur_detail')->get();
        $pegawai=DB::table('md_pegawai')->get();

        return view('pages.lembur.form_tambahsurattugas',['lemburheader'=>$lemburheader, 'lemburdetail'=>$lemburdetail, 'pegawai'=>$pegawai]);
    }


}
