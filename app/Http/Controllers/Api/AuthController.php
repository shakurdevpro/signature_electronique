<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Zutilisateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{


/*
    public function login(Request $request)
    {
        $request->validate([
            'AGT_Matricule' => 'required|string',
            'ZUTI_PASSWORD' => 'required|string',
        ]);

        // Récupérer l'utilisateur
        $user = Zutilisateur::find($request->AGT_Matricule);

        if (!$user || !$user->checkPassword($request->ZUTI_PASSWORD)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Identifiants incorrects'
            ], 401);
        }

        // Générer un token aléatoire
        $token = Str::random(60);

        // Stocker le token avec expiration (2 minutes)
        DB::table('zutilisateur_tokens')->insert([
            'AGT_Matricule' => $user->AGT_Matricule,
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(60)->toDateTimeString()
        ]);
    }
*/




public function login(Request $request)
{
    $request->validate([
        'AGT_Matricule' => 'required|string',
        'ZUTI_PASSWORD' => 'required|string',
    ]);

    // Récupérer l'utilisateur
    $user = Zutilisateur::find($request->AGT_Matricule);

    if (!$user || !$user->checkPassword($request->ZUTI_PASSWORD)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Identifiants incorrects'
        ], 401);
    }

    // Générer un token aléatoire
    $token = Str::random(60);

    $expiresAt = Carbon::now()->addMinutes(240);

    // Stocker le token en cache avec expiration
    Cache::put('token_' . $token, [
        'AGT_Matricule' => $user->AGT_Matricule,
        'expires_at'    => $expiresAt->toDateTimeString(),
    ], $expiresAt);

    return response()->json([
        'status'     => 'success',
        'token'      => $token,
        'expires_at' => $expiresAt->toDateTimeString()
    ]);
}



}
