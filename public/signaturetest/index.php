<?php

//creer parapheur
$curl = curl_init();

define ('SUNNYSTAMP_API_URI', 'https://sigfae-test.artci-sign.ci/api/');
define ('BEARER_API', 'Bearer act_5qgw9mF7iPZzcCu22yLDix4E.2ieLW6Tc3Yx9DLPetK3moWiVBDFfRX8NJBNUuUZx4gphQUFU3d7HRpQ7CHW681BU');
define ('COPID_API', 'cop_7pFnUCqhVfj7hgtWLmieBL9q');
//$copId = COPID_API;
$nomparapheur= "testAPIFINAL";
$mailcreator= "e-parapheur@egouv.ci";
$mailsign= "e-parapheur@egouv.ci";

$SIGNATURE =call_ws($nomparapheur, $mailcreator, $mailsign);

# Appel de Sunnystamp API



function call_ws($nomparapheur, $mailcreator, $mailsign)
{

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
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: '.BEARER_API
  ),
));

$responseuser = curl_exec($curluser);

$datauser = json_decode(curl_exec($curluser), true);
//if($datauser){
$creatorid = $datauser['items'][0]['id'];
//echo $creatorid;
//}
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
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: '.BEARER_API
  ),
));

$responssign = curl_exec($curlsign);

$datasign = json_decode(curl_exec($curlsign), true);
if($datasign){
$signid = $datasign['items'][0]['id'];
}
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
  CURLOPT_SSL_VERIFYPEER => false,
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
if($datauser){
//echo $response;
$wkflowid = $data['id'];
}

#CREER LE REFERENCEMENT DU DOCUMENT DANS WORKFLOW MANAGER


$uploadFile= 'Accordautorisationemp_7_16032021.pdf';
$filePath = getcwd()."/".$uploadFile;
$postData= array('pdf'=> new CURLFile($filePath,'application/pdf',basename($filePath)));

$curlpart = curl_init();

curl_setopt_array($curlpart, array(

  CURLOPT_URL => SUNNYSTAMP_API_URI.'workflows/'.$wkflowid.'/parts',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $postData,
  
  CURLOPT_HTTPHEADER => array(

    'Authorization: '.BEARER_API,

  ),

));

$responsepart = curl_exec($curlpart);
$err = curl_error($curlpart);
curl_close($curlpart);
$datapart = json_decode($responsepart, true);


$partname = $datapart['parts'][0]['filename'];
$parttype = $datapart['parts'][0]['contentType'];
$partsize = $datapart['parts'][0]['size'];
$parthash = $datapart['parts'][0]['hash'];

#LIER LE DOCUMENT AU WORKFLOW
$curldoc = curl_init();

curl_setopt_array($curldoc, array(
  CURLOPT_URL => SUNNYSTAMP_API_URI.'workflows/'.$wkflowid.'/documents',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_SSL_VERIFYPEER => false,
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
  CURLOPT_SSL_VERIFYPEER => false,
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
  CURLOPT_SSL_VERIFYPEER => false,
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

echo $SIGNATURE
?>


<a href="<?php echo $SIGNATURE; ?>" target="popup" onclick="window.open('<?php echo $SIGNATURE; ?>', 'popup', 'width=900px,height=500px,top=20px,left=20px'); return false;">SIGNER</a
