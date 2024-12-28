<?php

use App\Http\Controllers\HomeController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'checksession'], function () {
  Route::get('/', 'Auth\LoginController@login')->name('login');
  Route::get('/login', 'Auth\LoginController@login')->name('login');
  Route::post('/processing-login', 'Auth\LoginController@checking_login')->name('login.check');
  Route::get('/lupa-password', 'HomeController@forget_password')->name('forgetPassword');
  Route::get('/lupa-password/berhasil', 'HomeController@after_forget')->name('berhasil');
  Route::post('/processing-lupa-pwd', 'HomeController@checking_lupa')->name('forgetpwd.check');
  Route::post('/update-password', 'Auth\ResetPasswordController@update_password')->name('update.password');
});

Route::group(['middleware' => 'checkauth'], function () {
  Route::group(['middleware' => 'checkpermission'], function(){
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/profile/detail', 'ProfileController@detail')->name('profile-detail');

    Route::group(['prefix' => 'rt05'], function () {
      Route::get('/data-warga', 'DataWargaController@index')->name('rt5-data-warga');
    });

    Route::post('/data-warga/get-list', 'DataWargaController@getList')->name('data-warga.get-list');
    Route::post('/data-warga/export', 'DataWargaController@export')->name('data-warga.export');

    Route::post('/iuran/get-list', 'IuranController@getList')->name('iuran.get-list');
    Route::post('/iuran/export', 'IuranController@export')->name('iuran.export');

    Route::post('/laporan-keuangan/get-list', 'IuranController@getList')->name('laporan-keuangan.get-list');
    Route::post('/laporan-keuangan/export', 'IuranController@export')->name('laporan-keuangan.export');

    Route::group(['prefix' => 'rw'], function () {
      Route::get('/data-warga', 'DataWargaController@index')->name('rw-data-warga');
      Route::get('/iuran', 'IuranController@index')->name('rw-iuran');
      Route::get('/laporan-keuangan', 'LaporanKeuanganController@index')->name('rw-laporan-keuangan');
    });
    Route::group(['prefix' => 'rt01'], function () {
      Route::get('/data-warga', 'DataWargaController@index')->name('rt1-data-warga');
      Route::get('/iuran', 'IuranController@index')->name('rt1-iuran');
    });
    Route::group(['prefix' => 'rt02'], function () {
      Route::get('/data-warga', 'DataWargaController@index')->name('rt2-data-warga');
      Route::get('/iuran', 'IuranController@index')->name('rt2-iuran');
    });
    Route::group(['prefix' => 'rt03'], function () {
      Route::get('/data-warga', 'DataWargaController@index')->name('rt3-data-warga');
      Route::get('/iuran', 'IuranController@index')->name('rt3-iuran');
    });
    Route::group(['prefix' => 'rt04'], function () {
      Route::get('/data-warga', 'DataWargaController@index')->name('rt4-data-warga');
      Route::get('/iuran', 'IuranController@index')->name('rt4-iuran');
    });
    Route::group(['prefix' => 'rt05'], function () {
      Route::get('/data-warga', 'DataWargaController@index')->name('rt5-data-warga');
      Route::get('/iuran', 'IuranController@index')->name('rt5-iuran');
    });

    Route::get('/tidak-punya-akses/{name}/{msg}', 'DashboardController@haventPermission')->name('havent-permission');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/dashboard/lsbu', 'DashboardController@lsbu')->name('dashboard.lsbu');
    Route::get('/dashboard/mygoals', 'DashboardController@mygoals')->name('dashboard.mygoals');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    
        Route::get('/daftar-rekening', 'Autodebit\MyGoals\DaftarRekeningController@index')->name('autodebit.mygoals.daftar-rekening');
        Route::post('/daftar-rekening', 'Autodebit\MyGoals\DaftarRekeningController@ajax_goals')->name('autodebit.mygoals.daftar-rekening');
        Route::post('/daftar-rekening/export', 'Autodebit\MyGoals\DaftarRekeningController@export')->name('autodebit.mygoals.daftar-rekening.export');
        Route::get('/daftar-rekening/new', 'Autodebit\MyGoals\DaftarRekeningController@new')->name('autodebit.mygoals.daftar-rekening.new');
        Route::post('/daftar-rekening/new', 'Autodebit\MyGoals\DaftarRekeningController@create')->name('autodebit.mygoals.daftar-rekening.new');
        Route::post('/daftar-rekening/confirmcache', 'Autodebit\MyGoals\DaftarRekeningController@confirm')->name('autodebit.mygoals.daftar-rekening.confirm');
        Route::get('/daftar-rekening/confirm/{params}', 'Autodebit\MyGoals\DaftarRekeningController@form_confirm')->name('autodebit.mygoals.daftar-rekening.confirm-menu');
        Route::get('/daftar-rekening/show/{id}', 'Autodebit\MyGoals\DaftarRekeningController@show')->name('autodebit.mygoals.daftar-rekening.show');
        Route::get('/daftar-rekening/result/{params}', 'Autodebit\MyGoals\DaftarRekeningController@result')->name('autodebit.mygoals.daftar-rekening.result');
        Route::post('/daftar-rekening/show', 'Autodebit\MyGoals\DaftarRekeningController@ajax_show_goals')->name('autodebit.mygoals.daftar-rekening.ajax.show_goals');
        Route::post('/daftar-rekening/show/{id}', 'Autodebit\MyGoals\DaftarRekeningController@update')->name('autodebit.mygoals.daftar-rekening.update');
        Route::get('/daftar-rekening/show/inquiry/{id}', 'Autodebit\MyGoals\DaftarRekeningController@show_inquiry')->name('autodebit.mygoals.daftar-rekening.show-inquiry');
        Route::post('/daftar-rekening/show/inquiry/{id}', 'Autodebit\MyGoals\DaftarRekeningController@penutupan')->name('autodebit.mygoals.daftar-rekening.show-inquiry');
        Route::get('/daftar-rekening/show/tutup/{id}/{approval_status}', 'Autodebit\MyGoals\DaftarRekeningController@update_tutup')->name('autodebit.mygoals.daftar-rekening.update_tutup');
        Route::post('/daftar-rekening/savdep-product/ajax', 'Autodebit\MyGoals\DaftarRekeningController@ajax_savdep_product')->name('get.savdep_product');
        Route::post('/daftar-rekening/simulasi-autodebit', 'Autodebit\MyGoals\DaftarRekeningController@ajax_simulasi_autodebit')->name('get.simulasi_autodebit');
        Route::post('/daftar-rekening/validasi-norekening/{params}', 'Autodebit\MyGoals\DaftarRekeningController@validasiNorek')->name('get.validasi_norekening');
  });
});