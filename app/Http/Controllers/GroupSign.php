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
use PDO;
use Session;

class GroupSign extends Controller
{
    

    // Dans votre contrôleur Laravel
public function grouper(Request $request)
{

    $mail='so.cisse@fonctionpublique.gouv.ci';
    $http = new \GuzzleHttp\Client();
     

    //RECUPERATION DE LID DE LUTILISATEUR AVEC LE MAIL EN PARAMETRE
     $user =$http->request('GET','https://sigfae-test.artci-sign.ci/api/users?items.email='.$mail,
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
    

    // Récupérer les éléments cochés
    $elementsCoche = $request->input('elements');

    // Si les éléments cochés sont présents dans la requête, affichez-les
    if ($elementsCoche) {
        $i = 1;
        foreach ($elementsCoche as $element) {


        $doc = $element;

        //JOINDRE LE FICHIER

        $nom = $doc;
        $doc = $doc.'.PDF';

        //***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
        $source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A SIGNER/'.$doc;
        // Définir le chemin de destination pour le fichier
        $destination = 'ficheTemp/DOCTEMP'.$i.'.PDF';

        File::copy($source,  $destination);
        //*****************************RECUPER LA POSITION***************************************** */
        $cmd1 = 'java -jar java\getXY.jar "C:\xampp\htdocs\SIGNATURE\1\test\public\ficheTemp\DOCTEMP'.$i.'.PDF"';
        $coordonnee = shell_exec($cmd1);
        //***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
       // $coordonnee = $this->positionxy();
        $xy = explode("_", $coordonnee);
        $x = $xy[0];
        $y = $xy[1];
        //************************************************************************** */
        $FilePath= $destination;

        $result_response = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
        ->attach('attachment', file_get_contents($FilePath, 'application/pdf'))
        //->contentType('application/pdf')
        ->withHeaders([
            'contentType' => 'application/pdf',
        ]) 
        ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/parts');

        //****************************************************************** */
        $partname = $doc;
        $parttype = 'application/pdf';
        $partsize = $result_response['parts'][0]['size'];
        $parthash = $result_response['parts'][0]['hash'];

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
            "imageWidth" : 150.0,
            "imageHeight" : 80.0
          } ]
        }')
        ->post('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/documents');


            
            





        $i++;
        }
    } else {
        echo 'Aucun élément n\'a été cochée';
    }

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

    return $invitation;
}




//***************************************RECUPERATION DES COORDONNEE X Y*********************************************** */

private function positionxy($files=NULL){
    $cmd1 = 'java -jar java\getXY.jar "C:\xampp\htdocs\SIGNATURE\1\test\public\ficheTemp\DOCTEMP.PDF"';
    $coordonnee = shell_exec($cmd1);
   return $coordonnee;      
   }


}
