<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FoodMenuController;
use App\Http\Controllers\SpecialDishController;
use App\Http\Controllers\TestimonialController;

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

/* home */
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

/* Admin */
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/dashboard', 'index')->name('admin.index');
});

/* User */
Route::resource('user', UserController::class)->only([
    'index','destroy'
]);


Route::resource('contact', \App\Http\Controllers\ContactController::class)->only([
    'index', 'create', 'store', 'edit', 'update', 'destroy'
]);

Route::resource('department', \App\Http\Controllers\DepartmentController::class)->only([
    'index', 'create', 'store', 'edit', 'update', 'destroy'
]);

Route::match(['get', 'post'], '/contacts/search', 'App\Http\Controllers\AdminController@search')->name('contacts.search');



/* jetstream auth */
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

