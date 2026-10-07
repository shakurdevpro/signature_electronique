<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;
// Ajout de Log pour le débogage
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;

use App\Models\SignatureMod; // Assurez-vous d'importer votre modèle
use PDO;



class ApiConnectionController extends Controller
{
   




    public function connection(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    $matricule = $request->input('matricule');
    $password = $request->input('password');

    try {
        // Connexion à la base de données Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');

        if (!$conn) {
            $error = oci_error(); // Récupère les détails de l'erreur Oracle
            $errorMessage = 'Connexion Oracle échouée : ' . $error['message'];
            Log::error($errorMessage); // Ajout de log pour débogage
            return response()->json([
                'status' => 'error',
                'message' => $errorMessage,
                'code' => 401 // Code 401 pour échec de connexion
            ], 401); // Code HTTP 401
        }

        // Cryptage du matricule et du mot de passe avant de les retourner
        $encryptedMatricule = Crypt::encryptString($matricule);
        $encryptedPassword = Crypt::encryptString($password);

        // Connexion réussie
        // Génération d'un token aléatoire
        $token = bin2hex(random_bytes(32)); // Génère un token aléatoire

        // Définir une expiration du token à 5 minutes
        $expiresAt = Carbon::now()->addMinutes(10);
        Cache::put('token_expiration_' . $token, $expiresAt, $expiresAt);

        // Vous pouvez renvoyer le token comme réponse JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Connexion réussie',
            'token' => $token, // Retourne le token au client
            'expires_at' => $expiresAt, // Retourne l'heure d'expiration du token
            'matricule' => $encryptedMatricule, // Retourne le matricule crypté
            'password' => $encryptedPassword, // Retourne le mot de passe crypté
            'code' => 200 // Code 200 pour succès
        ], 200); // Code HTTP 200
    } catch (\Throwable $e) { // Capture toutes les exceptions et erreurs PHP
        $errorMessage = 'Une erreur est survenue : ' . $e->getMessage();
        Log::error($errorMessage); // Ajout de log pour débogage
        return response()->json([
            'status' => 'error',
            'message' => $errorMessage,
            'code' => 500 // Code 500 pour erreur interne
        ], 500); // Code HTTP 500
    }
}













public function validateConnection(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
        "page" => "sometimes|integer|min:1",
        "limit" => "sometimes|integer|min:1|max:100", // Limite maximale pour éviter une surcharge
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $page = $request->input('page', 1); // Par défaut 1
    $limit = $request->input('limit', 50); // Par défaut 10

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token
        $requestToken = $request->bearerToken();
        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);
        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle avec pagination
        $signatureMod = new SignatureMod();
        $LISTE_MUGEFCI = $signatureMod->LISTE_MUGEFCI($conn, $page, $limit);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_MUGEFCI,
            'pagination' => [
                'page' => $page,
                'limit' => $limit
            ]
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}







//**************************************LISTE_CARRIERE*****************************************************



public function carriere(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
        "matricule_agent" => "nullable|string", // facultatif
        "date_debut" => "nullable|date",        // facultatif
        "date_fin" => "nullable|date"          // facultatif
    ]);

    //$token = $request->input('token');
   // $token = $request->bearerToken();
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $matricule_agent = $request->input('matricule_agent');
    $date_debut = $request->input('date_debut');
    $date_fin = $request->input('date_fin');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token
        $requestToken = $request->bearerToken();
        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }


        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);
        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Connexion à Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Validation logique : au moins une condition doit être respectée
        if (empty($matricule_agent) && (empty($date_debut) || empty($date_fin))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Veuillez fournir soit un matricule_agent, soit une plage de dates valide.',
                'code' => 400
            ], 400);
        }

        // Appel au modèle avec les paramètres
        $signatureMod = new SignatureMod();
        $LISTE_CARRIERE = $signatureMod->LISTE_CARRIERE($conn, $matricule_agent, $date_debut, $date_fin);

        return response()->json([
            'status' => 'success',
            'message' => 'Données récupérées avec succès.',
            'code' => 200,
            'data' => $LISTE_CARRIERE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}




//**************************************LISTE_CIVILITE*****************************************************




public function civilite(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_CIVILITE = $signatureMod->LISTE_CIVILITE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_CIVILITE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}








//**************************************LISTE_CLASSE*****************************************************




public function classe(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

   // $token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }
        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_CLASSE = $signatureMod->LISTE_CLASSE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_CLASSE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}




//**************************************LISTE_EMPLOI*****************************************************




public function emploi(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_EMPLOI = $signatureMod->LISTE_EMPLOI($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_EMPLOI
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}







//**************************************LISTE_GRADE*****************************************************




public function grade(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

   // $token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_GRADE = $signatureMod->LISTE_GRADE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_GRADE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}





//**************************************LISTE_VILLE*****************************************************




public function ville(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_VILLE = $signatureMod->LISTE_VILLE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_VILLE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}








//**************************************LISTE_TYPE_AGENT*****************************************************




public function type_agent(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_TYPE_AGENT = $signatureMod->LISTE_TYPE_AGENT($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_TYPE_AGENT
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}







//**************************************LISTE_TYPE_ACTE*****************************************************




public function type_acte(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

   // $token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_TYPE_ACTE = $signatureMod->LISTE_TYPE_ACTE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_TYPE_ACTE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}










//**************************************LISTE_STRUCTURE*****************************************************



public function struct(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

   // $token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_STRUCTURE = $signatureMod->LISTE_STRUCTURE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_STRUCTURE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}








//**************************************LISTE_STATUT_JURIDIQUE*****************************************************



public function statut_jur(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       // "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_STATUT_JURIDIQUE = $signatureMod->LISTE_STATUT_JURIDIQUE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_STATUT_JURIDIQUE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}








//**************************************LISTE_POSITION*****************************************************



public function position(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_POSITION = $signatureMod->LISTE_POSITION($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_POSITION
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}







//**************************************LISTE_SIT_MATRI*****************************************************



public function sit_matri(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_SIT_MATRI = $signatureMod->LISTE_SIT_MATRI($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_SIT_MATRI
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}








//**************************************LISTE_NATURE_ACTE*****************************************************



public function nature_acte(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_NATURE_ACTE = $signatureMod->LISTE_NATURE_ACTE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_NATURE_ACTE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}



//**************************************LISTE_INFO_AGENT*****************************************************




public function info_agent(Request $request)
{
   $request->merge([
    'date_debut_service' => $request->input('date_debut_service') ? Carbon::createFromFormat('d-M-y', strtoupper($request->input('date_debut_service')))->format('Y-m-d') : null,
    'date_fin_service' => $request->input('date_fin_service') ? Carbon::createFromFormat('d-M-y', strtoupper($request->input('date_fin_service')))->format('Y-m-d') : null,
    'date_debut_retraite' => $request->input('date_debut_retraite') ? Carbon::createFromFormat('d-M-y', strtoupper($request->input('date_debut_retraite')))->format('Y-m-d') : null,
    'date_fin_retraite' => $request->input('date_fin_retraite') ? Carbon::createFromFormat('d-M-y', strtoupper($request->input('date_fin_retraite')))->format('Y-m-d') : null,
    'date_debut_deces' => $request->input('date_debut_deces') ? Carbon::createFromFormat('d-M-y', strtoupper($request->input('date_debut_deces')))->format('Y-m-d') : null,
    'date_fin_deces' => $request->input('date_fin_deces') ? Carbon::createFromFormat('d-M-y', strtoupper($request->input('date_fin_deces')))->format('Y-m-d') : null,
]);

$request->validate([
   // "token" => "required|string",
    "matricule" => "required|string",
    "password" => "required|string",
    "matricule_agent" => "nullable|string",
    "date_debut_service" => "nullable|date",
    "date_fin_service" => "nullable|date",
    "date_debut_retraite" => "nullable|date",
    "date_fin_retraite" => "nullable|date",
    "date_debut_deces" => "nullable|date",
    "date_fin_deces" => "nullable|date"
]);

   // $token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $matricule_agent = $request->input('matricule_agent');
    $date_debut_service = $request->input('date_debut_service');
    $date_fin_service = $request->input('date_fin_service');
    $date_debut_retraite = $request->input('date_debut_retraite');
    $date_fin_retraite = $request->input('date_fin_retraite');
    $date_debut_deces = $request->input('date_debut_deces');
    $date_fin_deces = $request->input('date_fin_deces');

    try {




          // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }




        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification et connexion Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        $signatureMod = new SignatureMod();
        $LISTE_INFO_AGENT = $signatureMod->LISTE_INFO_AGENT(
            $conn,
            $matricule_agent,
            $date_debut_service,
            $date_fin_service,
            $date_debut_retraite,
            $date_fin_retraite,
            $date_debut_deces,
            $date_fin_deces
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_INFO_AGENT
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn);
        }
    }
}





//**************************************LES AGENT EN SERVICE *********************************//




public function les_agent_en_service(Request $request)
{

   $aujourdhui = Carbon::today()->format('Y-m-d');

$request->validate([
   // "token" => "required|string",
    "matricule" => "required|string",
    "password" => "required|string",
    "aujourdhui" => "required|date"
]);

   // $token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $aujourdhui = $request->input('aujourdhui');


    try {




          // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }




        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification et connexion Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        $signatureMod = new SignatureMod();
        $LISTE_AGENT = $signatureMod->LISTE_AGENT(
            $conn,
            $aujourdhui
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_AGENT
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn);
        }
    }
}


//**************************************LISTE_ENFANT*****************************************************




public function enfant(Request $request)
{
    // Validation des données entrantes
    $request->validate([
       //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
        "matricule_parent" => "required|string",  // Ajout de la validation pour MATRICULE_PARENT
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $matriculeParent = $request->input('matricule_parent'); // Récupération de MATRICULE_PARENT

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données avec condition sur MATRICULE_PARENT
        $signatureMod = new SignatureMod();
        $LISTE_ENFANT = $signatureMod->LISTE_ENFANT($conn, $matriculeParent);  // Passage de MATRICULE_PARENT

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_ENFANT
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}







//**************************************LISTE_MOTIF_POSITION*****************************************************



public function motif_position(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_MOTIF_POSITION = $signatureMod->LISTE_MOTIF_POSITION($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_MOTIF_POSITION
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}








//**************************************LISTE_MVT_AGT_EMP*****************************************************




public function mvt_agt_emp(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
        "matricule_agent" => "required|string",  // Ajout de la validation pour MATRICULE_PARENT
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $matriculeAgent = $request->input('matricule_agent'); // Récupération de MATRICULE_PARENT

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données avec condition sur MATRICULE_PARENT
        $signatureMod = new SignatureMod();
        $LISTE_MVT_AGT_EMP = $signatureMod->LISTE_MVT_AGT_EMP($conn, $matriculeAgent);  // Passage de MATRICULE_PARENT

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_MVT_AGT_EMP
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}







//**************************************LISTE_MVT_AGT_STRUCT*****************************************************



public function mvt_agt_str(Request $request)
{
   

    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
        "matricule_agent" => "required|string",  // Ajout de la validation pour MATRICULE_PARENT
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $matriculeAgent = $request->input('matricule_agent'); // Récupération de MATRICULE_PARENT

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données avec condition sur MATRICULE_PARENT
        $signatureMod = new SignatureMod();
        $LISTE_MVT_AGT_STRUCT = $signatureMod->LISTE_MVT_AGT_STRUCT($conn, $matriculeAgent);  // Passage de MATRICULE_PARENT

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_MVT_AGT_STRUCT
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }

    
}







//**************************************LISTE_ECHELON*****************************************************



public function echelon(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_ECHELON = $signatureMod->LISTE_ECHELON($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_ECHELON
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}








//**************************************LISTE_EMPGRADE*****************************************************



public function emp_grade(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }

        // Appel au modèle pour récupérer les données
        $signatureMod = new SignatureMod();
        $LISTE_EMPGRADE = $signatureMod->LISTE_EMPGRADE($conn);

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_EMPGRADE
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }
}








//**************************************LISTE_POSITION_HISTO*****************************************************



public function position_histo(Request $request)
{
   

    // Validation des données entrantes
    $request->validate([
        //"token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
        "matricule_agent" => "required|string",  // Ajout de la validation pour MATRICULE_PARENT
    ]);

    //$token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $matriculeAgent = $request->input('matricule_agent'); // Récupération de MATRICULE_PARENT

    try {
        // Décryptage du matricule et du mot de passe
        $matricule = Crypt::decryptString($encryptedMatricule);
        $password = Crypt::decryptString($encryptedPassword);

        // Vérification du token passé dans la requête
        $requestToken = $request->bearerToken();

        $token = $request->bearerToken();
       
       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token manquant dans le header Authorization.',
                'code' => 401
            ], 401);
        }

        // Vérification de l'expiration du token
        $expirationDate = Cache::get('token_expiration_' . $token);

        if (!$expirationDate || Carbon::now()->greaterThan($expirationDate)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expiré.',
                'code' => 401
            ], 401);
        }

        // Création de la connexion PDO pour Oracle
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
        if (!$conn) {
            $error = oci_error();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion à Oracle : ' . $error['message'],
                'code' => 500
            ], 500);
        }


          // Validation logique : au moins une condition doit être respectée
        if (empty($matriculeAgent)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Veuillez fournir soit un matricule_agent.',
                'code' => 400
            ], 400);
        }



 // Validation logique : au moins une condition doit être respectée
        if (empty($matriculeAgent) ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Veuillez fournir soit un matricule_agent, soit une plage de dates valide.',
                'code' => 400
            ], 400);
        }

        // Appel au modèle pour récupérer les données avec condition sur MATRICULE_PARENT
        $signatureMod = new SignatureMod();
        $LISTE_POSITION_HISTO = $signatureMod->LISTE_POSITION_HISTO($conn, $matriculeAgent);  // Passage de MATRICULE_PARENT

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion validée.',
            'code' => 200,
            'data' => $LISTE_POSITION_HISTO
        ], 200);
    } catch (\Throwable $e) {
        Log::error('Erreur : ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            'code' => 500
        ], 500);
    } finally {
        if (isset($conn) && $conn) {
            oci_close($conn); // Fermer la connexion Oracle
        }
    }

    
}








}



/*
  $request->validate([
        "token" => "required|string",
        "matricule" => "required|string",
        "password" => "required|string",
        "matricule_agent" => "nullable|string", // facultatif
    ]);

    $token = $request->input('token');
    $encryptedMatricule = $request->input('matricule');
    $encryptedPassword = $request->input('password');
    $matricule_agent = $request->input('matricule_agent');
    $date_debut = $request->input('date_debut');
    $date_fin = $request->input('date_fin');



  // Validation logique : au moins une condition doit être respectée
 // Validation logique : au moins une condition doit être respectée
        if (empty($matricule_agent) && (empty($date_debut) || empty($date_fin))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Veuillez fournir soit un matricule_agent, soit une plage de dates valide.',
                'code' => 400
            ], 400);
        }

        */