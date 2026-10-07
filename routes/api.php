<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiConnectionController;
use App\Http\Controllers\MonTest;


//BIOMETRIE


use App\Http\Controllers\Api_Biometrie\FonctionnaireController;
use App\Http\Controllers\Api_Biometrie\SigfaeController;
use App\Http\Controllers\Api_Biometrie\StatutDossierController;
use App\Http\Controllers\Api_Biometrie\TableRecenseController;
use App\Http\Controllers\Api\FusionCopieController;

use App\Http\Controllers\Api_Biometrie\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('connection', [ApiConnectionController::class, 'connection']);

Route::post('validateconnection', [ApiConnectionController::class, 'validateConnection']);

Route::post('liste_agent', [ApiConnectionController::class, 'les_agent_en_service']);

Route::post('carriere', [ApiConnectionController::class, 'carriere']);

Route::post('civilite', [ApiConnectionController::class, 'civilite']);

Route::post('classe', [ApiConnectionController::class, 'classe']);

Route::post('emploi', [ApiConnectionController::class, 'emploi']);

Route::post('info_agent', [ApiConnectionController::class, 'info_agent']);

Route::post('enfant', [ApiConnectionController::class, 'enfant']);

Route::post('grade', [ApiConnectionController::class, 'grade']);

Route::post('ville', [ApiConnectionController::class, 'ville']);

Route::post('type_agent', [ApiConnectionController::class, 'type_agent']);

Route::post('type_acte', [ApiConnectionController::class, 'type_acte']);

Route::post('struct', [ApiConnectionController::class, 'struct']);

Route::post('statut_jur', [ApiConnectionController::class, 'statut_jur']);

Route::post('position', [ApiConnectionController::class, 'position']);

Route::post('sit_matri', [ApiConnectionController::class, 'sit_matri']);

Route::post('nature_acte', [ApiConnectionController::class, 'nature_acte']);

Route::post('motif_position', [ApiConnectionController::class, 'motif_position']);

Route::post('mvt_agt_emp', [ApiConnectionController::class, 'mvt_agt_emp']);

Route::post('mvt_agt_str', [ApiConnectionController::class, 'mvt_agt_str']);


Route::post('echelon', [ApiConnectionController::class, 'echelon']);
Route::post('emp_grade', [ApiConnectionController::class, 'emp_grade']);
Route::post('position_histo', [ApiConnectionController::class, 'position_histo']);


Route::get('test-curl', [MonTest::class, 'testCurl']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


######################################################################################################
###################################################API BIOMETRIE######################################
######################################################################################################


//authentification , pour recuperer token

Route::post('/login', [AuthController::class, 'login']);


//route pour verifier si l'agent est recenser dans l'espace fonctionnaire
Route::get('/verifier-recensement/{matricule}', [TableRecenseController::class, 'verifier']);



//route qui copie TBCE_AGT sur sigfae
Route::get('/sync-sigfae', [SigfaeController::class, 'syncExternalData']);


// Route spécifique pour le recensement
Route::post('recenser-fonctionnaires', [TableRecenseController::class, 'recenserFonctionnaires']);





######################################################################################################
###################################################API BIOMETRIE######################################
######################################################################################################


//ROUTE pour faire la copie instantannee
Route::post('/fusioncopie', [FusionCopieController::class, 'fusionnerEtCopier']);

//COMPTER LE NOMBRE DE LIGNE RESTANT APRES LES 50 PREMIERE COPIE
Route::get('/compterlignes', [FusionCopieController::class, 'compterLignes']);


//route pour tester si ya des donner dans les 2 vue
Route::get('/test-oracle', [FusionCopieController::class, 'testOracle']);

//route pour les diferent updat dans tbce_agt_bio
// Route pour mettre à jour ETAT_RECENSEMENT dans TBCE_AGT_BIO
Route::post('/update-etat-recensement', [FusionCopieController::class, 'mettreAJourEtatRecensement']);



