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
                  ->leftjoin('md_tugas AS t1', 'td_surattugas_header.jenis_tugas', '=', 't1.id')
                  ->select('td_surattugas_header.*', 't1.jenis_tugas AS jenistugas')
                  ->orderBy('td_surattugas_header.tanggal_tugas_awal','desc')
                  ->get();
        return view('pages.surattugas.daftarsurattugas', compact('stheader'));
   	}

    public function tambahsurattugas()
    {
        $stheader=DB::table('td_surattugas_header')->get();
        $stdetail=DB::table('td_surattugas_detail')->get();
        $pegawai=DB::table('md_pegawai')->get();
        $jenistugas=DB::table('md_tugas')->get();

        return view('pages.surattugas.form_tambahsurattugas',['stheader'=>$stheader, 'stdetail'=>$stdetail, 'pegawai'=>$pegawai, 'jenistugas'=>$jenistugas]);
    }

    public function prosestambahsurattugas(Request $request)
    {
        $tanggalsurat = $request->input('tanggal_surat');
        $newTanggalSurat = Carbon::createFromFormat('d/m/Y', $tanggalsurat)->format('Y-m-d');

        $tanggalawal = $request->input('tanggal_st_awal');
        $newTanggalAwal = Carbon::createFromFormat('d/m/Y', $tanggalawal)->format('Y-m-d');

        $tanggalakhir = $request->input('tanggal_st_akhir');
        $newTanggalAkhir = Carbon::createFromFormat('d/m/Y', $tanggalakhir)->format('Y-m-d');

        $validatedData = $request->validate([
              'no_surat' => 'required|string|unique:td_surattugas_header,no_surat',
        ]);

        $data = array(
          'no_surat' => $request->input('no_surat'),
          'tanggal_surat' => $newTanggalSurat,
          'tanggal_tugas_awal' => $newTanggalAwal,
          'tanggal_tugas_akhir' => $newTanggalAkhir,
          'nama_tugas' => $request->input('nama_tugas'),
          'jenis_tugas' => $request->input('jenis_tugas'),
          'metode' => $request->input('metode'),
          'penyelenggara' => $request->input('penyelenggara'),
          'penandatangan' => $request->input('penandatangan'),
          'jabatan_penandatangan' => $request->input('jabatan_penandatangan'),
        );

        $insertID = DB::table('td_surattugas_header')->insertGetId($data);

        foreach($request->input('peserta') as $dd)
        {
            $datastdetail = array(
                'id_header' => $insertID,
                'id_pegawai' => $dd,
            );

            $insertIDSTdetail = DB::table('td_surattugas_detail')->insertGetId($datastdetail);
        }

        return Redirect::to('surattugas')->with('message','Berhasil menyimpan data');
    }

    public function ubahsurattugas($id_surattugas)
    {
        $stheader=DB::table('td_surattugas_header')->where('id','=',$id_surattugas)->first();
        $stdetail=DB::table('td_surattugas_detail')
            ->where('td_surattugas_detail.id_header','=',$id_surattugas)
            ->get();
        $pegawai=DB::table('md_pegawai')->get();
        $jenistugas=DB::table('md_tugas')->get();

        $i=0;
        foreach($stdetail as $val)
        {
            $daftarpegawai[$i]=$val->id_pegawai;
            $i++;
        }

        //dd($daftarpegawai);

        return view('pages.surattugas.form_ubahsurattugas',['stheader'=>$stheader, 'stdetail'=>$stdetail, 'pegawai'=>$pegawai, 'jenistugas'=>$jenistugas, 'daftarpegawai'=>$daftarpegawai]);
    }

    public function prosesubahsurattugas(Request $request)
    {
        $tanggalsurat = $request->input('tanggal_surat');
        $newTanggalSurat = Carbon::createFromFormat('d/m/Y', $tanggalsurat)->format('Y-m-d');

        $tanggalawal = $request->input('tanggal_st_awal');
        $newTanggalAwal = Carbon::createFromFormat('d/m/Y', $tanggalawal)->format('Y-m-d');

        $tanggalakhir = $request->input('tanggal_st_akhir');
        $newTanggalAkhir = Carbon::createFromFormat('d/m/Y', $tanggalakhir)->format('Y-m-d');

        $data = array(
          'no_surat' => $request->input('no_surat'),
          'tanggal_surat' => $newTanggalSurat,
          'tanggal_tugas_awal' => $newTanggalAwal,
          'tanggal_tugas_akhir' => $newTanggalAkhir,
          'nama_tugas' => $request->input('nama_tugas'),
          'jenis_tugas' => $request->input('jenis_tugas'),
          'metode' => $request->input('metode'),
          'penyelenggara' => $request->input('penyelenggara'),
          'penandatangan' => $request->input('penandatangan'),
          'jabatan_penandatangan' => $request->input('jabatan_penandatangan'),
        );

        $updateID = $request->input('id');

        DB::table('td_surattugas_header')->where('id','=',$updateID)->update($data);

        $deletedetailtemporary = DB::table('td_surattugas_detail')->where('id_header','=',$updateID)->delete();

        foreach($request->input('peserta') as $dd)
        {
            $datastdetail = array(
                'id_header' => $updateID,
                'id_pegawai' => $dd,
            );

            $insertIDSTdetail = DB::table('td_surattugas_detail')->insertGetId($datastdetail);
        }

        return Redirect::to('surattugas')->with('message','Berhasil menyimpan data');
    }

    public function hapussurattugas($id_surattugas)
    {
        $data = DB::table('td_surattugas_header')->where('id','=',$id_surattugas)->delete();

        $datadetail = DB::table('td_surattugas_detail')->where('id_header','=',$id_surattugas)->delete();

        return Redirect::to('surattugas')->with('message','Berhasil menghapus data');
    }

    public function cetaksurattugas($id_surattugas)
    {
      $stheader=DB::table('td_surattugas_header')
                  ->where('td_surattugas_header.id','=',$id_surattugas)
                  ->leftjoin('md_pegawai AS t1', 'td_surattugas_header.penandatangan', '=', 't1.id')
                  ->select('td_surattugas_header.*', 't1.nama AS nama_penandatangan', 't1.nip AS nip_penandatangan')
                  ->first();

      $stdetail=DB::table('td_surattugas_detail')
                  ->where('td_surattugas_detail.id_header','=',$id_surattugas)
                  ->leftjoin('md_pegawai', 'td_surattugas_detail.id_pegawai', '=', 'md_pegawai.id')
                  ->leftjoin('td_pangkat_pegawai', 'md_pegawai.id', '=', 'td_pangkat_pegawai.id_pegawai')
                  ->leftjoin('md_pangkat', 'td_pangkat_pegawai.id_pangkat', '=', 'md_pangkat.id')
                  ->leftjoin('td_jabatan_pegawai', 'md_pegawai.id', '=', 'td_jabatan_pegawai.id_pegawai')
                  ->leftjoin('md_jabatan', 'td_jabatan_pegawai.id_jabatan', '=', 'md_jabatan.id')
                  ->leftjoin('md_jenjang_jabatan', 'td_jabatan_pegawai.id_jenjang_jabatan', '=', 'md_jenjang_jabatan.id')
                  ->leftjoin('md_jenis_jabatan', 'md_jenjang_jabatan.jenis_jabatan', '=', 'md_jenis_jabatan.id')
                  ->select('td_surattugas_detail.*', 'md_pegawai.nama AS nama', 'md_pegawai.nip AS nip', 'md_pangkat.golongan AS gol', 'md_jabatan.jabatan AS jabatan', 'md_jenjang_jabatan.jenjang_jabatan AS jenjang_jabatan', 'md_jenis_jabatan.jenis_jabatan AS jenis_jabatan')
                  ->orderByRaw("FIELD(md_pegawai.jenis_pegawai , 'PNS', 'CPNS', 'PPNPN') asc")
                  ->orderBy('md_jenis_jabatan.id', 'desc')
                  ->orderBy('md_jabatan.id','asc')
                  ->orderBy('md_jenjang_jabatan.id','desc')
                  ->orderBy('md_pangkat.id','desc')
                  ->get();


      return view('pages.surattugas.cetaksurattugas', ['stheader'=>$stheader, 'stdetail'=>$stdetail]);
    }

    public function cetakdatapelatihan()
    {
        $pelatihan=DB::table('td_surattugas_detail')
                  ->leftjoin('td_surattugas_header AS t1', 'td_surattugas_detail.id_header', '=', 't1.id')
                  ->leftjoin('md_pegawai AS t2', 'td_surattugas_detail.id_pegawai', '=', 't2.id')
                  ->leftjoin('md_tugas AS t3', 't1.jenis_tugas', '=', 't3.id')
                  ->where('t1.jenis_tugas', '<>', 10)
                  ->select('td_surattugas_detail.*', 't1.nama_tugas AS nama_tugas', 't1.penyelenggara AS penyelenggara', 't1.tanggal_tugas_awal AS tanggal_tugas_awal', 't1.tanggal_tugas_akhir AS tanggal_tugas_akhir', 't2.nama AS nama_pegawai', 't2.nip AS nip', 't3.jenis_tugas AS jenis_tugas')
                  ->orderBy('t2.nama','asc')
                  ->orderBy('t1.tanggal_tugas_awal','asc')
                  ->get();

        //dd($stheader);

        $pegawai=DB::table('md_pegawai')
                  ->where('jenis_pegawai', '=', 'PNS')
                  ->orWhere('jenis_pegawai', '=', 'CPNS')
                  ->select('md_pegawai.*')
                  ->orderBy('nama','asc')
                  ->get();

        return view('pages.surattugas.cetakdatapelatihan', compact('pelatihan', 'pegawai'));
    }

}
