<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

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

        $sql ="SELECT TBGL_DOSSIER.CE_AGT_MAT AS MAT,DECODE(PA_CIVILITE_CODE,'2',CE_AGT_NOM||' NEE '||CE_AGT_NOMJFIL,CE_AGT_NOM||' '||CE_AGT_PREN) AS NOMPREN,PA_NATACTE_LIB AS ACTE,PA_MSGETAT_LIB AS ETAT,GL_ACTE_NUM AS NUM,TBPA_SE_NOTIFICATION.GL_ACTE_ID AS IDACTE,TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOMACTE
        FROM TBGL_ACTE,TBPA_NATACTE,TBGL_DOSSIER,TBCE_AGT,TBGL_RDETBORD,TBPA_MSGETAT,TBPA_STRUCT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.GL_ACTE_ID=TBGL_RDETBORD.GL_ACTE_ID
        AND TBGL_RDETBORD.GL_DOSSIER_NUM=TBGL_DOSSIER.GL_DOSSIER_NUM
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
         AND TBCE_AGT.CE_AGT_STRUCT=TBPA_STRUCT.PA_STRUCT_COD
        AND GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0007','A0010')
        AND TBPA_STRUCT.PA_STRUCT_COD='S0019'
        AND GL_ACTE_USERCF IS NOT NULL
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND TBPA_SE_NOTIFICATION.STATUS IS NOT NULL
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TO_NUMBER(TO_CHAR(GL_ACTE_DATESAISIE,'YYYYMMDD'))>20210401
        ORDER BY 3,2";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }




}
