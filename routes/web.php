<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JsonController;

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

Route::get('/uploadJson', function () {
    return view('upload');
});

Route::post('/import', [JsonController::class, 'import'])->name('json.import');
Route::get('pdfData',  [JsonController::class, 'index']);
