<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Options Html API ===========================
Route::get('/bible/options/{book?}/{chapter?}/{startVs?}/{endVs?}', function ($book = "", $chapter = "", $startVs = "", $endVs = "") {
    return view('bible.bible_options', [
        'book'    => $book,
        'chapter' => $chapter,
        'startVs' => $startVs,
        'endVs'   => $endVs
    ]);
});


// Generate bible scripture
Route::post('/bible/gen', function() {
    return view('bible.bible_gen');
});
