 <!-- Add New Address Modal -->
<?php 
        $document = $_GET['id_document'] ;
        echo $document ;



//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
        $source= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/A SIGNER/'.$document;
        //$source= $document;
        // Définir le chemin de destination pour le fichier
        $destination = '../../../public/ficheTemp/DOCTEMP_VUE.PDF';
        // Définir le nom de fichier à utiliser
        copy($source,  $destination);
//************************************************************************** */

?>
                              

<embed src="ficheTemp/DOCTEMP_VUE.PDF" width=100% height=700px type='application/pdf'/>
                             
                      <!--/ Add New Address Modal -->


