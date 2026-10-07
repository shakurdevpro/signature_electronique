<?php

namespace App\Http\Controllers;
use App\Models\SignatureMod;
use PhpParser\Node\Stmt\TryCatch;
use PDO;
use Session;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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
                 $LISTE_ACTES_INST = $SignatureMod->LISTE_ACTES_INST($this->oracle);
                 // FIN NOMBRE DACTE PROMOTION SIGNE PAR LA MINISTRE
                 //var_dump($LISTE_ACTES_INST); die;

                 $data = array('USERFONCT' => $USERFONCTION, 'USERNAME' => $USERNAME, 'MAIL' => $USERMAIL, 'USERTEL' => $USERTEL,
                 'NBR_NOMI_INST_MIN' => $NBRE_NOMIN_INST_MIN, 'PROM_INST_MIN' => $NBRE_PROM_INST_MIN,
                 'NOMIN_SIGNE_MIN' => $NBRE_NOMIN_SIGNE_MIN, 'PROM_SIGNE_MIN' => $NBRE_PROM_SIGNE_MIN, 'LISTE_ACTES_INST' => $LISTE_ACTES_INST);


                

      
            $information = [ 'FONCTION'=>$USERFONCTION , 'NOM PRENOMS'=>$USERNAME, 'EMAIL'=>$USERMAIL, 'TELEPHONE'=>$USERTEL,'LOGINUSER' =>$matricule, 'PWDUSER' =>$password,'logged_in' => TRUE];
            $stat = [ 'NBRE_NOMIN_INST_MIN'=>$NBRE_NOMIN_INST_MIN , 'NBRE_PROM_INST_MIN'=>$NBRE_PROM_INST_MIN, 'NBRE_NOMIN_SIGNE_MIN'=>$NBRE_NOMIN_SIGNE_MIN, 'NBRE_PROM_SIGNE_MIN'=>$NBRE_PROM_SIGNE_MIN];
            
           // print_r($information);    
            $request->session()->put(['INFORMATION'=>$information, 'STAT'=>$stat, 'DOCUMENTS'=>$LISTE_ACTES_INST]);
            
            

       
          return redirect('/accueil');


            
        }
    }



} catch (\Throwable $th) {
    echo 'erreur  de connexion';

}


 }



//DECONNEXION 


public function destroy(Request $request)
{

   
    $request->session()->forget(['INFORMATION', 'STAT', 'DOCUMENTS']);
    $request->session()->flush();

    return redirect('/login');
}




 public function  dashboard(Request $request)

 {


$info = $request->session()->get('INFORMATION');
$doc = $request->session()->get('DOCUMENTS');
$stat = $request->session()->get('STAT');

return view('dashboard', compact('info', 'doc', 'stat'));

    
 }








 public function  test(Request $request)
 {


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

                  

                    


             //  var_dump($USERFONCTION , $USERNAME, $USERMAIL, $USERTEL );
              //  die;

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


}
