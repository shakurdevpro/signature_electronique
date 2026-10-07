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
        $data = ['NBRE_COMM'=>$data[0],'NBRE_ARR_ADM'=>$data[1] ,'NBRE_MF'=>$data[2] ,'NBRE_FF'=>$data[3],'NBRE_AP'=>$data[4],'NBRE_DP'=>$data[5],'NBRE_PB'=>$data[6],'NBRE_RGS'=>$data[7],'NBRE_ARSA'=>$data[8],'NBRE_COMM_OUVR'=>$data[9],'NBRE_ARR_OUVR'=>$data[10]];
        //var_dump($data); die;
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




///////////////////////////////////////////////////////////////////////////////////////////////////////
    //NOMBRE DE DOCUMENT
   




       
        



        public function FN_REPORT_SIGN_NUM($conn, $p_etat, $p_date_debut, $p_date_fin) {

            $sql ="SELECT FN_REPORT_SIGN_NUM(:P_ETAT, :P_DATE_DEBUT, :P_DATE_FIN) FROM DUAL";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':P_ETAT', $p_etat);
            $stm->bindParam(':P_DATE_DEBUT', $p_date_debut);
            $stm->bindParam(':P_DATE_FIN', $p_date_fin);
            $stm->execute();
            $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
            $data = $datas[0]["FN_REPORT_SIGN_NUM"];
            var_dump($data); die;
            return $data;
        }



    

        public function FN_REPORT_SIGN_NUM1($conn, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN)
{
    $sql = "SELECT FN_REPORT_SIGN_NUM(:P_ETAT, :P_DATE_DEBUT, :P_DATE_FIN) AS RESULT FROM DUAL";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':P_ETAT', $P_ETAT);
    $stm->bindParam(':P_DATE_DEBUT', $P_DATE_DEBUT);
    $stm->bindParam(':P_DATE_FIN', $P_DATE_FIN);
    $stm->execute();
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = $datas[0]["RESULT"];
   // var_dump($data); die;
    return $data;
}






        public function FN_REPORT_SIGN_NUM_NEW($conn, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN)
{
    $sql = "SELECT FN_REPORT_SIGN_NUM_NEW(:P_ETAT, :P_DATE_DEBUT, :P_DATE_FIN) AS RESULT FROM DUAL";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':P_ETAT', $P_ETAT);
    $stm->bindParam(':P_DATE_DEBUT', $P_DATE_DEBUT);
    $stm->bindParam(':P_DATE_FIN', $P_DATE_FIN);
    $stm->execute();
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = $datas[0]["RESULT"];
   // var_dump($data); die;
    return $data;
}


////////////////////////////////////////////////////////////////////////////////////////////////











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





public function UPDATE_TBGL_ACTE_00084($conn, $numActe)
{
    $sql = "
            UPDATE TBGL_ACTE 
            SET GL_ACTE_ETAT='00084'
            WHERE GL_ACTE_NUM  = :numacte
          ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numacte', $numActe);

    $stm->execute();

    return $stm->rowCount();
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






///######################################################## MODEL API MUGEFCI ########################################################
///######################################################## MODEL API MUGEFCI ########################################################


public function LISTE_MUGEFCI($conn, $page = 1, $limit = 500)
{
    $offset = ($page - 1) * $limit;
    $startRow = $offset; // Début de la plage
    $endRow = $offset + $limit; // Fin de la plage

    // Construire une requête SQL paginée
    $sql = "
        SELECT * FROM (
            SELECT a.*, ROWNUM rnum 
            FROM (
                SELECT * FROM VW_MUGEFCI_INFO_AGENT
                ORDER BY MATRICULE -- Remplacez 'ID' par la colonne de tri pertinente
            ) a
            WHERE ROWNUM <= :endRow
        )
        WHERE rnum > :startRow
    ";

    $stmt = oci_parse($conn, $sql);

    // Lier les variables à leurs placeholders respectifs
    oci_bind_by_name($stmt, ':startRow', $startRow);
    oci_bind_by_name($stmt, ':endRow', $endRow);

    // Exécuter la requête
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}




//****************************** VW_MUGEFCI_CARRIERE ******************************************



public function LISTE_CARRIERE($conn, $matricule_agent = null, $date_debut = null, $date_fin = null) 
{
    $conditions = [];
    $params = [];

    // Ajout de conditions dynamiques
    if (!empty($matricule_agent)) {
        $conditions[] = "MATRICULE = :matricule_agent";
        $params[':matricule_agent'] = $matricule_agent;
    }
    if (!empty($date_debut) && !empty($date_fin)) {
        $conditions[] = "DATE_SIGNATURE_ACTE BETWEEN TO_DATE(:date_debut, 'DD-MON-RR') AND TO_DATE(:date_fin, 'DD-MON-RR')";
        $params[':date_debut'] = strtoupper(date('d-M-y', strtotime($date_debut)));
        $params[':date_fin'] = strtoupper(date('d-M-y', strtotime($date_fin)));
    }

    // Construire la requête SQL
    $sql = "SELECT * FROM VW_MUGEFCI_CARRIERE";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = oci_parse($conn, $sql);

    // Associer les paramètres
    foreach ($params as $key => $value) {
        oci_bind_by_name($stmt, $key, $params[$key]);
    }

    if (!oci_execute($stmt)) {
        $error = oci_error($stmt);
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt);
    return $data;
}


//****************************** VW_MUGEFCI_CIVILITE ******************************************



public function LISTE_CIVILITE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_CIVILITE";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}




//****************************** VW_MUGEFCI_CLASSE ******************************************



public function LISTE_CLASSE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_CLASSE";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_EMPLOI ******************************************



public function LISTE_EMPLOI($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_EMPLOI";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_ENFANT ******************************************



public function LISTE_ENFANT($conn, $matriculeParent) 
{
    // Ajout de la condition MATRICULE_PARENT
    $sql = "SELECT * FROM VW_MUGEFCI_ENFANT WHERE MATRICULE_PARENT = :matriculeParent ";
    $stmt = oci_parse($conn, $sql);

    // Liaison de la variable MATRICULE_PARENT
    oci_bind_by_name($stmt, ':matriculeParent', $matriculeParent);

    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_GRADE ******************************************



public function LISTE_GRADE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_GRADE ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_INFO_AGENT ******************************************



public function LISTE_INFO_AGENT($conn, $matricule_agent = null, $date_debut_service = null, $date_fin_service = null, $date_debut_retraite = null, $date_fin_retraite = null, $date_debut_deces = null, $date_fin_deces = null) 
{
    $conditions = [];
    $params = [];

    // Ajouter la condition pour MATRICULE_AGENT si spécifié
    if (!empty($matricule_agent)) {
        $conditions[] = "MATRICULE = :matricule_agent";
        $params[':matricule_agent'] = $matricule_agent;
    }

    // Ajouter les intervalles de dates pour DATE_PPSERVICE
    if (!empty($date_debut_service) && !empty($date_fin_service)) {
        $conditions[] = "DATE_PPSERVICE BETWEEN TO_DATE(:date_debut_service, 'YYYY-MM-DD') AND TO_DATE(:date_fin_service, 'YYYY-MM-DD')";
        $params[':date_debut_service'] = $date_debut_service;
        $params[':date_fin_service'] = $date_fin_service;
    }

    // Ajouter les intervalles de dates pour DATE_DEP_RETRAITE
    if (!empty($date_debut_retraite) && !empty($date_fin_retraite)) {
        $conditions[] = "DATE_DEP_RETRAITE BETWEEN TO_DATE(:date_debut_retraite, 'YYYY-MM-DD') AND TO_DATE(:date_fin_retraite, 'YYYY-MM-DD')";
        $params[':date_debut_retraite'] = $date_debut_retraite;
        $params[':date_fin_retraite'] = $date_fin_retraite;
    }

    // Ajouter les intervalles de dates pour DATE_DECES
    if (!empty($date_debut_deces) && !empty($date_fin_deces)) {
        $conditions[] = "DATE_DECES BETWEEN TO_DATE(:date_debut_deces, 'YYYY-MM-DD') AND TO_DATE(:date_fin_deces, 'YYYY-MM-DD')";
        $params[':date_debut_deces'] = $date_debut_deces;
        $params[':date_fin_deces'] = $date_fin_deces;
    }

    // Vérifier qu'au moins une condition est spécifiée
    if (empty($conditions)) {
        throw new \Exception("Au moins une condition (matricule ou intervalle de dates) doit être spécifiée.");
    }

    // Construire la requête SQL
    $sql = "SELECT * FROM VW_MUGEFCI_INFO_AGENT WHERE " . implode(' AND ', $conditions) ;
    $stmt = oci_parse($conn, $sql);

    // Associer les paramètres
    foreach ($params as $key => $value) {
        oci_bind_by_name($stmt, $key, $params[$key]);
    }

    if (!oci_execute($stmt)) {
        $error = oci_error($stmt);
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt);
    return $data;
}







//****************************** VW_MUGEFCI_LISTE_AGENT ******************************************



public function LISTE_AGENT($conn, $aujourdhui)
{
    // Construire la requête SQL
    $sql = "
      SELECT * FROM (
            SELECT *
            FROM VW_MUGEFCI_INFO_AGENT
            WHERE DATE_RADIATION < TO_DATE(:aujourdhui, 'YYYY-MM-DD')
            ORDER BY DATE_RADIATION DESC
        )
        WHERE ROWNUM <= 10

    ";
//var_dump('ok'); die;
    $stmt = oci_parse($conn, $sql);

    // Bind du paramètre
    oci_bind_by_name($stmt, ':aujourdhui', $aujourdhui);

    if (!oci_execute($stmt)) {
        $error = oci_error($stmt);
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt);
    return $data;
}




//****************************** VW_MUGEFCI_MOTIF_POSITION ******************************************



public function LISTE_MOTIF_POSITION($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_MOTIF_POSITION ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}





//****************************** VW_MUGEFCI_MVT_AGT_EMP ******************************************



public function LISTE_MVT_AGT_EMP($conn, $matriculeAgent) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_MVT_AGT_EMP WHERE CE_AGT_MAT = :matriculeAgent ";
    $stmt = oci_parse($conn, $sql);
   
    // Liaison de la variable MATRICULE_PARENT
    oci_bind_by_name($stmt, ':matriculeAgent', $matriculeAgent);

    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}





//****************************** VW_MUGEFCI_MVT_AGT_STRUCT ******************************************



public function LISTE_MVT_AGT_STRUCT($conn, $matriculeAgent) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_MVT_AGT_STRUCT WHERE MATRICULE = :matriculeAgent";
    $stmt = oci_parse($conn, $sql);
    
    // Liaison de la variable MATRICULE_PARENT
    oci_bind_by_name($stmt, ':matriculeAgent', $matriculeAgent);

    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_NATURE_ACTE******************************************



public function LISTE_NATURE_ACTE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_NATURE_ACTE ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}




//****************************** VW_MUGEFCI_POSITION******************************************



public function LISTE_POSITION($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_POSITION ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_SIT_MATRI******************************************



public function LISTE_SIT_MATRI($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_SIT_MATRI ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_STATUT_JURIDIQUE******************************************



public function LISTE_STATUT_JURIDIQUE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_STATUT_JURIDIQUE ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_STRUCTURE******************************************



public function LISTE_STRUCTURE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_STRUCTURE ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}



//****************************** VW_MUGEFCI_TYPE_ACTE******************************************



public function LISTE_TYPE_ACTE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_TYPE_ACTE ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}




//****************************** VW_MUGEFCI_TYPE_AGENT******************************************



public function LISTE_TYPE_AGENT($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_TYPE_AGENT ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}





//****************************** VW_MUGEFCI_VILLE******************************************



public function LISTE_VILLE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_VILLE";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}






//****************************** VW_MUGEFCI_MVT_AGT_EMP ******************************************



public function MVT_AGT_EMP($conn) 
{
     $sql = "SELECT * FROM VW_MUGEFCI_MVT_AGT_EMP WHERE ROWNUM <= 80";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}





//****************************** VW_MUGEFCI_ECHELON******************************************



public function LISTE_ECHELON($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_ECHELON ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}





//****************************** VW_MUGEFCI_EMPGRADE******************************************



public function LISTE_EMPGRADE($conn) 
{
    $sql = "SELECT * FROM VW_MUGEFCI_EMPGRADE ";
    $stmt = oci_parse($conn, $sql);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}






//****************************** VW_MUGEFCI_POSITION_HISTO******************************************







public function LISTE_POSITION_HISTO($conn, $matriculeAgent) 
{
    // Ajout de la condition MATRICULE_PARENT
    $sql = "SELECT * FROM VW_MUGEFCI_POSITION_HISTO WHERE MATRICULE = :matriculeAgent ";
    $stmt = oci_parse($conn, $sql);

    // Liaison de la variable MATRICULE_PARENT
    oci_bind_by_name($stmt, ':matriculeAgent', $matriculeAgent);

    if (!oci_execute($stmt)) {
        $error = oci_error($stmt); // Récupérer les erreurs de la requête
        throw new \Exception('Erreur d’exécution : ' . $error['message']);
    }

    $data = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $data[] = $row;
    }

    oci_free_statement($stmt); // Libérer les ressources
    return $data;
}




///######################################################## MODEL API MUGEFCI ########################################################
///######################################################## MODEL API MUGEFCI ########################################################










//************************************************************************ */

    //LISTE DES NOMINATIONS ET PROMOTIONS EN INSTANCE DE SIGNATURE MINISTRE
    public function LISTE_ACTES_INST($conn, $loginuser, $fonction){

//var_dump($loginuser, $fonction); die;


//$FONCTION = $info["FONCTION"];
//$LOGINUSER = $info["LOGINUSER"];


      
///######################################################## MINISTRE ########################################################

if ($fonction == 'MINISTRE') {



    $sql ="SELECT * FROM ((SELECT DISTINCT
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
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00031'
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0048','A0044','A0078','A0076')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))
UNION
(SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID, 
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00031'
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0173')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))
UNION
(SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID, 
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00031'
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0174')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)))
        ORDER BY DATE_VALIDATION_DIRCAB DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

    
}


///######################################################## DAF ########################################################

if ($loginuser == 'J435402') {



    $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0127','A0128')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

   
}


///######################################################## DGAPCE ########################################################

if ($loginuser == 'X477231')  {


    $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00031','00032')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0155','A0158','A0097')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC
";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
        
    }    
        




    if ( $loginuser == 'Z444473') {


    



         $sql ="SELECT * FROM ((SELECT DISTINCT
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
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00031'
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0048','A0044','A0078','A0076')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))
UNION
(SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID, 
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00031'
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0173')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))
UNION
(SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID, 
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00031'
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0174')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))



UNION
(SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0127','A0128')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))

UNION
(SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00031','00032')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0155','A0158','A0097')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)) )

        ORDER BY DATE_VALIDATION_DIRCAB DESC

        ";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
}

  

    }




     /////////////////////////////////////////////////////////////////////////////////



      //LISTE DES NOMINATIONS ET PROMOTIONS EN INSTANCE DE SIGNATURE MINISTRE
    public function LISTE_ACTES_SIGNE($conn, $loginuser, $fonction){



////NOUVELLE REQUETTE


///######################################################## MINISTRE ########################################################

if ($fonction == 'MINISTRE' OR $loginuser == 'Z444473') {
    
        $sql ="SELECT * FROM ((SELECT DISTINCT
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
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0048','A0044','A0078','A0076')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))
        UNION
        (SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00010'
    --AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0173')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))
UNION
 (SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00010'
    --AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0174')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)))
        ORDER BY DATE_SIGNATURE DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

      


        
}



///######################################################## DAF ########################################################

if ($loginuser == 'J435402') {



    $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0127','A0128')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

   
}



///######################################################## DGAPCE ########################################################

if ($loginuser == 'X477231')  {


    $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00010')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0155','A0158')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) DESC
";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
      return $data;
        
    }   




if ( $loginuser == 'Z444473') {


     $sql ="SELECT * FROM ((SELECT DISTINCT
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
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0048','A0044','A0078','A0076')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))
        UNION
        (SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00010'
    --AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0173')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))
UNION
 (SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00010'
    --AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0174')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))

UNION
   (SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0127','A0128')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL))

UNION
    (SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00010')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0155','A0158')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)))
        ORDER BY DATE_SIGNATURE DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;



}

    }




////////////////////////////////////LISTE DES ACTES EN INSTANCES/////////////////////////////////////////////////////////

      //LISTE DES ACTES A SIGNEES
      public function LISTE_FIN_FORMATION_INSTANCE($conn, $loginuser){


if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473' OR $loginuser == 'K349954')  {

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
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00031'
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0076')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY DATE_VALIDATION_DIRCAB DESC";
        
    }


        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

    }



     //LISTE DES ACTES SIGNEES
     public function LISTE_MISE_FORMATION_INSTANCE($conn, $loginuser){

if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473' OR $loginuser == 'K349954' )  {

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
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00031'
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0078')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY DATE_VALIDATION_DIRCAB DESC";


}
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }


    //LISTE DES ACTES SIGNEES
    public function LISTE_COMMUNIQUE_INSTANCE($conn, $loginuser){

if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473' OR $loginuser == 'E319795' OR $loginuser == 'H388545' )  {

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
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00031'
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0048')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY DATE_VALIDATION_DIRCAB DESC";

}
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }


    //LISTE DES ACTES SIGNEES
    public function LISTE_ARRETE_ADMISSION_INSTANCE($conn, $loginuser){

if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473' OR $loginuser == 'E319795' OR $loginuser == 'H388545')  {

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
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00031'
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0044','A0097')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY DATE_VALIDATION_DIRCAB DESC";

}
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }





    //LISTE DES ACTES SIGNEES
    public function LISTE_COMM_OUVERTURE_INSTANCE($conn, $loginuser){

if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473' OR $loginuser == 'E319795' OR $loginuser == 'H388545')  {

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID, 
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00031'
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0174')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY DATE_VALIDATION_DIRCAB DESC";

}
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }



     //LISTE DES ACTES SIGNEES
    public function LISTE_ARRETE_OUVERTURE_INSTANCE($conn, $loginuser){

if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473' OR $loginuser == 'E319795' OR $loginuser == 'H388545')  {

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID, 
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00031'
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) >= to_number(to_char(to_date(:P_DATE_DEBUT,'DD/MM/YYYY'), 'YYYYMMDD'))
    --AND to_number(to_char(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB, 'YYYYMMDD')) <= to_number(to_char(to_date(:P_DATE_FIN,'DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0173')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY DATE_VALIDATION_DIRCAB DESC";

}
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }



public function LISTE_PRET_BANCAIR_INSTANCE($conn, $loginuser){


    if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473')  {

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0097')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

    }else{

         $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0097')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

    }
}



public function LISTE_RGS_INSTANCE($conn, $loginuser){


    if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473')  {

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00031','00032')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0155')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

         }else{

            $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00031','00032')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0155')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
         }
    }






public function LISTE_ARSA_INSTANCE($conn, $loginuser){

    if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473')  {

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00031','00032')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0158')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

        }else{


        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00031','00032')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0158')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;



        }


    }





public function LISTE_ATT_PRIME_INSTANCE($conn, $loginuser){

        if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473')  {

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0127')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;

         }else{


            $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0127')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;



            }


    }



public function LISTE_DOM_PRIME_INSTANCE($conn, $loginuser){


        if ($loginuser == 'X505234' OR $loginuser == 'T279354' OR $loginuser == 'Z444473')  {

        $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0128')
        --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";

        }else{

             $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00031'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0128')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";

        }


        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }









    public function LISTE_CCM_INSTANCE($conn, $loginuser){



// 🔹 Charger les structures du user depuis config/structure.php
    $structures = config('structure.structures');
    $user_structures = [];

    foreach ($structures as $item) {
        if ($item['matricule'] === $loginuser) {
            $user_structures[] = $item['structure'];
        }
    }

    if (empty($user_structures)) {
        return []; // Aucun document si le user n’a pas de structure
    }

    // 🔹 Création des placeholders dynamiques pour le IN (...)
    $placeholders = implode(',', array_fill(0, count($user_structures), '?'));

    // 🔹 SQL : jointure entre TBGL_DOSSIER et TBGL_CCM_NAVETTE
    $sql = "
        SELECT 
            d.*,
            n.GL_CCM_NAV_ORD_SIGN,
            n.GL_CCM_NAV_ETAT,
            n.GL_CCM_NAV_DESTINAT,
            n.GL_CCM_NAV_ORD_SIGN,
            b.GL_ACTE_ID AS GL_ACTE_ID,
            a.GL_ACTE_NUM AS NUMERO_ACTE,
            l.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
            l.PA_NATACTE_CODE as NATURE_ACTE_CODE,
            f.GL_ACTE_NAME as NOM_FICHIER

        FROM TBGL_DOSSIER d
         JOIN TBGL_CCM_NAVETTE n ON d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM

         JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
         JOIN TBGL_ACTE a ON a.GL_ACTE_ID = b.GL_ACTE_ID

         JOIN TBPA_SE_NOTIFICATION f ON f.GL_ACTE_ID = b.GL_ACTE_ID

         JOIN TBPA_NATACTE l ON l.PA_NATACTE_CODE = d.PA_NATACTE_CODE




        WHERE d.PA_NATACTE_CODE = 'A0168'
          AND d.GL_DOSSIER_ETAT = '00031'
          AND n.GL_CCM_NAV_DESTINAT IN ($placeholders)
          AND (n.GL_CCM_NAV_ETAT IS NULL OR n.GL_CCM_NAV_ETAT <> '00010')
          AND NOT EXISTS (
                SELECT 1
                FROM TBGL_CCM_NAVETTE n2
                WHERE n2.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
                  AND n2.GL_CCM_NAV_ORD_SIGN < n.GL_CCM_NAV_ORD_SIGN
                  AND (n2.GL_CCM_NAV_ETAT <> '00010' OR n2.GL_CCM_NAV_ETAT IS NULL)
          )
        ORDER BY d.GL_DOSSIER_NUM ASC
    ";

    // 🔹 Exécution de la requête
    $stm = $conn->prepare($sql);
    $stm->execute($user_structures);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);

    $data = $datas;
        return $data;


    }




public function LISTE_CCM_SIGNE($conn, $loginuser,$P_DATE_DEBUT, $P_DATE_FIN){
    // 🔹 Charger les structures du user depuis config/structure.php
    $structures = config('structure.structures');
    $user_structures = [];
    
    foreach ($structures as $item) {
        if ($item['matricule'] === $loginuser) {
            $user_structures[] = $item['structure'];
        }
    }
    
    if (empty($user_structures)) {
        return []; // Aucun document si le user n'a pas de structure
    }
    
    // 🔹 Création des placeholders dynamiques pour le IN (...)
    $placeholders = implode(',', array_fill(0, count($user_structures), '?'));   //var_dump($user_structures); die;
    
    // 🔹 SQL : jointure entre TBGL_DOSSIER et TBGL_CCM_NAVETTE
    $sql = "
        SELECT 
            d.*,
            n.GL_CCM_NAV_ORD_SIGN,
            n.GL_CCM_NAV_ETAT,
            n.GL_CCM_NAV_DESTINAT,
            n.GL_CCM_NAV_ORD_SIGN,
            b.GL_ACTE_ID AS GL_ACTE_ID,
            a.GL_ACTE_NUM AS NUMERO_ACTE,
            l.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
            l.PA_NATACTE_CODE as NATURE_ACTE_CODE,
            f.GL_ACTE_NAME as NOM_FICHIER,
            a.GL_ACTE_DATESIGN AS DATE_SIGNATURE
            
        FROM TBGL_DOSSIER d
         JOIN TBGL_CCM_NAVETTE n ON d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
         JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
         JOIN TBGL_ACTE a ON a.GL_ACTE_ID = b.GL_ACTE_ID
         JOIN TBPA_SE_NOTIFICATION f ON f.GL_ACTE_ID = b.GL_ACTE_ID
         JOIN TBPA_NATACTE l ON l.PA_NATACTE_CODE = d.PA_NATACTE_CODE
         
        WHERE d.PA_NATACTE_CODE = 'A0168'
          --AND d.GL_DOSSIER_ETAT = '00031'
          AND n.GL_CCM_NAV_DESTINAT IN ($placeholders)
          AND n.GL_CCM_NAV_ETAT IN ('00010', '00084')



        AND to_number(to_char(a.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
        AND to_number(to_char(a.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))


          
        ORDER BY d.GL_DOSSIER_NUM ASC
    ";
    
    // 🔹 Exécution de la requête
    $stm = $conn->prepare($sql);
    $stm->execute($user_structures);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
    
    return $datas;
}













    public function VERIF_ORDRE($conn, $structure, $numActe)
{
    $sql = "
        SELECT n.GL_CCM_NAV_ORD_SIGN
        FROM TBGL_CCM_NAVETTE n
        JOIN TBGL_DOSSIER d ON d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
        JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
        JOIN TBGL_ACTE a ON a.GL_ACTE_ID = b.GL_ACTE_ID
        WHERE a.GL_ACTE_NUM = :numact
        AND n.GL_CCM_NAV_DESTINAT = :structure
        ORDER BY n.GL_CCM_NAV_ORD_SIGN ASC
    ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numact', $numActe);
    $stm->bindParam(':structure', $structure);
    $stm->execute();

    // Récupérer le premier ordre (le plus petit)
    return $stm->fetch(PDO::FETCH_ASSOC); // ['GL_CCM_NAV_ORD_SIGN' => ...]
}



    public function SIGNATAIRE_RESTANT($conn, $loginuser, $numActe)
{
    $sql = "
         SELECT COUNT(*) AS NBRE_LIGNES
        FROM TBGL_CCM_NAVETTE n
        JOIN TBGL_DOSSIER d   ON d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
        JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
        JOIN TBGL_ACTE a     ON a.GL_ACTE_ID = b.GL_ACTE_ID
        WHERE a.GL_ACTE_NUM = :numacte
              AND (n.GL_CCM_NAV_ETAT IS NULL OR TRIM(n.GL_CCM_NAV_ETAT) = '')
              AND (n.GL_CCM_NAV_DATE_SIGNAT IS NULL OR TRIM(n.GL_CCM_NAV_DATE_SIGNAT) = '')
        ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numacte', $numActe);
    $stm->execute();

    // Récupérer le premier ordre (le plus petit)
    return $stm->fetch(PDO::FETCH_ASSOC); // ['GL_CCM_NAV_ORD_SIGN' => ...]
}


public function NBRE_SIGNATAIRE($conn, $loginuser, $numActe)
{
    $sql = "
         SELECT COUNT(*) AS NBRE_LIGNES
        FROM TBGL_CCM_NAVETTE n
        JOIN TBGL_DOSSIER d   ON d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
        JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
        JOIN TBGL_ACTE a     ON a.GL_ACTE_ID = b.GL_ACTE_ID
        WHERE a.GL_ACTE_NUM = :numacte
              AND (n.GL_CCM_NAV_ETAT IS NULL OR TRIM(n.GL_CCM_NAV_ETAT) = '')
              AND (n.GL_CCM_NAV_DATE_SIGNAT IS NULL OR TRIM(n.GL_CCM_NAV_DATE_SIGNAT) = '')
        ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numacte', $numActe);
    $stm->execute();

    // Récupérer le premier ordre (le plus petit)
    return $stm->fetch(PDO::FETCH_ASSOC); // ['GL_CCM_NAV_ORD_SIGN' => ...]
}



public function LISTE_SIGNATAIRE($conn, $loginuser, $numActe)
{
    $sql = "
        SELECT 
            COUNT(*) AS NBRE_LIGNES,
            LISTAGG(n.GL_CCM_NAV_DESTINAT, ', ') 
                WITHIN GROUP (ORDER BY n.GL_CCM_NAV_ORD_SIGN) AS LISTE_DESTINATAIRES
        FROM TBGL_CCM_NAVETTE n
        JOIN TBGL_DOSSIER d   ON d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
        JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
        JOIN TBGL_ACTE a     ON a.GL_ACTE_ID = b.GL_ACTE_ID
        WHERE a.GL_ACTE_NUM = :numacte
    ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numacte', $numActe);
    $stm->execute();

    return $stm->fetch(PDO::FETCH_ASSOC);
}



public function INSERER_WORKFLOW($conn, $workflow, $numActe, $structureAssociee)
{
    $sql = "
        UPDATE TBGL_CCM_NAVETTE n
        SET n.GL_CCM_NAV_FLOW = :workflow
        WHERE n.GL_DOSSIER_NUM IN (
            SELECT d.GL_DOSSIER_NUM
            FROM TBGL_DOSSIER d
            JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
            JOIN TBGL_ACTE a ON a.GL_ACTE_ID = b.GL_ACTE_ID
            WHERE a.GL_ACTE_NUM = :numacte
        )
        AND n.GL_CCM_NAV_DESTINAT = :structureassociee
    ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':workflow', $workflow);
    $stm->bindParam(':numacte', $numActe);
    $stm->bindParam(':structureassociee', $structureAssociee);

    $stm->execute();

    return $stm->rowCount();
}




public function RECUPEWORKFLOW($conn, $numActe, $signatairePrecedent)
{
    $sql = "
        SELECT n.GL_CCM_NAV_FLOW AS WORKFLOW
        FROM TBGL_CCM_NAVETTE n
        WHERE n.GL_DOSSIER_NUM IN (
            SELECT d.GL_DOSSIER_NUM
            FROM TBGL_DOSSIER d
            JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
            JOIN TBGL_ACTE a ON a.GL_ACTE_ID = b.GL_ACTE_ID
            WHERE a.GL_ACTE_NUM = :numacte
        )
        AND n.GL_CCM_NAV_ORD_SIGN = :signataireprecedent
    ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numacte', $numActe);
    $stm->bindParam(':signataireprecedent', $signatairePrecedent);

    $stm->execute();

    // Récupère la valeur
    $workflow = $stm->fetchColumn();

    return $workflow;
}




public function REINITIALISERNAVETTE($conn, $numActe)
{
    $sql = "
        UPDATE TBGL_CCM_NAVETTE n
        SET 
            n.GL_CCM_NAV_FLOW = '',
            n.GL_CCM_NAV_ETAT = '',
            n.GL_CCM_NAV_DATE_SIGNAT = NULL
        WHERE n.GL_DOSSIER_NUM IN (
            SELECT d.GL_DOSSIER_NUM
            FROM TBGL_DOSSIER d
            JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
            JOIN TBGL_ACTE a ON a.GL_ACTE_ID = b.GL_ACTE_ID
            WHERE a.GL_ACTE_NUM = :numacte
        )
    ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numacte', $numActe);

    $stm->execute();

    return $stm->rowCount();
}





         public function LISTE_EMAIL($conn, $matricule)
        {
            $sql = "SELECT FN_SE_USER_INFO(:matricule) AS INFO FROM DUAL";

            $stm = $conn->prepare($sql);
            $stm->bindParam(':matricule', $matricule);
            $stm->execute();

            $row = $stm->fetch(PDO::FETCH_ASSOC);

            if (!$row || empty($row['INFO'])) {
                return null;
            }

            $data = explode('|', $row['INFO']);

            return $data[1] ?? null; // 👈 EMAIL seulement
        }



 


    public function SIGNER_ACTE($conn, $structure, $numActe)
{
    $sql = "
            UPDATE TBGL_CCM_NAVETTE n
            SET n.GL_CCM_NAV_ETAT = '00010',
                n.GL_CCM_NAV_DATE_SIGNAT = TO_CHAR(SYSDATE, 'DD-MON-YY')
            WHERE EXISTS (
                SELECT 1
                FROM TBGL_DOSSIER d
                JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
                JOIN TBGL_ACTE a     ON a.GL_ACTE_ID = b.GL_ACTE_ID
                WHERE d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
                  AND a.GL_ACTE_NUM = :numacte
            )
            AND n.GL_CCM_NAV_DESTINAT = :structure
        ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numacte', $numActe);
    $stm->bindParam(':structure', $structure);
    $stm->execute();

    // Récupérer le premier ordre (le plus petit)
   // return $stm->fetch(PDO::FETCH_ASSOC); // ['GL_CCM_NAV_ORD_SIGN' => ...]
}





  public function SIGNER_LETTRE_TRANSMITION($conn, $structure, $numActe)
{
    $sql = "
        UPDATE TBGL_ACTE 
        SET 
            GL_ACTE_ETAT     = '00010',
            GL_ACTE_DATESIGN = TO_CHAR(SYSDATE, 'DD-MON-YY')
        WHERE GL_ACTE_ID = (
            SELECT GL_ACTE_ID
            FROM (
                SELECT a.GL_ACTE_ID
                FROM TBGL_ACTE a
                WHERE a.MAT_ATTEST_REGUL IN (
                    SELECT GL_DOSSIER_NUM
                    FROM TBGL_RDETBORD 
                    WHERE GL_ACTE_ID IN (
                        SELECT GL_ACTE_ID
                        FROM TBGL_ACTE
                        WHERE GL_ACTE_NUM = :numacte
                    )
                )
                AND a.PA_NATACTE_CODE = 'A0169'
                AND a.GL_ACTE_ETAT   = '00032'
                ORDER BY a.CD_AUDI_CODE
            )
            WHERE ROWNUM = 1
        )
    ";

    $stm = $conn->prepare($sql);
    $stm->bindParam(':numacte', $numActe);
    $stm->execute();
}






        public function LISTE_CCM_AUTRE_INSTANCE($conn, $loginuser){


        

        $sql ="SELECT DISTINCT
    TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
    TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
    TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
    NULL AS TYPECONC_CODE,
    NULL AS TYPECONC_LIB,
    NULL AS CONC_CODE,
    NULL AS CONC_LIB,
    TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
    TBGL_EXCE.GL_EXCELIB AS ANNEE,
    TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
    TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
    TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
    TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) AS DATE_VALIDATION
    
FROM
    TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
WHERE 
    TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
    AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
    AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
    AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
    AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
    --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
    AND TBGL_ACTE.GL_ACTE_ETAT IN ('00031')
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0168') --- NATURE D'ACTE CCM
    --AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
    AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
    AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
    AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESAISIE,'YYYYMMDD')) DESC";

       


        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }

















            public function TEST_CCM($conn, $loginuser){


        
/*
        $sql ="SELECT *
FROM TBGL_CCM_NAVETTE, TBGL_DOSSIER, TBPA_STRUCT
WHERE TBGL_CCM_NAVETTE.GL_DOSSIER_NUM = TBGL_DOSSIER.GL_DOSSIER_NUM
AND TBGL_CCM_NAVETTE.GL_CCM_NAV_DESTINAT = TBPA_STRUCT.PA_STRUCT_COD
";
*/


        $sql ="
                SELECT *
                FROM TBGL_CCM_NAVETTE n
                LEFT JOIN TBGL_DOSSIER d   ON d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
                LEFT JOIN TBGL_RDETBORD b ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM
                LEFT JOIN TBGL_ACTE a     ON a.GL_ACTE_ID = b.GL_ACTE_ID
                ORDER BY a.GL_ACTE_NUM ASC, n.GL_CCM_NAV_ORD_SIGN ASC

                "; 

 /*        $sql =" SELECT * FROM TBGL_DOSSIER  WHERE GL_DOSSIER_ETAT='00031' AND PA_NATACTE_CODE ='A0168'"; */
       



        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }







public function TEST_CCM1($conn, $loginuser)
{
    // 🔹 Charger les structures du user depuis config/structure.php
    $structures = config('structure.structures');
    $user_structures = [];

    foreach ($structures as $item) {
        if ($item['matricule'] === $loginuser) {
            $user_structures[] = $item['structure'];
        }
    }

    if (empty($user_structures)) {
        return []; // Aucun document si le user n’a pas de structure
    }

    // 🔹 Création des placeholders dynamiques pour le IN (...)
    $placeholders = implode(',', array_fill(0, count($user_structures), '?'));

    // 🔹 SQL : jointure entre TBGL_DOSSIER et TBGL_CCM_NAVETTE
    $sql = "
        SELECT 
    d.*,
    n.*,
    b.*,
    a.*,
    f.*,
    l.*
FROM TBGL_DOSSIER d
LEFT JOIN TBGL_CCM_NAVETTE n 
       ON d.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM

LEFT JOIN TBGL_RDETBORD b 
       ON b.GL_DOSSIER_NUM = d.GL_DOSSIER_NUM

LEFT JOIN TBGL_ACTE a 
       ON a.GL_ACTE_ID = b.GL_ACTE_ID

LEFT JOIN TBPA_SE_NOTIFICATION f 
       ON f.GL_ACTE_ID = b.GL_ACTE_ID

LEFT JOIN TBPA_NATACTE l 
       ON l.PA_NATACTE_CODE = d.PA_NATACTE_CODE

WHERE d.PA_NATACTE_CODE = 'A0168'
  AND d.GL_DOSSIER_ETAT = '00031'
  AND n.GL_CCM_NAV_DESTINAT IN ($placeholders)
  AND NOT EXISTS (
        SELECT 1
        FROM TBGL_CCM_NAVETTE n2
        WHERE n2.GL_DOSSIER_NUM = n.GL_DOSSIER_NUM
          AND n2.GL_CCM_NAV_ORD_SIGN < n.GL_CCM_NAV_ORD_SIGN
          AND (n2.GL_CCM_NAV_ETAT <> '00010' OR n2.GL_CCM_NAV_ETAT IS NULL)
  )
ORDER BY d.GL_DOSSIER_NUM ASC

    ";

    // 🔹 Exécution de la requête
    $stm = $conn->prepare($sql);
    $stm->execute($user_structures);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $datas;
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////






       public function TMP_RCANDEMPSTRUCT($conn, $loginuser){


        

        $sql ="SELECT * FROM TMP_RCANDEMPSTRUCT WHERE FC_CAND_NUM LIKE 'CD14-00060%'";

       


        $stm = $conn->prepare($sql);
        $stm->execute();
        $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = $datas;
        return $data;
    }


/////////////////////////////////////////////LISTE DES ACTES SIGNES//////////////////////////////////////////////////////////



  //LISTE DES ACTES SIGNEES
  public function LISTE_FIN_FORMATION_SIGNE($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0076')
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




public function LISTE_FIN_FORMATION_DATE_SIGNE($conn, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
       COUNT (UNIQUE TBGL_DOSSIER.GL_DOSSIER_NUM) AS NBR_DOSSIER,
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
       TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
       --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
       AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
       AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
       AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
       AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0076')
       AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
       AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
       AND (TBPA_SE_NOTIFICATION.STATUS IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
       GROUP BY TBGL_ACTE.GL_ACTE_NUM ,
       TBGL_DOSSIER.PA_NATACTE_CODE,
       DECODE(TBPA_NATACTE.PA_NATACTE_LIB,'ADMISSION','ARRETE D''ADMISSION',TBPA_NATACTE.PA_NATACTE_LIB),
       TBGL_DOSSIER.GL_DOSSIER_TYPECONC,
       TBPA_TYPECONC.PA_TYPECONC_LIB,
       TBGL_DOSSIER.PA_CONC_NUM,
       TBPA_CONC.PA_CONC_LIB,
       TBGL_DOSSIER.GL_DOSSIER_ANNEECONC,
       TBGL_EXCE.GL_EXCELIB,
       TBPA_MSGETAT.PA_MSGETAT_LIB,
       TBPA_SE_NOTIFICATION.GL_ACTE_NAME,
       TBGL_ACTE.GL_ACTE_ID,
       TBGL_ACTE.GL_ACTE_DATESIGN,
       TO_NUMBER(TO_CHAR(TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD'))
       ORDER BY TBGL_ACTE.GL_ACTE_DATESIGN DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }



 //LISTE DES ACTES SIGNEES
 public function LISTE_MISE_FORMATION_SIGNE($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0078')
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





public function LISTE_MISE_FORMATION_DATE_SIGNE($conn, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
       COUNT (UNIQUE TBGL_DOSSIER.GL_DOSSIER_NUM) AS NBR_DOSSIER,
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
       TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
       --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
       AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
       AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
       AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
       AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0078')
       AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
       AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
       AND (TBPA_SE_NOTIFICATION.STATUS IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
       GROUP BY TBGL_ACTE.GL_ACTE_NUM ,
       TBGL_DOSSIER.PA_NATACTE_CODE,
       DECODE(TBPA_NATACTE.PA_NATACTE_LIB,'ADMISSION','ARRETE D''ADMISSION',TBPA_NATACTE.PA_NATACTE_LIB),
       TBGL_DOSSIER.GL_DOSSIER_TYPECONC,
       TBPA_TYPECONC.PA_TYPECONC_LIB,
       TBGL_DOSSIER.PA_CONC_NUM,
       TBPA_CONC.PA_CONC_LIB,
       TBGL_DOSSIER.GL_DOSSIER_ANNEECONC,
       TBGL_EXCE.GL_EXCELIB,
       TBPA_MSGETAT.PA_MSGETAT_LIB,
       TBPA_SE_NOTIFICATION.GL_ACTE_NAME,
       TBGL_ACTE.GL_ACTE_ID,
       TBGL_ACTE.GL_ACTE_DATESIGN,
       TO_NUMBER(TO_CHAR(TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD'))
       ORDER BY TBGL_ACTE.GL_ACTE_DATESIGN DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }


//LISTE DES ACTES SIGNEES
public function LISTE_COMMUNIQUE_SIGNE($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0048')
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



public function LISTE_COMMUNIQUE_DATE_SIGNE($conn, $P_DATE_DEBUT, $P_DATE_FIN){
 //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
    $sql ="SELECT DISTINCT
    COUNT (UNIQUE TBGL_DOSSIER.GL_DOSSIER_NUM) AS NBR_DOSSIER,
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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
    AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
    AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0048')
    AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
    AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
    AND (TBPA_SE_NOTIFICATION.STATUS IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
       GROUP BY TBGL_ACTE.GL_ACTE_NUM ,
       TBGL_DOSSIER.PA_NATACTE_CODE,
       DECODE(TBPA_NATACTE.PA_NATACTE_LIB,'ADMISSION','ARRETE D''ADMISSION',TBPA_NATACTE.PA_NATACTE_LIB),
       TBGL_DOSSIER.GL_DOSSIER_TYPECONC,
       TBPA_TYPECONC.PA_TYPECONC_LIB,
       TBGL_DOSSIER.PA_CONC_NUM,
       TBPA_CONC.PA_CONC_LIB,
       TBGL_DOSSIER.GL_DOSSIER_ANNEECONC,
       TBGL_EXCE.GL_EXCELIB,
       TBPA_MSGETAT.PA_MSGETAT_LIB,
       TBPA_SE_NOTIFICATION.GL_ACTE_NAME,
       TBGL_ACTE.GL_ACTE_ID,
       TBGL_ACTE.GL_ACTE_DATESIGN,
       TO_NUMBER(TO_CHAR(TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD'))
       ORDER BY TBGL_ACTE.GL_ACTE_DATESIGN DESC";
    $stm = $conn->prepare($sql);
    $stm->execute();
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = $datas;
    return $data;
}


//LISTE DES ACTES SIGNEES
public function LISTE_ARRETE_ADMISSION_SIGNE($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0044')
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



public function LISTE_ARRETE_ADMISSION_DATE_SIGNE($conn, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
       COUNT (UNIQUE TBGL_DOSSIER.GL_DOSSIER_NUM) AS NBR_DOSSIER,
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
       TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
       --AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
       AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
       AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
       AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
       AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0044')
       AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
       AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
       AND (TBPA_SE_NOTIFICATION.STATUS IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
       GROUP BY TBGL_ACTE.GL_ACTE_NUM ,
       TBGL_DOSSIER.PA_NATACTE_CODE,
       DECODE(TBPA_NATACTE.PA_NATACTE_LIB,'ADMISSION','ARRETE D''ADMISSION',TBPA_NATACTE.PA_NATACTE_LIB),
       TBGL_DOSSIER.GL_DOSSIER_TYPECONC,
       TBPA_TYPECONC.PA_TYPECONC_LIB,
       TBGL_DOSSIER.PA_CONC_NUM,
       TBPA_CONC.PA_CONC_LIB,
       TBGL_DOSSIER.GL_DOSSIER_ANNEECONC,
       TBGL_EXCE.GL_EXCELIB,
       TBPA_MSGETAT.PA_MSGETAT_LIB,
       TBPA_SE_NOTIFICATION.GL_ACTE_NAME,
       TBGL_ACTE.GL_ACTE_ID,
       TBGL_ACTE.GL_ACTE_DATESIGN,
       TO_NUMBER(TO_CHAR(TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD'))
       ORDER BY TBGL_ACTE.GL_ACTE_DATESIGN DESC


";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }




   public function LISTE_ARRETE_OUVERTURE_DATE_SIGNE($conn, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00010'
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0173')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TBGL_ACTE.GL_ACTE_DATESIGN DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }




   public function LISTE_COMM_OUVERTURE_DATE_SIGNE($conn, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,
        TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,
        TBGL_DOSSIER_OUV_CONC.GL_EXCECODE AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
        TO_NUMBER(TO_CHAR(TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_DATERESPO_DCAB,'YYYYMMDD')) AS DATE_VALIDATION_DIRCAB
        FROM TBGL_DOSSIER_OUV_CONC,TBGL_RDETBORD,TBGL_ACTE,TBPA_NATACTE,TBPA_TYPECONC,TBPA_CONC,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_TYPECONC_CODE=TBPA_TYPECONC.PA_TYPECONC_CODE
        AND TBGL_DOSSIER_OUV_CONC.PA_CONC_NUM=TBPA_CONC.PA_CONC_NUM
        AND TBGL_DOSSIER_OUV_CONC.GL_EXCECODE=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER_OUV_CONC.GL_DOSSIER_ETAT ='00010'
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'   
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = 'X505234' --**************** MINISTRE
        AND TBGL_DOSSIER_OUV_CONC.PA_NATACTE_CODE IN('A0174')
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TBGL_ACTE.GL_ACTE_DATESIGN DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }









################################### DIRECTEUR ######################################################



  //LISTE DES ACTES SIGNEES
  public function LISTE_PRET_BANCAIR_SIGNE ($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0076')
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




public function LISTE_PRET_BANCAIR_DATE_SIGNE($conn, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0097')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }


  //LISTE DES ACTES SIGNEES
  public function LISTE_RGS_SIGNE ($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0076')
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




public function LISTE_RGS_DATE_SIGNE($conn, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00010')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0155')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }

  //LISTE DES ACTES SIGNEES
  public function LISTE_ARSA_SIGNE ($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0076')
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




public function LISTE_ARSA_DATE_SIGNE($conn, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_DOSSIER,TBGL_RDETBORD,TBGL_ACTE,TBCE_AGT,TBPA_NATACTE,TBPA_MSGETAT,TBGL_EXCE,TBPA_SE_NOTIFICATION
        WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
        AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
        AND TBGL_DOSSIER.CE_AGT_MAT=TBCE_AGT.CE_AGT_MAT
        AND TBGL_ACTE.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC=TBGL_EXCE.GL_EXCECODE
        --AND TBGL_DOSSIER.GL_DOSSIER_ETAT IN ('00031','00032')
        AND TBGL_ACTE.GL_ACTE_ETAT IN ('00010')
        AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0158')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DGAPCE
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }


  //LISTE DES ACTES SIGNEES
  public function LISTE_ATT_PRIME_SIGNE ($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0076')
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




public function LISTE_ATT_PRIME_DATE_SIGNE($conn, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0127')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }


  //LISTE DES ACTES SIGNEES
  public function LISTE_DOM_PRIME_SIGNE ($conn){

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
    TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,
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
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT ='00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN('A0076')
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




public function LISTE_DOM_PRIME_DATE_SIGNE($conn, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN){
    //var_dump($P_DATE_DEBUT." -------".$P_DATE_FIN); die;
       $sql ="SELECT DISTINCT
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_ACTE.PA_NATACTE_CODE AS NATURE_ACTE_CODE,
        TBPA_NATACTE.PA_NATACTE_LIB AS NATURE_ACTE_LIB,
        NULL AS TYPECONC_CODE,
        NULL AS TYPECONC_LIB,
        NULL AS CONC_CODE,
        NULL AS CONC_LIB,
        NULL AS EXCE_CODE,
        NULL AS ANNEE,
        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,
        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) AS DATE_SIGNATURE
        FROM TBGL_ACTE, TBPA_NATACTE,TBPA_MSGETAT,TBPA_SE_NOTIFICATION
        WHERE TBGL_ACTE.PA_NATACTE_CODE=TBPA_NATACTE.PA_NATACTE_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT=TBPA_MSGETAT.PA_MSGETAT_CODE
        AND TBGL_ACTE.GL_ACTE_ETAT ='00010'
        AND TBGL_ACTE.PA_NATACTE_CODE IN('A0128')
        AND TBPA_NATACTE.TBPC_HABVIS_CODE = '$loginuser' --**************** DAAF
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) >= to_number(to_char(to_date('$P_DATE_DEBUT','DD/MM/YYYY'), 'YYYYMMDD'))
        AND to_number(to_char(TBGL_ACTE.GL_ACTE_DATESIGN, 'YYYYMMDD')) <= to_number(to_char(to_date('$P_DATE_FIN','DD/MM/YYYY'), 'YYYYMMDD'))
        AND TBGL_ACTE.GL_ACTE_ID=TBPA_SE_NOTIFICATION.GL_ACTE_ID
        AND TBPA_SE_NOTIFICATION.GL_ACTE_NAME IS NOT NULL
        AND (TBPA_SE_NOTIFICATION.STATUS NOT IN('RECIPIENTFINISHED','WORKFLOWFINISHED','recipientfinished','workflowfinished') or TBPA_SE_NOTIFICATION.STATUS is NULL)
        ORDER BY TO_NUMBER(TO_CHAR(TBGL_ACTE.GL_ACTE_DATESIGN,'YYYYMMDD')) DESC";
       $stm = $conn->prepare($sql);
       $stm->execute();
       $datas = $stm->fetchAll(PDO::FETCH_ASSOC);
       $data = $datas;
       return $data;
   }


//////////////////////////////////////////////////////////////////////////////////////////////////////




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





####################################  VERIFICATION QR AUTHENTIQUE #############################



    public function VERIF_MISE_FORMATION_SIGNE($conn, $act)
    {
        $sql = "SELECT DISTINCT
        COUNT(DISTINCT TBGL_DOSSIER.GL_DOSSIER_NUM) OVER () AS NBR_DOSSIER,
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,

        DECODE(
            TBPA_NATACTE.PA_NATACTE_LIB,
            'ADMISSION', 'ARRETE D''ADMISSION',
            TBPA_NATACTE.PA_NATACTE_LIB
        ) AS NATURE_ACTE_LIB,

        TBGL_DOSSIER.GL_DOSSIER_TYPECONC AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,

        TBGL_DOSSIER.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,

        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,

        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,

        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,

        TO_NUMBER(
            TO_CHAR(
                TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,
                'YYYYMMDD'
            )
        ) AS DATE_VALIDATION_DIRCAB

    FROM TBGL_DOSSIER,
         TBGL_RDETBORD,
         TBGL_ACTE,
         TBPA_RCANDCONC,
         TBPA_NATACTE,
         TBPA_TYPECONC,
         TBPA_CONC,
         TBPA_MSGETAT,
         TBGL_EXCE,
         TBPA_SE_NOTIFICATION

    WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
    AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
    AND TBGL_DOSSIER.CE_AGT_MAT = TBPA_RCANDCONC.FC_CAND_NUM
    AND TBGL_DOSSIER.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = TBPA_MSGETAT.PA_MSGETAT_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_TYPECONC = TBPA_TYPECONC.PA_TYPECONC_CODE
    AND TBGL_DOSSIER.PA_CONC_NUM = TBPA_CONC.PA_CONC_NUM
    AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC = TBGL_EXCE.GL_EXCECODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = '00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0078')
    AND TBGL_ACTE.GL_ACTE_ID = TBPA_SE_NOTIFICATION.GL_ACTE_ID
    AND TBGL_ACTE.GL_ACTE_NUM = :act

    ORDER BY DATE_VALIDATION_DIRCAB DESC";

    $stm = $conn->prepare($sql);
    $stm->execute([':act' => $act]);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $datas;
}






  public function VERIF_FIN_FORMATION_SIGNE($conn, $act)
    {
        $sql = "SELECT DISTINCT
        COUNT(DISTINCT TBGL_DOSSIER.GL_DOSSIER_NUM) OVER () AS NBR_DOSSIER,
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,

        DECODE(
            TBPA_NATACTE.PA_NATACTE_LIB,
            'ADMISSION', 'ARRETE D''ADMISSION',
            TBPA_NATACTE.PA_NATACTE_LIB
        ) AS NATURE_ACTE_LIB,

        TBGL_DOSSIER.GL_DOSSIER_TYPECONC AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,

        TBGL_DOSSIER.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,

        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,

        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,

        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,

        TO_NUMBER(
            TO_CHAR(
                TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,
                'YYYYMMDD'
            )
        ) AS DATE_VALIDATION_DIRCAB

    FROM TBGL_DOSSIER,
         TBGL_RDETBORD,
         TBGL_ACTE,
         TBPA_RCANDCONC,
         TBPA_NATACTE,
         TBPA_TYPECONC,
         TBPA_CONC,
         TBPA_MSGETAT,
         TBGL_EXCE,
         TBPA_SE_NOTIFICATION

    WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
    AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
    AND TBGL_DOSSIER.CE_AGT_MAT = TBPA_RCANDCONC.FC_CAND_NUM
    AND TBGL_DOSSIER.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = TBPA_MSGETAT.PA_MSGETAT_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_TYPECONC = TBPA_TYPECONC.PA_TYPECONC_CODE
    AND TBGL_DOSSIER.PA_CONC_NUM = TBPA_CONC.PA_CONC_NUM
    AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC = TBGL_EXCE.GL_EXCECODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = '00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0076')
    AND TBGL_ACTE.GL_ACTE_ID = TBPA_SE_NOTIFICATION.GL_ACTE_ID
    AND TBGL_ACTE.GL_ACTE_NUM = :act

    ORDER BY DATE_VALIDATION_DIRCAB DESC";

    $stm = $conn->prepare($sql);
    $stm->execute([':act' => $act]);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $datas;
}






public function VERIF_FIN_FORMATION_SIGNE1($conn, $act)
    {
        $sql = "SELECT DISTINCT
        COUNT(DISTINCT TBGL_DOSSIER.GL_DOSSIER_NUM) OVER () AS NBR_DOSSIER,
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,

        DECODE(
            TBPA_NATACTE.PA_NATACTE_LIB,
            'ADMISSION', 'ARRETE D''ADMISSION',
            TBPA_NATACTE.PA_NATACTE_LIB
        ) AS NATURE_ACTE_LIB,

        TBGL_DOSSIER.GL_DOSSIER_TYPECONC AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,

        TBGL_DOSSIER.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,

        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,

        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,

        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,

        TO_NUMBER(
            TO_CHAR(
                TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,
                'YYYYMMDD'
            )
        ) AS DATE_VALIDATION_DIRCAB

    FROM TBGL_DOSSIER,
         TBGL_RDETBORD,
         TBGL_ACTE,
         TBPA_RCANDCONC,
         TBPA_NATACTE,
         TBPA_TYPECONC,
         TBPA_CONC,
         TBPA_MSGETAT,
         TBGL_EXCE,
         TBPA_SE_NOTIFICATION

    WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
    AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
    AND TBGL_DOSSIER.CE_AGT_MAT = TBPA_RCANDCONC.FC_CAND_NUM
    AND TBGL_DOSSIER.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = TBPA_MSGETAT.PA_MSGETAT_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_TYPECONC = TBPA_TYPECONC.PA_TYPECONC_CODE
    AND TBGL_DOSSIER.PA_CONC_NUM = TBPA_CONC.PA_CONC_NUM
    AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC = TBGL_EXCE.GL_EXCECODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = '00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0076')
    AND TBGL_ACTE.GL_ACTE_ID = TBPA_SE_NOTIFICATION.GL_ACTE_ID
    AND TBGL_ACTE.GL_ACTE_NUM = :act

    ORDER BY DATE_VALIDATION_DIRCAB DESC";

    $stm = $conn->prepare($sql);
    $stm->execute([':act' => $act]);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $datas;
}





public function VERIF_COMMUNIQUE_SIGNE($conn, $act)
    {
        $sql = "SELECT DISTINCT
        COUNT(DISTINCT TBGL_DOSSIER.GL_DOSSIER_NUM) OVER () AS NBR_DOSSIER,
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,

        DECODE(
            TBPA_NATACTE.PA_NATACTE_LIB,
            'ADMISSION', 'ARRETE D''ADMISSION',
            TBPA_NATACTE.PA_NATACTE_LIB
        ) AS NATURE_ACTE_LIB,

        TBGL_DOSSIER.GL_DOSSIER_TYPECONC AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,

        TBGL_DOSSIER.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,

        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,

        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,

        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,

        TO_NUMBER(
            TO_CHAR(
                TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,
                'YYYYMMDD'
            )
        ) AS DATE_VALIDATION_DIRCAB

    FROM TBGL_DOSSIER,
         TBGL_RDETBORD,
         TBGL_ACTE,
         TBPA_RCANDCONC,
         TBPA_NATACTE,
         TBPA_TYPECONC,
         TBPA_CONC,
         TBPA_MSGETAT,
         TBGL_EXCE,
         TBPA_SE_NOTIFICATION

    WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
    AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
    AND TBGL_DOSSIER.CE_AGT_MAT = TBPA_RCANDCONC.FC_CAND_NUM
    AND TBGL_DOSSIER.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = TBPA_MSGETAT.PA_MSGETAT_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_TYPECONC = TBPA_TYPECONC.PA_TYPECONC_CODE
    AND TBGL_DOSSIER.PA_CONC_NUM = TBPA_CONC.PA_CONC_NUM
    AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC = TBGL_EXCE.GL_EXCECODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = '00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0048')
    AND TBGL_ACTE.GL_ACTE_ID = TBPA_SE_NOTIFICATION.GL_ACTE_ID
    AND TBGL_ACTE.GL_ACTE_NUM = :act

    ORDER BY DATE_VALIDATION_DIRCAB DESC";

    $stm = $conn->prepare($sql);
    $stm->execute([':act' => $act]);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $datas;
}







public function VERIF_ARRETE_ADMISSION_SIGNE($conn, $act)
    {
        $sql = "SELECT DISTINCT
        COUNT(DISTINCT TBGL_DOSSIER.GL_DOSSIER_NUM) OVER () AS NBR_DOSSIER,
        TBGL_ACTE.GL_ACTE_NUM AS NUMERO_ACTE,
        TBGL_DOSSIER.PA_NATACTE_CODE AS NATURE_ACTE_CODE,

        DECODE(
            TBPA_NATACTE.PA_NATACTE_LIB,
            'ADMISSION', 'ARRETE D''ADMISSION',
            TBPA_NATACTE.PA_NATACTE_LIB
        ) AS NATURE_ACTE_LIB,

        TBGL_DOSSIER.GL_DOSSIER_TYPECONC AS TYPECONC_CODE,
        TBPA_TYPECONC.PA_TYPECONC_LIB AS TYPECONC_LIB,

        TBGL_DOSSIER.PA_CONC_NUM AS CONC_CODE,
        TBPA_CONC.PA_CONC_LIB AS CONC_LIB,

        TBGL_DOSSIER.GL_DOSSIER_ANNEECONC AS EXCE_CODE,
        TBGL_EXCE.GL_EXCELIB AS ANNEE,

        TBPA_MSGETAT.PA_MSGETAT_LIB AS ETAT,
        TBPA_SE_NOTIFICATION.GL_ACTE_NAME AS NOM_FICHIER,

        TBGL_ACTE.GL_ACTE_ID AS GL_ACTE_ID,
        TBGL_ACTE.GL_ACTE_DATESIGN AS DATE_SIGNATURE,

        TO_NUMBER(
            TO_CHAR(
                TBGL_DOSSIER.GL_DOSSIER_DATERESPO_DCAB,
                'YYYYMMDD'
            )
        ) AS DATE_VALIDATION_DIRCAB

    FROM TBGL_DOSSIER,
         TBGL_RDETBORD,
         TBGL_ACTE,
         TBPA_RCANDCONC,
         TBPA_NATACTE,
         TBPA_TYPECONC,
         TBPA_CONC,
         TBPA_MSGETAT,
         TBGL_EXCE,
         TBPA_SE_NOTIFICATION

    WHERE TBGL_DOSSIER.GL_DOSSIER_NUM = TBGL_RDETBORD.GL_DOSSIER_NUM
    AND TBGL_RDETBORD.GL_ACTE_ID = TBGL_ACTE.GL_ACTE_ID
    AND TBGL_DOSSIER.CE_AGT_MAT = TBPA_RCANDCONC.FC_CAND_NUM
    AND TBGL_DOSSIER.PA_NATACTE_CODE = TBPA_NATACTE.PA_NATACTE_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = TBPA_MSGETAT.PA_MSGETAT_CODE
    AND TBGL_DOSSIER.GL_DOSSIER_TYPECONC = TBPA_TYPECONC.PA_TYPECONC_CODE
    AND TBGL_DOSSIER.PA_CONC_NUM = TBPA_CONC.PA_CONC_NUM
    AND TBGL_DOSSIER.GL_DOSSIER_ANNEECONC = TBGL_EXCE.GL_EXCECODE
    AND TBGL_DOSSIER.GL_DOSSIER_ETAT = '00010'
    AND TBGL_DOSSIER.PA_NATACTE_CODE IN ('A0044')
    AND TBGL_ACTE.GL_ACTE_ID = TBPA_SE_NOTIFICATION.GL_ACTE_ID
    AND TBGL_ACTE.GL_ACTE_NUM = :act

    ORDER BY DATE_VALIDATION_DIRCAB DESC";

    $stm = $conn->prepare($sql);
    $stm->execute([':act' => $act]);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $datas;
}





public function VERIF_PRET_BANCAIR_SIGNE($conn, $act)
    {
        $sql = " SELECT CE_AGT_MAT, DATE_INSERTION, DATE_PAYEMENT, IMPUTE, DATE_IMPUTATION, NOM_PREN, TITRE, CIVILITE_CODE,
                 ETAT_PROJET, DATE_PROJET, GESTIONNAIRE, NOMBRE_COPIE,BANQUE_GEST,AGENCE_GEST,ETAT_AGT_ACTE_TARIFE,CE_AGT_RADIATION,CE_AGT_ANCIENNETE,DATENAISS,EMPLOI_LIB,NOM_PRENOM_GEST,

                 --  PA_NATACTE_CODE,
                 
                 --LIEUNAISS,
                 --GL_ACTE_ID,
                 --CE_AGT_NOMPERE,
                 --CE_AGT_NOMMERE,
                 
                 --PA_CONC_NUM,
                 -- PA_TYPECONC_CODE,
                 
                 --EMAIL_GEST,
                 -- TEL_GEST,
                 --GEST_INTRA,
                 --  VALIDE_FIN_PRET,
                 TBGL_ACTE.GL_ACTE_ETAT,
                 TBGL_ACTE.GL_ACTE_DATESIGN
                 FROM TBPA_ACTE_TARIFE,TBGL_ACTE
                 WHERE TBPA_ACTE_TARIFE.GL_ACTE_ID=TBGL_ACTE.GL_ACTE_ID
                 AND TBPA_ACTE_TARIFE.PA_NATACTE_CODE=TBGL_ACTE.PA_NATACTE_CODE
                 AND TBGL_ACTE.GL_ACTE_ETAT='00031' -- ETAT SIGNE '00031' -- INSTANCE DE SIGNATURE
                 AND TBGL_ACTE.GL_ACTE_NUM= :act
        ";

    $stm = $conn->prepare($sql);
    $stm->execute([':act' => $act]);
    $datas = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $datas;
}




}
