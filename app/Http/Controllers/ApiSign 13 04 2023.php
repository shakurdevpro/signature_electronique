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


//use phpseclib\Net\SFTP;

class ApiSign extends Controller
{




  public function apiSign($doc){ 
//$sftp = new SFTP('192.168.6.12');
//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
    $source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A SIGNER/'.$doc;
    // Définir le chemin de destination pour le fichier
    $destination = $doc;
    // Définir le nom de fichier à utiliser
   File::copy($source,  $destination);
//$sftp->get($source, $destination)
//************************************************************************** */

   }  
   
 

  //public function getSignateur(Request $request,  $mail, $doc){

  public function getSignateur( $mail, $doc){
    
//$sftp() = new SFTP('192.168.6.12');


//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
$source= "https://192.168.6.12/sigfae_test/DOSSIER_SAVE/A SIGNER/".$doc;
// Définir le chemin de destination pour le fichier
$destination = 'ficheTemp/DOCTEMP.PDF';
// Définir le nom de fichier à utiliser
//$sftp->get($source, $destination)
Storage::copy($source,  $destination);
//File::copy($source,  $destination);
//************************************************************************** */

//***************************RECUPERRER COORDONNES DE LA SIGNATURE****************************** */
$coordonnee = $this->positionxy();
$xy = explode("_", $coordonnee);
$x = 55;
$y = 55;
//************************************************************************** */

 




    //$FilePath= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A SIGNER/'.$doc;
      $FilePath= 'ficheTemp/DOCTEMP.PDF';
    
    
   /* dd($FilePath); die;*/

    $mail = 'so.cisse@fonctionpublique.gouv.ci';
    //$FilePath= 'ADMISSION_0442342524.PDF';
    $FilePathPosition= $_SERVER['DOCUMENT_ROOT']."/SIGNATURE/1/test/public/ADMISSION_0442342524.PDF";
    //dd(file_exists($FilePathPosition));
   // return $this->positionxy($FilePathPosition);
   // phpinfo(); die;
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

            //JOINDRE UN FICHIER
           
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

            
            //****************************************************************** */
            $partname = $doc;
            $parttype = 'application/pdf';
            //****************************************************************** */
            //$partname = $result_response['parts'][0]['filename'];
            //$parttype = $result_response['parts'][0]['contentType'];
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

           return $invitation;




    
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
  
    echo 'Coordonné X = '.$x; // x
    echo 'Coordonné Y = '.$y; // y
die;

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

               return $invitation;
    }













}
