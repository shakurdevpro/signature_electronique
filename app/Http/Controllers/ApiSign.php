<?php

namespace App\Http\Controllers;

use App\Models\SignatureMod;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Http;
use App\Services\PdfQrService;
use Illuminate\Support\Facades\Crypt;
use PDO;
use Session;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


//use phpseclib\Net\SFTP;


class ApiSign extends Controller
{



  public function apiSign($doc){ 

//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
 //QUAND ON EST EN LOCAL  
//$source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A_SIGNER_TEST/'.$doc;

     $source= '//mnt/DATEDRV/A_SIGNER_TEST/'.$doc;
     $source = public_path('DOSSIER_SAVE/A_SIGNER_TEST/'.$doc);//REPERTOIRE A SUPPRIMER



 //QUAND ON EST SUR UN SERVEUR DISTANT
 ## /mnt/DATEDRV/ 'represente \\\192.168.6.12/sigfae_test/DOSSIER_SAVE
    // Définir le chemin de destination pour le fichier

    $destination = $doc;
    
    // Définir le nom de fichier à utiliser
   File::copy($source,  $destination);
//************************************************************************** */

   }  
   
 

  //public function getSignateur(Request $request,  $mail, $doc){

  public function getSignateur( $mail, $doc){
                   // var_dump(class_exists('\phpseclib\Net\SFTP'));
                  //  die;
                 //  $sftp = new SFTP('192.168.6.12');  

// Trouver la position du dernier underscore avant les chiffres
$lastUnderscore = strrpos($doc, "_");

// Extraire la partie avant ce dernier underscore
$extracted = substr($doc, 0, $lastUnderscore);


$parts = explode('_', $doc);
$numact = end($parts);


if ($extracted !='MISE_EN_FORMATION_HORS_CI')

{

$nom = $doc;
$doc = $doc.'.PDF';


$resultat = $this->signerDocumentAvecNom($doc, $nom);



//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
//$source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A_SIGNER_TEST/'.$doc;
$source= '//mnt/DATEDRV/A_SIGNER_TEST/'.$doc;
$source = public_path('DOSSIER_SAVE/A_SIGNER_TEST/'.$doc);//REPERTOIRE A SUPPRIMER


// Définir le chemin de destination pour le fichier
$destination = storage_path('DOCTEMP.PDF');


// Définir le nom de fichier à utiliser
File::copy($source,  $destination);


//************************************************************************** */

//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */


$coordonnee = $this->positionxy();

//var_dump($coordonnee); die;

$x = $coordonnee["X"];
$y = $coordonnee["Y"];
//************************************************************************** */


 
    //$FilePath= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A_SIGNER_TEST/'.$doc;
      $FilePath= storage_path('DOCTEMP.PDF');
    
    //var_dump($FilePath); die;
   /* dd($FilePath); die;*/

    $mail = 'so.cisse@fonctionpublique.gouv.ci';
    //$FilePath= 'ADMISSION_0442342524.PDF';
   // $FilePathPosition= $_SERVER['DOCUMENT_ROOT']."/SIGNATURE/1/test/public/ADMISSION_0442342524.PDF";
    //dd(file_exists($FilePathPosition));
   // return $this->positionxy($FilePathPosition);
   // phpinfo(); die;






     $http = new \GuzzleHttp\Client();


     
 //RECUPERATION DE LID DE LUTILISATEUR AVEC LE MAIL EN PARAMETRE
             $user = $http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email='.$mail,
                [RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                    ],
                    'http_errors' => false
                ]);
           
             $result_user = json_decode($user->getBody(),true);
             $id_user = $result_user['items'][0]['id'];






            //RECUPERATION DE l'ID du SIGNATEUR
            $signataire =$http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email='.$mail,
            [RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                ],
                'http_errors' => false
            ]);
            $result_signataire = json_decode($signataire->getBody(),true);
            $id_signataire = $result_signataire['items'][0]['id'];


      



//CREATION DU WORKFLOW AVEC LID DE LUTILISATEUR EN PARAMETRE
$workflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->withBody('{
                "name" : "ParapheurTest",
                "steps" : [ {
                  "stepType" : "signature",
                  "recipients" : [ {
                    "consentPageId" : "cop_7pFnUCqhVfj7hgtWLmieBL9q",
                    "email" : "'.$mail.'",
                    "userId" :"'.$id_signataire.'"
                  } ]
                   } ]
            }')
            ->post('https://sigfae-test.artci-sign.ci/api/users/'.$id_user.'/workflows');
            
           
            $id_workflow = $workflow['id'];





//JOINDRE UN FICHIER
$result_response = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->attach('attachment', file_get_contents($FilePath, 'application/pdf'))
            //->contentType('application/pdf')
             ->withHeaders([
                'contentType' => 'application/pdf',
            ]) 
            ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/parts');

            $partsize = $result_response['parts'][0]['size'];
            $parthash = $result_response['parts'][0]['hash'];



            //********************** */
            $partname = $doc;
            $parttype = 'application/pdf';
            //********************** */
            
 $hauteur_signature = '275.0'; 
 $lageur_signature = '165.0'; 
 $x = $x-90; $y = $y-50;  




            //LIER LE DOCUMENT AU WORKFLOW
            


            $docworkflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->withBody('{
                "parts": [
                    {
                        "filename": "'.$partname.'",
                        "contentType": "'.$parttype.'",
                        "size": '.$partsize.',
                        "hash": "'.$parthash.'"
                    }
                ],
                "signatureProfileId" : "sip_9Z5cyNfXuZvQxZYmNATCqV1Q",
                "pdfSignatureFields" : [ {
                "imagePage" : -1,
                "imageX" : '.$x.',
                "imageY" : '.$y.',
                "imageWidth" : '.$hauteur_signature.',
                "imageHeight" : '.$lageur_signature.'
              } ]
            }')
            ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/documents');

            
            //LANCER LE PARAPHEUR
            $parapheur = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->timeout(0)
            ->withBody('{"workflowStatus":"started"}')
            ->patch('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow);

           
             
          // return $parapheur;


           //LANCER L'INVITATION A SIGNER
           $invitation = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
           ->timeout(0)
           ->withBody('{"recipientEmail":"'.$mail.'"}')
           ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/invite');

         

         //  $traitement = session();
          
         //  $traitement=($infodoc);
           
         session()->put(['WORKFLOW'=>$id_workflow, 'DOCUMENT'=>$doc, 'NOM'=>$nom, 'ETAT'=>'workflowStarted']);
       
        //var_dump($invitation); die;  
           return $invitation;die;


         // var_dump($id_workflow); die;  


}



################################################################################## SI CCM

if ($extracted =='MISE_EN_FORMATION_HORS_CI')

{

                 
                 //  $sftp = new SFTP('192.168.6.12');  
$nom = $doc;
$doc = $doc.'.PDF';

;

//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
//$source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A_SIGNER_TEST/'.$doc;
$source= '//mnt/DATEDRV/A_SIGNER_TEST/'.$doc;
$source = public_path('DOSSIER_SAVE/A_SIGNER_TEST/'.$doc);//REPERTOIRE A SUPPRIMER


// Définir le chemin de destination pour le fichier
$destination = storage_path('DOCTEMP.PDF');


// Définir le nom de fichier à utiliser
File::copy($source,  $destination);


//************************************************************************** */

//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */




    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $fonction = $info['FONCTION'];
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();


  $structure = collect(config('structure.structures'))
    ->firstWhere('matricule', $loginuser)['structure'] ?? null;

    // Appel de la méthode du model
    $TEST_CCM = $SignatureMod->VERIF_ORDRE($this->oracle, $structure, $numact);

    $ordreSignature = $TEST_CCM['GL_CCM_NAV_ORD_SIGN'] ?? null;

    $NBRESIGNATAIRE = $SignatureMod->NBRE_SIGNATAIRE($this->oracle, $loginuser, $numact);

    $rest_nbre_signataire = $NBRESIGNATAIRE['NBRE_LIGNES'] ?? null;


    $LISTESIGNATAIRE = $SignatureMod->LISTE_SIGNATAIRE($this->oracle, $loginuser, $numact);

    $nbre_signataire = (int) $LISTESIGNATAIRE['NBRE_LIGNES'];
    $destinataires = explode(', ', $LISTESIGNATAIRE['LISTE_DESTINATAIRES']); 

    $configStructures = config('structure.structures'); 

    $map = [];
    foreach ($configStructures as $item) {
        $map[$item['structure']] = $item['matricule'];
    }


    $matricules = [];


    foreach ($destinataires as $dest) {
        if (isset($map[$dest])) {
            $matricules[] = $map[$dest];
        } else {
            $matricules[] = null; // ou 'INCONNU'
        }
    }

    for ($i = 0; $i < $nbre_signataire; $i++) {
    ${'matricule' . ($i + 1)} = $matricules[$i] ?? null;
    }



$emails = [];

foreach ($matricules as $mat) {
    $email = $SignatureMod->LISTE_EMAIL($this->oracle, $mat);
    if ($email) {
        $emails[] = $email;
    }
}







// Créer email1, email2, ... dynamiquement
for ($i = 0; $i < $nbre_signataire; $i++) {
    ${'email' . ($i + 1)} = $emails[$i] ?? null;
}

/* 🔍 Test
for ($i = 1; $i <= $nb; $i++) {
    echo "email$i = " . ${'email' . $i} . "\n";
}
*/





$coordonnee = $this->positionxy_ccm($ordreSignature); 



$x = $coordonnee["X"];
$y = $coordonnee["Y"];
//************************************************************************** */

 
    //$FilePath= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A_SIGNER_TEST/'.$doc;
      $FilePath= storage_path('DOCTEMP.PDF');
    
    //var_dump($FilePath); die;
   /* dd($FilePath); die;*/

    $mail1 = 'so.cisse@fonctionpublique.gouv.ci';
    //$mail = 'a.diamala@fonctionpublique.gouv.ci';
    $mail2 = 'va.bakayoko@fonctionpublique.gouv.ci';


    //$FilePath= 'ADMISSION_0442342524.PDF';
   // $FilePathPosition= $_SERVER['DOCUMENT_ROOT']."/SIGNATURE/1/test/public/ADMISSION_0442342524.PDF";
    //dd(file_exists($FilePathPosition));
   // return $this->positionxy($FilePathPosition);
   // phpinfo(); die;






     $http = new \GuzzleHttp\Client();


     

     if ($rest_nbre_signataire == $nbre_signataire) {
         
     
 //RECUPERATION DE LID DE LUTILISATEUR AVEC LE MAIL EN PARAMETRE
             $user = $http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email='.$email1,
                [RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                    ],
                    'http_errors' => false
                ]);
           
             $result_user = json_decode($user->getBody(),true);
             $id_user = $result_user['items'][0]['id'];




                $signataires_ids = []; // tableau pour stocker les ID des signataires

                for ($i = 1; $i <= $nbre_signataire; $i++) {
                    $emailVar = ${'email' . $i} ?? null;

                    if (!$emailVar) continue; // si email vide, on saute

                    $response = $http->request(
                        'GET',
                        'https://sigfae-test.artci-sign.ci/api/users?items.email=' . $emailVar,
                        [
                            RequestOptions::HEADERS => [
                                'Accept' => 'application/json',
                                'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                            ],
                            'http_errors' => false
                        ]
                    );

                    $result = json_decode($response->getBody(), true);

                    // Vérification simple
                    $id_signataire = $result['items'][0]['id'] ?? null;

                    $signataires_ids[] = $id_signataire;

                    // Optionnel : créer des variables dynamiques email1_id, email2_id, ...
                    ${'email' . $i . '_id'} = $id_signataire;
                }

               




/*

            //RECUPERATION DE l'ID du SIGNATEUR
            $signataire1 =$http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email='.$email1,
            [RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                ],
                'http_errors' => false
            ]);
            $result_signataire1 = json_decode($signataire1->getBody(),true);
            $id_signataire1 = $result_signataire1['items'][0]['id'];


                 //RECUPERATION DE l'ID du SIGNATEUR
            $signataire2 =$http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email='.$mail2,
            [RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                ],
                'http_errors' => false
            ]);
            $result_signataire2 = json_decode($signataire2->getBody(),true);
            $id_signataire2 = $result_signataire2['items'][0]['id'];

/*
      



//CREATION DU WORKFLOW AVEC LID DE LUTILISATEUR EN PARAMETRE
            /*
$workflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->withBody('{
                "name" : "ParapheurTest",
                "steps" : [ {
                  "stepType" : "signature",
                  "recipients" : [ {
                    "consentPageId" : "cop_7pFnUCqhVfj7hgtWLmieBL9q",
                    "email" : "'.$mail.'",
                    "userId" :"'.$id_signataire.'"
                  } ]
                   } ]
            }')
            ->post('https://sigfae-test.artci-sign.ci/api/users/'.$id_user.'/workflows');
            
           
            $id_workflow = $workflow['id'];


*/


/*

        $workflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->withBody('{
                "name" : "ParapheurTest",
                "steps": [
                          {
                            "stepType": "signature",
                            "recipients": [
                              { "email": "'.$mail1.'", "userId": "'.$id_signataire1.'", "consentPageId": "cop_7pFnUCqhVfj7hgtWLmieBL9q" }
                            ]
                          },
                          {
                            "stepType": "signature",
                            "recipients": [
                              { "email": "'.$mail2.'", "userId": "'.$id_signataire2.'", "consentPageId": "cop_7pFnUCqhVfj7hgtWLmieBL9q" }
                            ]
                          }
                        ]
            }')
            ->post('https://sigfae-test.artci-sign.ci/api/users/'.$id_user.'/workflows');
            
           
            $id_workflow = $workflow['id'];

*/



            $steps = [];

            for ($i = 1; $i <= $nbre_signataire; $i++) {
                $email = ${'email' . $i} ?? null;
                $userId = ${'email' . $i . '_id'} ?? null;

                if (!$email || !$userId) continue; // on skip si info manquante

                $steps[] = [
                    'stepType' => 'signature',
                    'recipients' => [
                        [
                            'email' => $email,
                            'userId' => $userId,
                            'consentPageId' => 'cop_7pFnUCqhVfj7hgtWLmieBL9q'
                        ]
                    ]
                ];
            }

            // Construire le corps JSON
            $body = [
                'name' => 'ParapheurTest',
                'steps' => $steps
            ];

            // Envoyer la requête
            $workflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
                ->withBody(json_encode($body), 'application/json')
                ->post('https://sigfae-test.artci-sign.ci/api/users/'.$id_user.'/workflows');

            $id_workflow = $workflow['id'] ?? null;

            // 🔍 Debug
            //var_dump($id_workflow);
           // die;





//JOINDRE UN FICHIER
$result_response = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->attach('attachment', file_get_contents($FilePath, 'application/pdf'))
            //->contentType('application/pdf')
             ->withHeaders([
                'contentType' => 'application/pdf',
            ]) 
            ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/parts');

            $partsize = $result_response['parts'][0]['size'];
            $parthash = $result_response['parts'][0]['hash'];



            //********************** */
            $partname = $doc;
            $parttype = 'application/pdf';
            //********************** */
            
 $hauteur_signature = '91.66'; 
 $lageur_signature = '55.0'; 
 $x = $x-10; 
 $y = $y-10; 





            //LIER LE DOCUMENT AU WORKFLOW
            
/*

            $docworkflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->withBody('{
                "parts": [
                    {
                        "filename": "'.$partname.'",
                        "contentType": "'.$parttype.'",
                        "size": '.$partsize.',
                        "hash": "'.$parthash.'"
                    }
                ],
                "signatureProfileId" : "sip_9Z5cyNfXuZvQxZYmNATCqV1Q",
                "pdfSignatureFields" : [ {
                "imagePage" : -1,
                "imageX" : '.$x.',
                "imageY" : '.$y.',
                "imageWidth" : '.$hauteur_signature.',
                "imageHeight" : '.$lageur_signature.'
              } ]
            }')
            ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/documents');
*/



$pdfSignatureFields = [];

$largeur = 200;   // width signature
$hauteur = 85;   // height signature

for ($ordre = 1; $ordre <= $nbre_signataire; $ordre++) {

    $coordonnee = $this->positionxy_ccm($ordre);

    $pdfSignatureFields[] = [
        "imagePage"   => -1,
        "imageX"      => $coordonnee["X"]-100,
        "imageY"      => $coordonnee["Y"]-20,
        "imageWidth"  => $largeur,
        "imageHeight" => $hauteur
    ];
}






            


            $docworkflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
    ->withBody(json_encode([
        "parts" => [[
            "filename" => $partname,
            "contentType" => $parttype,
            "size" => (int)$partsize,
            "hash" => $parthash
        ]],
        "signatureProfileId" => "sip_9Z5cyNfXuZvQxZYmNATCqV1Q",
        "pdfSignatureFields" => $pdfSignatureFields
    ]), 'application/json')
    ->post("https://sigfae-test.artci-sign.ci/api/workflows/$id_workflow/documents");










            
            //LANCER LE PARAPHEUR
            $parapheur = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->timeout(0)
            ->withBody('{"workflowStatus":"started"}')
            ->patch('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow);

           
             
          // return $parapheur;


           //LANCER L'INVITATION A SIGNER
           $invitation = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
           ->timeout(0)
           ->withBody('{"recipientEmail":"'.$email1.'"}')
           ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/invite');


   




           
         session()->put(['WORKFLOW'=>$id_workflow, 'DOCUMENT'=>$doc, 'NOM'=>$nom, 'ETAT'=>'workflowStarted']);
       
        //var_dump($invitation); die;  
           return $invitation;die;


         // var_dump($id_workflow); die;  

}else{


//$REINITIALISERNAVETTE = $SignatureMod->REINITIALISERNAVETTE($this->oracle, $numact); die;



$SIGNATAIREACTUEL = $nbre_signataire - $rest_nbre_signataire+1;
$signataireprecedent = $nbre_signataire - $rest_nbre_signataire;

$emailActuel = ${'email' . $SIGNATAIREACTUEL} ?? null;



    $RECUPEWORKFLOW = $SignatureMod->RECUPEWORKFLOW($this->oracle, $numact, $signataireprecedent );


     $invitation = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
           ->timeout(0)
           ->withBody('{"recipientEmail":"'.$emailActuel.'"}')
           ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$RECUPEWORKFLOW.'/invite');


            session()->put(['WORKFLOW'=>$RECUPEWORKFLOW, 'DOCUMENT'=>$doc, 'NOM'=>$nom, 'ETAT'=>'workflowStarted']);
       
        //var_dump($invitation); die;  
          return $invitation;die;


    




   


}





}
################################################################################## FIN SI CCM





    
    }


















###########################################################################################################################
###########################################################################################################################
###########################################################################################################################
###########################################################################################################################


    public function quitter(Request $request) {

      //phpinfo(); die;

      //RECUPERER LES VALEURS DU FORMULAIRE QUITTER
      $idacte  = $request->P_ACTE_ID;
      $numacte  = $request->P_ACTE_NUM;


      
      $usermin = $request->P_USERMIN;
      

   $avant_artci1 = microtime(true);  
      //TESTER LE STATUT SIGNE DU DOCUMENT
      $id_workflow = session()->get('WORKFLOW');
      $doc = session()->get('DOCUMENT');
      $nom = session()->get('NOM');


$lastUnderscore = strrpos($doc, "_");
// Extraire la partie avant ce dernier underscore
$extracted = substr($doc, 0, $lastUnderscore);










      
      $wehbook = "wbh_4ZJP78j8ohr9kjwjuFjoB8Km";
  // $id_workflow = 'wfl_FPsHfqy3otZGm5uJ61FxP5Vb';
      
      $statuswork = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
      ->get('https://sigfae-test.artci-sign.ci/api/webhookEvents/?webhookEventId='.$wehbook.'&items.workflowId='.$id_workflow);

   ///tessssss  ############################################### 

$response = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
    ->get('https://sigfae-test.artci-sign.ci/api/workflows/' . $id_workflow);

$workflow = $response->json();

$statutsSignataires = [];
$totalSignataires = 0;
$nombreSignes = 0;

if (isset($workflow['steps']) && is_array($workflow['steps'])) {
    foreach ($workflow['steps'] as $indexStep => $step) {
        // Les statuts se trouvent sur l'étape ($step)
        $isFinished = !empty($step['isFinished']);
        $isStarted  = !empty($step['isStarted']);
        
        // Détermination du statut de l'étape
        if ($isFinished) {
            $statut = 'recipientFinished';
            $nombreSignes++;
        } elseif ($isStarted) {
            $statut = 'workflowStarted';
        } else {
            $statut = 'pending';
        }

        foreach ($step['recipients'] as $recipient) {
            $totalSignataires++;
            $email = $recipient['email'] ?? 'Email inconnu';

            $statutsSignataires[] = [
                'étape'      => $indexStep + 1,
                'email'      => $email,
                'statut'     => $statut,
                'isFinished' => $isFinished,
                'isStarted'  => $isStarted
            ];
        }
    }
}

var_dump([
    'total_signataires' => $totalSignataires,
    'nombre_signes'     => $nombreSignes,
    'detail'            => $statutsSignataires
]);

die;
///tessssss  ############################################### 


     $etat = $statuswork['items'][0]['eventType'];

var_dump($statuswork); die;

    $apres_artci1 = microtime(true);




    $avant_artci2 = microtime(true);  
    //CONNEXION ET UPDATE SUR LA TABLE
     defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
     (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');
     
       $info      = session()->get('INFORMATION');
       $loginuser = $info['LOGINUSER'];
     
     
       $pwduser   = $info['PWDUSER'];
       $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
      
       //UTILISATION DE LA FONCTION UPDATE
       $SignatureMod    = new SignatureMod();
      // $nom_ministre = utf8_decode($usermin);
      // $FN_SE_USER_INFO =  $SignatureMod->PR_SE_MAJ_NOTIF_MIN_COLL($this->oracle, $idacte, $nom, $loginuser, $id_workflow, 'WORKFLOWFINISHED');
     
     // Obtenir l'adresse IP de la machine
   //  $SYSTEM_USER  = get_current_user();
     
     //$idae = "1";
     // Obtenir le nom d'utilisateur de la machine
    // $SYSTEM_MACHINE  = gethostname();
     
   //  $FN_SE_MSJ_INFO =  $SignatureMod->PR_SE_SIGN_MIN_COLL($this->oracle, $idacte, $SYSTEM_MACHINE, $SYSTEM_USER);


    // $SELECT =  $SignatureMod->SELECT($this->oracle, $idacte);
     
    // die;








    $apres_artci2 = microtime(true);

   


if ($extracted !='MISE_EN_FORMATION_HORS_CI'){
 
  
    if ($etat == 'recipientFinished'  OR $etat == 'workflowFinished' ){
    
   $avant_artci3 = microtime(true);
#######################################################################################################
// LE DOUMENT A TELECHARGER
     $document = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
     ->get('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/downloadDocuments');

     $apres_artci3 = microtime(true);
#######################################################################################################

$avant_artci4 = microtime(true);
// TELECHARGEMENT DU DOUMENT
//$document_tel= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/ACTESIGNE_TEST/'.$doc;	 

 $document_tel='../../../../PDFSIGNE/'.$doc;
$handle = fopen($document_tel, "w");
fwrite($handle, $document);
fclose($handle);


//$document_tel_1= '//mnt/DATEDRV/ACTESIGNE_TEST/'.$doc;
$document_tel_1 = public_path('DOSSIER_SAVE/ACTESIGNE_TEST/'.$doc);//REPERTOIRE A SUPPRIMER
$handle_1 = fopen($document_tel_1, "w");
fwrite($handle_1, $document);
fclose($handle_1);    
     
$apres_artci4 = microtime(true);



#######################################################################################################
// FAIT UN UPDATE SUR LA TABLE

$avant_artci5 = microtime(true);
//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

  $info      = session()->get('INFORMATION');
  $loginuser = $info['LOGINUSER'];
  $fonction = $info['FONCTION'];


  $pwduser   = $info['PWDUSER'];
  $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser, $fonction);
 
  //UTILISATION DE LA FONCTION UPDATE
  $SignatureMod    = new SignatureMod();
  $nom_ministre = 'nom du ministre';
  $FN_SE_USER_INFO =  $SignatureMod->PR_SE_MAJ_NOTIF_MIN_COLL($this->oracle, $idacte, $nom, $loginuser, $fonction, $id_workflow, 'WORKFLOWFINISHED');

// Obtenir l'adresse IP de la machine
$SYSTEM_USER  = get_current_user();

//$idae = "1";
// Obtenir le nom d'utilisateur de la machine
$SYSTEM_MACHINE  = gethostname();

$FN_SE_MSJ_INFO =  $SignatureMod->PR_SE_SIGN_MIN_COLL($this->oracle, $numacte, $SYSTEM_MACHINE, $SYSTEM_USER);

//var_dump( 'ACTE:'.$numacte .' GL_ACTE_SYSTEME : '.$SYSTEM_MACHINE.' / GL_ACTE_USER_SYSTEME '.$SYSTEM_USER);
//die;

$apres_artci5 = microtime(true);


     }

}





################################################################################## SI CCM

if ($extracted =='MISE_EN_FORMATION_HORS_CI'){
 
 
  
    if ($etat == 'recipientFinished'  OR $etat == 'workflowFinished' ){
    
   $avant_artci3 = microtime(true);
#######################################################################################################
// LE DOUMENT A TELECHARGER
     $document = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
     ->get('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/downloadDocuments');

     $apres_artci3 = microtime(true);
#######################################################################################################

$avant_artci4 = microtime(true);
// TELECHARGEMENT DU DOUMENT
//$document_tel= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/ACTESIGNE_TEST/'.$doc;    





//CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $fonction = $info['FONCTION'];
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();


//update de la table navette
  $structure = collect(config('structure.structures'))
    ->firstWhere('matricule', $loginuser)['structure'] ?? null;
 $SIGNER_ACTE = $SignatureMod->SIGNER_ACTE($this->oracle, $structure, $numacte);
$SIGNER_LETTRE_TRANSMITION = $SignatureMod->SIGNER_LETTRE_TRANSMITION($this->oracle, $structure, $numacte);






      $configStructures = config('structure.structures');
       $structureAssociee = null;
        foreach ($configStructures as $item) {
            if ($item['matricule'] === $loginuser) {
                $structureAssociee = $item['structure'];
                break;
            }
        }
         


         $INSERERWORKFLOW = $SignatureMod->INSERER_WORKFLOW($this->oracle, $id_workflow, $numacte, $structureAssociee );



    // Appel de la méthode du model
    $SIGNATAIRE_RESTANT = $SignatureMod->SIGNATAIRE_RESTANT($this->oracle, $loginuser, $numacte);

    $reste_signataire = $SIGNATAIRE_RESTANT['NBRE_LIGNES'] ?? null;


if ($reste_signataire > 0) {
    



$document_tel_1 = public_path('DOSSIER_SAVE/A_SIGNER_TEST/'.$doc);//REPERTOIRE A SUPPRIMER
if (file_exists($document_tel_1)) {unlink($document_tel_1);}
$handle_1 = fopen($document_tel_1, "w");
fwrite($handle_1, $document);
fclose($handle_1);  


}else{



 $document_tel='../../../../PDFSIGNE/'.$doc;
$handle = fopen($document_tel, "w");
fwrite($handle, $document);
fclose($handle);

$document_tel_1 = public_path('DOSSIER_SAVE/ACTESIGNE_TEST/'.$doc);//REPERTOIRE A SUPPRIMER
$handle_1 = fopen($document_tel_1, "w");
fwrite($handle_1, $document);
fclose($handle_1);  









     
$apres_artci4 = microtime(true);


#######################################################################################################
// FAIT UN UPDATE SUR LA TABLE

$avant_artci5 = microtime(true);
//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

  $info      = session()->get('INFORMATION');
  $loginuser = $info['LOGINUSER'];
  $fonction = $info['FONCTION'];


  $pwduser   = $info['PWDUSER'];
  //$this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser,$fonction);
  $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
 
  //UTILISATION DE LA FONCTION UPDATE
  $SignatureMod    = new SignatureMod();
  $nom_ministre = 'nom du ministre';
  //$FN_SE_USER_INFO =  $SignatureMod->PR_SE_MAJ_NOTIF_MIN_COLL($this->oracle, $idacte, $nom, $loginuser, $fonction, $id_workflow, 'WORKFLOWFINISHED');

  $FN_SE_USER_INFO =  $SignatureMod->PR_SE_MAJ_NOTIF_MIN_COLL($this->oracle, $idacte, $nom, $loginuser, $id_workflow, 'WORKFLOWFINISHED');


// Obtenir l'adresse IP de la machine
$SYSTEM_USER  = get_current_user();

//$idae = "1";
// Obtenir le nom d'utilisateur de la machine
$SYSTEM_MACHINE  = gethostname();

$FN_SE_MSJ_INFO =  $SignatureMod->PR_SE_SIGN_MIN_COLL($this->oracle, $numacte, $SYSTEM_MACHINE, $SYSTEM_USER);

$UPDATE_TBGL_ACTE_00084 = $SignatureMod->UPDATE_TBGL_ACTE_00084($this->oracle, $numacte); 


//var_dump( 'ACTE:'.$numacte .' GL_ACTE_SYSTEME : '.$SYSTEM_MACHINE.' / GL_ACTE_USER_SYSTEME '.$SYSTEM_USER);
//die;

$apres_artci5 = microtime(true);

}



     }

}

################################################################################## FIN SI CCM




     

    
      $fonction = $info['FONCTION'];


     $avant_artci6 = microtime(true);

     $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
     $NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
     $NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
     $NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
     $NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
     $stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];


     $LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
     $LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);


      $request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
      $request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
      $request->session()->put('STAT', $stat);

      $apres_artci6 = microtime(true);


    /*  $artci1 = $apres_artci1 - $avant_artci1;
      $artci2 = $apres_artci2 - $avant_artci2;
      $artci3 = $apres_artci3 - $avant_artci3;
      $artci4 = $apres_artci4 - $avant_artci4;
      $artci5 = $apres_artci5 - $avant_artci5;
      $artci6 = $apres_artci6 - $avant_artci6; */
      //echo 'TESTER LE STATUT SIGNE DU DOCUMENT = '.$artci1.'  CONNEXION A LA BD = '.$artci2.'  LE DOUMENT A TELECHARGER = '.$artci3.'  TELECHARGEMENT DU DOUMENT = '.$artci4.'  CONNEXION ET UPDATE SUR LA TABLE = '.$artci5.'  RETOUR A LA PAGE = '.$artci6;
      
     // $temps = $artci1+$artci2+$artci3+$artci4+$artci5+$artci6;
      
    //  echo 'TOTAL = '.$temps;
    //  die;
           
    

     return redirect('/accueil');
       
  }



###########################################################################################################################
###########################################################################################################################
###########################################################################################################################
###########################################################################################################################

//***************************************RECUPERATION DES COORDONNEE X Y*********************************************** */

private function positionxy($files=NULL){

$configfile = 'java/getXY.jar';
$files = storage_path('DOCTEMP.PDF');

if(file_exists($files)){

     exec('/opt/java/jdk17/bin/java -jar '.$configfile.' '.$files, $response);
      $XY = explode("_", $response[0]);
        
        $coordonnee = array('X'=> $XY[0], 'Y' => $XY[1] );

        return $coordonnee;

        }

        else{
            echo "deseole";
        }

/*
        $cmd1 = 'java -jar java\getXY.jar "C:\xampp\htdocs\SIGNATURE\1\test\public\ficheTemp\DOCTEMP.PDF"';
 $coordonnee = shell_exec($cmd1);
return $coordonnee;
*/

}



####################################  POSITION ### POUR QR #############################

private function positionxy_QR($files=NULL){

$configfile = 'java/getXY_QR.jar';
$files = storage_path('DOCTEMP.PDF');

if(file_exists($files)){

     exec('/opt/java/jdk17/bin/java -jar '.$configfile.' '.$files, $response);
      $XY = explode("_", $response[0]);
        
        $coordonnee = array('X'=> $XY[0], 'Y' => $XY[1] );

        return $coordonnee;  

        }

        else{
            echo "deseole";
        }

/*
        $cmd1 = 'java -jar java\getXY.jar "C:\xampp\htdocs\SIGNATURE\1\test\public\ficheTemp\DOCTEMP.PDF"';
 $coordonnee = shell_exec($cmd1);
return $coordonnee;
*/

}


###########################################################################################################################
###########################################################################################################################
###########################################################################################################################
###########################################################################################################################









########################################################################################################################
########################################################################################################################
########################################################################################################################



  public function apiSign_ccm($doc){ 

//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
 //QUAND ON EST EN LOCAL  
//$source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A_SIGNER_TEST/'.$doc;

     $source= '//mnt/DATEDRV/A_SIGNER_TEST/'.$doc;
     $source = public_path('DOSSIER_SAVE/A_SIGNER_TEST/'.$doc);//REPERTOIRE A SUPPRIMER



 //QUAND ON EST SUR UN SERVEUR DISTANT
 ## /mnt/DATEDRV/ 'represente \\\192.168.6.12/sigfae_test/DOSSIER_SAVE
    // Définir le chemin de destination pour le fichier

    $destination = $doc;
    
    // Définir le nom de fichier à utiliser
   File::copy($source,  $destination);
//************************************************************************** */

   }  
   
 

  //public function getSignateur(Request $request,  $mail, $doc){

  public function getSignateur_ccm( $mail, $doc){
                   // var_dump(class_exists('\phpseclib\Net\SFTP'));
                  //  die;
                 //  $sftp = new SFTP('192.168.6.12'); 
$nom = $doc;
$doc = $doc.'.PDF';



//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
//$source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A_SIGNER_TEST/'.$doc;
$source= '//mnt/DATEDRV/A_SIGNER_TEST/'.$doc;
$source = public_path('DOSSIER_SAVE/A_SIGNER_TEST/'.$doc);//REPERTOIRE A SUPPRIMER


// Définir le chemin de destination pour le fichier
$destination = storage_path('DOCTEMP.PDF');


// Définir le nom de fichier à utiliser
File::copy($source,  $destination);


//************************************************************************** */

//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
$coordonnee = $this->positionxy_ccm();
$x = $coordonnee["X"];
$y = $coordonnee["Y"];
//************************************************************************** */

    //$FilePath= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A_SIGNER_TEST/'.$doc;
      $FilePath= storage_path('DOCTEMP.PDF');
    
    //var_dump($FilePath); die;
   /* dd($FilePath); die;*/

    $mail = 'so.cisse@fonctionpublique.gouv.ci';
    //$FilePath= 'ADMISSION_0442342524.PDF';
   // $FilePathPosition= $_SERVER['DOCUMENT_ROOT']."/SIGNATURE/1/test/public/ADMISSION_0442342524.PDF";
    //dd(file_exists($FilePathPosition));
   // return $this->positionxy($FilePathPosition);
   // phpinfo(); die;






     $http = new \GuzzleHttp\Client();


     
 //RECUPERATION DE LID DE LUTILISATEUR AVEC LE MAIL EN PARAMETRE
             $user = $http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email='.$mail,
                [RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                    ],
                    'http_errors' => false
                ]);
           
             $result_user = json_decode($user->getBody(),true);
             $id_user = $result_user['items'][0]['id'];






            //RECUPERATION DE l'ID du SIGNATEUR
            $signataire =$http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email='.$mail,
            [RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                ],
                'http_errors' => false
            ]);
            $result_signataire = json_decode($signataire->getBody(),true);
            $id_signataire = $result_signataire['items'][0]['id'];


      



//CREATION DU WORKFLOW AVEC LID DE LUTILISATEUR EN PARAMETRE
$workflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->withBody('{
                "name" : "ParapheurTest",
                "steps" : [ {
                  "stepType" : "signature",
                  "recipients" : [ {
                    "consentPageId" : "cop_7pFnUCqhVfj7hgtWLmieBL9q",
                    "email" : "'.$mail.'",
                    "userId" :"'.$id_signataire.'"
                  } ]
                   } ]
            }')
            ->post('https://sigfae-test.artci-sign.ci/api/users/'.$id_user.'/workflows');
            
           
            $id_workflow = $workflow['id'];





//JOINDRE UN FICHIER
$result_response = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->attach('attachment', file_get_contents($FilePath, 'application/pdf'))
            //->contentType('application/pdf')
             ->withHeaders([
                'contentType' => 'application/pdf',
            ]) 
            ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/parts');

            $partsize = $result_response['parts'][0]['size'];
            $parthash = $result_response['parts'][0]['hash'];



            //********************** */
            $partname = $doc;
            $parttype = 'application/pdf';
            //********************** */
            


            $x = $x-90;
            $y = $y-50;


            //LIER LE DOCUMENT AU WORKFLOW
            
            $docworkflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->withBody('{
                "parts": [
                    {
                        "filename": "'.$partname.'",
                        "contentType": "'.$parttype.'",
                        "size": '.$partsize.',
                        "hash": "'.$parthash.'"
                    }
                ],
                "signatureProfileId" : "sip_9Z5cyNfXuZvQxZYmNATCqV1Q",
                "pdfSignatureFields" : [ {
                "imagePage" : -1,
                "imageX" : '.$x.',
                "imageY" : '.$y.',
                "imageWidth" : 275.0,
                "imageHeight" : 165.0
              } ]
            }')
            ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/documents');

            
            //LANCER LE PARAPHEUR
            $parapheur = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->timeout(0)
            ->withBody('{"workflowStatus":"started"}')
            ->patch('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow);

           
             
          // return $parapheur;


           //LANCER L'INVITATION A SIGNER
           $invitation = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
           ->timeout(0)
           ->withBody('{"recipientEmail":"'.$mail.'"}')
           ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/invite');

         

         //  $traitement = session();
          
         //  $traitement=($infodoc);
           
         session()->put(['WORKFLOW'=>$id_workflow, 'DOCUMENT'=>$doc, 'NOM'=>$nom, 'ETAT'=>'workflowStarted']);
       
        //var_dump($invitation); die;  
           return $invitation;die;


         // var_dump($id_workflow); die;  



    
    }



#######################################################

    private function positionxy_ccm($ordreSignature, $files=NULL){

$configfile = 'java/getXY_ccm.jar';
$files = storage_path('DOCTEMP.PDF');

if(file_exists($files)){

     exec('/opt/java/jdk17/bin/java -jar '.$configfile.' '.$files.' '.$ordreSignature, $response);
      $XY = explode("_", $response[0]);
        
        $coordonnee = array('X'=> $XY[0], 'Y' => $XY[1] );

        return $coordonnee;

        }

        else{
            echo "deseole";
        }

/*
        $cmd1 = 'java -jar java\getXY.jar "C:\xampp\htdocs\SIGNATURE\1\test\public\ficheTemp\DOCTEMP.PDF"';
 $coordonnee = shell_exec($cmd1);
return $coordonnee;
*/

}

########################################################################################################################
########################################################################################################################
########################################################################################################################
























    // vue du tableau contenant tous les demandes des mutualistes chez l'assistante sociale
    public function getSignateur1(Request $request)
    
    {

       
     // $this->positionxy('$coordonnee');


      $coordonnee = $this->positionxy();

      $xy = explode("_", $coordonnee);


      $x = $xy[0];
      $y = $xy[1];
  
 /*   echo 'Coordonné X = '.$x; // x
    echo 'Coordonné Y = '.$y; // y
die;
*/

       // phpinfo(); die;
         $http = new \GuzzleHttp\Client();
         
                //RECUPERATION DE LID DE LUTILISATEUR AVEC LE MAIL EN PARAMETRE
                 $user =$http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email=so.cisse@fonctionpublique.gouv.ci',
                    [RequestOptions::HEADERS => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                        ],
                        'http_errors' => false
                    ]);
                 $result_user = json_decode($user->getBody(),true);
                 $id_user = $result_user['items'][0]['id'];

                //RECUPERATION DE l'ID du SIGNATEUR
                $signataire =$http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email=so.cisse@fonctionpublique.gouv.ci',
                [RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                    ],
                    'http_errors' => false
                ]);
                $result_signataire = json_decode($signataire->getBody(),true);
                $id_signataire = $result_signataire['items'][0]['id'];

                
                //CREATION DU WORKFLOW AVEC LID DE LUTILISATEUR EN PARAMETRE
                $workflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
                ->withBody('{
                    "name" : "ParapheurTest",
                    "steps" : [ {
                      "stepType" : "signature",
                      "recipients" : [ {
                        "consentPageId" : "cop_7pFnUCqhVfj7hgtWLmieBL9q",
                        "email" : "so.cisse@fonctionpublique.gouv.ci",
                        "userId" :"'.$id_signataire.'"
                      } ]
                       } ]
                }')
                ->post('https://sigfae-test.artci-sign.ci/api/users/'.$id_user.'/workflows');
                
               
                $id_workflow = $workflow['id'];

                //JOINDRE UN FICHIER
                $FilePath= 'ADMISSION_0442342524.PDF';
               // $FilePath = "http://192.168.1.48/SIGNATURE/1/test/public/".$FilePathok;
               // dd($FilePath);

                //$cFile = curl_file_create($FilePath);
                //$post = array('file'=> $cFile);
               // var_dump($http); die;
/*                  $result_response = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
                ->withHeaders([
                    'Content-Type' => 'application/pdf',
                   // 'Content-Type' => ' application/octet-stream',
                    //'Content-Disposition' => 'attachment; filename="diamala.pdf"'
                
                ])
                ->withBody(
                    base64_encode($FilePath),'application/pdf'
                )
                ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/parts');
                dd( $result_response); die; */
                
                $result_response = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
                ->attach('attachment', file_get_contents($FilePath, 'application/pdf'))
                //->contentType('application/pdf')
                 ->withHeaders([
                    'contentType' => 'application/pdf',
                ]) 
                ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/parts');
                //return($result_response); die;

/*                 $result_response = new \GuzzleHttp\Client(['handler' => HandlerStack::create(new CurlMultiHandler([
                    'options' => [
                        'CURLOPT_URL' => 'https://sigfae-test.artci-sign.ci/api/workflows//'.$id_workflow.'/parts',

                        'CURLOPT_RETURNTRANSFER' => true,
                      
                        'CURLOPT_POST' => true,
                      
                        'CURLOPT_POSTFIELDS' => array('pdf' => curl_file_create($FilePath, mime_content_type($FilePath), basename($FilePath))),
                      
                        'CURLOPT_HTTPHEADER' => array(
                      
                          'Authorization: Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU'
                      
                        ),
                    ]
                ]))]); */
                
                
                //****************************************************************** */
                $partname = $FilePath;
                $parttype = 'application/pdf';
                //****************************************************************** */
                //$partname = $result_response['parts'][0]['filename'];
                //$parttype = $result_response['parts'][0]['contentType'];
                $partsize = $result_response['parts'][0]['size'];
                $parthash = $result_response['parts'][0]['hash'];
                
                //dd($result_response);
                //LIER LE DOCUMENT AU WORKFLOW
                $docworkflow = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
                ->withBody('{
                    "parts": [
                        {
                            "filename": "'.$partname.'",
                            "contentType": "'.$parttype.'",
                            "size": '.$partsize.',
                            "hash": "'.$parthash.'"
                        }
                    ],
                  "pdfSignatureFields" : [ {
                    "imagePage" : -1,
                    "imageX" : '.$x.',
                    "imageY" : '.$y.',
                    "imageWidth" : 275.0,
                    "imageHeight" : 165.0;

                  } ]
                }')
                ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/documents');


                

                
                //LANCER LE PARAPHEUR
                $parapheur = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
                ->timeout(0)
                ->withBody('{"workflowStatus":"started"}')
                ->patch('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow);

                

              // return $parapheur;


               //LANCER L'INVITATION A SIGNER
               $invitation = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
               ->timeout(0)
               ->withBody('{"recipientEmail":"so.cisse@fonctionpublique.gouv.ci"}')
               ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/invite');
/*
               var_dump($id_workflow); die; */
               return $invitation;


               $statusfinish = NULL ;
               while($statusfinish =! 'recipientFinished')
               {

                $wehbook = "wbh_4ZJP78j8ohr9kjwjuFjoB8Km";
                $statuswork = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
                ->get('https://sigfae-test.artci-sign.ci/api/webhookEvents/?webhookEventId='.$wehbook.'&items.workflowId='.$id_workflow.'&items.eventType=recipientFinished'); 
                  
                //$statuswork['items'][0]['eventType']=='recipientFinished';
                $statusfinish = $statuswork['items'][0]['eventType'];
               }


              
            
    }

    public function statutworkflow($id_workflow) {
        //TESTER LE STATUT SIGNE DU DOCUMENT
        $wehbook = "wbh_4ZJP78j8ohr9kjwjuFjoB8Km";
        $statuswork = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
        ->get('https://sigfae-test.artci-sign.ci/api/webhookEvents/?webhookEventId='.$wehbook.'&items.workflowId='.$id_workflow.'&items.eventType=recipientFinished'); 
          
        IF ($statuswork['items'][0]['eventType']=='recipientFinished') {
          return "ok";
          //DOWNLOAD LE FICHIER
        } else {
          return "ok pas";
        }
    }








#############################################################
################  CODE QR ###################################
#############################################################

private string $cleSecrete = 'FonctionPubliqueCI2026!';
private function crypterNomCompact(string $texte): string
    {
        $raw = openssl_encrypt($texte, 'AES-128-ECB', $this->cleSecrete, OPENSSL_RAW_DATA);
        return rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');
    }


  public function signerDocumentAvecNom(string $doc, string $nom): array
    {
        // 1. Chemin du document dans /public/DOSSIER_SAVE/A_SIGNER_TEST/
        $le_doc_pour_le_qr = public_path('DOSSIER_SAVE/A_SIGNER_TEST/' . basename($doc));

       // var_dump($le_doc_pour_le_qr); die;

        if (!file_exists($le_doc_pour_le_qr)) {
            throw new \RuntimeException("Le document {$doc} n'existe pas dans public/DOSSIER_SAVE/A_SIGNER_TEST/");
        }

        $pdfQrService = app(PdfQrService::class);

          $nomCrypte = $this->crypterNomCompact($nom); //var_dump($nomCrypte); die;
         $urlVerification = "https://formation-signature.fonctionpublique.gouv.ci/verif/" . $nomCrypte;

        // 2. Extraction des coordonnées X, Y du repère '#' via positionxy_QR
        $coordonnee_QR = $pdfQrService->positionxy_QR($le_doc_pour_le_qr);  
        $x_QR = $coordonnee_QR["X"];
        $y_QR = $coordonnee_QR["Y"];

        // 3. Génération du QR Code avec la valeur de $nom et remplacement du fichier dans le même dossier
        $cheminFinal = $pdfQrService->ajouterQrSurPdf($le_doc_pour_le_qr, $urlVerification);

        return [
            'success' => true,
            'document' => basename($doc),
            'nom_original' => $nom,
            'nom_crypte' => $nomCrypte,
            'url_verification' => $urlVerification,
            'coordonnees' => [
                'X' => $x_QR,
                'Y' => $y_QR,
            ],
            'chemin_final' => $cheminFinal,
        ];
    }



   public function decrypterNomCompact(string $tokenCrypte): string
    {
        $raw = base64_decode(strtr($tokenCrypte, '-_', '+/'));
        $decrypted = openssl_decrypt($raw, 'AES-128-ECB', $this->cleSecrete, OPENSSL_RAW_DATA);
        return $decrypted !== false ? $decrypted : '';
    }



 


 /**
 * Page de décryptage et de vérification d'authenticité de l'acte (/verif/{nomCrypte})
 */
public function verifierActe(string $nomCrypte)
{
    $status = 'notfound';
    $nomOriginal = null;
    $numeroActe = null;
    $typeActe = "Document Officiel MFPMA";
    $dateVerification = date('d/m/Y à H:i');
    $dateSignature = '-';
    $downloadUrl = null;
    $detailsActe = null;
    $prefix = '';

    try {
        // 1. Déchiffrement du token compact
        $nomOriginal = $this->decrypterNomCompact($nomCrypte);

        if (!empty($nomOriginal)) {
            // Nettoyage du nom sans extension
            $cleanName = pathinfo($nomOriginal, PATHINFO_FILENAME); // ex: PRET_BANCAIRE_0972240991

            // 2. Extraction du NUMERO_ACTE (après le dernier '_') et du PREFIXE (avant le dernier '_')
            $lastUnderscorePos = strrpos($cleanName, '_');

            if ($lastUnderscorePos !== false) {
                $prefix = strtoupper(substr($cleanName, 0, $lastUnderscorePos)); // ex: MISE_EN_FORMATION
                $numeroActe = substr($cleanName, $lastUnderscorePos + 1);       // ex: 0782342576
            } else {
                $prefix = '';
                $numeroActe = $cleanName;
            }

            // 3. Mapping dynamique de la Nature de l'Acte
            $mapNatures = [
                'MISE_EN_FORMATION'      => 'Mise en formation',
                'FIN_DE_FORMATION'      => 'Fin de formation',
                'COMMUNIQUE'             => 'Communiqué d\'admission',
                'ADMISSION'              => 'Arrêté d\'Admission',
                'COMMUNIQUE_OUVERTURE'   => 'Communiqué d\'ouverture',
                'ARRETE_OUVERTURE'       => 'Arrêté d\'ouverture',
                'ATTESTATION_PRIME'      => 'Attestation de Prime',
                'DOMICILIATION_PRIME'    => 'Domiciliation de Prime',
                'PRET_BANCAIRE'          => 'Prêt bancaire',
                'RGS'                    => 'RGS',
                'ARSA'                   => 'ARSA',
            ];

            if (isset($mapNatures[$prefix])) {
                $typeActe = $mapNatures[$prefix];
            }

            // 4. Vérification du fichier physique dans public/DOSSIER_SAVE/A_SIGNER_TEST/
            $fileNamePdf = str_ends_with(strtolower($nomOriginal), '.pdf') ? $nomOriginal : $nomOriginal . '.PDF';
            $filePath = public_path('DOSSIER_SAVE/ACTESIGNE_TEST/' . basename($fileNamePdf));

            if (file_exists($filePath)) {
                $downloadUrl = route('documents.view', ['filename' => basename($fileNamePdf)]);
                //$status = 'ok';
            }

            // 5. Intégration Modèle SignatureMod / Connexion Oracle BD
            try {
                $signatureMod = new SignatureMod();

                defined('TNSNAME') OR define('TNSNAME', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');
                $conn = $this->oracle = new \PDO('oci:dbname=' . TNSNAME, 'X505234', 'Welcome1');

                $liste = [];

                switch ($prefix) {
                    case 'MISE_EN_FORMATION':
                        $liste = $signatureMod->VERIF_MISE_FORMATION_SIGNE($conn, $numeroActe);
                        break;
                    case 'FIN_DE_FORMATION':
                        $liste = $signatureMod->VERIF_FIN_FORMATION_SIGNE($conn, $numeroActe);
                        break;
                    case 'COMMUNIQUE':
                        $liste = $signatureMod->VERIF_COMMUNIQUE_SIGNE($conn, $numeroActe);
                        break;
                    case 'ADMISSION':
                    case 'ARRETE_ADMISSION':
                        $liste = $signatureMod->VERIF_ARRETE_ADMISSION_SIGNE($conn, $numeroActe);
                        break;
                    case 'PRET_BANCAIRE':
                        $liste = $signatureMod->VERIF_PRET_BANCAIR_SIGNE($conn, $numeroActe);
                        break;
                    case 'ARSA':
                    case 'RGS':
                        $liste = $signatureMod->VERIF_ARSA_SIGNE($conn, $numeroActe);
                        break;
                    case 'ATTESTATION_PRIME':
                        $liste = $signatureMod->VERIF_ATT_PRIME_SIGNE($conn, $numeroActe);
                        break;
                    case 'DOMICILIATION_PRIME':
                        $liste = $signatureMod->VERIF_DOM_PRIME_SIGNE($conn, $numeroActe);
                        break;
                }

if (isset($liste) && $liste !== []) { $status = 'ok'; }

                // Affectation directe des données de la requête SQL Oracle
                if (!empty($liste) && is_array($liste) && isset($liste[0])) {
                   // $status = 'ok';
                    $detailsActe = $liste[0];

                    if (!empty($detailsActe['TITRE']) && $detailsActe['TITRE'] !== 'NULL') {
                        $typeActe = $detailsActe['TITRE'];
                    } elseif (!empty($detailsActe['NATURE_ACTE_LIB']) && $detailsActe['NATURE_ACTE_LIB'] !== 'NULL') {
                        $typeActe = $detailsActe['NATURE_ACTE_LIB'];
                    }

                    if (!empty($detailsActe['GL_ACTE_DATESIGN']) && $detailsActe['GL_ACTE_DATESIGN'] !== 'NULL') {
                        $dateSignature = $detailsActe['GL_ACTE_DATESIGN'];
                    } elseif (!empty($detailsActe['DATE_SIGNATURE']) && $detailsActe['DATE_SIGNATURE'] !== 'NULL') {
                        $dateSignature = $detailsActe['DATE_SIGNATURE'];
                    } else {
                        $dateSignature = '-';
                    }
                }

            } catch (\Throwable $eDb) {
                // Si erreur de connexion BD, se fier au fichier physique
            }
        }
    } catch (\Throwable $e) {
        $status = 'notfound';
    }

    return view('verification', compact(
        'status',
        'nomOriginal',
        'numeroActe',
        'typeActe',
        'prefix',
        'dateVerification',
        'dateSignature',
        'downloadUrl',
        'detailsActe'
    ));
}







public function viewDocumentFile(string $filename): \Symfony\Component\HttpFoundation\BinaryFileResponse
{
    $safeName = basename($filename);
    $filePath = public_path('DOSSIER_SAVE/ACTESIGNE_TEST/' . $safeName);

    if (!file_exists($filePath)) {
        abort(404, "Le document {$safeName} est introuvable.");
    }

    return response()->file($filePath, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $safeName . '"',
    ]);
}


}
