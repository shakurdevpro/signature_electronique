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


//use phpseclib\Net\SFTP;


class ApiSign extends Controller
{



  public function apiSign($doc){ 

//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
    $source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A SIGNER/'.$doc;
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
$nom = $doc;
$doc = $doc.'.PDF';

//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
$source= '/mnt/DATEDRV/'.$doc;
echo $source; 
if(file_exists($source)) {
  echo "ok";
} else {
  echo "no";
}
// die;
// Définir le chemin de destination pour le fichier
$destination = 'ficheTemp/DOCTEMP.PDF';

// Définir le nom de fichier à utiliser
// File::copy($source,  $destination);

/***
 * 
 * DEBUT COPY FILE AMANI
 */
  //   (file_exists)
  // $file = fopen($source, 'r');
  // if($file) {
  //   return "ok";
  // } else {
  //   return "not ok";
  // }

 /**
  *  FIN COPY FILE AMANI
  * 
  */




    
    }





###########################################################################################################################
###########################################################################################################################
###########################################################################################################################
###########################################################################################################################


    public function quitter(Request $request) {

      //RECUPERER LES VALEURS DU FORMULAIRE QUITTER
      $idacte  = $request->P_ACTE_ID;
      $usermin = $request->P_USERMIN;
      

    
      //TESTER LE STATUT SIGNE DU DOCUMENT
      $id_workflow = session()->get('WORKFLOW');
      $doc = session()->get('DOCUMENT');
      $nom = session()->get('NOM');

      
      $wehbook = "wbh_4ZJP78j8ohr9kjwjuFjoB8Km";
      $statuswork = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
      ->get('https://sigfae-test.artci-sign.ci/api/webhookEvents/?webhookEventId='.$wehbook.'&items.workflowId='.$id_workflow); 
        
     $etat = $statuswork['items'][0]['eventType'];

 

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

      $info      = session()->get('INFORMATION');
      $loginuser = $info['LOGINUSER'];

    
      $pwduser   = $info['PWDUSER'];
      $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
     
      //UTILISATION DE LA FONCTION UPDATE
      $SignatureMod    = new SignatureMod();
       $nom_ministre = utf8_decode($usermin);
     $FN_SE_USER_INFO =  $SignatureMod->PR_SE_MAJ_NOTIF_MIN_COLL($this->oracle, $idacte, $nom, $loginuser, $id_workflow, 'WORKFLOWFINISHED');

   // Obtenir l'adresse IP de la machine
   $ip = "1";
   $idae = "1";
   // Obtenir le nom d'utilisateur de la machine
   $username = '1';
 
   
    $FN_SE_MSJ_INFO =  $SignatureMod->FN_SE_SIGN_MIN_COLL($this->oracle, $idae, $ip, $username);







    //if ($etat == 'workflowFinished'){
    if ($etat == 'recipientFinished'  OR $etat == 'workflowFinished' ){
    
 
#######################################################################################################
// LE DOUMENT A TELECHARGER
     $document = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
     ->get('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/downloadDocuments');


#######################################################################################################
// TELECHARGEMENT DU DOUMENT
$document_tel= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/ACTESIGNE/'.$doc;	 	
$handle = fopen($document_tel, "w");
fwrite($handle, $document);
fclose($handle);


#######################################################################################################
// FAIT UN UPDATE SUR LA TABLE

 

    





     }

     return redirect('/accueil');
       
  }



###########################################################################################################################
###########################################################################################################################
###########################################################################################################################
###########################################################################################################################

//***************************************RECUPERATION DES COORDONNEE X Y*********************************************** */

private function positionxy($files=NULL){
 $cmd1 = 'java -jar java\getXY.jar "C:\xampp\htdocs\SIGNATURE\1\test\public\ficheTemp\DOCTEMP.PDF"';
 $coordonnee = shell_exec($cmd1);
return $coordonnee;      
}


###########################################################################################################################
###########################################################################################################################
###########################################################################################################################
###########################################################################################################################


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
                    "imageWidth" : 150.0,
                    "imageHeight" : 80.0
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











}
