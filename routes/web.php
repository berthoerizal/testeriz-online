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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Auth::routes([
//     'register' => false, // Registration Routes...
//     'reset' => false, // Password Reset Routes...
//     'verify' => false, // Email Verification Routes...
// ]);

Route::resource('home', 'HomeController');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::resource('profile', 'ProfileController');
Route::put('/update_password/{id}', ['as' => 'update_password', 'uses' => 'ProfileController@update_password']);
Route::resource('user', 'UserController');
Route::get('/reset_password/{id}', ['as' => 'reset_password', 'uses' => 'UserController@reset_password']);
Route::resource('konfigurasi', 'KonfigurasiController');
Route::resource('soal', 'SoalController');
Route::get('/download_materi/{id}', ['as' => 'download_materi', 'uses' => 'SoalController@download_materi']);
Route::resource('tanya', 'TanyaController');
Route::resource('ujian', 'UjianController');
Route::post('/daftar_ujian', 'UjianController@daftar_ujian')->name('daftar_ujian');
Route::get('/tunggu_ujian/{slug_soal}', ['as' => 'tunggu_ujian', 'uses' => 'UjianController@tunggu_ujian']);
Route::put('soal/{id_soal}/tanya/{id_tanya}', ['as' => 'user_jawab_ujian', 'uses' => 'UjianController@user_jawab_ujian']);
Route::get('/nilai_peserta/{id}', ['as' => 'nilai_peserta', 'uses' => 'NilaiController@nilai_peserta']);
Route::get('soal/{id_soal}/peserta/{id_user}/detail_nilai', ['as' => 'detail_nilai', 'uses' => 'NilaiController@detail_nilai']);

Route::get('/ujian_sudah_daftar', 'UjianController@ujian_sudah_daftar')->name('ujian_sudah_daftar');
Route::post('/selesai_ujian_essay', 'UjianController@selesai_ujian_essay')->name('selesai_ujian_essay');
Route::post('/nilai_essay', 'NilaiController@nilai_essay')->name('nilai_essay');


// make route get using this function from controller : reset_nilai($id_soal, $id_user, $flag = null)
Route::get('/reset_nilai/{id_soal}/{flag}/{id_user?}', 'NilaiController@reset_nilai')->name('reset_nilai');
//make route get unsing JenisSoalController for index
Route::resource('jenis_soal', 'JenisSoalController');


Route::put('/jawab_ujian/{slug_soal}', ['as' => 'jawab_ujian_post', 'uses' => 'UjianController@jawab_ujian_post']);
Route::get('/jawab_ujian/{slug_soal}', ['as' => 'jawab_ujian', 'uses' => 'UjianController@jawab_ujian_get']);
Route::post('soal/{id_soal}/selesai_ujian', ['as' => 'selesai_ujian', 'uses' => 'UjianController@selesai_ujian']);
