<?php

use Illuminate\Support\Facades\Route;
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
    'admin/teachings' => TeachingController::class
]);

Route::get( '/bible/options/{book?}/{chapter?}/{startVs?}/{endVs?}', function($book = "", $chapter = "", $startVs = "", $endVs = "") {
    return view('bible.bibleapi', [
        'book'    => $book,
        'chapter' => $chapter,
        'startVs' => $startVs,
        'endVs'   => $endVs
    ]);
});

// Route::get('/bible/{query}', function($query) {
//     return view('bible.bibleapi', ['query' => $query]);
// } );


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



