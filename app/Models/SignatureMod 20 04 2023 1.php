<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Return_;

class SignatureMod extends Model
{


    
    use HasFactory;

    protected $fillable = ['matricule'];

    public function USERFONCTION($matricule, $password){
      
        $sql ="SELECT FN_SE_USERFONCTION('".$matricule."') FROM DUAL";
        $stm = $password->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_USERFONCTION('".$matricule."')"];
        return $data;
        
    }


    public function FN_SE_USER_INFO($matricule, $password){

        $sql ="SELECT FN_SE_USER_INFO('".$matricule."') FROM DUAL";
        $stm = $password->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_USER_INFO('".$matricule."')"];
        $data = explode("|", $data); 
        $data = ['NOM_PRENOMS'=>$data[0],'EMAIL'=>$data[1] ,  'FONCTION'=>$data[2],'TELEPHONE'=>$data[3]];
      // var_dump($data); die;
        return $data;

        
    }


//**************************CODIFICATION DES DOCUMENTS ******************************/
//NBRE_MF : Décision de mise en formation :  MISE_EN_FORMATION_Numero_acte.PDF
//NBRE_FF : Décision de fin de formation : FIN_DE_FORMATION_Numero_acte.PDF
//NBRE_ARR_ADM : Arrêté d'admission : ADMISSION_Numero_acte.PDF
//NBRE_COMM : Communiqué d'admission : COMMUNIQUE_Numero_acte.PDF

    public function FN_SE_GET_NBRE_INSTANCE($matricule, $password){
      
        $sql ="SELECT FN_SE_GET_NBRE_INSTANCE('".$matricule."') FROM DUAL";
        $stm = $password->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_GET_NBRE_INSTANCE('".$matricule."')"];
        $data = explode("|", $data); 
        $data = ['NBRE_COMM'=>$data[0],'NBRE_ARR_ADM'=>$data[1] ,'NBRE_MF'=>$data[2] ,'NBRE_FF'=>$data[3]];
       // var_dump($data); die;
        return $data;

 
    }

    public function USERNAME($matricule, $password){

        $sql ="SELECT FN_SE_USERNAME('".$matricule."') FROM DUAL";
        $stm = $password->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_USERNAME('".$matricule."')"];
        return $data;
    }

    public function USERMAIL($matricule, $password){

        $sql ="SELECT FN_SE_USERMAIL('".$matricule."') FROM DUAL";
        $stm = $password->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_USERMAIL('".$matricule."')"];
        return $data;
    }

    //

    public function USERTEL($matricule, $password){

        $sql ="SELECT FN_SE_USERTEL('".$matricule."') FROM DUAL";
        $stm = $password->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_USERTEL('".$matricule."')"];
        return $data;
    }

    

    public function NOMIN_INST_MIN($conn){

        $sql ="SELECT FN_SE_NBRE_NOMIN_INST_MIN FROM DUAL";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_NBRE_NOMIN_INST_MIN"];
        return $data;
    }

    public function PROM_INST_MIN($conn){

        $sql ="SELECT FN_SE_NBRE_PROM_INST_MIN FROM DUAL";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_NBRE_PROM_INST_MIN"];
        return $data;
    }

    public function NOMIN_SIGNE_MIN($conn){

        $sql ="SELECT FN_SE_NBRE_NOMIN_SIGNE_MIN FROM DUAL";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_NBRE_NOMIN_SIGNE_MIN"];
        return $data;
    }

    public function PROM_SIGNE_MIN($conn){

        $sql ="SELECT FN_SE_NBRE_PROM_SIGNE_MIN FROM DUAL";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas[0]["FN_SE_NBRE_PROM_SIGNE_MIN"];
        return $data;
    }

    //FONCTION A REGARDER
     public function PR_SE_MAJ_NOTIF_MIN_COLL($conn,$id_acte, $acte_name, $usermin, $id_workflow, $statut_workflow){


 
   $sql = "begin PR_SE_MAJ_NOTIF_MIN_COLL(:P_ACTE_ID, :P_ACTE_NAME, :P_USERMIN, :P_ID_WORKFLOW, :P_STATUS); end;";
    try {
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(':P_ACTE_ID', $id_acte);
    $stmt->bindParam(':P_ACTE_NAME', $acte_name);
    $stmt->bindParam(':P_USERMIN', $usermin);
    $stmt->bindParam(':P_ID_WORKFLOW', $id_workflow);
    $stmt->bindParam(':P_STATUS', $statut_workflow);
  
    $result = $stmt->execute();

  
} catch (\Throwable $th) {
    echo $th;

}

}

// fonction procedurale



 //FONCTION A REGARDER
 public function PR_SE_SIGN_MIN_COLL($conn,$numacte, $SYSTEM_MACHINE , $SYSTEM_USER ){





    $sql = "BEGIN PR_SE_SIGN_MIN_COLL(:P_GL_ACTE_NUM , :SYSTEM_MACHINE, :SYSTEM_USER); END;";
    try {
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(':P_GL_ACTE_NUM', $numacte);
    $stmt->bindParam(':SYSTEM_MACHINE', $SYSTEM_MACHINE);
    $stmt->bindParam(':SYSTEM_USER', $SYSTEM_USER);
  
    $result = $stmt->execute();


    //var_dump($result); die;
} catch (\Throwable $th) {
    echo $th;

}


}




public function SELECT($conn,$idacte ){


    $sql1 = "SELECT *   FROM TBGL_ACTE WHERE GL_ACTE_ETAT ='00010' AND GL_ACTE_DATESIGN LIKE '%04/23'
    left join TBGL_DOSSIER ON ACTE_ID";
   // $sql1 = "SELECT DISTINCT GL_ACTE_ETAT  FROM TBGL_ACTE  ";
   // $sql1 = "SELECT * FROM TBPA_SE_NOTIFICATION    ";
   //$sql1 = "SELECT * FROM TBGL_DOSSIER ";
    $stmt = $conn->prepare($sql1); 
    $result = $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Afficher tous les éléments de la table
    foreach ($rows as $row) {
        print_r($row);

    }




}





/*
$sql1 = "SELECT * FROM TBPA_SE_NOTIFICATION WHERE ID_WORKFLOW = 'wfl_J4n8BjuiLBBpzWHwu5QiAVFd'";
$stmt = $conn->prepare($sql1); 
$result = $stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher tous les éléments de la table
foreach ($rows as $row) {
    print_r($row);
}

*/






   // var_dump($result);
   // die();
      // var_dump($result.' '.$id_acte.'/ '. $acte_name.' / '. $usermin.' / '. $id_workflow.' / '. $statut_workflow);
       // die;

  
//******************************************************************* */









//************************************************************************ */

    //LISTE DES NOMINATIONS ET PROMOTIONS EN INSTANCE DE SIGNATURE MINISTRE
    public function LISTE_ACTES_INST($conn){

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        DECODE(TBPA_NATACTE.PA_NATACTE_LIB,'ADMISSION','ARRETE D''ADMISSION',TBPA_NATACTE.PA_NATACTE_LIB) AS NATURE_ACTE_LIB,
        TBGL_DOSSIER.GL_DOSSIER_TYPECONC AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBPA_RCANDCONC,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBPA_RCANDCONC.FC_CAND_NUM
        AND TBGL_DOSSIER.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_TYPECONC=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00031'
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0048','A0044','A0078','A0076')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY DATE_VALIDATION_DIRCAB DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

        

    }




     



    //**************************************************************************
    //*********************** SIGNATURE AVEC YASSI//****************************
    //**************************************************************************


    //creer parapheur
    public function call_ws($nomparapheur, $mailcreator, $mailsign)
    {
    define ('SUNNYSTAMP_API_URI', 'https://sigfae-test.artci-sign.ci/api/');
    define ('BEARER_API', 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU');
    define ('COPID_API', 'cop_7pFnUCqhVfj7hgtWLmieBL9q');

    
    #RECUPERATION DE l'ID du createur
    $curluser = curl_init();

    curl_setopt_array($curluser, array(
    CURLOPT_URL => SUNNYSTAMP_API_URI.'users?items.email='.$mailcreator ,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.BEARER_API
    ),
    ));

    $responseuser = curl_exec($curluser);

    $datauser = json_decode(curl_exec($curluser), true);
    $creatorid = $datauser['items'][0]['id'];
    //echo $creatorid;

    curl_close($curluser);


    #RECUPERATION DE l'ID du SIGNATEUR
    $curlsign = curl_init();

    curl_setopt_array($curlsign, array(
    CURLOPT_URL => SUNNYSTAMP_API_URI.'users?items.email='.$mailsign,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.BEARER_API
    ),
    ));

    $responssign = curl_exec($curlsign);

    $datasign = json_decode(curl_exec($curlsign), true);
    $signid = $datasign['items'][0]['id'];

    curl_close($curlsign);
    //echo $responssign;


    #CREATION DU WORKFLOW
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => SUNNYSTAMP_API_URI.'users/'.$creatorid.'/workflows',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "name" : "'.$nomparapheur.'" ,
    "steps" : [ { 
        "stepType" : "signature",
        "recipients" : [ {
        "consentPageId" : "'.COPID_API.'",
        "email" : "'.$mailsign.'",
        "userId" : "'.$signid.'"
        } ]
    }]
    }
    ',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.BEARER_API,
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $data = json_decode($response, true);

    //echo $response;
    $wkflowid = $data['id'];


    #CREER LE REFERENCEMENT DU DOCUMENT DANS WORKFLOW MANAGER
    $curlpart = curl_init();

    $uploadFile= 'Accordautorisationemp_7_16032021.pdf';
    $filePath = getcwd()."/".$uploadFile;
    //echo $filePath;


    curl_setopt_array($curlpart, array(

    CURLOPT_URL => SUNNYSTAMP_API_URI.'workflows/'.$wkflowid.'/parts',

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_POST => true,

    CURLOPT_POSTFIELDS => array('pdf' => curl_file_create($filePath, mime_content_type($filePath), basename($filePath))),

    CURLOPT_HTTPHEADER => array(

        'Authorization: '.BEARER_API

    ),

    ));

    $responsepart = curl_exec($curlpart);

    curl_close($curlpart);
    //echo $responsepart;

    $datapart = json_decode($responsepart, true);
    curl_close($curlpart);


    $partname = $datapart['parts'][0]['filename'];
    $parttype = $datapart['parts'][0]['contentType'];
    $partsize = $datapart['parts'][0]['size'];
    $parthash = $datapart['parts'][0]['hash'];

    //echo $responsepart;


    #LIER LE DOCUMENT AU WORKFLOW
    $curldoc = curl_init();

    curl_setopt_array($curldoc, array(
    CURLOPT_URL => SUNNYSTAMP_API_URI.'workflows/'.$wkflowid.'/documents',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS =>'{
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
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.BEARER_API,
        'Content-Type: application/json'
    ),
    ));

    $responsedoc = curl_exec($curldoc);
    $datadoc = json_decode($responsedoc, true);
    curl_close($curldoc);
    //echo $responsedoc;


    #LANCER LE PARAPHEUR
    $curlupdwkl = curl_init();

    curl_setopt_array($curlupdwkl, array(
    CURLOPT_URL => SUNNYSTAMP_API_URI.'workflows/'.$wkflowid.'',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PATCH',
    CURLOPT_POSTFIELDS =>'{
    "workflowStatus" : "started"
    }

    ',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.BEARER_API,
        'Content-Type: application/json'
    ),
    ));

    $responseupdwkl = curl_exec($curlupdwkl);

    curl_close($curlupdwkl);
    $dataupdwkl = json_decode($responseupdwkl, true);
    //echo $responseupdwkl;



    #LANCER L'INVITATION A SIGNER
    $curlinvit = curl_init();

    curl_setopt_array($curlinvit, array(
    CURLOPT_URL => SUNNYSTAMP_API_URI.'workflows/'.$wkflowid.'/invite',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "recipientEmail" : "'.$mailsign.'"
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.BEARER_API,
        'Content-Type: application/json'
    ),
    ));

    $responsinvit = curl_exec($curlinvit);

    curl_close($curlinvit);
    $datainvit = json_decode($responsinvit, true);
    //echo $responsinvit;

    $urlsign = $datainvit['inviteUrl'];
    return $urlsign;
    }




    //************************************************************ */
    public function getSignateur( $mail, $FilePath){
 
    }


}
