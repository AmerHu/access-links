<?php

use App\Http\Controllers\AccessLinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
 

Route::get('/', [AccessLinkController::class, 'showForm'])->name('form');
Route::post('/generate-link', [AccessLinkController::class, 'generateLink'])->name('generate-link');
Route::get('/secure-content/{token}', [AccessLinkController::class, 'secureContent'])->name('secure-content')->middleware('signed');
