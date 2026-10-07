<?php

use App\Http\Controllers\SignatureController;
use App\Models\SignatureMod;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\TryCatch;

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

Route::get('/', function () {
    return view('login');
});

//TEST POUR LA CONNECTION A DASHBOARD
Route::get('/test', [SignatureController::class, 'test'])->name('test');


//AFFICHAGE DES LA PAGE DE LOGIN
Route::get('/login', function () { return view('login');});

//VALIDATION DU LOGIN ET MOT DE PASS
Route::post('/validation', [SignatureController::class, 'connection'])->name('envoyer');


//AFFICHAGE DE LA PAGE DASHBOARD
//Route::get('/accueil', function () { return view('dashboard');});

Route::get('/accueil', [SignatureController::class, 'dashboard'])->name('accueil');

//DECONNECT
Route::get('logout', [SignatureController::class, 'destroy'])->name('logout');












//Route::get('/login', function () { return view('login');});

//Route::get('/login', [SignatureController::class, 'connection'])->name('login');

//Route::post('/', 'SignatureController@connection')->name('form.submit');


//Route::post('/validation', [SignatureController::class, 'connection'])->name('envoyer');