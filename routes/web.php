<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Backend\PostCatalogueController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\GenerateController;
use App\Http\Controllers\Ajax\LocationController;

use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;



Route::get('/', function () {
    return view('welcome');
});

/*Backend routes*/

Route::group(['middleware' => ['admin', 'locale']], function() {
    Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    /* USER */
    Route::group(['prefix' => 'user'], function () {
        Route::get('index', [UserController::class, 'index' ])->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
        Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update');
        Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
        Route::post('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy');
    });

    /* USER-Catalogue */
    Route::group(['prefix' => 'user/catalogue'], function () {
        Route::get('index', [UserCatalogueController::class, 'index' ])->name('user.catalogue.index');
        Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
        Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
        Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit');
        Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update');
        Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete');
        Route::post('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy');
        Route::get('permission', [UserCatalogueController::class, 'permission'])->name('user.catalogue.permission');
        Route::post('updatePermission', [UserCatalogueController::class, 'updatePermission'])->name('user.catalogue.updatePermission');
    });

    /* LANGUAGE */
    Route::group(['prefix' => 'language'], function () {
        Route::get('index', [LanguageController::class, 'index' ])->name('language.index');
        Route::get('create', [LanguageController::class, 'create'])->name('language.create');
        Route::post('store', [LanguageController::class, 'store'])->name('language.store');
        Route::get('{id}/edit', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('language.edit');
        Route::post('{id}/update', [LanguageController::class, 'update'])->where(['id' => '[0-9]+'])->name('language.update');
        Route::get('{id}/delete', [LanguageController::class, 'delete'])->where(['id' => '[0-9]+'])->name('language.delete');
        Route::post('{id}/destroy', [LanguageController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('language.destroy');
        Route::get('{id}/switch', [LanguageController::class, 'switchBackendLanguage' ])->where(['id' => '[0-9]+'])->name('language.switch');
        Route::get('{id}/{languageId}/{model}/translate', [LanguageController::class, 'translate'])->where(['id' => '[0-9]+', 'languageId' => '[0-9]+'])->name('language.translate');
        Route::post('storeTranslate', [LanguageController::class, 'storeTranslate'])->name('language.storeTranslate');
    });

    /* POST-CATALOGUES */
    Route::group(['prefix' => 'post/catalogue'], function () {
        Route::get('index', [PostCatalogueController::class, 'index' ])->name('post.catalogue.index');
        Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
        Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
        Route::get('{id}/edit', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit');
        Route::post('{id}/update', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.catalogue.update');
        Route::get('{id}/delete', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete');
        Route::post('{id}/destroy', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy');
    });

    /* POST */
    Route::group(['prefix' => 'post'], function () {
        Route::get('index', [PostController::class, 'index' ])->name('post.index');
        Route::get('create', [PostController::class, 'create'])->name('post.create');
        Route::post('store', [PostController::class, 'store'])->name('post.store');
        Route::get('{id}/edit', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.edit');
        Route::post('{id}/update', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.update');
        Route::get('{id}/delete', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete');
        Route::post('{id}/destroy', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.destroy');
    });

    /* PERMISSION */
    Route::group(['prefix' => 'permission'], function () {
        Route::get('index', [PermissionController::class, 'index' ])->name('permission.index');
        Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('{id}/edit', [PermissionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('permission.edit');
        Route::post('{id}/update', [PermissionController::class, 'update'])->where(['id' => '[0-9]+'])->name('permission.update');
        Route::get('{id}/delete', [PermissionController::class, 'delete'])->where(['id' => '[0-9]+'])->name('permission.delete');
        Route::post('{id}/destroy', [PermissionController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('permission.destroy');
    });

    /* MODULE */
    Route::group(['prefix' => 'generate'], function () {
        Route::get('index', [GenerateController::class, 'index' ])->name('generate.index');
        Route::get('create', [GenerateController::class, 'create'])->name('generate.create');
        Route::post('store', [GenerateController::class, 'store'])->name('generate.store');
        Route::get('{id}/edit', [GenerateController::class, 'edit'])->where(['id' => '[0-9]+'])->name('generate.edit');
        Route::post('{id}/update', [GenerateController::class, 'update'])->where(['id' => '[0-9]+'])->name('generate.update');
        Route::get('{id}/delete', [GenerateController::class, 'delete'])->where(['id' => '[0-9]+'])->name('generate.delete');
        Route::post('{id}/destroy', [GenerateController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('generate.destroy');


    });

    /* AJAX */
    Route::get('ajax/Location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index');
    Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');
    Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');
});





Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware(LoginMiddleware::class);
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
