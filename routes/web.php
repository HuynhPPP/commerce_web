<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Backend\PostCatalogueController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Ajax\LocationController;

use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;



Route::get('/', function () {
    return view('welcome');
});

/*Backend routes*/
Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(AuthenticateMiddleware::class);

/* USER */
Route::group(['prefix' => 'user'], function () {
    Route::get('index', [UserController::class, 'index' ])->name('user.index')->middleware(AuthenticateMiddleware::class);
    Route::get('create', [UserController::class, 'create'])->name('user.create')->middleware(AuthenticateMiddleware::class);
    Route::post('store', [UserController::class, 'store'])->name('user.store')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy')->middleware(AuthenticateMiddleware::class);
});

/* USER-Catalogue */
Route::group(['prefix' => 'user/catalogue'], function () {
    Route::get('index', [UserCatalogueController::class, 'index' ])->name('user.catalogue.index')->middleware(AuthenticateMiddleware::class);
    Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create')->middleware(AuthenticateMiddleware::class);
    Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy')->middleware(AuthenticateMiddleware::class);
});

/* LANGUAGE */
Route::group(['prefix' => 'language'], function () {
    Route::get('index', [LanguageController::class, 'index' ])->name('language.index')->middleware(AuthenticateMiddleware::class);
    Route::get('create', [LanguageController::class, 'create'])->name('language.create')->middleware(AuthenticateMiddleware::class);
    Route::post('store', [LanguageController::class, 'store'])->name('language.store')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/edit', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('language.edit')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/update', [LanguageController::class, 'update'])->where(['id' => '[0-9]+'])->name('language.update')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/delete', [LanguageController::class, 'delete'])->where(['id' => '[0-9]+'])->name('language.delete')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/destroy', [LanguageController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('language.destroy')->middleware(AuthenticateMiddleware::class);
});

/* BLOGS-ADMIN */
Route::group(['prefix' => 'post/catalogue'], function () {
    Route::get('index', [PostCatalogueController::class, 'index' ])->name('post.catalogue.index')->middleware(AuthenticateMiddleware::class);
    Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create')->middleware(AuthenticateMiddleware::class);
    Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/edit', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/update', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.catalogue.update')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/delete', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/destroy', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy')->middleware(AuthenticateMiddleware::class);
});

/* AJAX */
Route::get('ajax/Location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index')->middleware(AuthenticateMiddleware::class);
Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus')->middleware(AuthenticateMiddleware::class);
Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll')->middleware(AuthenticateMiddleware::class);


Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware(LoginMiddleware::class);
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
