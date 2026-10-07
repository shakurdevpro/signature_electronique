 <!-- Add New Address Modal -->
<?php 
        $document = $idacte;
        //echo $document ;



//***************************COPIER LE FICHIER DANS LE DOSSIER PUBLIC POUR TRAITEMENT****************************** */
 
        $source= '//mnt/DATEDRV/ACTESIGNE_TEST/'.$document;
        $source = public_path('DOSSIER_SAVE/ACTESIGNE_TEST/'.$document);//REPERTOIRE A SUPPRIMER
       // $source1= '\\\192.168.6.12/sigfae_test/DOSSIER_SAVE/ACTESIGNE_TEST/'.$document;
        $destination = 'DOCTEMP_VUE.PDF';

        if (file_exists($source)) { 
               
               if( copy($source,  $destination)){  ?>

                <center class="doc"><?= substr($document,0,-4) ?></center>
                <embed src='DOCTEMP_VUE.PDF' width=100% height=700px type='application/pdf'/>



        <?php } else{ ?>


                        <center>
                        <div class="alert alert-danger  align-items-center" role="alert" id="animation1"  >
                                <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                OUVERTURE DU . . .
                        </div>
                        </center>
        <?php } }  else{ ?>


                <center>
                <div class="alert alert-danger  align-items-center" role="alert" id="animation1"  >
                        <span class="ti ti-ban ti-xs" role="status" aria-hidden="true"></span>
                        AUCUN DOCUMENT TROUVE
                </div>
                </center>


<?php  } ?>
        
                 
<style>
.doc{
        background-color: black;
        color: white;
        font-size: 30px;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif
}
</style>