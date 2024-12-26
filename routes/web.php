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
    Route::get('/tidak-punya-akses/{name}/{msg}', 'DashboardController@haventPermission')->name('havent-permission');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/dashboard/lsbu', 'DashboardController@lsbu')->name('dashboard.lsbu');
    Route::get('/dashboard/mygoals', 'DashboardController@mygoals')->name('dashboard.mygoals');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/log-acitvity/daftar-log', 'Log\LogController@getBasicData')->name('log.basicdata');
    Route::get('/monitoring/daftar-transaksi', 'Monitoring\MonitoringController@getBasicData')->name('monitoring.basicdata');
    Route::get('/monitoring/export', 'Monitoring\MonitoringController@export')->name('monitoring.transaksi.export');
    
    Route::group(['prefix' => 'autodebit'], function () {
      //my goals start
      Route::group(['prefix' => 'my-goals'], function () {
        //daftar rekening
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
        //pendaftaran
        Route::get('/laporan-pendaftaran', 'Autodebit\MyGoals\PendaftaranController@index')->name('autodebit.mygoals.pendaftaran');
        Route::post('/laporan-pendaftaran', 'Autodebit\MyGoals\PendaftaranController@ajax_goals')->name('autodebit.mygoals.pendaftaran');
        Route::post('/laporan-pendaftaran/export', 'Autodebit\MyGoals\PendaftaranController@export')->name('autodebit.mygoals.pendaftaran.export');
        //penutupan
        Route::get('/laporan-penutupan', 'Autodebit\MyGoals\PenutupanController@index')->name('autodebit.mygoals.penutupan');
        Route::post('/laporan-penutupan', 'Autodebit\MyGoals\PenutupanController@ajax_goals')->name('autodebit.mygoals.penutupan');
        Route::post('/laporan-penutupan/export', 'Autodebit\MyGoals\PenutupanController@export')->name('autodebit.mygoals.penutupan.export');
        //approval
        Route::get('/approval', 'Autodebit\MyGoals\ApprovalController@index')->name('autodebit.mygoals.approval');
        Route::post('/approval', 'Autodebit\MyGoals\ApprovalController@ajax_approval')->name('autodebit.mygoals.approval');
        Route::get('/approval/show/{params}/{approval_type}', 'Autodebit\MyGoals\ApprovalController@show')->name('autodebit.mygoals.approval.show');
        Route::get('/approval/{params}/{action}', 'Autodebit\MyGoals\ApprovalController@update')->name('autodebit.mygoals.approval.update');
        Route::post('/approval/checking-spv', 'Autodebit\MyGoals\ApprovalController@checking_spv')->name('autodebit.mygoals.approval.checking_spv');
     
        //Route::get('/log-activity', 'Log\LogController@indexMyGoals')->name('log.mygoals');
        Route::get('/log-activity', 'Autodebit\MyGoals\LogActivityController@index')->name('autodebit.mygoals.log-activity');
        Route::post('/log-activity', 'Autodebit\MyGoals\LogActivityController@ajax')->name('autodebit.mygoals.log-activity');
        Route::get('/log-activity-coba', 'Autodebit\MyGoals\LogActivityController@ajaxCoba');
       
        Route::get('/monitoring-transaksi-coba', 'Autodebit\MyGoals\MonitoringTransaksiController@coba');
        //Route::get('/monitoring', 'Monitoring\MonitoringController@indexMyGoals')->name('monitoring.transkasi.mygoals');
        Route::get('/monitoring', 'Autodebit\MyGoals\MonitoringTransaksiController@index')->name('autodebit.mygoals.monitoring-transaksi');
        Route::post('/monitoring-transaksi', 'Autodebit\MyGoals\MonitoringTransaksiController@ajax')->name('autodebit.mygoals.monitoring-transaksi');
        Route::post('/monitoring-transaksi/daftar-rekening/export', 'Autodebit\MyGoals\MonitoringTransaksiController@export')->name('autodebit.mygoals.monitoring-transaksi.export');
  
      });
      //my goals end
      //regular start
      Route::group(['prefix' => 'regular'], function() {
        //daftar rekening
        Route::get('/daftar-rekening', 'Autodebit\Regular\DaftarRekeningController@index')->name('autodebit.regular.daftar-rekening');
        Route::post('/daftar-rekening', 'Autodebit\Regular\DaftarRekeningController@ajax_goals')->name('autodebit.regular.daftar-rekening');
        Route::get('/daftar-rekening/new', 'Autodebit\Regular\DaftarRekeningController@new')->name('autodebit.regular.daftar-rekening.new');
        Route::post('/daftar-rekening/new', 'Autodebit\Regular\DaftarRekeningController@create')->name('autodebit.regular.daftar-rekening.create');
        Route::get('/daftar-rekening/show/{id}', 'Autodebit\Regular\DaftarRekeningController@show')->name('autodebit.regular.daftar-rekening.show');
        Route::post('/daftar-rekening/show/{id}', 'Autodebit\Regular\DaftarRekeningController@update')->name('autodebit.regular.daftar-rekening.update');
        Route::post('/daftar-rekening/export', 'Autodebit\Regular\DaftarRekeningController@export')->name('autodebit.regular.daftar-rekening.export');
      
        Route::get('/log-activity', 'Log\LogController@indexRegular')->name('log.regular');
        Route::get('/log-acitvity/daftar-log', 'Log\LogController@getBasicData')->name('log.regular.data');
  
        Route::get('/monitoring', 'Monitoring\MonitoringController@indexRegular')->name('monitoring.transkasi.regular');
  
      });
      //regular end
      //lsbu start
      Route::group(['prefix' => 'lsbu'], function() {
        //daftar rekening
        Route::get('/daftar-rekening', 'Autodebit\LSBU\DaftarRekeningController@index')->name('autodebit.lsbu.daftar-rekening');
        Route::post('/daftar-rekening', 'Autodebit\LSBU\DaftarRekeningController@ajax')->name('autodebit.lsbu.daftar-rekening');
        Route::get('/daftar-rekening/new', 'Autodebit\LSBU\DaftarRekeningController@new')->name('autodebit.lsbu.daftar-rekening.new');
        Route::post('/daftar-rekening/simulation', 'Autodebit\LSBU\DaftarRekeningController@ajax_simulasi_autodebit')->name('autodebit.lsbu.daftar-rekening.simulasi');
        Route::post('/daftar-rekening/confirmcache', 'Autodebit\LSBU\DaftarRekeningController@confirm')->name('autodebit.lsbu.daftar-rekening.confirm');
        Route::get('/daftar-rekening/confirm/{params}', 'Autodebit\LSBU\DaftarRekeningController@form_confirm')->name('autodebit.lsbu.daftar-rekening.confirm-menu');
        Route::post('/daftar-rekening/new', 'Autodebit\LSBU\DaftarRekeningController@create')->name('autodebit.lsbu.daftar-rekening.create');
        Route::get('/daftar-rekening/result/{params}/{paramsDua}', 'Autodebit\LSBU\DaftarRekeningController@result')->name('autodebit.lsbu.daftar-rekening.result');
        Route::get('/daftar-rekening/show/{id}', 'Autodebit\LSBU\DaftarRekeningController@show')->name('autodebit.lsbu.daftar-rekening.show');
        Route::post('/daftar-rekening/show/{id}', 'Autodebit\LSBU\DaftarRekeningController@update')->name('autodebit.lsbu.daftar-rekening.update');
        Route::post('/daftar-rekening/show/transaksi/{id}', 'Autodebit\LSBU\DaftarRekeningController@show_transaksi')->name('autodebit.lsbu.daftar-rekening.transaksi');
        Route::get('/daftar-rekening/show/inquiry/{id}', 'Autodebit\LSBU\DaftarRekeningController@show_inquiry')->name('autodebit.lsbu.daftar-rekening.show-inquiry');
        Route::post('/daftar-rekening/show/inquiry/{id}', 'Autodebit\LSBU\DaftarRekeningController@penutupan')->name('autodebit.lsbu.daftar-rekening.show-inquiry');
        Route::post('/daftar-rekening/export', 'Autodebit\LSBU\DaftarRekeningController@export')->name('autodebit.lsbu.daftar-rekening.export');
        Route::post('/daftar-rekening/validasi-norekening/{params}', 'Autodebit\LSBU\DaftarRekeningController@validasiNorek')->name('get.validasi_norekening');
        Route::get('/daftar-rekening/edit/{id}', 'Autodebit\LSBU\DaftarRekeningController@edit')->name('autodebit.lsbu.daftar-rekening.edit');
        Route::post('/daftar-rekening/edit/{id}', 'Autodebit\LSBU\DaftarRekeningController@update')->name('autodebit.lsbu.daftar-rekening.edit');
        
        Route::post('/daftar-rekening/riwayat-sumber', 'Autodebit\LSBU\DaftarRekeningController@riwayatSumber')->name('autodebit.lsbu.daftar-rekening.riwayat');
        // Route::get('/monitoring/show/{id}', 'Monitoring\RiwayatGagalAutodebitController@show')->name('monitoring.transaksi.daftar-rekening.show');
        // Route::post('/monitoring/daftar-transaksi', 'Monitoring\RiwayatGagalAutodebitController@ajax_goals')->name('monitoring.transkasi.daftar-rekening');
        
        Route::get('/monitoring-transaksi', 'Autodebit\LSBU\MonitoringTransaksiController@index')->name('autodebit.lsbu.monitoring-transaksi');
        Route::post('/monitoring-transaksi', 'Autodebit\LSBU\MonitoringTransaksiController@ajax')->name('autodebit.lsbu.monitoring-transaksi');
        Route::post('/monitoring-transaksi/daftar-rekening/export', 'Autodebit\LSBU\MonitoringTransaksiController@export')->name('autodebit.lsbu.monitoring-transaksi.export');
      
        Route::get('/log-activity', 'Autodebit\LSBU\LogActivityController@index')->name('autodebit.lsbu.log-activity');
        Route::post('/log-activity', 'Autodebit\LSBU\LogActivityController@ajax')->name('autodebit.lsbu.log-activity');
        Route::get('/log-activity/daftar-log', 'Log\UserPusatController@getBasicData')->name('log.lsbu.data');
  
        
        //approval
        Route::get('/approval', 'Autodebit\LSBU\ApprovalController@index')->name('autodebit.lsbu.approval');
        Route::post('/approval', 'Autodebit\LSBU\ApprovalController@ajax_approval')->name('autodebit.lsbu.approval');
        Route::get('/approval/show/{params}', 'Autodebit\LSBU\ApprovalController@show')->name('autodebit.lsbu.approval.show');
        Route::get('/approval/edit/{params}', 'Autodebit\LSBU\ApprovalController@edit')->name('autodebit.lsbu.approval.edit');
        Route::post('/approval/edit/{params}', 'Autodebit\LSBU\ApprovalController@update')->name('autodebit.lsbu.approval.edit');
        Route::post('/approval/checking-spv', 'Autodebit\LSBU\ApprovalController@checking_spv')->name('autodebit.lsbu.approval.checking_spv');
        Route::post('/approval/export', 'Autodebit\LSBU\ApprovalController@export')->name('autodebit.lsbu.approval.export');
        
        //pendaftaran
        Route::get('/laporan-pendaftaran', 'Autodebit\LSBU\PendaftaranController@index')->name('autodebit.lsbu.pendaftaran');
        Route::post('/laporan-pendaftaran', 'Autodebit\LSBU\PendaftaranController@ajax')->name('autodebit.lsbu.pendaftaran');
        Route::post('/laporan-pendaftaran/export', 'Autodebit\LSBU\PendaftaranController@export')->name('autodebit.lsbu.pendaftaran.export');
        
        //penutupan
        Route::get('/laporan-penutupan', 'Autodebit\LSBU\PenutupanController@index')->name('autodebit.lsbu.penutupan');
        Route::post('/laporan-penutupan', 'Autodebit\LSBU\PenutupanController@ajax')->name('autodebit.lsbu.penutupan');
        Route::get('/laporan-penutupan/show/{params}/{paramsDua}', 'Autodebit\LSBU\PenutupanController@show')->name('autodebit.lsbu.penutupan.show');
        Route::post('/laporan-penutupan/export', 'Autodebit\LSBU\PenutupanController@export')->name('autodebit.lsbu.penutupan.export');
  
        //fee lsbu
        Route::get('/fee-lsbu', 'Autodebit\LSBU\FeeLSBUController@index')->name('autodebit.lsbu.fee-lsbu');
        Route::post('/fee-lsbu', 'Autodebit\LSBU\FeeLSBUController@ajax')->name('autodebit.lsbu.fee-lsbu');
        Route::post('/fee-lsbu/export', 'Autodebit\LSBU\FeeLSBUController@export')->name('autodebit.lsbu.fee-lsbu.export');
      });
      //lsbu end
      //list approval start
      Route::get('/list-approval', 'Autodebit\ListApprovalController@index')->name('autodebit.listapproval');
      //list approval end
    });
  
    Route::group(['prefix' => 'skema-proses'], function () {
      //daftar skema start
      Route::get('/daftar-skema', 'SkemaProses\DaftarSkemaController@index')->name('skemaproses.daftarskema');
      Route::post('/daftar-skema', 'SkemaProses\DaftarSkemaController@ajax_goals')->name('skemaproses.daftarskema');
      Route::get('/daftar-skema/new', 'SkemaProses\DaftarSkemaController@new')->name('skemaproses.daftarskema.new');
      Route::post('/daftar-skema/new', 'SkemaProses\DaftarSkemaController@create')->name('skemaproses.daftarskema.create');
      Route::get('/daftar-skema/show/{id}', 'SkemaProses\DaftarSkemaController@show')->name('skemaproses.daftarskema.show');
      Route::post('/daftar-skema/show/{id}', 'SkemaProses\DaftarSkemaController@update')->name('skemaproses.daftarskema.update');
      //daftar skema end
  
    });
  
    Route::group(['prefix' => 'monitoring'], function () {
      //riwayat sukses start
      // Route::get('/riwayat-sukses-autodebit', 'Monitoring\RiwayatSuksesAutodebitController@index')->name('monitoring.riwayatsuksesautodebit');
      //riwayat sukses end
      //riwayat gagal start
      Route::get('/riwayat-gagal-autodebit', 'Monitoring\RiwayatGagalAutodebitController@index')->name('monitoring.riwayatgagalautodebit');
      //riwayat gagal end
      Route::get('/riwayat', 'Monitoring\RiwayatSuksesAutodebitController@index')->name('monitoring.riwayat');
  
    });
  
    Route::group(['prefix' => 'lsbu'], function () {
      //user pusat start
      Route::get('/log-activity', 'Log\UserPusatController@index')->name('log.userpusat');
      //user pusat end
      //user cabang start
      Route::get('/user-cabang', 'Log\UserCabangController@index')->name('log.usercabang');
      //user cabang end
    });
  
    Route::group(['prefix' => 'reporting'], function () {
      //pembukaan rekening start
      Route::get('/pembukaan-rekening', 'Reporting\PembukaanRekeningController@index')->name('reporting.pembukaanrekening');
      //pembukaan rekening end
      //penutupan rekening start
      Route::get('/penutupan-rekening', 'Reporting\PenutupanRekeningController@index')->name('reporting.penutupanrekening');
      //penutupan rekening end
      //daftar premi start
      Route::get('/daftar-premi', 'Reporting\DaftarPremiController@index')->name('reporting.daftarpremi');
      //daftar premi end
      //perhitungan fee lsbu start
      Route::get('/perhitungan-fee-lsbu', 'Reporting\PerhitunganFeeLsbuController@index')->name('reporting.perhitunganfeelsbu');
      //perhitungan fee lsbu end
    });
  
    Route::group(['prefix' => 'setting'], function () {
      //setup rekening start
      Route::get('/setup-rekening', 'Setting\SetupRekeningController@index')->name('setting.setuprekening');
      Route::post('/setup-rekening', 'Setting\SetupRekeningController@ajax')->name('setting.setuprekening');
      Route::get('/setup-rekening/new', 'Setting\SetupRekeningController@new')->name('setting.setuprekening.new');
      Route::post('/setup-rekening/new', 'Setting\SetupRekeningController@create')->name('setting.setuprekening.new');
      Route::post('/setup-rekening/show', 'Setting\SetupRekeningController@show')->name('setting.setuprekening.show');
      Route::post('/setup-rekening/update', 'Setting\SetupRekeningController@update')->name('setting.setuprekening.update');
      Route::post('/setup-rekening/delete', 'Setting\SetupRekeningController@delete')->name('setting.setuprekening.delete');
      //setup rekening end
      //account type start
      Route::get('/account-type', 'Setting\AccountTypeController@index')->name('setting.accounttype');
      Route::post('/account-type', 'Setting\AccountTypeController@ajax')->name('setting.accounttype');
      Route::get('/account-type/new', 'Setting\AccountTypeController@new')->name('setting.accounttype.new');
      Route::post('/account-type/new', 'Setting\AccountTypeController@create')->name('setting.accounttype.new');
      Route::post('/account-type/show', 'Setting\AccountTypeController@show')->name('setting.accounttype.show');
      Route::post('/account-type/update', 'Setting\AccountTypeController@update')->name('setting.accounttype.update');
      Route::post('/account-type/delete', 'Setting\AccountTypeController@delete')->name('setting.accounttype.delete');
      //account type end
      //group account start
      Route::group(['prefix' => 'group-account'], function () {
        Route::get('/', 'Setting\GroupAccountController@index')->name('setting.groupaccount');
        Route::post('/', 'Setting\GroupAccountController@ajax')->name('setting.groupaccount');
        Route::get('/new', 'Setting\GroupAccountController@new')->name('setting.groupaccount.new');
        Route::post('/new', 'Setting\GroupAccountController@create')->name('setting.groupaccount.new');
        Route::post('/show', 'Setting\GroupAccountController@show_ajax')->name('setting.groupaccount.show');
        Route::get('/show/{params}', 'Setting\GroupAccountController@show')->name('setting.groupaccount.shows');
        Route::post('/show/{params}', 'Setting\GroupAccountController@ajax_type')->name('setting.groupaccount.shows');
        Route::post('/shows/{params}', 'Setting\GroupAccountController@ajax_shows_type')->name('setting.groupaccount.shows-type');
        Route::post('/delete/{params}', 'Setting\GroupAccountController@delete_type')->name('setting.groupaccount.delete-type');
        Route::post('/create/{params}', 'Setting\GroupAccountController@create_type')->name('setting.groupaccount.create-type');
        Route::post('/update/{params}', 'Setting\GroupAccountController@update_type')->name('setting.groupaccount.update-type');
        Route::post('/update', 'Setting\GroupAccountController@update')->name('setting.groupaccount.update');
        Route::post('/delete', 'Setting\GroupAccountController@delete')->name('setting.groupaccount.delete');
      });
      //group account end
      //jangka waktu start
      Route::get('/jangka-waktu', 'Setting\JangkaWaktuController@index')->name('setting.jangkawaktu');
      Route::post('/jangka-waktu', 'Setting\JangkaWaktuController@ajax')->name('setting.jangkawaktu');
      Route::get('/jangka-waktu/new', 'Setting\JangkaWaktuController@new')->name('setting.jangkawaktu.new');
      Route::post('/jangka-waktu/new', 'Setting\JangkaWaktuController@create')->name('setting.jangkawaktu.new');
      Route::post('/jangka-waktu/show', 'Setting\JangkaWaktuController@show')->name('setting.jangkawaktu.show');
      Route::post('/jangka-waktu/update', 'Setting\JangkaWaktuController@update')->name('setting.jangkawaktu.update');
      Route::post('/jangka-waktu/delete', 'Setting\JangkaWaktuController@delete')->name('setting.jangkawaktu.delete');
      //jangka waktu end
      //parameter tabungan start
      Route::get('/parameter-tabungan', 'Setting\ParameterTabunganController@index')->name('setting.parametertabungan');
      Route::post('/parameter-tabungan', 'Setting\ParameterTabunganController@ajax')->name('setting.parametertabungan');
      Route::get('/parameter-tabungan/new', 'Setting\ParameterTabunganController@new')->name('setting.parametertabungan.new');
      Route::post('/parameter-tabungan/new', 'Setting\ParameterTabunganController@create')->name('setting.parametertabungan.new');
      Route::post('/parameter-tabungan/show', 'Setting\ParameterTabunganController@show')->name('setting.parametertabungan.show');
      Route::get('/parameter-tabungan/edit/{params}', 'Setting\ParameterTabunganController@edit')->name('setting.parametertabungan.edit');
      Route::post('/parameter-tabungan/edit/{params}', 'Setting\ParameterTabunganController@update')->name('setting.parametertabungan.edit');
      Route::post('/parameter-tabungan/delete', 'Setting\ParameterTabunganController@delete')->name('setting.parametertabungan.delete');
      Route::post('/parameter-tabungan/ajax/form-new', 'Setting\ParameterTabunganController@ajax_new')->name('setting.parametertabungan.ajax.form-new');
      //parameter tabungan end
      //role management start
      Route::get('/role-management', 'Setting\RoleManagementController@index')->name('setting.rolemanagement');
      Route::post('/role-management', 'Setting\RoleManagementController@ajax_roles')->name('setting.rolemanagement.ajax_roles');
      Route::post('/role-management/show', 'Setting\RoleManagementController@ajax_show')->name('setting.rolemanagement.show');
      Route::get('/role-management/new', 'Setting\RoleManagementController@new')->name('setting.rolemanagement.new');
      Route::post('/role-management/new', 'Setting\RoleManagementController@create')->name('setting.rolemanagement.insert');
      Route::post('/role-management/update', 'Setting\RoleManagementController@update')->name('setting.rolemanagement.update');
      Route::post('/role-management/branches', 'Setting\RoleManagementController@ajax_branches')->name('setting.rolemanagement.branches');
      Route::get('/role-management/access/{roleId}', 'Setting\RoleManagementController@access')->name('setting.rolemanagement.access');
      Route::post('/role-management/access', 'Setting\RoleManagementController@ajax_access_by_role')->name('setting.rolemanagement.access');
      Route::post('/role-management/access/role-permission', 'Setting\RoleManagementController@ajax_update_permission')->name('setting.rolemanagement.access.role_permission');
      //role management end
      //schedule start
      Route::get('/scheduler', 'Setting\SchedulerController@index')->name('setting.scheduler');
      Route::post('/scheduler', 'Setting\SchedulerController@ajax')->name('setting.scheduler');
      Route::get('/scheduler/new', 'Setting\SchedulerController@new')->name('setting.scheduler.new');
      Route::post('/scheduler/new', 'Setting\SchedulerController@create')->name('setting.scheduler.new');
      Route::post('/scheduler/show', 'Setting\SchedulerController@show')->name('setting.scheduler.show');
      Route::get('/scheduler/edit/{params}', 'Setting\SchedulerController@edit')->name('setting.scheduler.edit');
      Route::post('/scheduler/edit/{params}', 'Setting\SchedulerController@update')->name('setting.scheduler.edit');
      Route::post('/scheduler/delete', 'Setting\SchedulerController@delete')->name('setting.scheduler.delete');
      //schedule end
      //setup eq start
      Route::get('/setup-eq', 'Setting\SetupEqController@index')->name('setting.setupeq');
      Route::post('/setup-eq', 'Setting\SetupEqController@ajax')->name('setting.setupeq');
      Route::get('/setup-eq/new', 'Setting\SetupEqController@new')->name('setting.setupeq.new');
      Route::post('/setup-eq/new', 'Setting\SetupEqController@create')->name('setting.setupeq.new');
      Route::post('/setup-eq/show', 'Setting\SetupEqController@show')->name('setting.setupeq.show');
      Route::get('/setup-eq/edit/{params}', 'Setting\SetupEqController@edit')->name('setting.setupeq.edit');
      Route::post('/setup-eq/edit', 'Setting\SetupEqController@update')->name('setting.setupeq.edit');
      Route::post('/setup-eq/delete', 'Setting\SetupEqController@delete')->name('setting.setupeq.delete');
      //setup eq end
    });

    Route::group(['prefix' => 'download-manager'], function() {
      Route::get('/', 'DownloadManager\DownloadManagerController@index')->name('download-manager');
      Route::post('/', 'DownloadManager\DownloadManagerController@ajax')->name('download-manager');
      Route::post('/delete', 'DownloadManager\DownloadManagerController@delete')->name('download-manager.delete');
      Route::get('/download/{params}', 'DownloadManager\DownloadManagerController@download')->name('download-manager.download');
    });

    Route::group(['prefix' => 'data-warehouse'], function() {
      Route::get('/', 'DataWarehouse\DataWarehouseController@index')->name('data-warehouse');
      Route::post('/', 'DataWarehouse\DataWarehouseController@ajax')->name('data-warehouse');
      Route::post('/delete', 'DataWarehouse\DataWarehouseController@delete')->name('data-warehouse.delete');
      Route::get('/download/{params}', 'DataWarehouse\DataWarehouseController@download')->name('data-warehouse.download');
    });
  });

  //route digunakan untuk menambahkan module ke sys_role_permissions
  Route::get('/insert-batch/rpermission/{applicationId}/{type}', 'DashboardController@insert_batch')->name('batching');
  Route::get('/insert-batch/permission/{permissionId}', 'DashboardController@insert_batch_permission')->name('batching-permission');

  //route digunakan untuk User Activity 
  Route::post('/user-log-activity', 'Controller@logActivity')->name('logactivity');
});