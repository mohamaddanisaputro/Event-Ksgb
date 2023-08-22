<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use app\Http\Controllers\AuthController;
// use app\Http\Controllers\RegisterController;


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

// itu middleware ganti dulu pak sesuai tutor
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/v1/posts', 'api\v1\PostsController@index');
Route::post('/v1/posts/store', 'api\v1\PostsController@store');
Route::post('/v1/posts/update', 'api\v1\PostsController@update');
Route::get('/v1/posts/{id?}', 'api\v1\PostsController@show');
Route::delete('/v1/posts/{id?}', 'api\v1\postsController@destroy');


Route::post('/register', api\RegisterController::class)->name('register');
Route::post('/login',api\LoginController::class)->name('login');
Route::post('/logout',api\LogoutController::class)->name('logout');

Route::post('/v1/peserta/store', 'api\v1\PesertaController@store');
Route::post('/v1/peserta/update', 'api\v1\PesertaController@update');
Route::get('/v1/peserta', 'api\v1\PesertaController@index');
Route::get('/v1/peserta/{id?}', 'api\v1\PesertaController@show');
Route::delete('/v1/peserta/{id?}', 'api\v1\PesertaController@destroy');

Route::post('/v1/kategorikelas/store', 'api\v1\KategoriKelasController@store');
Route::post('/v1/kategorikelas/update', 'api\v1\KategoriKelasController@update');
Route::get('/v1/kategorikelas', 'api\v1\KategoriKelasController@index');
Route::get('/v1/kategorikelas/{id?}', 'api\v1\KategoriKelasController@show');

Route::delete('/v1/kategorikelas/{id?}', 'api\v1\KategoriKelasController@destroy');




