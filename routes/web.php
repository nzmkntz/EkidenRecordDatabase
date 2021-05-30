<?php

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

////////////////////////
// ルートページに遷移
////////////////////////
Route::get('/', function () {
    return view('index');
});
// ルートページでの言語変更
Route::post('/', 'MainController@setLocale');

////////////////////////
// 
// 検索系
// 
////////////////////////
// 検索メインに遷移
Route::get('/search/main', 'SearchController@searchMain');

// 検索ボタン押下後
Route::post('/search/exec', 'SearchController@searchExec');

// チャート
Route::get('/search/chart', 'SearchController@makeChart');

////////////////////////
// 
// 登録系
// 
////////////////////////
// 登録メインに遷移
Route::get('/update/main', 'UpdateController@updateMain');

// 各種登録画面に遷移
Route::get('/update/{kind}', 'UpdateController@updateKind');

// ajaxでのデータ取得
Route::get('/update/ajax/searchM_PLAYERS', 'UpdateController@updateAjaxSearchM_PLAYERS');    // ←{proc}をやめて個別指定にかえようとしている
Route::get('/update/ajax/{proc}', 'UpdateController@updateAjax');
Route::post('/update/ajax/{proc}', 'UpdateController@updateAjax');

// 年別登録画面のキー情報検索処理に遷移
Route::post('/update/recYear/{proc}', 'UpdateController@updateYearProc');

// 選手別登録画面のキー情報検索処理に遷移
Route::post('/update/recPlayer/{proc}', 'UpdateController@updatePlayerProc');

// 大学マスタ、選手マスタの検索・登録
Route::post('/update/{kind}', 'UpdateController@updateKind');

////////////////////////
// 
// メンテナンスに遷移
// 
////////////////////////
// メンテナンスに遷移
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () { 
    Route::get('/maintenance/main', 'MaintenanceController@maintenanceMain');
});





////////////////////////
// Default pages
////////////////////////
// welcomeページ
Route::get('/welcome', function () {
    return view('welcome');
});

// auth
Auth::routes();

// authorization sample page
Route::get('/home', 'HomeController@index')->name('home');
