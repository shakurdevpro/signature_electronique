<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;
use Ixudra\Curl\Facades\Curl;


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


    //LISTE DES NOMINATIONS ET PROMOTIONS EN INSTANCE DE SIGNATURE MINISTRE
    public function LISTE_ACTES_INST($conn){

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        TBGL_DOSSIER.GL_DOSSIER_TYPECONC AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
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
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('recipeintFinished','workflowFinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
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

    }






}
