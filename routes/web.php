<?php

use App\Http\Controllers\Admin\ManageArticleCategoryController;
use App\Http\Controllers\Admin\ManageArticleController;
use App\Http\Controllers\Admin\ManageProductCategoryController;
use App\Http\Controllers\Admin\ManageProductController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function () {
    Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'App\Http\Controllers\Auth\RegisterController@create');
    Route::get('login','App\Http\Controllers\Auth\LoginController@showLoginForm');
    Route::post('login','App\Http\Controllers\Auth\LoginController@Login');
});
Route::get('/', 'App\Http\Controllers\Market\HomeController@index');
Route::post('/', 'App\Http\Controllers\Market\HomeController@search');
Route::get('/blog/{id}', 'App\Http\Controllers\Market\HomeController@GetArticle');
Route::get('/product/{id}', 'App\Http\Controllers\Market\HomeController@GetProduct');
Route::post('/buy/{id}', 'App\Http\Controllers\Market\HomeController@Purchase');
Route::get('/blog/category/{id}/{page}/{take}', 'App\Http\Controllers\Market\HomeController@GetArticleCatgeory');
Route::get('/product/category/{id}/{page}/{take}', 'App\Http\Controllers\Market\HomeController@GetProductCatgeory');
Route::get('/dashboard', 'App\Http\Controllers\Dashboard\DashboardController@Index');

Route::group(['prefix' => 'admin'], function () {

    Route::get('/', '\App\Http\Controllers\Admin\PanelController@index');
    Route::get('/login', '\App\Http\Controllers\AdminAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', '\App\Http\Controllers\AdminAuth\LoginController@login');
    Route::post('/logout', '\App\Http\Controllers\AdminAuth\LoginController@logout')->name('logout');

    Route::get('/register', '\App\Http\Controllers\AdminAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', '\App\Http\Controllers\AdminAuth\RegisterController@register');

    Route::post('/password/email', '\App\Http\Controllers\AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', '\App\Http\Controllers\AdminAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', '\App\Http\Controllers\AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', '\App\Http\Controllers\AdminAuth\ResetPasswordController@showResetForm');

    Route::resource('ManageArticle', ManageArticleController::class)->middleware('admin');
    Route::resource('ManageArticleCategory', ManageArticleCategoryController::class)->middleware('admin');
    Route::resource('ManageProduct', ManageProductController::class)->middleware('admin');
    Route::resource('ManageProductCategory', ManageProductCategoryController::class)->middleware('admin');

    Route::get('/home', function () {
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('admin')->user();

        return view('admin.home');
    })->name('home');
});


