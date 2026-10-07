<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fonctionnaire;
use App\Models\TableRecense;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TableRecenseController extends Controller
{
   

public function recenserFonctionnaires(Request $request)
{
    // 🔐 1. Récupérer le token
    $token = $request->bearerToken();

    if (!$token) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token manquant'
        ], 401);
    }

    // 🔎 2. Vérifier s'il existe
    $tokenData = DB::table('zutilisateur_tokens')
        ->where('token', $token)
        ->first();

    if (!$tokenData) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token invalide'
        ], 401);
    }

    // ⏳ 3. Vérifier expiration
    if (Carbon::now()->greaterThan(Carbon::parse($tokenData->expires_at))) {
        return response()->json([
            'status' => 'error',
            'message' => 'Clé de sécurité expirée'
        ], 401);
    }

    // ===================================
    // 🚀 TOKEN VALIDE → TRAITEMENT
    // ===================================




    $fonctionnaires = Fonctionnaire::get();

$insertData = [];

foreach ($fonctionnaires as $f) {

    $existing = TableRecense::where('FON_Matricule', $f->FON_Matricule)->first();

    // Si le matricule n'existe pas → on insère
    if (!$existing) {
        $insertData[] = $f->only([
            // 👉 tes champs ici (je les laisse comme dans ton code)

                        'FON_Matricule',
                        'STAT_Code',
                        'FON_SIGFAENom',
                        'FON_SIGFAEPrenoms',
                        'FON_SIGFAENomEpouse',
                        'FON_SIGFAENomJeuneFille',
                        'FON_SIGFAEDatNais',
                        'FON_SIGFAELieuNais',
                        'FON_SIGFAESexe',
                        'FON_SIGFAESexeLibel',
                        'FON_SIGFAECivilite',
                        'FON_SIGFAECiviliteLibel',
                        'FON_SIGFAESituaMatrimo',
                        'FON_SIGFAESituaMatrimoLibel',
                        'FON_SIGFAEPerNom',
                        'FON_SIGFAEPerPrenoms',
                        'FON_SIGFAEPere',
                        'FON_SIGFAEMerNom',
                        'FON_SIGFAEMerPrenoms',
                        'FON_SIGFAEMere',
                        'FON_SIGFAEPieceType',
                        'FON_SIGFAEPieceNum',
                        'FON_SIGFAEPieceDate',
                        'FON_SIGFAEContact',
                        'FON_SIGFAEFonction',
                        'FON_SIGFAEEmploi',
                        'FON_SIGFAEStructure',
                        'FON_SIGFAEDirGenerale',
                        'FON_SIGFAEDrCentrale',
                        'FON_SIGFAETypeAgent',
                        'FON_SIGFAELieuTravail',
                        'FON_SIGFAEEmail',
                        'FON_Nom',
                        'FON_Prenoms',
                        'FON_NomPrenoms',
                        'FON_NomEpouse',
                        'FON_DatNais',
                        'FON_LieuNais',
                        'FON_Sexe',
                        'FON_Civilite',
                        'FON_SituaMatrimo',
                        'FON_PerNom',
                        'FON_PerPrenoms',
                        'FON_MerNom',
                        'FON_MerPrenoms',
                        'FON_PieceType',
                        'FON_PieceNum',
                        'FON_PieceDate',
                        'FON_PieceLieu',
                        'FON_NNI',
                        'FON_Contact',
                        'FON_Fonction',
                        'FON_Emploi',
                        'FON_Structure',
                        'FON_DirGenerale',
                        'FON_DirCentrale',
                        'FON_TypeAgent',
                        'FON_LieuTravail',
                        'FON_LocTravail',
                        'FON_LocTravailCode',
                        'FON_Email',
                        'FON_DatSaisie',
                        'FON_LocSaisie',
                        'FON_LocSaisieCode',
                        'FON_OperaMatricule',
                        'FON_OperaIdentite',
                        'FON_DatTransfert',
                        'FON_CodeValise',
                        'FON_SITCode',
                        'FON_SECCode',
                        'FON_LRCode',
                        'FON_LRLibel',
                        'FON_OperationAbisDate',
                        'FON_OperationAbisType'
        ]);
        continue;
    }

    // Si STAT_Code = 00 → on ignore
    if ($f->STAT_Code == '00') {
        continue;
    }

    // Cas 01
    if ($f->STAT_Code == '01') {
        if ($existing->STAT_Code == '00') {

            // On écrase
            $existing->update(
                $f->only([
                    // 👉 tes champs ici

                        'FON_Matricule',
                        'STAT_Code',
                        'FON_SIGFAENom',
                        'FON_SIGFAEPrenoms',
                        'FON_SIGFAENomEpouse',
                        'FON_SIGFAENomJeuneFille',
                        'FON_SIGFAEDatNais',
                        'FON_SIGFAELieuNais',
                        'FON_SIGFAESexe',
                        'FON_SIGFAESexeLibel',
                        'FON_SIGFAECivilite',
                        'FON_SIGFAECiviliteLibel',
                        'FON_SIGFAESituaMatrimo',
                        'FON_SIGFAESituaMatrimoLibel',
                        'FON_SIGFAEPerNom',
                        'FON_SIGFAEPerPrenoms',
                        'FON_SIGFAEPere',
                        'FON_SIGFAEMerNom',
                        'FON_SIGFAEMerPrenoms',
                        'FON_SIGFAEMere',
                        'FON_SIGFAEPieceType',
                        'FON_SIGFAEPieceNum',
                        'FON_SIGFAEPieceDate',
                        'FON_SIGFAEContact',
                        'FON_SIGFAEFonction',
                        'FON_SIGFAEEmploi',
                        'FON_SIGFAEStructure',
                        'FON_SIGFAEDirGenerale',
                        'FON_SIGFAEDrCentrale',
                        'FON_SIGFAETypeAgent',
                        'FON_SIGFAELieuTravail',
                        'FON_SIGFAEEmail',
                        'FON_Nom',
                        'FON_Prenoms',
                        'FON_NomPrenoms',
                        'FON_NomEpouse',
                        'FON_DatNais',
                        'FON_LieuNais',
                        'FON_Sexe',
                        'FON_Civilite',
                        'FON_SituaMatrimo',
                        'FON_PerNom',
                        'FON_PerPrenoms',
                        'FON_MerNom',
                        'FON_MerPrenoms',
                        'FON_PieceType',
                        'FON_PieceNum',
                        'FON_PieceDate',
                        'FON_PieceLieu',
                        'FON_NNI',
                        'FON_Contact',
                        'FON_Fonction',
                        'FON_Emploi',
                        'FON_Structure',
                        'FON_DirGenerale',
                        'FON_DirCentrale',
                        'FON_TypeAgent',
                        'FON_LieuTravail',
                        'FON_LocTravail',
                        'FON_LocTravailCode',
                        'FON_Email',
                        'FON_DatSaisie',
                        'FON_LocSaisie',
                        'FON_LocSaisieCode',
                        'FON_OperaMatricule',
                        'FON_OperaIdentite',
                        'FON_DatTransfert',
                        'FON_CodeValise',
                        'FON_SITCode',
                        'FON_SECCode',
                        'FON_LRCode',
                        'FON_LRLibel',
                        'FON_OperationAbisDate',
                        'FON_OperationAbisType'
                ])
            );
        }
        continue;
    }

    // Cas 02
    if ($f->STAT_Code == '02') {
        if (in_array($existing->STAT_Code, ['00', '01'])) {

            // On écrase
            $existing->update(
                $f->only([
                    // 👉 tes champs ici
                        'FON_Matricule',
                        'STAT_Code',
                        'FON_SIGFAENom',
                        'FON_SIGFAEPrenoms',
                        'FON_SIGFAENomEpouse',
                        'FON_SIGFAENomJeuneFille',
                        'FON_SIGFAEDatNais',
                        'FON_SIGFAELieuNais',
                        'FON_SIGFAESexe',
                        'FON_SIGFAESexeLibel',
                        'FON_SIGFAECivilite',
                        'FON_SIGFAECiviliteLibel',
                        'FON_SIGFAESituaMatrimo',
                        'FON_SIGFAESituaMatrimoLibel',
                        'FON_SIGFAEPerNom',
                        'FON_SIGFAEPerPrenoms',
                        'FON_SIGFAEPere',
                        'FON_SIGFAEMerNom',
                        'FON_SIGFAEMerPrenoms',
                        'FON_SIGFAEMere',
                        'FON_SIGFAEPieceType',
                        'FON_SIGFAEPieceNum',
                        'FON_SIGFAEPieceDate',
                        'FON_SIGFAEContact',
                        'FON_SIGFAEFonction',
                        'FON_SIGFAEEmploi',
                        'FON_SIGFAEStructure',
                        'FON_SIGFAEDirGenerale',
                        'FON_SIGFAEDrCentrale',
                        'FON_SIGFAETypeAgent',
                        'FON_SIGFAELieuTravail',
                        'FON_SIGFAEEmail',
                        'FON_Nom',
                        'FON_Prenoms',
                        'FON_NomPrenoms',
                        'FON_NomEpouse',
                        'FON_DatNais',
                        'FON_LieuNais',
                        'FON_Sexe',
                        'FON_Civilite',
                        'FON_SituaMatrimo',
                        'FON_PerNom',
                        'FON_PerPrenoms',
                        'FON_MerNom',
                        'FON_MerPrenoms',
                        'FON_PieceType',
                        'FON_PieceNum',
                        'FON_PieceDate',
                        'FON_PieceLieu',
                        'FON_NNI',
                        'FON_Contact',
                        'FON_Fonction',
                        'FON_Emploi',
                        'FON_Structure',
                        'FON_DirGenerale',
                        'FON_DirCentrale',
                        'FON_TypeAgent',
                        'FON_LieuTravail',
                        'FON_LocTravail',
                        'FON_LocTravailCode',
                        'FON_Email',
                        'FON_DatSaisie',
                        'FON_LocSaisie',
                        'FON_LocSaisieCode',
                        'FON_OperaMatricule',
                        'FON_OperaIdentite',
                        'FON_DatTransfert',
                        'FON_CodeValise',
                        'FON_SITCode',
                        'FON_SECCode',
                        'FON_LRCode',
                        'FON_LRLibel',
                        'FON_OperationAbisDate',
                        'FON_OperationAbisType'
                ])
            );
        }
    }
}

// Insertion des nouveaux
if (!empty($insertData)) {
    TableRecense::insert($insertData);
}

return response()->json([
    'status' => 'success',
    'message' => "Synchronisation terminée"
]);


}








    // Nouvelle méthode pour vérifier si un agent est recensé dans l'espace fonctionnaire
   public function verifier($matricule)
{
    $recense = TableRecense::where('FON_Matricule', $matricule)->first();

    if (!$recense) {
        return response()->json([
            'status' => 'error',
            'message' => 'Vous n’êtes pas encore recensé.'
        ]);
    }

    switch ($recense->STAT_Code) {

        case '00':
            return response()->json([
                'status' => 'success',
                'etat'   => '00',
                'message'=> 'Vous êtes bien recensé. Mais vos données ne sont pas encore validées.'
            ]);
            break;

        case '01':
            return response()->json([
                'status' => 'success',
                'etat'   => '01',
                'message'=> 'Vous êtes bien recensé. Et vos données sont en cours de validation.'
            ]);
            break;

        case '02':
            return response()->json([
                'status' => 'success',
                'etat'   => '02',
                'message'=> 'Vous êtes bien recensé. Et vos données sont validées.'
            ]);
            break;

        default:
            return response()->json([
                'status' => 'success',
                'etat'   => $recense->STAT_Code,
                'message'=> 'Vous êtes bien recensé. Statut inconnu.'
            ]);
    }
}
   
}
