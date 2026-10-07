<?php

use App\Http\Controllers\MonTest;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\ApiSign;
use App\Http\Controllers\GroupSign;
use App\Http\Controllers\TestGroup;
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

//AFFICHAGE DES ACTES EN INSTANCE DE SIGNATURE
Route::get('/instance', [SignatureController::class, 'instance'])->name('instance');

//AFFICHAGE DES ACTES SIGNES
Route::get('/tous_signe', [SignatureController::class, 'tous_signe'])->name('tous_signe');

//DECONNECT
//Route::put('/logout', [SignatureController::class, 'logout'])->name('logout');
Route::get('logout', [SignatureController::class, 'destroy'])->name('logout');



//SIGNATURE DOCUMENT
Route::get('/signature/{mail}/{doc}', [ApiSign::class, 'getSignateur'])->name('signer');

//SIGNATURE GROUPE DOCUMENT
Route::post('/grouper', [GroupSign::class, 'grouper'])->name('grouper');
Route::get('/Tgrouper/{doc}', [TestGroup::class, 'groupe'])->name('Tgrouper');
Route::post('/quitgroupe', [TestGroup::class, 'quittergroupe'])->name('quitgroupe');

//VOIR DOCUMENT
Route::get('/document/{doc}', [SignatureController::class, 'document'])->name('document');
Route::get('/documentsigner/{doc}', [SignatureController::class, 'documentsigner'])->name('documentsigner');

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

//********************************************************************* */
Route::get('/fin_formation', [SignatureController::class, 'fin_formation'])->name('fin_formation');
Route::get('/mise_formation', [SignatureController::class, 'mise_formation'])->name('mise_formation');
Route::get('/communique', [SignatureController::class, 'communique'])->name('communique');
Route::get('/arrete', [SignatureController::class, 'arrete'])->name('arrete');

Route::get('/att_prime', [SignatureController::class, 'att_prime'])->name('att_prime');
Route::get('/dom_prime', [SignatureController::class, 'dom_prime'])->name('dom_prime');
Route::get('/pret_banc', [SignatureController::class, 'pret_banc'])->name('pret_banc');
Route::get('/rgs', [SignatureController::class, 'rgs'])->name('rgs');
Route::get('/arsa', [SignatureController::class, 'arsa'])->name('arsa');

Route::get('/comm_ouv', [SignatureController::class, 'comm_ouv'])->name('comm_ouv');
Route::get('/arrete_ouv', [SignatureController::class, 'arrete_ouv'])->name('arrete_ouv');


Route::get('/mise_formation_hors_pays_en_instance_de_signature', [SignatureController::class, 'ccm_instance'])->name('ccm_instance');
Route::get('/mise_formation_hors_pays_signe', [SignatureController::class, 'ccm_signe'])->name('ccm_signe');



//***************************************************************************** */

Route::get('/test_ccm', [SignatureController::class, 'test_ccm'])->name('test_ccm');



//***************************************************************************** */

//AFFICHAGE DES ACTES SIGNES
Route::get('/signe', [SignatureController::class, 'signe'])->name('signe');
Route::post('/signe', [SignatureController::class, 'filter'])->name('filter');
Route::post('/signe_ccm', [SignatureController::class, 'filter_ccm'])->name('filter_ccm');

Route::get('/fin_formation_signe', [SignatureController::class, 'fin_formation_signe'])->name('fin_formation_signe');
Route::get('/mise_formation_signe', [SignatureController::class, 'mise_formation_signe'])->name('mise_formation_signe');
Route::get('/communique_signe', [SignatureController::class, 'communique_signe'])->name('communique_signe');
Route::get('/arrete_signe', [SignatureController::class, 'arrete_signe'])->name('arrete_signe');

Route::get('/pret_bancair_signe', [SignatureController::class, 'pret_bancair_signe'])->name('pret_bancair_signe');
Route::get('/rgs_signe', [SignatureController::class, 'rgs_signe'])->name('rgs_signe');
Route::get('/arsa_signe', [SignatureController::class, 'arsa_signe'])->name('arsa_signe');
Route::get('/att_prime_signe', [SignatureController::class, 'att_prime_signe'])->name('att_prime_signe');
Route::get('/dom_prime_signe', [SignatureController::class, 'dom_prime_signe'])->name('dom_prime_signe');

Route::get('/comm_ouv_signe', [SignatureController::class, 'comm_ouv_signe'])->name('comm_ouv_signe');
Route::get('/arrete_ouv_signe', [SignatureController::class, 'arrete_ouv_signe'])->name('arrete_ouv_signe');





//AFFICHAGE DE LA PAGE DASHBOARD MINISTRE , DAF ET DGAPCE
Route::get('/accueil1', [SignatureController::class, 'dashboard_min'])->name('accueil');
Route::get('/accueil2', [SignatureController::class, 'dashboard_daf'])->name('accueil');
Route::get('/accueil3', [SignatureController::class, 'dashboard_dgapce'])->name('accueil');
Route::get('/accueil4', [SignatureController::class, 'dashboard_ccm'])->name('accueil');

Route::get('/stat1', [SignatureController::class, 'signe_min'])->name('sat');
Route::get('/stat2', [SignatureController::class, 'signe_daf'])->name('sat');
Route::get('/stat3', [SignatureController::class, 'signe_dgapce'])->name('sat');
Route::get('/stat4', [SignatureController::class, 'signe_ccm'])->name('sat');




//TMP_RCANDEMPSTRUCT
Route::get('/TMP_RCANDEMPSTRUCT', [SignatureController::class, 'TMP_RCANDEMPSTRUCT'])->name('TMP_RCANDEMPSTRUCT');




// Route pour le traitement du QR Code
//Route::post('/traiter-qr-pdf', [ApiSign::class, 'traiterQrPdf']);
//Route::get('/verif/{nomCrypte}', [ApiSign::class, 'verifierActe'])->name('pdf.verify');

// Page de décryptage et de vérification d'authenticité de l'acte (/verif/{nomCrypte})
Route::get('/verif/{nomCrypte}', [ApiSign::class, 'verifierActe'])->name('pdf.verify');

// Visionneuse / Prévisualisation des documents
Route::get('/documents/view/{filename}', [ApiSign::class, 'viewDocumentFile'])->name('documents.view');