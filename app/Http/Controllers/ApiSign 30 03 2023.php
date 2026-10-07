<?php

namespace App\Http\Controllers;

use App\Models\SignatureMod;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Http;

class ApiSign extends Controller
{



  public function apiSign(){  }  
   
 
  public function getSignateur( $mail, $FilePath){
    



    $mail = 'so.cisse@fonctionpublique.gouv.ci';
    //$FilePath= 'ADMISSION_0442342524.PDF';
    $FilePath= 'testPDFJava.pdf';
    //$FilePathPosition= $_SERVER['DOCUMENT_ROOT']."/signature/ADMISSION_0442342524.PDF";
    $FilePathPosition= $_SERVER['DOCUMENT_ROOT']."/storage/java/testPDFJava.pdf";
    //var_dump($FilePathPosition,$_SERVER['DOCUMENT_ROOT'], file_exists($FilePathPosition)); die;
    $respo= $this->positionxy($FilePathPosition);
	var_dump($respo); die;
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
                "imageX" : 390.0,
                "imageY" : 700.0,
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





    // vue du tableau contenant tous les demandes des mutualistes chez l'assistante sociale
    public function getSignateur1(Request $request)
    
    {

       


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
                    "imageX" : 390.0,
                    "imageY" : 700.0,
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





    private function positionxy($files){
      //$configfile = asset('../storage/java/getXY.jar');
      $configfile = "/storage/java/getXY.jar";
      //var_dump($_SERVER['DOCUMENT_ROOT']."/".$configfile); 
      $bonfile = $_SERVER['DOCUMENT_ROOT']."/".$configfile;
      //var_dump(file_exists($bonfile)); die;
      $rest = exec('/opt/java/jdk17/bin/java -jar'.$bonfile.' '.$files, $response); 
      var_dump($rest,$response); die;
      $XY = explode("_", $response[0]);
      
      $geo = array('X'=> $XY[0], 'Y' => $XY[1] );

      return $geo;
  }






}
