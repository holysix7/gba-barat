<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('list-provinsi', 'Api\GeneralController@provinsi');
Route::post('list-kabkota', 'Api\GeneralController@kabkota');
Route::post('list-kecamatan', 'Api\GeneralController@kecamatan');
Route::post('list-kelurahan', 'Api\GeneralController@kelurahan');
Route::post('wilayah', 'Api\GeneralController@wilayah');
Route::post('list-bank', 'Api\GeneralController@bank');
Route::post('store-activity', 'Api\MongoController@store_activity');
Route::post('gen-otp', 'Api\GeneralController@genotp');
/**
 * API QS 4 Eyes
 */
Route::post('list-management-four-eyes', 'Api\FourEyesController@index');
Route::post('list-management-four-eyes/show', 'Api\FourEyesController@show');
Route::post('list-management-four-eyes/edit', 'Api\FourEyesController@edit');
Route::post('list-management-four-eyes/like', 'Api\FourEyesController@like');
Route::post('list-management-four-eyes/detail/like', 'Api\FourEyesController@show_like');
Route::post('list-management-four-eyes/detail/edit', 'Api\FourEyesController@show_edit');
Route::post('list-management-four-eyes/detail/new', 'Api\FourEyesController@show_new');
Route::post('list-management-four-eyes/detail/new/params', 'Api\FourEyesController@show_new_params');
Route::post('list-management-four-eyes/detail/edit/akses', 'Api\FourEyesController@show_edit_akses');

//fds
Route::get('fds/skema', 'Api\FdsController@getSkemas');
Route::get('fds/skema-param', 'Api\FdsController@getSkemaParams');
Route::post('fds/list-risk-category', 'Api\FdsController@getListRiskCategory');
Route::post('fds/detail-risk-category', 'Api\FdsController@getDetailRiskCategory');
Route::post('fds/insert-param', 'Api\FdsController@storeParam');

//sof
//Route::get('sof/top-transaction-by-customer', 'Api\SOF\MonitoringtransactionController@getTopTransactionByCustomer');

//sharing fee
Route::get('sharing-fee', 'Api\SharingFeeController@getMdrData');

/**
 * API JMTO Bank
 */
Route::post('jmto-bank', 'Api\GeneralController@getJmtoBank');