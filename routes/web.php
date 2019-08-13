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

Route::domain(config('app.domain'))->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    Auth::routes();

    Route::group(['prefix' => str_slug('init tenant')], function() {
        Route::get('/', 'TenantController@create');
        Route::post('/', 'TenantController@store');
    });
});

// NOTE: activate line below to use app in a prod-like env, else, $tenant value will be available for demo purposes
// Route::domain('{tenant}.' . 'tenancy.' . config('app.domain'))->middleware(['subdomain.resolution'])->group(function () {
Route::domain('{tenant}.' . config('app.tenancy') . '.' . config('app.domain'))->middleware(['subdomain.resolution'])->group(function () {
    Route::get('/', function () {
        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        $tenant = $hostname->fqdn;

        return view('welcome')->with(compact('tenant'));
    });

    Route::get('articles/table', 'ArticleController@table')->name('articles.table');
    Route::resource('articles', 'ArticleController');
});
