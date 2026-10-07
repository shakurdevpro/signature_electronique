<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TbceAgt_Sigfae;
use App\Models\Sigfae;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SigfaeController extends Controller
{
    /**
     * Synchroniser les données de la table externe tbce_agt
     * vers la table locale sigfae
     */
  public function syncExternalData(Request $request)
{
    // 🔐 1. Récupérer le token depuis le header
    $token = $request->bearerToken();

    if (!$token) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token manquant'
        ], 401);
    }

    // 🔎 2. Vérifier si le token existe
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

    // ==============================
    // 🚀 TOKEN VALIDE → TRAITEMENT
    // ==============================

    $externalData = TbceAgt_Sigfae::get();
    $countInserted = 0;

    foreach ($externalData as $row) {

        $exists = Sigfae::where('MATRICULE', $row->MATRICULE)->exists();

        if (!$exists) {

            Sigfae::create([
                'code_user' => $row->code_user,
                'CODE_ROLE' => $row->CODE_ROLE,
                'login' => $row->login,
                'nom' => $row->nom,
                'prenoms' => $row->prenoms,
                'email' => $row->email,
                'mdp' => $row->mdp,
                'date_creation' => $row->date_creation,
                'date_modif' => $row->date_modif,
                'role' => $row->role,
                'MATRICULE' => $row->MATRICULE,
                'CODE_ST' => $row->CODE_ST,
                'CODE_DR' => $row->CODE_DR,
                'CODE_SVCE' => $row->CODE_SVCE,
                'CODE_FON' => $row->CODE_FON,
                'ETAT_REINI' => $row->ETAT_REINI,
                'AJOUTEUR' => $row->AJOUTEUR,
                'MODIFIEUR' => $row->MODIFIEUR,
                'DATE_REINITIALISATION' => $row->DATE_REINITIALISATION,
                'REINITIALISATEUR' => $row->REINITIALISATEUR,
                'ANNEE' => $row->ANNEE,
                'LIEN' => $row->LIEN,
                'ETAT_USER' => $row->ETAT_USER,
            ]);

            $countInserted++;
        }
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Les données ont été synchronisées avec succès !',
        'count' => $countInserted
    ]);
}


}
