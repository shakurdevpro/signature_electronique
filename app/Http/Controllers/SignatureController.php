<?php

namespace App\Http\Controllers;
use App\Models\SignatureMod;
use PhpParser\Node\Stmt\TryCatch;
use PDO;
use Session;
use Dompdf\Dompdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    

 // appel a la page de connection 

 public function  connection(Request $request)

 {
    
   
    $request->validate([
        "matricule"=>"required",
        "password"=>"required",
    ]);


    $matricule = $request->matricule;
    $password = $request->password;
    // Etudiant::create($request->all());

   // $matricule=$this->input->post('matricule');

   try {
       

 // Verification de la connection a la base de donnnées
    if (!empty($matricule) && !empty($password))
    { 
        $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');

        if (!$conn) {

            $data_error=array('message_error' =>'Login ou mode passe incorrecte');


        }
        else{


            //CREATION DUNE SESSION 

//Session::flush();
            $session = session();
         
            $ses_data =array('LOGINUSER' =>$matricule, 'PWDUSER' =>$password,'logged_in' => TRUE);
            $session=($ses_data);
            

           
           // $value = session(['LOGINUSER' =>$matricule, 'PWDUSER' =>$password]);


            defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
            (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

            //$CsigneModel = new CsigneModel;
           $this->oracle = new PDO('oci:dbname='.TNSNAME,$session['LOGINUSER'],$session['PWDUSER']);
            $SignatureMod = new SignatureMod();
        //    $Mcfsigne =new Mcfsigne();

           $FN_SE_USER_INFO =  $SignatureMod->FN_SE_USER_INFO($matricule,$this->oracle);
           $NOM_PRENOMS = $FN_SE_USER_INFO['NOM_PRENOMS'];
           $LOGINUSER = $matricule;
           $FONCTION = $FN_SE_USER_INFO['FONCTION'];
           $EMAIL = $FN_SE_USER_INFO['EMAIL'];
           $TELEPHONE = $FN_SE_USER_INFO['TELEPHONE'];        
           

           $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($matricule,$this->oracle);
           
           //var_dump($GET_NBRE_INSTANCE);
           //die;
           $NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
           $NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
           $NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
           $NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];

        /*$INFO_NBUSER =  $SignatureMod->nbreA($matricule,$this->oracle);
               var_dump($INFO_NBUSER);
               die;

               $INFO_USER =  $SignatureMod->INFO_USER($matricule,$this->oracle);
               var_dump($INFO_USER);
               die;
               */

                // fonction de l'utilisateur connecté
                $USERFONCTION = $SignatureMod->USERFONCTION($matricule,$this->oracle);
                // fin fonction

                // nom et prenom de l'utilisateur connecté
                $USERNAME = $SignatureMod->USERNAME($matricule,$this->oracle);
                // fin nom et prenom
                //email
                $USERMAIL = $SignatureMod->USERMAIL($matricule,$this->oracle);
                // fin email

                //USERTEL
                $USERTEL = $SignatureMod->USERTEL($matricule,$this->oracle);
                // fin  USERTEL

                //TOUS LES DOCUMENT

                 // NOMBRE DE NOMMINATION EN INSTANCE DE SIGNATURE
                 $NBRE_NOMIN_INST_MIN = $SignatureMod->NOMIN_INST_MIN($this->oracle);
                 // FIN NOMBRE DE NOMMINATION EN INSTANCE DE SIGNATURE

                 // NOMBRE DE PROMOTION EN INSTANCE DE SIGNATURE
                 $NBRE_PROM_INST_MIN = $SignatureMod->PROM_INST_MIN($this->oracle);
                 // FIN NOMBRE DE PROMOTION EN INSTANCE DE SIGNATURE

                 //FONCTION NOMBRE DACTE NOMINATION SIGNE PAR LA MINISTRE
                 $NBRE_NOMIN_SIGNE_MIN = $SignatureMod->NOMIN_SIGNE_MIN($this->oracle);
                 // FIN NOMBRE DACTE NOMINATION SIGNE PAR LA MINISTRE

                 //FONCTION NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE
                 $NBRE_PROM_SIGNE_MIN = $SignatureMod->PROM_SIGNE_MIN($this->oracle);
                 // FIN NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE


                 //FONCTION NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE
                 $LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $LOGINUSER, $FONCTION);
                 // FIN NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE
                 //var_dump($LISTE_ACTES_INST); die;
                 $LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $LOGINUSER, $FONCTION);
                 

                 $data = array('USERFONCT' => $USERFONCTION, 'USERNAME' => $USERNAME, 'MAIL' => $USERMAIL, 'USERTEL' => $USERTEL,
                 'NBR_NOMI_INST_MIN' => $NBRE_NOMIN_INST_MIN, 'PROM_INST_MIN' => $NBRE_PROM_INST_MIN,
                 'NOMIN_SIGNE_MIN' => $NBRE_NOMIN_SIGNE_MIN, 'PROM_SIGNE_MIN' => $NBRE_PROM_SIGNE_MIN, 'LISTE_ACTES_INST' => $LISTE_ACTES_INST);


                

      
            //$information = [ 'FONCTION'=>$USERFONCTION , 'NOM PRENOMS'=>$USERNAME, 'EMAIL'=>$USERMAIL, 'TELEPHONE'=>$USERTEL,'LOGINUSER' =>$matricule, 'PWDUSER' =>$password,'logged_in' => TRUE];
            //$information = ['FN_SE_USER_INFO'=>$FN_SE_USER_INFO];
            $informations = ['NOM PRENOMS'=>$NOM_PRENOMS, 'FONCTION'=>$FONCTION , 'EMAIL'=>$EMAIL, 'TELEPHONE'=>$TELEPHONE, 'LOGINUSER' =>$matricule, 'PWDUSER'=>$password, 'logged_in' => TRUE];

           
            //$stat = [ 'NBRE_NOMIN_INST_MIN'=>$NBRE_NOMIN_INST_MIN , 'NBRE_PROM_INST_MIN'=>$NBRE_PROM_INST_MIN, 'NBRE_NOMIN_SIGNE_MIN'=>$NBRE_NOMIN_SIGNE_MIN, 'NBRE_PROM_SIGNE_MIN'=>$NBRE_PROM_SIGNE_MIN];
            //$stat = ['GET_NBRE_INSTANCE'=>$GET_NBRE_INSTANCE];
            $stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];

            
           // $docsigne = $request->session()->get('LISTE_ACTES_SIGNE');

          //  $request->session()->put(['INFORMATION'=>$information, 'STAT'=>$stat, 'DOCUMENTS'=>$LISTE_ACTES_INST, 'INFO_USER'=> $INFO_USER, 'NBRE_INSTANCE'=>$GET_NBRE_INSTANCE]);
          $request->session()->put(['INFORMATION'=>$informations, 'STAT'=>$stat, 'DOCUMENTS'=>$LISTE_ACTES_INST, 'DOCUMENTSSIGNES'=>$LISTE_ACTES_SIGNE]);
            
        //  var_dump($LISTE_ACTES_INST);
        //  die;


       // dd($LISTE_ACTES_INST );
       // die;
       
          return redirect('/accueil');

            
        }
    }



} catch (\Throwable $th) {

    echo $th->getMessage();
//return redirect('/login')->with('message', 'Matricule ou mot de passe incorrect');
    

}


 }



//DECONNEXION 


public function destroy(Request $request)
{

   
    $request->session()->forget(['INFORMATION', 'STAT', 'DOCUMENTS','DOCUMENTSSIGNES','INFO_USER','NBRE_INSTANCE']);
    $request->session()->flush();

    return redirect('/login');
}




 public function dashboard(Request $request)

 {

    
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

  $info      = session()->get('INFORMATION');
  $loginuser = $info['LOGINUSER'];
  $fonction = $info['FONCTION'];
  $pwduser   = $info['PWDUSER'];
  $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
  $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$NBRE_AP = $GET_NBRE_INSTANCE['NBRE_AP'];
$NBRE_DP = $GET_NBRE_INSTANCE['NBRE_DP'];
$NBRE_PB = $GET_NBRE_INSTANCE['NBRE_PB'];
$NBRE_RGS = $GET_NBRE_INSTANCE['NBRE_RGS'];
$NBRE_ARSA = $GET_NBRE_INSTANCE['NBRE_ARSA'];
$NBRE_COMM_OUVR = $GET_NBRE_INSTANCE['NBRE_COMM_OUVR'];
$NBRE_ARR_OUVR = $GET_NBRE_INSTANCE['NBRE_ARR_OUVR'];

$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM, 'NBRE_AP'=>$NBRE_AP, 'NBRE_DP'=>$NBRE_DP, 'NBRE_PB'=>$NBRE_PB, 'NBRE_RGS'=>$NBRE_RGS, 'NBRE_ARSA'=>$NBRE_ARSA, 'NBRE_COMM_OUVR'=>$NBRE_COMM_OUVR, 'NBRE_ARR_OUVR'=>$NBRE_ARR_OUVR];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);


$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $stat);



    $P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


    $LISTE_CCM_INSTANCE = $SignatureMod->LISTE_CCM_INSTANCE($this->oracle, $loginuser);
    $NBRE_CCM_INSTANCE = count($LISTE_CCM_INSTANCE);

    $LISTE_CCM_SIGNE = $SignatureMod->LISTE_CCM_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);
    $NBRE_CCM_SIGNE = count($LISTE_CCM_SIGNE);

      $datesInst  = $this->datesActes($LISTE_ACTES_INST,  'DATE_VALIDATION_DIRCAB');
      $datesSigne = $this->datesActes($LISTE_ACTES_SIGNE, 'DATE_SIGNATURE');

      // La fenêtre de 12 mois se termine au mois du dernier acte trouvé (ou ce mois-ci s'il n'y en a aucun)
      $tous = array_merge($datesInst, $datesSigne);
      $fin  = $tous ? max($tous)->copy()->startOfMonth() : Carbon::now()->startOfMonth();

      $mois = [];
      for ($i = 11; $i >= 0; $i--) {
         $d = $fin->copy()->subMonths($i);
         $mois[$d->format('Y-m')] = $d->format('m/Y');
      }

      $compter = function ($dates) use ($mois) {
         $c = array_fill_keys(array_keys($mois), 0);
         foreach ($dates as $d) {
            $k = $d->format('Y-m');
            if (isset($c[$k])) {
               $c[$k]++;
            }
         }
         return array_values($c);
      };

      $chartActes = [
         'labels'   => array_values($mois),
         'instance' => $compter($datesInst),
         'signe'    => $compter($datesSigne),
      ];

      $parNature = [];
      foreach ((array) $LISTE_ACTES_INST as $l) {
         $l = (array) $l;
         $n = (isset($l['NATURE_ACTE_LIB']) && $l['NATURE_ACTE_LIB'] !== '') ? $l['NATURE_ACTE_LIB'] : 'Non défini';
         $parNature[$n] = (isset($parNature[$n]) ? $parNature[$n] : 0) + 1;
      }
      arsort($parNature);

      $top    = array_slice($parNature, 0, 6, true);
      $autres = array_sum(array_slice($parNature, 6, null, true));
      if ($autres > 0) {
         $top['Autres'] = $autres;
      }

      $chartDonut = ['labels' => array_keys($top), 'data' => array_values($top)];

      $chartDfrc = $this->regrouper($LISTE_ACTES_INST, 'TYPECONC_LIB');

      return view('dashboard', compact(
         'info',
         'doc',
         'stat',
         'docsigne',
         'NBRE_CCM_INSTANCE',
         'NBRE_CCM_SIGNE',
         'chartActes',
         'chartDonut',
         'chartDfrc'
      ));      }

   private function parseDateActe($v)
   {
      $v = trim((string) $v);
      if ($v === '') {
         return null;
      }

      foreach (['Ymd', 'd-M-y', 'd/m/Y', 'Y-m-d'] as $format) {
         $d   = \DateTime::createFromFormat('!' . $format, $v);
         $err = \DateTime::getLastErrors();
         if ($d && (!$err || ($err['warning_count'] == 0 && $err['error_count'] == 0))) {
            return Carbon::instance($d);
         }
      }
      return null;
   }

   private function datesActes($liste, $colonne)
   {
      $dates = [];
      foreach ((array) $liste as $ligne) {
         $ligne = (array) $ligne;
         $d = $this->parseDateActe(isset($ligne[$colonne]) ? $ligne[$colonne] : '');
         if ($d) {
            $dates[] = $d;
         }
      }
      return $dates;
   }

   private function regrouper($liste, $colonne, $max = 6)
   {
      $groupes = [];
      foreach ((array) $liste as $l) {
         $l = (array) $l;
         $n = (isset($l[$colonne]) && $l[$colonne] !== '') ? $l[$colonne] : 'Non défini';
         $groupes[$n] = (isset($groupes[$n]) ? $groupes[$n] : 0) + 1;
      }
      arsort($groupes);

      $top    = array_slice($groupes, 0, $max, true);
      $autres = array_sum(array_slice($groupes, $max, null, true));
      if ($autres > 0) {
         $top['Autres'] = $autres;
      }

      return ['labels' => array_keys($top), 'data' => array_values($top)];
   }


 //DASHBOARD DE DAF##################################################################################


 public function  dashboard_min(Request $request)

 {

    
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

  $info      = session()->get('INFORMATION');
  $loginuser = $info['LOGINUSER'];
  $fonction = $info['FONCTION'];
  $pwduser   = $info['PWDUSER'];
  $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
  $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$NBRE_AP = $GET_NBRE_INSTANCE['NBRE_AP'];
$NBRE_DP = $GET_NBRE_INSTANCE['NBRE_DP'];
$NBRE_PB = $GET_NBRE_INSTANCE['NBRE_PB'];
$NBRE_RGS = $GET_NBRE_INSTANCE['NBRE_RGS'];
$NBRE_ARSA = $GET_NBRE_INSTANCE['NBRE_ARSA'];
$NBRE_COMM_OUVR = $GET_NBRE_INSTANCE['NBRE_COMM_OUVR'];
$NBRE_ARR_OUVR = $GET_NBRE_INSTANCE['NBRE_ARR_OUVR'];

$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM, 'NBRE_AP'=>$NBRE_AP, 'NBRE_DP'=>$NBRE_DP, 'NBRE_PB'=>$NBRE_PB, 'NBRE_RGS'=>$NBRE_RGS, 'NBRE_ARSA'=>$NBRE_ARSA, 'NBRE_COMM_OUVR'=>$NBRE_COMM_OUVR, 'NBRE_ARR_OUVR'=>$NBRE_ARR_OUVR];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);


$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $stat);




return view('dashboard_min', compact('info', 'doc', 'stat','docsigne'));
    
 }

 ####################################################################################################


 //DASHBOARD DE DAF##################################################################################


 public function  dashboard_daf(Request $request)

 {

    
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

  $info      = session()->get('INFORMATION');
  $loginuser = $info['LOGINUSER'];
  $fonction = $info['FONCTION'];
  $pwduser   = $info['PWDUSER'];
  $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
  $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$NBRE_AP = $GET_NBRE_INSTANCE['NBRE_AP'];
$NBRE_DP = $GET_NBRE_INSTANCE['NBRE_DP'];
$NBRE_PB = $GET_NBRE_INSTANCE['NBRE_PB'];
$NBRE_RGS = $GET_NBRE_INSTANCE['NBRE_RGS'];
$NBRE_ARSA = $GET_NBRE_INSTANCE['NBRE_ARSA'];
$NBRE_COMM_OUVR = $GET_NBRE_INSTANCE['NBRE_COMM_OUVR'];
$NBRE_ARR_OUVR = $GET_NBRE_INSTANCE['NBRE_ARR_OUVR'];

$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM, 'NBRE_AP'=>$NBRE_AP, 'NBRE_DP'=>$NBRE_DP, 'NBRE_PB'=>$NBRE_PB, 'NBRE_RGS'=>$NBRE_RGS, 'NBRE_ARSA'=>$NBRE_ARSA, 'NBRE_COMM_OUVR'=>$NBRE_COMM_OUVR, 'NBRE_ARR_OUVR'=>$NBRE_ARR_OUVR];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);


$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $stat);




return view('dashboard_daf', compact('info', 'doc', 'stat','docsigne'));
    
 }

 ####################################################################################################





 //DASHBOARD DE DGAPCE##################################################################################


 public function  dashboard_dgapce(Request $request)

 {

    
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

  $info      = session()->get('INFORMATION');
  $loginuser = $info['LOGINUSER'];
  $fonction = $info['FONCTION'];
  $pwduser   = $info['PWDUSER'];
  $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
  $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$NBRE_AP = $GET_NBRE_INSTANCE['NBRE_AP'];
$NBRE_DP = $GET_NBRE_INSTANCE['NBRE_DP'];
$NBRE_PB = $GET_NBRE_INSTANCE['NBRE_PB'];
$NBRE_RGS = $GET_NBRE_INSTANCE['NBRE_RGS'];
$NBRE_ARSA = $GET_NBRE_INSTANCE['NBRE_ARSA'];
$NBRE_COMM_OUVR = $GET_NBRE_INSTANCE['NBRE_COMM_OUVR'];
$NBRE_ARR_OUVR = $GET_NBRE_INSTANCE['NBRE_ARR_OUVR'];

$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM, 'NBRE_AP'=>$NBRE_AP, 'NBRE_DP'=>$NBRE_DP, 'NBRE_PB'=>$NBRE_PB, 'NBRE_RGS'=>$NBRE_RGS, 'NBRE_ARSA'=>$NBRE_ARSA, 'NBRE_COMM_OUVR'=>$NBRE_COMM_OUVR, 'NBRE_ARR_OUVR'=>$NBRE_ARR_OUVR];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);


$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $stat);




return view('dashboard_dgapce', compact('info', 'doc', 'stat','docsigne'));
    
 }

 ####################################################################################################




 //DASHBOARD DE CCM##################################################################################


 public function  dashboard_ccm(Request $request)

 {

    
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

  $info      = session()->get('INFORMATION');
  $loginuser = $info['LOGINUSER'];
  $fonction = $info['FONCTION'];
  $pwduser   = $info['PWDUSER'];
  $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
  $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$NBRE_AP = $GET_NBRE_INSTANCE['NBRE_AP'];
$NBRE_DP = $GET_NBRE_INSTANCE['NBRE_DP'];
$NBRE_PB = $GET_NBRE_INSTANCE['NBRE_PB'];
$NBRE_RGS = $GET_NBRE_INSTANCE['NBRE_RGS'];
$NBRE_ARSA = $GET_NBRE_INSTANCE['NBRE_ARSA'];
$NBRE_COMM_OUVR = $GET_NBRE_INSTANCE['NBRE_COMM_OUVR'];
$NBRE_ARR_OUVR = $GET_NBRE_INSTANCE['NBRE_ARR_OUVR'];

$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM, 'NBRE_AP'=>$NBRE_AP, 'NBRE_DP'=>$NBRE_DP, 'NBRE_PB'=>$NBRE_PB, 'NBRE_RGS'=>$NBRE_RGS, 'NBRE_ARSA'=>$NBRE_ARSA, 'NBRE_COMM_OUVR'=>$NBRE_COMM_OUVR, 'NBRE_ARR_OUVR'=>$NBRE_ARR_OUVR];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);


$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $stat);




return view('dashboard_ccm', compact('info', 'doc', 'stat','docsigne'));
    
 }

 ####################################################################################################

 
 //AFFICHAGE DE DOCUMENT EN INSTANCE DE SIGNATURE

 public function document($doc) {

    $idacte  = $doc;
    return view('doc.instance', compact('idacte'));
  
 }


  //AFFICHAGE DE DOCUMENT SIGNER

  public function documentsigner($doc) {

    $idacte  = $doc;
    return view('doc.signe', compact('idacte'));
  
 }




 public function  test(Request $request)
 {
      //dd(app()->version());

    $matricule = 'X505234';
    $password = 'Welcome1';

    try {
       


        if (!empty($matricule) && !empty($password))
        { 
            $conn = oci_connect($matricule, $password, '192.168.6.78/DBMFPE');
    
            if (!$conn) {
    
                $data_error=array('message_error' =>'Login ou mode passe incorrecte');
    
    
    
            }
            else{


                //CREATION DUNE SESSION 

               $session = session();
                $ses_data =array('LOGINUSER' =>$matricule, 'PWDUSER' =>$password,'logged_in' => TRUE);
                $session=($ses_data);

               // $value = session(['LOGINUSER' =>$matricule, 'PWDUSER' =>$password]);


                defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

                //$CsigneModel = new CsigneModel;
               $this->oracle = new PDO('oci:dbname='.TNSNAME,$session['LOGINUSER'],$session['PWDUSER']);
                $SignatureMod = new SignatureMod();
            //    $Mcfsigne =new Mcfsigne();

                    // fonction de l'utilisateur connecté
                    $USERFONCTION = $SignatureMod->USERFONCTION($matricule,$this->oracle);
                    // fin fonction

                    // nom et prenom de l'utilisateur connecté
                    $USERNAME = $SignatureMod->USERNAME($matricule,$this->oracle);
                    // fin nom et prenom
                    //email
                    $USERMAIL = $SignatureMod->USERMAIL($matricule,$this->oracle);
                    // fin email

                    //USERTEL
                    $USERTEL = $SignatureMod->USERTEL($matricule,$this->oracle);
                    // fin  USERTEL



                   
                        //  ESPACE MINISTRE

                    // NOMBRE DE NOMMINATION EN INSTANCE DE SIGNATURE
                    $NBRE_NOMIN_INST_MIN = $SignatureMod->NOMIN_INST_MIN($this->oracle);
                    // FIN NOMBRE DE NOMMINATION EN INSTANCE DE SIGNATURE

                    // NOMBRE DE PROMOTION EN INSTANCE DE SIGNATURE
                    $NBRE_PROM_INST_MIN = $SignatureMod->PROM_INST_MIN($this->oracle);
                    // FIN NOMBRE DE PROMOTION EN INSTANCE DE SIGNATURE

                    //FONCTION NOMBRE DACTE NOMINATION SIGNE PAR LA MINISTRE
                    $NBRE_NOMIN_SIGNE_MIN = $SignatureMod->NOMIN_SIGNE_MIN($this->oracle);
                    // FIN NOMBRE DACTE NOMINATION SIGNE PAR LA MINISTRE

                    //FONCTION NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE
                    $NBRE_PROM_SIGNE_MIN = $SignatureMod->PROM_SIGNE_MIN($this->oracle);
                    // FIN NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE


                    //FONCTION NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE
                    $LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle);
                    // FIN NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE
                    //var_dump($LISTE_ACTES_INST); die;

                    $data = array('USERFONCT' => $USERFONCTION, 'USERNAME' => $USERNAME, 'MAIL' => $USERMAIL, 'USERTEL' => $USERTEL,
                    'NBR_NOMI_INST_MIN' => $NBRE_NOMIN_INST_MIN, 'PROM_INST_MIN' => $NBRE_PROM_INST_MIN,
                    'NOMIN_SIGNE_MIN' => $NBRE_NOMIN_SIGNE_MIN, 'PROM_SIGNE_MIN' => $NBRE_PROM_SIGNE_MIN, 'LISTE_ACTES_INST' => $LISTE_ACTES_INST);

                  

                    


             

                $information = [ 'FONCTION'=>$USERFONCTION , 'NOM PRENOMS'=>$USERNAME, 'EMAIL'=>$USERMAIL, 'TELEPHONE'=>$USERTEL];


                $documents = [ 'FONCTION'=>$NBRE_NOMIN_INST_MIN , 'NOM PRENOMS'=>$NBRE_PROM_INST_MIN, 'EMAIL'=>$NBRE_NOMIN_SIGNE_MIN, 'TELEPHONE'=>$NBRE_PROM_SIGNE_MIN,  'TELEPHONE'=>$LISTE_ACTES_INST];

               // print_r($information); 
                
               // print_r($documents); 

               echo 'NOMINATION EN INSTANCE : '.$NBRE_NOMIN_INST_MIN.'</br>';
               echo 'NOMINATION  SIGNE : '.$NBRE_NOMIN_SIGNE_MIN.'</br>';

               echo 'PROMOTION EN INSTANCE : '.$NBRE_PROM_INST_MIN.'</br>';
               echo 'PROMOTION  SIGNE : '.$NBRE_PROM_SIGNE_MIN.'</br>';

               $documents = [ $LISTE_ACTES_INST];

               print_r($documents); 

               

            }
        }



    } catch (\Throwable $th) {
        echo 'erreur';
    }





 }


 public function instance (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $fonction = $info['FONCTION'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
    $NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
    $NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
    $NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
    $NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
    $stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];
    $LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
    $LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);


   


    $request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
    $doc = $request->session()->get('DOCUMENTS');

    return view('instance', compact('info', 'doc', 'stat','docsigne'));
 }

//**************************************STAT DES ACTES SIGNE********************************************************** */




public function  signe(Request $request)

{

   
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

 $info      = session()->get('INFORMATION');
 $loginuser = $info['LOGINUSER'];
 $fonction   = $info['FONCTION'];
 $pwduser   = $info['PWDUSER'];
 $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
 $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);




////////////////////////////////////////////////////////
$conn = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//callPromSigneMinFunction($conn);


$P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


//var_dump($P_DATE_FIN);  die;

$result = $SignatureMod->FN_REPORT_SIGN_NUM1($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);
$result_impact = $SignatureMod->FN_REPORT_SIGN_NUM_NEW($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);

//var_dump($result);  die;

////////////////////////////////////////////////////////////////////////////////

$stat = $result;
$stat_impact = $result_impact;
$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $result);
$request->session()->put('STAT_IMPACT', $result_impact);

$request->session()->put('P_DATE_DEBUT', $P_DATE_DEBUT);
$request->session()->put('P_DATE_FIN', $P_DATE_FIN);




return view('signe', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
   
}






public function  signe_min(Request $request)

{

   
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

 $info      = session()->get('INFORMATION');
 $loginuser = $info['LOGINUSER'];
 $fonction   = $info['FONCTION'];
 $pwduser   = $info['PWDUSER'];
 $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
 $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);




////////////////////////////////////////////////////////
$conn = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//callPromSigneMinFunction($conn);


$P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


//var_dump($P_DATE_FIN);  die;

$result = $SignatureMod->FN_REPORT_SIGN_NUM1($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);
$result_impact = $SignatureMod->FN_REPORT_SIGN_NUM_NEW($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);

//var_dump($result);  die;

////////////////////////////////////////////////////////////////////////////////

$stat = $result;
$stat_impact = $result_impact;
$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $result);
$request->session()->put('STAT_IMPACT', $result_impact);

$request->session()->put('P_DATE_DEBUT', $P_DATE_DEBUT);
$request->session()->put('P_DATE_FIN', $P_DATE_FIN);




return view('signe_min', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
   
}




public function  signe_daf(Request $request)

{

   
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

 $info      = session()->get('INFORMATION');
 $loginuser = $info['LOGINUSER'];
 $fonction   = $info['FONCTION'];
 $pwduser   = $info['PWDUSER'];
 $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
 $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);




////////////////////////////////////////////////////////
$conn = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//callPromSigneMinFunction($conn);


$P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


//var_dump($P_DATE_FIN);  die;

$result = $SignatureMod->FN_REPORT_SIGN_NUM1($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);
$result_impact = $SignatureMod->FN_REPORT_SIGN_NUM_NEW($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);

//var_dump($result);  die;

////////////////////////////////////////////////////////////////////////////////

$stat = $result;
$stat_impact = $result_impact;
$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $result);
$request->session()->put('STAT_IMPACT', $result_impact);

$request->session()->put('P_DATE_DEBUT', $P_DATE_DEBUT);
$request->session()->put('P_DATE_FIN', $P_DATE_FIN);




return view('signe_daf', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
   
}



public function  signe_dgapce(Request $request)

{

   
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

 $info      = session()->get('INFORMATION');
 $loginuser = $info['LOGINUSER'];
 $fonction   = $info['FONCTION'];
 $pwduser   = $info['PWDUSER'];
 $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
 $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);




////////////////////////////////////////////////////////
$conn = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//callPromSigneMinFunction($conn);


$P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


//var_dump($P_DATE_FIN);  die;

$result = $SignatureMod->FN_REPORT_SIGN_NUM1($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);
$result_impact = $SignatureMod->FN_REPORT_SIGN_NUM_NEW($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);

//var_dump($result);  die;

////////////////////////////////////////////////////////////////////////////////

$stat = $result;
$stat_impact = $result_impact;
$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $result);
$request->session()->put('STAT_IMPACT', $result_impact);

$request->session()->put('P_DATE_DEBUT', $P_DATE_DEBUT);
$request->session()->put('P_DATE_FIN', $P_DATE_FIN);




return view('signe_dgapce', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
   
}







public function  signe_ccm(Request $request)

{

   
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

 $info      = session()->get('INFORMATION');
 $loginuser = $info['LOGINUSER'];
 $fonction   = $info['FONCTION'];
 $pwduser   = $info['PWDUSER'];
 $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
 $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);




////////////////////////////////////////////////////////
$conn = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//callPromSigneMinFunction($conn);


$P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


//var_dump($P_DATE_FIN);  die;

$result = $SignatureMod->FN_REPORT_SIGN_NUM1($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);
$result_impact = $SignatureMod->FN_REPORT_SIGN_NUM_NEW($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);

//var_dump($result);  die;

////////////////////////////////////////////////////////////////////////////////

$stat = $result;
$stat_impact = $result_impact;
$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $result);
$request->session()->put('STAT_IMPACT', $result_impact);

$request->session()->put('P_DATE_DEBUT', $P_DATE_DEBUT);
$request->session()->put('P_DATE_FIN', $P_DATE_FIN);




return view('signe_ccm', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
   
}






public function  filter_ccm(Request $request)

{

   
$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');
$docsigne = $request->session()->get('DOCUMENTSSIGNES');

//CONNEXION ET UPDATE SUR LA TABLE
defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

 $info      = session()->get('INFORMATION');
 $loginuser = $info['LOGINUSER'];
 $fonction   = $info['FONCTION'];
 $pwduser   = $info['PWDUSER'];
 $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
 $SignatureMod    = new SignatureMod();

$GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);




////////////////////////////////////////////////////////
$conn = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//callPromSigneMinFunction($conn);


$P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


//var_dump($P_DATE_FIN);  die;

$result = $SignatureMod->FN_REPORT_SIGN_NUM1($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);
$result_impact = $SignatureMod->FN_REPORT_SIGN_NUM_NEW($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);

//var_dump($result);  die;

////////////////////////////////////////////////////////////////////////////////

$stat = $result;
$stat_impact = $result_impact;
$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $result);
$request->session()->put('STAT_IMPACT', $result_impact);

$request->session()->put('P_DATE_DEBUT', $P_DATE_DEBUT);
$request->session()->put('P_DATE_FIN', $P_DATE_FIN);


   $LISTE_CCM_INSTANCE = $SignatureMod->LISTE_CCM_INSTANCE($this->oracle, $loginuser);
    $NBRE_CCM_INSTANCE = count($LISTE_CCM_INSTANCE);

    $LISTE_CCM_SIGNE = $SignatureMod->LISTE_CCM_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);
    $NBRE_CCM_SIGNE = count($LISTE_CCM_SIGNE);




return view('signe_ccm', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN','NBRE_CCM_INSTANCE','NBRE_CCM_SIGNE'));
   
}



public function filter(Request $request)
{


   
   $info      = session()->get('INFORMATION');
   $loginuser = $info['LOGINUSER'];
   $pwduser   = $info['PWDUSER'];
   defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');
   $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
   $SignatureMod    = new SignatureMod();
   $conn = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   

    $P_ETAT = '00010';
    $P_DATE_DEBUT1 = $request->input('P_DATE_DEBUT1');
    $P_DATE_FIN1 = $request->input('P_DATE_FIN1');



    if (empty($P_DATE_DEBUT1)) { $P_DATE_DEBUT1 = '2023-06-19'; }


  if (empty($P_DATE_FIN1)) { $P_DATE_FIN1 = '3000-01-01'; }

    

    $format = 'Y-m-d';
    $P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
    $P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');
    
    $P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
    $P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');

   // var_dump($P_DATE_DEBUT , $P_DATE_FIN); die;

    $result = $SignatureMod->FN_REPORT_SIGN_NUM1($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);
    $result_impact = $SignatureMod->FN_REPORT_SIGN_NUM_NEW($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);

    // Vous pouvez maintenant utiliser $heureDebut et $heureFin pour les afficher sur la page ou effectuer toute autre logique souhaitée.
    // Par exemple, vous pouvez les transmettre à la vue et les afficher dans le formulaire ou dans une autre partie de la page.

    // Exemple pour les renvoyer à la même vue :


    $request->session()->put('STAT', $result);
    $request->session()->put('STAT_IMPACT', $result_impact);
    $request->session()->put('P_DATE_DEBUT', $P_DATE_DEBUT);
    $request->session()->put('P_DATE_FIN', $P_DATE_FIN);
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');



     
   return view('signe', compact('info', 'stat', 'stat_impact', 'P_DATE_DEBUT', 'P_DATE_FIN'));
}


















 ///***********************LISTE DE TOUS LES  ACTES SIGNES*********************************************** */
 public function tous_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
     $fonction = $info['FONCTION'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,'X505234','Welcome1');
    $SignatureMod    = new SignatureMod();

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

    return view('tous_signe', compact('info', 'doc', 'stat','docsigne'));
 }


/////////////////////////////LES ACTES SIGNE/////////////////////////////////////////

 public function fin_formation_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_FIN_FORMATION_DATE_SIGNE = $SignatureMod->LISTE_FIN_FORMATION_DATE_SIGNE($this->oracle, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_FIN_FORMATION_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');


   


   if ($loginuser != 'X505234' ) { return view('liste_actes_signe_min', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}
     //if ($loginuser != 'J435402' ) { return view('liste_actes_signe_daf', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN')); }
     //if ($loginuser != 'X477231' ) { return view('liste_actes_signe_dgapce', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }




 public function mise_formation_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_MISE_FORMATION_DATE_SIGNE = $SignatureMod->LISTE_MISE_FORMATION_DATE_SIGNE($this->oracle, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_MISE_FORMATION_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;

    if ($loginuser != 'X505234' ) { return view('liste_actes_signe_min', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }




 public function communique_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);


    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_COMMUNIQUE_DATE_SIGNE = $SignatureMod->LISTE_COMMUNIQUE_DATE_SIGNE($this->oracle, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_COMMUNIQUE_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');

  

    

    if ($loginuser != 'X505234' ) { return view('liste_actes_signe_min', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact', 'docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }



 public function arrete_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_ARRETE_ADMISSION_DATE_SIGNE = $SignatureMod->LISTE_ARRETE_ADMISSION_DATE_SIGNE($this->oracle, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_ARRETE_ADMISSION_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;

    if ($loginuser != 'X505234' ) { return view('liste_actes_signe_min', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact', 'docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }








 public function comm_ouv_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_COMM_OUVERTURE_DATE_SIGNE = $SignatureMod->LISTE_COMM_OUVERTURE_DATE_SIGNE($this->oracle, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_COMM_OUVERTURE_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;

    if ($loginuser != 'X505234' ) { return view('liste_actes_signe_min', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }







  public function arrete_ouv_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_ARRETE_OUVERTURE_DATE_SIGNE = $SignatureMod->LISTE_ARRETE_OUVERTURE_DATE_SIGNE($this->oracle, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_ARRETE_OUVERTURE_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;

    if ($loginuser != 'X505234' ) { return view('liste_actes_signe_min', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact', 'docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }







 public function pret_bancair_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_PRET_BANCAIR_DATE_SIGNE = $SignatureMod->LISTE_PRET_BANCAIR_DATE_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_PRET_BANCAIR_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;


     if ($loginuser != 'X477231' ) { return view('liste_actes_signe_dgapce', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact', 'docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }


 public function rgs_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_RGS_DATE_SIGNE = $SignatureMod->LISTE_RGS_DATE_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_RGS_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;


     if ($loginuser != 'X477231' ) { return view('liste_actes_signe_dgapce', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }


 public function arsa_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_ARSA_DATE_SIGNE = $SignatureMod->LISTE_ARSA_DATE_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_ARSA_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;


     if ($loginuser != 'X477231' ) { return view('liste_actes_signe_dgapce', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));}

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact', 'docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }


 public function att_prime_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_ATT_PRIME_DATE_SIGNE = $SignatureMod->LISTE_ATT_PRIME_DATE_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_ATT_PRIME_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;

      if ($loginuser != 'J435402' ) { return view('liste_actes_signe_daf', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN')); }

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }


 public function dom_prime_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');
   
    $LISTE_DOM_PRIME_DATE_SIGNE = $SignatureMod->LISTE_DOM_PRIME_DATE_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);


    $request->session()->put('DOCUMENTS', $LISTE_DOM_PRIME_DATE_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');



   // var_dump($stat); die;

      if ($loginuser != 'J435402' ) { return view('liste_actes_signe_daf', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN')); }

    return view('liste_actes_signe', compact('info', 'doc', 'stat', 'stat_impact','docsigne', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }


/////////////////////////////////////////////////////////////////////////////////








////////////////////////////LES ACTES EN INSTANCE DE SIGNATURES /////////////////////////////////////////////////

 public function fin_formation (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_FIN_FORMATION_INSTANCE = $SignatureMod->LISTE_FIN_FORMATION_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_FIN_FORMATION_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

     if ($loginuser != 'X505234') { return view('liste_actes_min', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }




 public function mise_formation (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_MISE_FORMATION_INSTANCE = $SignatureMod->LISTE_MISE_FORMATION_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_MISE_FORMATION_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

     if ($loginuser != 'X505234') { return view('liste_actes_min', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }




 public function communique (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_COMMUNIQUE_INSTANCE = $SignatureMod->LISTE_COMMUNIQUE_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_COMMUNIQUE_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

     if ($loginuser != 'X505234') { return view('liste_actes_min', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }



 public function arrete (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_ARRETE_ADMISSION_INSTANCE = $SignatureMod->LISTE_ARRETE_ADMISSION_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_ARRETE_ADMISSION_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

     if ($loginuser != 'X505234') { return view('liste_actes_min', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }



  public function comm_ouv (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_COMM_OUVERTURE_INSTANCE = $SignatureMod->LISTE_COMM_OUVERTURE_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_COMM_OUVERTURE_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

     if ($loginuser != 'X505234') { return view('liste_actes_min', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }



  public function arrete_ouv (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_ARRETE_OUVERTURE_INSTANCE = $SignatureMod->LISTE_ARRETE_OUVERTURE_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_ARRETE_OUVERTURE_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

    if ($loginuser != 'X505234') { return view('liste_actes_min', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }




  public function pret_banc (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_PRET_BANCAIR_INSTANCE = $SignatureMod->LISTE_PRET_BANCAIR_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_PRET_BANCAIR_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

    if ($loginuser != 'X477231') { return view('liste_actes_dgapce', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }


   public function att_prime (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_ATT_PRIME_INSTANCE = $SignatureMod->LISTE_ATT_PRIME_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_ATT_PRIME_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

    if ($loginuser != 'J435402') { return view('liste_actes_daf', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }



  public function dom_prime (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_DOM_PRIME_INSTANCE = $SignatureMod->LISTE_DOM_PRIME_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_DOM_PRIME_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

    if ($loginuser != 'J435402') { return view('liste_actes_daf', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }


  public function rgs (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_RGS_INSTANCE = $SignatureMod->LISTE_RGS_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_RGS_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

   if ($loginuser != 'X477231') { return view('liste_actes_dgapce', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }


  public function arsa (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $LISTE_ARSA_INSTANCE = $SignatureMod->LISTE_ARSA_INSTANCE($this->oracle, $loginuser);


    $request->session()->put('DOCUMENTS', $LISTE_ARSA_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');

if ($loginuser != 'X477231') { return view('liste_actes_dgapce', compact('info', 'doc', 'stat','docsigne')); }

    return view('liste_actes', compact('info', 'doc', 'stat','docsigne'));
 }





   public function ccm_instance (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION'); 
    $fonction = $info['FONCTION'];
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   

   $P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


    $LISTE_CCM_INSTANCE = $SignatureMod->LISTE_CCM_INSTANCE($this->oracle, $loginuser);
    $NBRE_CCM_INSTANCE = count($LISTE_CCM_INSTANCE);

    $LISTE_CCM_SIGNE = $SignatureMod->LISTE_CCM_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);
    $NBRE_CCM_SIGNE = count($LISTE_CCM_SIGNE);





    $request->session()->put('DOCUMENTS', $LISTE_CCM_INSTANCE);
    $doc = $request->session()->get('DOCUMENTS');



    return view('liste_actes_ccm', compact('info', 'doc', 'stat','docsigne', 'NBRE_CCM_INSTANCE' , 'NBRE_CCM_SIGNE'));
 }



    public function ccm_signe (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION'); 
    $fonction = $info['FONCTION'];
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   


    $P_DATE_DEBUT = $request->session()->get('P_DATE_DEBUT');
    $P_DATE_FIN  = $request->session()->get('P_DATE_FIN');
    $stat = $request->session()->get('STAT');
    $stat_impact = $request->session()->get('STAT_IMPACT');

    $LISTE_CCM_INSTANCE = $SignatureMod->LISTE_CCM_INSTANCE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);
    $NBRE_CCM_INSTANCE = count($LISTE_CCM_INSTANCE);

    $LISTE_CCM_SIGNE = $SignatureMod->LISTE_CCM_SIGNE($this->oracle, $loginuser, $P_DATE_DEBUT, $P_DATE_FIN);
    $NBRE_CCM_SIGNE = count($LISTE_CCM_SIGNE);

    $request->session()->put('DOCUMENTS', $LISTE_CCM_SIGNE);
    $doc = $request->session()->get('DOCUMENTS');






$NBRE_MF = $GET_NBRE_INSTANCE['NBRE_MF'];
$NBRE_FF = $GET_NBRE_INSTANCE['NBRE_FF'];
$NBRE_ARR_ADM = $GET_NBRE_INSTANCE['NBRE_ARR_ADM'];
$NBRE_COMM = $GET_NBRE_INSTANCE['NBRE_COMM'];
$stat = [ 'NBRE_MF'=>$NBRE_MF , 'NBRE_FF'=>$NBRE_FF, 'NBRE_ARR_ADM'=>$NBRE_ARR_ADM, 'NBRE_COMM'=>$NBRE_COMM];
$LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle, $loginuser, $fonction);
$LISTE_ACTES_SIGNE = $SignatureMod->LISTE_ACTES_SIGNE($this->oracle, $loginuser, $fonction);




$conn = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//callPromSigneMinFunction($conn);


$P_ETAT = '00010';
$P_DATE_DEBUT1 = '19/06/2023';
$P_DATE_FIN1 = '01/01/3000';

$format = 'd/m/Y';
$P_DATE_DEBUT = Carbon::createFromFormat($format, $P_DATE_DEBUT1);
$P_DATE_DEBUT = $P_DATE_DEBUT->format('d/m/Y');

$P_DATE_FIN = Carbon::createFromFormat($format, $P_DATE_FIN1);
$P_DATE_FIN = $P_DATE_FIN->format('d/m/Y');


//var_dump($P_DATE_FIN);  die;

$result = $SignatureMod->FN_REPORT_SIGN_NUM1($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);
$result_impact = $SignatureMod->FN_REPORT_SIGN_NUM_NEW($this->oracle, $P_ETAT, $P_DATE_DEBUT, $P_DATE_FIN);

//var_dump($result);  die;

////////////////////////////////////////////////////////////////////////////////

$stat = $result;
$stat_impact = $result_impact;
$request->session()->put('DOCUMENTS', $LISTE_ACTES_INST);
$request->session()->put('DOCUMENTSSIGNES', $LISTE_ACTES_SIGNE);
$request->session()->put('STAT', $result);
$request->session()->put('STAT_IMPACT', $result_impact);

$request->session()->put('P_DATE_DEBUT', $P_DATE_DEBUT);
$request->session()->put('P_DATE_FIN', $P_DATE_FIN);






    return view('liste_actes_signe_ccm', compact('info', 'doc', 'stat','docsigne', 'stat_impact', 'NBRE_CCM_INSTANCE', 'NBRE_CCM_SIGNE', 'P_DATE_DEBUT', 'P_DATE_FIN'));
 }



















 public function test_ccm (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $fonction = $info['FONCTION'];
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $TEST_CCM1 = $SignatureMod->TEST_CCM1($this->oracle, $loginuser);
    $TEST_CCM = $SignatureMod->TEST_CCM($this->oracle, $loginuser);

//var_dump($TEST_CCM ); die;

    $request->session()->put('DOCUMENTS', $TEST_CCM);
    $doc = $request->session()->get('DOCUMENTS');

    $request->session()->put('DOCUMENTS1', $TEST_CCM1);
    $doc1 = $request->session()->get('DOCUMENTS1');


//var_dump($TEST_CCM); die;


if ($fonction != 'MINISTRE')  { return view('liste_actes_ccm', compact('info', 'doc', 'doc1', 'stat','docsigne')); }

    return view('test_ccm', compact('info', 'doc', 'doc1', 'stat','docsigne'));
 }



/////////////////////////////////////////////////////////////////////////////////






public function TMP_RCANDEMPSTRUCT (Request $request) {
    $info = $request->session()->get('INFORMATION');
    $doc = $request->session()->get('DOCUMENTS');
    $stat = $request->session()->get('STAT');
    $docsigne = $request->session()->get('DOCUMENTSSIGNES');

    //CONNEXION ET UPDATE SUR LA TABLE
    defined('TNSNAME')  OR  define('TNSNAME','(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.6.78)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBMFPE)))');

    $info      = session()->get('INFORMATION');
    $fonction = $info['FONCTION'];
    $loginuser = $info['LOGINUSER'];
    $pwduser   = $info['PWDUSER'];
    $this->oracle = new PDO('oci:dbname='.TNSNAME,$loginuser,$pwduser);
    $SignatureMod    = new SignatureMod();

    $GET_NBRE_INSTANCE =  $SignatureMod->FN_SE_GET_NBRE_INSTANCE($loginuser,$this->oracle);
   
    $TEST_CCM1 = $SignatureMod->TEST_CCM1($this->oracle, $loginuser);
    $TEST_CCM = $SignatureMod->TEST_CCM($this->oracle, $loginuser);
    $TMP_RCANDEMPSTRUCT = $SignatureMod->TMP_RCANDEMPSTRUCT($this->oracle, $loginuser);

//var_dump($TEST_CCM ); die;

    $request->session()->put('DOCUMENTS', $TEST_CCM);
    $doc = $request->session()->get('DOCUMENTS');

    $request->session()->put('DOCUMENTS1', $TEST_CCM1);
    $doc1 = $request->session()->get('DOCUMENTS1');


    $request->session()->put('TMP_RCANDEMPSTRUCT', $TMP_RCANDEMPSTRUCT);
    $doc_TMP_RCANDEMPSTRUCT = $request->session()->get('TMP_RCANDEMPSTRUCT');


//var_dump($doc_TMP_RCANDEMPSTRUCT); die;


if ($fonction != 'MINISTRE')  { return view('liste_actes_ccm', compact('info', 'doc', 'doc1', 'doc_TMP_RCANDEMPSTRUCT', 'stat','docsigne')); }

    return view('TMP_RCANDEMPSTRUCT', compact('info', 'doc', 'doc1', 'doc_TMP_RCANDEMPSTRUCT', 'stat','docsigne'));
 }




}
