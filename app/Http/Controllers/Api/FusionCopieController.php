<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fonctionnaire;
use App\Models\VW_FONCT_NON_RECENCE_INTRANET;
use App\Models\VW_FONCT_NON_RECENCE_SPEC_INTRANET;
use App\Models\SIGFAE_TEMPON;
use App\Models\TBCE_AGT_BIO_INTRANET;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;



class FusionCopieController extends Controller
{
    
    
  public function fusionnerEtCopier()
{
    set_time_limit(0);
    ini_set('memory_limit', '512M');

  /*  try {
        DB::connection('mssql_biometrie')->getPdo();
        echo "Connexion SQL Server OK";
    } catch (\Exception $e) {
        echo $e->getMessage();
    }*/

    // Fusionner les deux vues
    $agents = VW_FONCT_NON_RECENCE_INTRANET::all()  ->concat(VW_FONCT_NON_RECENCE_SPEC_INTRANET::all());


  /*  $agents = VW_FONCT_NON_RECENCE_INTRANET::where('sigfae_matricule', '902624U')->get()
            ->concat(
                VW_FONCT_NON_RECENCE_SPEC_INTRANET::where('sigfae_matricule', '902624U')->get()
            ); */

              

    $totalAvant    = $agents->count();
    $agentsATraiter = $agents->take(50);

     // var_dump($agentsATraiter); die;

    $insertes = 0;
    $ignores  = 0;

    $formatDate = function($date) {
        if (!$date) return null;
        try {
            return \Carbon\Carbon::parse($date)->format('d/m/Y');
        } catch (\Exception $e) {
            return null;
        }
    };

    foreach ($agentsATraiter as $agent) {//var_dump($agent); die;

        // 🔍 Vérifier si le matricule existe déjà dans TBCE_AGT_BIO
        $existe = TBCE_AGT_BIO_INTRANET::where('ce_agt_mat', $agent->sigfae_matricule)->exists();

        if ($existe) {
            $ignores++;
            continue;
        }



        
        // 🔍 Vérifier si le matricule existe déjà dans SIGFAE
     /*   $existeSigfae = DB::connection('mssql_biometrie')
                            ->table('SIGFAE')
                            ->where('SIGFAE_Matricule', (string) $agent->sigfae_matricule)
                            ->exists();
 */
        else {
            $sigfae = SIGFAE_TEMPON::create([
                'SIGFAE_Matricule'         => (string) $agent->sigfae_matricule,
                'SIGFAE_Nom'               => $agent->sigfae_nom ?? null,
                'SIGFAE_Prenoms'           => $agent->sigfae_prenoms ?? null,
                'SIGFAE_NomEpouse'         => null,
                'SIGFAE_NomJeuneFille'     => $agent->sigfae_nomjeunefille ?? null,
                'SIGFAE_DatNais'           => $agent->sigfae_datnais
                                                ? DB::raw("CONVERT(datetime, '".$formatDate($agent->sigfae_datnais)."', 103)")
                                                : null,
                'SIGFAE_LieuNais'          => $agent->sigfae_lieunais ?? null,
                'SIGFAE_Sexe'              => $agent->sigfae_sexe ?? null,
                'SIGFAE_SexeLibel'         => $agent->sigfae_sexelibel ?? null,
                'SIGFAE_Civilite'          => $agent->sigfae_civilite ?? null,
                'SIFGAE_CiviiteLibel'      => $agent->sifgae_civiitelibel ?? null,
                'SIGFAE_SituaMatrimo'      => $agent->sigfae_situamatrimo ?? null,
                'SIGFAE_SituaMatrimoLibel' => $agent->sigfae_situamatrimolibel ?? null,
                'SIGFAE_PerNom'            => null,
                'SIGFAE_PerPrenoms'        => null,
                'SIGFAE_Pere'              => $agent->sigfae_pere ?? null,
                'SIGFAE_MerNom'            => null,
                'SIGFAE_MerPrenoms'        => null,
                'SIGFAE_Mere'              => $agent->sigfae_mere ?? null,
               // 'SIGFAE_PieceType'         => $agent->cni ?? null,
                'SIGFAE_PieceNum'          => $agent->sigfae_piecenum ?? null,
                'SIGFAE_PieceDate'         => $agent->sigfae_piecedate ?? null,
                'SIGFAE_Contact'           => $agent->sigfae_contact ??  null,
                'SIGFAE_Structure'         => $agent->sigfae_structure ?? null,
                'SIGFAE_DirGenerale'       => $agent->sigfae_dirgenerale ?? null,
                'SIGFAE_DirCentrale'       => $agent->sigfae_dircentrale ?? null,
                'SIGFAE_TypeAgent'         => $agent->sigfae_typeagent ?? null,
                'SIGFAE_Fonction'          => null,
                'SIGFAE_Emploi'            => $agent->sigfae_emploi ?? null,
                'SIGFAE_LieuTravail'       => $agent->sigfae_lieutravail ?? null,
                'SIGFAE_Email'             => $agent->sigfae_email ?? null,
               // 'SIGFAE_DatEnroll'         => DB::raw("CONVERT(datetime, '".Carbon::now()->format('d/m/Y H:i:s')."', 103)"),
                'SIGFAE_DatInsert'         => DB::raw("CONVERT(datetime, '".Carbon::now()->format('d/m/Y H:i:s')."', 103)"),
                'SIGFAE_Cabinet'           =>$agent->sigfae_cabinet ?? null,
                'SIGFAE_SousDirection'     => $agent->sigfae_sousdirection ?? null,
                'SIGFAE_Service'           => $agent->sigfae_service ?? null,
            ]);




             // ✅ Copier dans TBCE_AGT_BIO (Oracle)
        TBCE_AGT_BIO_INTRANET::create([
            'ce_agt_mat'                => $sigfae->SIGFAE_Matricule,
            'ce_agt_etat_recensement'       => "00",
//'CE_AGT_DATE_RECENSEMENT'   => DB::raw("TO_DATE('".Carbon::now()->format('d/m/Y H:i:s')."', 'DD/MM/YYYY HH24:MI:SS')"),
        ]);

        $insertes++;


        } 

       
    }

    return response()->json([
        'success'       => true,
        'message'       => 'Traitement terminé',
        'insertes'      => $insertes,
        'ignores'       => $ignores,
        'total_restant' => VW_FONCT_NON_RECENCE_INTRANET::count() +  VW_FONCT_NON_RECENCE_SPEC_INTRANET::count(),
        'VW_FONCT_NON_RECENCE_INTRANET'     => VW_FONCT_NON_RECENCE_INTRANET::count(),
    'VW_FONCT_NON_RECENCE_SPEC_INTRANET'=> VW_FONCT_NON_RECENCE_SPEC_INTRANET::count(),

    

    ]);
}

public function compterLignes()
{
    $countVue1 = VW_FONCT_NON_RECENCE_INTRANET::count();
    $countVue2 = VW_FONCT_NON_RECENCE_SPEC_INTRANET::count();

    return response()->json([
        'VW_FONCT_NON_RECENCE_INTRANET'      => $countVue1,
        'VW_FONCT_NON_RECENCE_SPEC_INTRANET' => $countVue2,
    ]);
}




public function compterLignes1()
{
    $agents = VW_FONCT_NON_RECENCE_INTRANET::limit(10)->get();

    return response()->json([
        'success' => true,
        'connection' => $agents->first()?->getConnectionName(),
        'count' => $agents->count(),
        'data_sample' => $agents,
    ]);
}






public function VW_FONCT_NON_RECENCE_INTRANET()
{
    $loginuser = 'UT_SIGNATURE';
    $pwduser   = 'uSIGNATURE';

    // Connexion Oracle avec oci_connect
    $oracle = oci_connect($loginuser, $pwduser, '192.168.6.37/dbmfpe.mfp.ci');

    // Vérification de la connexion
    if (!$oracle) {
        $e = oci_error();
        die('Erreur connexion Oracle : ' . $e['message']);
    }

    $SignatureMod = new VW_FONCT_NON_RECENCE_INTRANET();

    $VW_FONCT_NON_RECENCE_INTRANET = $SignatureMod->VW_FONCT_NON_RECENCE(
        $oracle,
        $loginuser
    );

    oci_close($oracle);

    return view('liste_actes', compact('VW_FONCT_NON_RECENCE_INTRANET'));
}





public function mettreAJourEtatRecensement()
{
    set_time_limit(0); // Pas de limite de temps
    ini_set('memory_limit', '2024M'); // Plus de mémoire si nécessaire
    $modifies = 0;
    $ignores = 0;

    $tbceAgents = TBCE_AGT_BIO_INTRANET::where('ce_agt_etat_recensement', '!=', '02')->get();

  // var_dump($tbceAgents);   die;

    foreach ($tbceAgents as $tbceAgent) {
        $fonctionnaire = Fonctionnaire::where('FON_Matricule', $tbceAgent->ce_agt_mat)->first();
        //     var_dump( $tbceAgent->ce_agt_mat);   die;

     


        if (!$fonctionnaire) {
            $ignores++;
            continue;
        }else {

        $updateData = [];

        // STAT_Code == '00' et ETAT_RECENSEMENT != '01'
        if ($fonctionnaire->STAT_Code === '00' && $tbceAgent->ce_agt_etat_recensement !== '01') {
            
        
            $updateData['ce_agt_etat_recensement'] = '01'; // '01'

       $modifies++;

            // Date dans la même condition
            if ($fonctionnaire->FON_DatSaisie) {
                $updateData['ce_agt_date_recensement'] = \Carbon\Carbon::parse($fonctionnaire->FON_DatSaisie)->format('Y-m-d');
            }
        }
        // STAT_Code == '02'
        elseif ($fonctionnaire->STAT_Code === '02') {
            $updateData['ce_agt_etat_recensement'] = '02'; // '02'
$modifies++;
            // Date dans la même condition
            if ($fonctionnaire->FON_DatSaisie) {
                $updateData['ce_agt_date_recensement'] = \Carbon\Carbon::parse($fonctionnaire->FON_DatSaisie)->format('Y-m-d');
            }
        }

        if (!empty($updateData)) {
            $tbceAgent->update($updateData);  //var_dump($updateData); die;
           // $modifies++;
        } else {
           // $ignores++;
        }
    }
}

    return response()->json([
        'success' => true,
        'message' => 'Mise à jour des états de recensement terminée',
        'modifies' => $modifies,
        'ignores' => $ignores
    ]);
}





/*

public function mettreAJourEtatRecensement()
{
    set_time_limit(0); // Pas de limite de temps
    ini_set('memory_limit', '1024M'); // Plus de mémoire si nécessaire

    $modifies = 0;
    $ignores = 0;

    // Traitement par lot de 100 agents
    TBCE_AGT_BIO_INTRANET::where('CE_AGT_ETAT_RECENSEMENT', '!=', '02')
        ->chunk(100, function ($tbceAgents) use (&$modifies, &$ignores) {

            // Récupérer tous les matricules des agents du lot
            $matricules = $tbceAgents->pluck('CE_AGT_MAT')->all();

            // Précharger les fonctionnaires correspondants en une seule requête
            $fonctionnaires = Fonctionnaire::whereIn('FON_Matricule', $matricules)
                ->get()
                ->keyBy('FON_Matricule');

            foreach ($tbceAgents as $tbceAgent) {
                $fonctionnaire = $fonctionnaires[$tbceAgent->CE_AGT_MAT] ?? null;

                if (!$fonctionnaire) {
                    $ignores++;
                    continue;
                }

                $updateData = [];

                // STAT_Code == '00' et ETAT_RECENSEMENT != '01'
                if ($fonctionnaire->STAT_Code === '00' && $tbceAgent->CE_AGT_ETAT_RECENSEMENT !== '01') {
                    $updateData['CE_AGT_ETAT_RECENSEMENT'] = str_pad('1', 2, '0', STR_PAD_LEFT); // '01'

                    if ($fonctionnaire->FON_DatSaisie) {
                        $updateData['CE_AGT_DATE_RECENSEMENT'] = \Carbon\Carbon::parse($fonctionnaire->FON_DatSaisie)->format('Y-m-d');
                    }
                }
                // STAT_Code == '02'
                elseif ($fonctionnaire->STAT_Code === '02') {
                    $updateData['CE_AGT_ETAT_RECENSEMENT'] = str_pad('2', 2, '0', STR_PAD_LEFT); // '02'

                    if ($fonctionnaire->FON_DatSaisie) {
                        $updateData['CE_AGT_DATE_RECENSEMENT'] = \Carbon\Carbon::parse($fonctionnaire->FON_DatSaisie)->format('Y-m-d');
                    }
                }

                if (!empty($updateData)) {
                    $tbceAgent->update($updateData);
                    $modifies++;
                } else {
                    $ignores++;
                }
            }
        });

    return response()->json([
        'success' => true,
        'message' => 'Mise à jour des états de recensement terminée',
        'modifies' => $modifies,
        'ignores' => $ignores
    ]);
}

*/


}