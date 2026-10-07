<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fonctionnaire;
use App\Models\TableRecense;

use App\Models\Zutilisateur;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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
    //$tokenData = DB::table('zutilisateur_tokens')->where('token', $token)->first();
    $tokenData = Cache::get('token_' . $token);

    //$expires_at = $tokenData->expires_at;
    $expires_at = $tokenData['expires_at'];

    if (!$tokenData) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token invalide'
        ], 401);
    }

    // ⏳ 3. Vérifier expiration
    if (Carbon::now()->greaterThan(Carbon::parse($expires_at))) {
        return response()->json([
            'status' => 'error',
            'message' => 'Cle de securite expiree'
        ], 401);
    }

    // ===================================
    // 🚀 TOKEN VALIDE → TRAITEMENT
    // ===================================

    $limite = 2000;
    $dernierMatricule = $request->input('matricule');

    $query = Fonctionnaire::orderBy('FON_Matricule', 'asc');

    if ($dernierMatricule) {
        $query->where('FON_Matricule', '>', $dernierMatricule);
    }

    $fonctionnaires = $query->limit($limite)->get();

    if ($fonctionnaires->isEmpty()) {
        return response()->json([
            'status'             => 'success',
            'message'            => 'Synchronisation terminée',
            'lignes_restantes'   => 0,
            'dernier_matricule'  => $dernierMatricule,
        ]);
    }

    // ─── Fonction helper : mapper Fonctionnaire → TableRecense ────
    $mapper = function ($f) {
        return [
            'matricule'          => $f->FON_Matricule,
            'date_recensement'   => $f->FON_DatSaisie,
            'statut'             => $f->STAT_Code,
            // 👉 ajoute tes autres champs ici
        ];
    };

    // ─── Traitement ───────────────────────────────────────────
    $insertData = [];

    foreach ($fonctionnaires as $f) {

        $existing = TableRecense::where('matricule', $f->FON_Matricule)->first();

        // Si le matricule n'existe pas → on insère
        if (!$existing) {
            $insertData[] = $mapper($f);
            continue;
        }

        // Si STAT_Code = 00 → on ignore
        if ($f->STAT_Code == '00') {
            continue;
        }

        // Cas 01
        if ($f->STAT_Code == '01') {
            if ($existing->statut == '00') {
                $existing->update($mapper($f));
            }
            continue;
        }

        // Cas 02
        if ($f->STAT_Code == '02') {
            if (in_array($existing->statut, ['00', '01'])) {
                $existing->update($mapper($f));
            }
        }
    }

    // Insertion des nouveaux
    if (!empty($insertData)) {
        TableRecense::insert($insertData);
    }

    // ─── Calcul des infos de pagination ───────────────────────
    $dernierMatriculeTraite = $fonctionnaires->last()->FON_Matricule;

    $lignesRestantes = Fonctionnaire::orderBy('FON_Matricule', 'asc')
        ->where('FON_Matricule', '>', $dernierMatriculeTraite)
        ->count();

    return response()->json([
        'status'             => 'success',
        'message'            => 'Synchronisation terminée',
        'lignes_restantes'   => $lignesRestantes,
        'dernier_matricule'  => $dernierMatriculeTraite,
    ]);
}










public function updateRecenser(Request $request)
{
    // 🔐 1. Récupérer le token
    $token = $request->bearerToken();
    if (!$token) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token manquant'
        ], 401);
    }

    // 🔎 2. Vérifier s'il existe
   // $tokenData = DB::table('zutilisateur_tokens')->where('token', $token)->first();
    $tokenData = Cache::get('token_' . $token);

    //$expires_at = $tokenData->expires_at;
    $expires_at = $tokenData['expires_at'];

    if (!$tokenData) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token invalide'
        ], 401);
    }

    // ⏳ 3. Vérifier expiration
    if (Carbon::now()->greaterThan(Carbon::parse($expires_at))) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Clé de sécurité expirée'
        ], 401);
    }

    // ===================================
    // 🚀 TOKEN VALIDE → TRAITEMENT
    // ===================================

    $limite           = 1000;
    $dernierMatricule = $request->input('matricule');

    // 🔍 Lignes de table_recense dont statut <> '02'
    $query = TableRecense::where('statut', '<>', '02')
                         ->orderBy('matricule', 'asc');

    if ($dernierMatricule) {
        $query->where('matricule', '>', $dernierMatricule);
    }

    $recensees = $query->limit($limite)->get();

    if ($recensees->isEmpty()) {
        return response()->json([
            'status'            => 'success',
            'message'           => 'Mise à jour terminée — aucune ligne à traiter',
            'lignes_restantes'  => 0,
            'dernier_matricule' => $dernierMatricule,
            'updated_count'     => 0,
        ]);
    }

    // ─── Mapper Fonctionnaire → TableRecense ────────────────────
    $mapper = function ($f) {
        return [
            'matricule'        => $f->FON_Matricule,
            'date_recensement' => $f->FON_DatSaisie,
            'statut'           => $f->STAT_Code,
            // 👉 ajoute tes autres champs ici
        ];
    };

    // ─── Traitement ─────────────────────────────────────────────
    $updatedCount = 0;

    foreach ($recensees as $recense) {

        // Chercher la ligne correspondante dans fonctionnaires
        $fonctionnaire = Fonctionnaire::where('FON_Matricule', $recense->matricule)->first();

        // Si pas trouvé → on skip
        if (!$fonctionnaire) {
            continue;
        }

        // Si le statut est identique → rien à faire
        if ($fonctionnaire->STAT_Code == $recense->statut) {
            continue;
        }

        // 🔄 Règle : on ne régresse jamais (00 → 01 → 02)
        $ordre = ['00' => 0, '01' => 1, '02' => 2];

        $niveauActuel  = $ordre[$recense->statut]           ?? -1;
        $niveauNouveau = $ordre[$fonctionnaire->STAT_Code]  ?? -1;

        // On met à jour uniquement si le nouveau statut est plus avancé
        if ($niveauNouveau > $niveauActuel) {
            $recense->update($mapper($fonctionnaire));
            $updatedCount++;
        }
    }

    // ─── Calcul pagination ──────────────────────────────────────
    $dernierMatriculeTraite = $recensees->last()->matricule;

    $lignesRestantes = TableRecense::where('statut', '<>', '02')
                                   ->where('matricule', '>', $dernierMatriculeTraite)
                                   ->count();

    return response()->json([
        'status'            => 'success',
        'message'           => 'Mise à jour terminée',
        'updated_count'     => $updatedCount,
        'lignes_restantes'  => $lignesRestantes,
        'dernier_matricule' => $dernierMatriculeTraite,
    ]);
}





    // Nouvelle méthode pour vérifier si un agent est recensé dans l'espace fonctionnaire
public function verifier_fonctionnaire($matricule)
{
    // Vérification du Referer
    $referer = request()->headers->get('referer');
    $allowed_url = 'https://espacefonctionnaire.fonctionpublique.gouv.ci/w/index.php/front-page/espace_fonctionnaire/accueil';

    if (!$referer || !str_starts_with($referer, $allowed_url)) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Accès non autorisé.'
        ], 403);
    }

    // Votre logique existante
    $recense = TableRecense::where('matricule', $matricule)->first();

    if (!$recense) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Vous n\'êtes pas encore recensé.'
        ]);
    }

    switch ($recense->statut) {
        case '00':
            return response()->json([
                'status'  => 'success',
                'etat'    => '00',
                'message' => 'Vous êtes bien recensé. Mais vos données ne sont pas encore validées.'
            ]);

        case '01':
            return response()->json([
                'status'  => 'success',
                'etat'    => '01',
                'message' => 'Vous êtes bien recensé. Et vos données sont en cours de validation.'
            ]);

        case '02':
            return response()->json([
                'status'  => 'success',
                'etat'    => '02',
                'message' => 'Vous êtes bien recensé. Et vos données sont validées.'
            ]);

        default:
            return response()->json([
                'status'  => 'success',
                'etat'    => $recense->status,
                'message' => 'Vous êtes bien recensé. Statut inconnu.'
            ]);
    }
}





public function verifier_admin(Request $request, $matricule)
{
    // 🔎 1. Récupérer le token
    $token = $request->bearerToken();
    if (!$token) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token manquant'
        ], 401);
    }

    // 🔎 2. Vérifier s'il existe
  //  $tokenData = DB::table('zutilisateur_tokens')->where('token', $token)->first(); 

    $tokenData = Cache::get('token_' . $token);

    if (!$tokenData) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token invalide'
        ], 401);
    }

    // 🔎 3. Vérifier le recensement
    $recense = TableRecense::where('matricule', $matricule)->first();

    if (!$recense) {
        return response()->json([
            'status' => 'error',
            'message' => 'Vous n\'êtes pas encore recensé.'
        ]);
    }

    switch ($recense->statut) {

        case '00':
            return response()->json([
                'status' => 'success',
                'etat'   => '00',
                'message'=> 'Vous êtes bien recensé. Mais vos données ne sont pas encore validées.'
            ]);

        case '01':
            return response()->json([
                'status' => 'success',
                'etat'   => '01',
                'message'=> 'Vous êtes bien recensé. Et vos données sont en cours de validation.'
            ]);

        case '02':
            return response()->json([
                'status' => 'success',
                'etat'   => '02',
                'message'=> 'Vous êtes bien recensé. Et vos données sont validées.'
            ]);

        default:
            return response()->json([
                'status' => 'success',
                'etat'   => $recense->status,
                'message'=> 'Vous êtes bien recensé. Statut inconnu.'
            ]);
    }
}





public function dernier_matricule(Request $request)
{
    // 🔑 1. Récupérer le token
    $token = $request->bearerToken();
    if (!$token) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token manquant'
        ], 401);
    }

    // 🔎 2. Vérifier s'il existe
   // $tokenData = DB::table('zutilisateur_tokens')->where('token', $token)->first();
    $tokenData = Cache::get('token_' . $token);

    if (!$tokenData) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token invalide'
        ], 401);
    }

    // ⏳ 3. Vérifier expiration
    if (Carbon::now()->greaterThan(Carbon::parse($tokenData['expires_at']))) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Clé de sécurité expirée'
        ], 401);
    }

    // 📋 4. Récupérer le dernier matricule
    try {
        $dernierMatricule = TableRecense::orderBy('matricule', 'desc')
            ->select('matricule', 'statut', 'date_recensement')
            ->first();

        if (!$dernierMatricule) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Aucun matricule trouvé'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Dernier matricule récupéré avec succès',
            'data'    => [
                'matricule'  => $dernierMatricule->matricule,
                'statut'      => $dernierMatricule->statut,
                'date_recensement'  => $dernierMatricule->date_recensement,
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Erreur serveur : ' . $e->getMessage()
        ], 500);
    }
}







public function dernier_matricule_00(Request $request)
{
    // 🔑 1. Récupérer le token
    $token = $request->bearerToken();
    if (!$token) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token manquant'
        ], 401);
    }

    // 🔎 2. Vérifier s'il existe
   // $tokenData = DB::table('zutilisateur_tokens')->where('token', $token)->first();
   $tokenData = Cache::get('token_' . $token);

  // $expires_at = $tokenData->expires_at;
    $expires_at = $tokenData['expires_at'];

    if (!$tokenData) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token invalide'
        ], 401);
    }

    // ⏳ 3. Vérifier expiration
    if (Carbon::now()->greaterThan(Carbon::parse($expires_at))) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Clé de sécurité expirée'
        ], 401);
    }

    // 📋 4. Récupérer le dernier matricule
    try {
        $dernierMatricule = TableRecense::where('statut', '<>', '02')
                ->orderBy('matricule', 'desc')
                ->select('matricule', 'statut', 'date_recensement')
                ->first();

        if (!$dernierMatricule) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Aucun matricule trouvé'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Dernier matricule récupéré avec succès',
            'data'    => [
                'matricule'  => $dernierMatricule->matricule,
                'statut'      => $dernierMatricule->statut,
                'date_recensement'  => $dernierMatricule->date_recensement,
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Erreur serveur : ' . $e->getMessage()
        ], 500);
    }
}










public function matricule_restant(Request $request)
{
    // 🔑 1. Récupérer le token
    $token = $request->bearerToken();
    if (!$token) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token manquant'
        ], 401);
    }

    // 🔎 2. Vérifier s'il existe
    $tokenData = Cache::get('token_' . $token);

    if (!$tokenData) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token invalide'
        ], 401);
    }

    // ⏳ 3. Vérifier expiration
    $expires_at = $tokenData['expires_at'];
    if (Carbon::now()->greaterThan(Carbon::parse($expires_at))) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Clé de sécurité expirée'
        ], 401);
    }

    // 📋 4. Calculer la différence et récupérer les derniers matricules
    try {
        
            // Nombre de lignes
            $totalFonctionnaire  = Fonctionnaire::count();
            $totalTableRecense   = TableRecense::count();

            $matricule_restant = $totalFonctionnaire - $totalTableRecense;

            // Dernier matricule Fonctionnaire
            $dernierFonctionnaire = Fonctionnaire::orderBy('FON_Matricule', 'desc')
                ->select('FON_Matricule')
                ->first();

            // Dernier matricule TableRecense
            $dernierRecense = TableRecense::orderBy('matricule', 'desc')
                ->select('matricule')
                ->first();

            return response()->json([
                'status'  => 'success',
                'message' => 'Données récupérées avec succès',
                'data'    => [
                    'matricule_restant'               => $matricule_restant,
                    'derniere_matricule_Fonctionnaire' => $dernierFonctionnaire?->FON_Matricule ?? null,
                    'derniere_matricule_TableRecense'  => $dernierRecense?->matricule ?? null,
                ]
            ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Erreur serveur : ' . $e->getMessage()
        ], 500);
    }
}



public function insert_user(Request $request)
{
    $validated = $request->validate([
       // 'ZUTI_CODE'      => 'required|string',
        'AGT_Matricule'  => 'required|string',
        'ZGRP_CODE'      => 'required|string',
        'ZSIT_CODE'      => 'required|string',
        'ZSEC_CODE'      => 'required|string',
        'ZUTI_NOM'       => 'required|string',
        'ZUTI_PASSWORD'  => 'required|string|min:6',
    ]);

    $validated['ZUTI_PASSWORD'] = Hash::make($validated['ZUTI_PASSWORD']);

    $user = Zutilisateur::create($validated);

    return response()->json([
        'message' => 'Utilisateur créé avec succès',
        'data'    => $user
    ], 201);
}


   
}
