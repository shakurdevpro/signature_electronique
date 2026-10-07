<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiSign extends Controller
{
  public function apiSign(){


   

        
  }  
   


  public function getSignateur($email){

    define ('SUNNYSTAMP_API_URI', 'https://sigfae-test.artci-sign.ci/api/');

    define ('BEARER_API', 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU');

    define ('COPID_API', 'cop_7pFnUCqhVfj7hgtWLmieBL9q');

    define ('ID_CREATEUR', 'usr_L7LQAhzKqVdnHzo83uAaZ65B');

 
   echo 'start';
    $idSignataire ="";
    $curlgetSignateur = curl_init();
    //$curlgetSignateur ="Resource id #3";

    if (\is_resource($curlgetSignateur)) {
        var_dump($curlgetSignateur);
        die;
    } 

      curl_setopt_array($curlgetSignateur , array(
      CURLOPT_URL => SUNNYSTAMP_API_URI.'users?items.email='.$email,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: '.BEARER_API
      ),
    ));
    
    $responsUser = curl_exec($curlgetSignateur );
    $err = curl_error($curlgetSignateur);
    curl_close($curlgetSignateur);

    $dataUser = json_decode(curl_exec($curlgetSignateur ), true);

    print_r($dataUser);
    print_r($err);
    $idSignataire = $dataUser['items'][0]['id'];
    
    

    return $idSignataire;
    
    }
}
