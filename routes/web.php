<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index')->name('home');


Auth::routes();

Route::middleware('permission:dashboard')->get('/home', 'HomeController@index')->name('home');

Route::get('/adminlte', function () {
    return view('admin/adminlte');
});

//Absensi
Route::get('pilihabsen', 'AbsenController@pilihabsen');
Route::post('absen', 'AbsenController@daftarabsen');
Route::post('daftarabsen', 'AbsenController@daftarabsenpegawai');
Route::get('formabsen', 'AbsenController@formabsen');
Route::get('prosesabsen/{radius}/{radworkshop}/{radlogam}', 'AbsenController@prosesabsen');
Route::get('daftarabsenpegawai', 'AbsenController@tampildaftarabsenpegawai');
Route::post('daftarabsenpegawai', 'AbsenController@prosesdaftarabsenpegawai');
Route::get('inputabsenseries', 'AbsenController@inputabsenseries');
Route::post('prosesabsenseries', 'AbsenController@prosesabsenseries');

//Pegawai
Route::middleware('role:admin')->get('pegawai', 'PegawaiController@daftarpegawai');
Route::get('profilpegawai/{id_pegawai}', 'PegawaiController@profilpegawai');
Route::get('lapjabatanfungsional', 'PegawaiController@lapjabatanfungsional');
Route::get('lappangkatgol', 'PegawaiController@lappangkatgol');

//Lembur Pegawai
Route::get('lembur', 'LemburController@daftarlembur');
Route::middleware('permission:tambah lembur')->get('tambahlembur', 'LemburController@tambahlembur');
Route::post('prosestambahlembur', 'LemburController@prosestambahlembur');
Route::get('ubahlembur/{id_lembur}','LemburController@ubahlembur');
Route::post('prosesubahlembur','LemburController@prosesubahlembur');
Route::get('tambahlemburdetail/{id_lembur}','LemburController@tambahlemburdetail');
Route::post('prosestambahlemburdetail','LemburController@prosestambahlemburdetail');
Route::post('prosesubahlemburdetail','LemburController@prosesubahlemburdetail');
Route::get('cetaklembur/{id_lembur}','LemburController@cetaklembur');
Route::get('cetaklampiranlembur/{id_lembur}','LemburController@cetaklampiranlembur');
Route::get('hapuslembur/{id_lembur}','LemburController@hapuslembur');
Route::get('hapuslemburdetail/{id_lembur}/{id_lemburdetail}','LemburController@hapuslemburdetail');
Route::get('jsondatapegawai/{id_pegawai}','LemburController@jsondatapegawai');
Route::get('jsonlemburdetail/{id_lemburdetail}','LemburController@jsonlemburdetail');
Route::post('prosestambahjamlemburdetail', 'LemburController@prosestambahjamlemburdetail');
Route::get('daftarlemburpegawai', 'LemburController@tampildaftarlemburpegawai');
Route::post('daftarlemburpegawai', 'LemburController@pilihdaftarlemburpegawai');
Route::get('daftarlemburperbulan', 'LemburController@tampildaftarlemburperbulan');
Route::post('daftarlemburperbulan', 'LemburController@pilihdaftarlemburperbulan');

//Surat Tugas
Route::get('surattugas', 'SuratTugasController@daftarsurattugas');
Route::get('tambahsurattugas', 'SuratTugasController@tambahsurattugas');
Route::post('prosestambahsurattugas', 'SuratTugasController@prosestambahsurattugas');
Route::get('ubahsurattugas/{id_surattugas}','SuratTugasController@ubahsurattugas');
Route::post('prosesubahsurattugas','SuratTugasController@prosesubahsurattugas');
Route::get('hapussurattugas/{id_surattugas}','SuratTugasController@hapussurattugas');
Route::get('cetaksurattugas/{id_surattugas}','SuratTugasController@cetaksurattugas');
Route::get('cetakdatapelatihan','SuratTugasController@cetakdatapelatihan');

//Location
Route::get('locationIP', 'AbsenController@getLocationbyIP');

//Pengaturan
Route::get('role', 'PengaturanController@daftarrole');
Route::get('permission', 'PengaturanController@daftarpermission');
Route::get('tambahpermission', 'PengaturanController@tambahpermission');
Route::post('prosestambahpermission', 'PengaturanController@prosestambahpermission');
Route::get('user', 'PengaturanController@daftaruser');
Route::get('ubahuser/{id_user}','PengaturanController@ubahuser');
Route::post('prosesubahuser','PengaturanController@prosesubahuser');