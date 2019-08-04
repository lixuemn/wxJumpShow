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

Route::post('/ajax/{id}', function ($id) {
    $article = \Illuminate\Support\Facades\DB::connection('mysql')
        ->table('articles')
        ->where('id', $id)
        ->first();
    return response()->json($article);
});

Route::get('A-url/{id}', 'AurlController@index');
//Route::get('show/{id}','ShowController@index');
//Route::get('frame/{id}','IframeController@index');
Route::post('getArticle/{id}', 'ShowController@getArticle');

Route::get('/update/article/{id}', 'CacheFile\CacheFileController@index');


Route::any('form/{id}', function ($id) {
    $article = (array)\Illuminate\Support\Facades\DB::connection('mysql_data')
        ->table('articles')
        ->where('id', $id)
        ->first();
    $obj = new  \App\Http\Controllers\Article\Template\Tempalte2($article);
    return $obj->getContent();
});

Route::get('ttt', function() {
    return view('tt');
});

Route::get('show/{id}', 'ArticleController@show');
Route::get('iframe/{id}', 'ArticleController@show');
