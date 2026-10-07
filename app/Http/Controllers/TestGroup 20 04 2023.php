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
use ZipArchive;
class TestGroup extends Controller
{
  





    
    // Dans votre contrôleur Laravel
public function groupe($request)
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
    






    
    $elementsCoche = explode('@@', $request);
    $i = 1;
    foreach ($elementsCoche as $element) {
        

        //var_dump($request->numact); die;
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
   
 session()->put(['WORKFLOW'=>$id_workflow]);

   return $invitation;
}





public function quittergroupe(Request $request) {

    $lesvaleursid  = $request->lesvaleursid;
    $lesvaleursnum  = $request->lesvaleursnum;
    $lesvaleursnom  = $request->lesvaleursnom;
    $usermin = $request->P_USERMIN;

    $elementsCoche = explode('@@', $lesvaleursid);

    $elementsCoche1 = explode('@@', $lesvaleursnum);

    $elementsCoche2 = explode('@@', $lesvaleursnom);
    $i = 0;

    //var_dump($elementsCoche ) ; die;

        for ($i=0; $i < count($elementsCoche); $i++) { 

            $idacte = $elementsCoche[$i];
            $numacte = $elementsCoche1[$i];
           // $nomacte = $elementsCoche2[$i];

           // var_dump($idacte.' / '.$numacte.' / '.$nomacte ); die;

            //TESTER LE STATUT SIGNE DU DOCUMENT
            $id_workflow = session()->get('WORKFLOW');
            $nom = $elementsCoche2[$i];
            $doc = $nom.'.PDF';



            $wehbook = "wbh_4ZJP78j8ohr9kjwjuFjoB8Km";
            $statuswork = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
            ->get('https://sigfae-test.artci-sign.ci/api/webhookEvents/?webhookEventId='.$wehbook.'&items.workflowId='.$id_workflow); 
              
             $etat = $statuswork['items'][0]['eventType'];




              
              
             

             if ($etat == 'recipientFinished'  OR $etat == 'workflowFinished' ){
    

                if($i==1){
 
                #######################################################################################################
                // LE DOUMENT A TELECHARGER
                     $document = Http::withToken('act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU')
                     ->get('https://sigfae-test.artci-sign.ci/api/workflows/'.$id_workflow.'/downloadDocuments');
                
                
                #######################################################################################################
                $dossierzip = "actegrouper.rar";
                // TELECHARGEMENT DU DOUMENT
                $document_tel= 'ficheTemp/'.$dossierzip;	 	
                $handle = fopen($document_tel, "w");
                fwrite($handle, $document);
                fclose($handle);
                //deziper
                $archive = new ZipArchive;
                if ($archive->open($document_tel) === TRUE) {
                $archive->extractTo('\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/ACTESIGNE/');
                $archive->close();
                    } else {
                        echo 'Échec de la décompression du fichier !'; die;
                    }
                
            }
                #######################################################################################################
                // FAIT UN UPDATE SUR LA TABLE
                
              
                  //CONNEXION ET UPDATE SUR LA TABLE
                  defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
                  (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

                    $info      = session()->get('INFORMATION');
                    $loginuser = $info['LOGINUSER'];


                    $pwduser   = $info['PWDUSER'];
                    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
                  
                    //UTILISATION DE LA FONCTION UPDATE
                    $SignatureMod    = new SignatureMod();
                    $nom_ministre = 'nom du ministre';
                    $FN_SE_USER_INFO =  $SignatureMod->PR_SE_MAJ_NOTIF_MIN_COLL($this->oracle, $idacte, $nom, $loginuser, $id_workflow, 'WORKFLOWFINISHED');

                  // Obtenir l'adresse IP de la machine
                  $SYSTEM_USER  = get_current_user();

                  //$idae = "1";
                  // Obtenir le nom d'utilisateur de la machine
                  $SYSTEM_MACHINE  = gethostname();

                  $FN_SE_MSJ_INFO =  $SignatureMod->PR_SE_SIGN_MIN_COLL($this->oracle, $numacte, $SYSTEM_MACHINE, $SYSTEM_USER);

                  //var_dump( 'ACTE:'.$numacte .' GL_ACTE_SYSTEME : '.$SYSTEM_MACHINE.' / GL_ACTE_USER_SYSTEME '.$SYSTEM_USER);
                  //die;
                
                
                
                
                
                     }
                
                    
      



        }

        $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
        $NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
        $NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
        $NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
        $NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
        $stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];


        $LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle);


          $request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
          $request->session()->put('STAT', $stat);


        return redirect('/accueil');

    }

}



