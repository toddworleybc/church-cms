<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeachingController;

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

Route::view('/', 'index')->name('index');

Route::view('/welcome', 'welcome');

Route::view('/admin', 'admin.index')->name('admin.index');




//Admin Resources ===/
Route::resources([
    'admin/teachings' => TeachingController::class,
    'admin/staff'     => StaffController::class,
    'admin/events'    => EventController::class
]);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// DONT FORGET TO ADD AUTH MIDDLEWARE FOR FILEMANAGER BELOW!!!!!!!!!!

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
