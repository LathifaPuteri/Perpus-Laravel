<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::group(['middleware' => ['cors','jwt.verify']], function (){

    Route::get('/login_check','UserController@getAuthenticatedUser');

    //SUPER ADMIN
Route::group(['middleware' => ['api.superadmin']], function (){
    Route::delete('/Siswa/{id}', 'SiswaController@destroy');
    Route::delete('/Kelas/{id}', 'KelasController@destroy');
    Route::delete('/Buku/{id}', 'BukuController@destroy');
    Route::delete('/Peminjaman_buku/{id}', 'PeminjamanBukuController@destroy');
    Route::delete('/Detail_peminjaman_buku/{id}', 'DetailPeminjamanBukuController@destroy');
    Route::delete('/Pengembalian_buku/{id}', 'PengembalianBukuController@destroy');
});

    //ADMIN
Route::group(['middleware' => ['api.admin']], function (){
    Route::post('/Siswa', 'SiswaController@store');
    Route::put('/Siswa/{id}', 'SiswaController@update');

    Route::post('/Kelas', 'KelasController@store');
    Route::put('/Kelas/{id}', 'KelasController@update');

    Route::post('/Buku', 'BukuController@store');
    Route::put('/Buku/{id}', 'BukuController@update');

    Route::post('/Peminjaman_buku', 'PeminjamanBukuController@store');
    Route::put('/Peminjaman_buku/{id}', 'PeminjamanBukuController@update');

    Route::post('/Detail_peminjaman_buku', 'DetailPeminjamanBukuController@store');
    Route::put('/Detail_peminjaman_buku/{id}', 'DetailPeminjamanBukuController@update');

    Route::post('/Pengembalian_buku', 'PengembalianBukuController@store');
    Route::put('/Pengembalian_buku/{id}', 'PengembalianBukuController@update');
});

    //Get Start

    Route::post('pinjam_buku','transaksiController@pinjamBuku');
    Route::post('tambah_item/{id}','transaksiController@tambahItem');
    Route::post('mengembalikan_buku','transaksiController@mengembalikanBuku');

    Route::get('/Siswa', 'SiswaController@show');
    Route::get('/Siswa/{id}', 'SiswaController@detail');

    Route::get('/Kelas', 'KelasController@show');
    Route::get('/Kelas/{id}', 'KelasController@detail');

    Route::get('/Buku', 'BukuController@show');
    Route::get('/Buku/{id}', 'BukuController@detail');

    Route::get('/Peminjaman_buku', 'PeminjamanBukuController@show');
    Route::get('/Peminjaman_buku/{id}', 'PeminjamanBukuController@detail');

    Route::get('/Detail_peminjaman_buku', 'DetailPeminjamanBukuController@show');
    Route::get('/Detail_peminjaman_buku/{id}', 'DetailPeminjamanBukuController@detail');

    Route::get('/Pengembalian_buku', 'PengembalianBukuController@show');
    Route::get('/Pengembalian_buku/{id}', 'PengembalianBukuController@detail');
});