<?php

use App\Http\Controllers\MonTest;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\ApiSign;
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
//Route::put('/logout', [SignatureController::class, 'logout'])->name('logout');
Route::get('logout', [SignatureController::class, 'destroy'])->name('logout');



//SIGNATURE DOCUMENT
Route::get('/signature/{mail}/{doc}', [ApiSign::class, 'getSignateur'])->name('signer');


//RETOUR AU TABLEAU DE BORD
//Route::get('/quit', [ApiSign::class, 'quitter'])->name('quit');

Route::post('/quit', [ApiSign::class, 'quitter'])->name('quit');

//*******************
Route::get('/test/{mail}/{doc}', [ApiSign::class, 'getSignateur'])->name('test');

Route::get('/test1/{doc}', [ApiSign::class, 'apiSign'])->name('test1');








//***************************************************************************************************************** */
Route::get('/api/{mail}', [ApiSign::class, 'getSignateur1']);

Route::get('/statut/{wkfl}', [ApiSign::class, 'statutworkflow']);
//************************************************************** */

Route::get('/apitest', [MonTest::class, 'mafonction']);


//Route::get('/login', function () { return view('login');});

//Route::get('/login', [SignatureController::class, 'connection'])->name('login');

//Route::post('/', 'SignatureController@connection')->name('form.submit');


//Route::post('/validation', [SignatureController::class, 'connection'])->name('envoyer');