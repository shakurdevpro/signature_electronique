@extends('layouts.base_new')
@section('content')
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar ">
    <div class="layout-container">

        <!-- Menu -->
        @include('incs.menu_new')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('incs.header_new')
            <!-- / Navbar -->
    
            <!-- Content wrapper -->
            <div class="content-wrapper">
            <!-- Content -->



            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <h5 class="card-header"><center>Filtrer par date</center></h5>
                    <div class="card-body">
                      <form action="{{ route('signe') }}" method="POST">
                        @csrf
                      <div class="row">
                        <div class="col-md-6 col-12 mb-md-0 mb-4">
                          <label for="P_DATE_DEBUT1" class="form-label">Du <b style="color: red"> <?php if ($P_DATE_DEBUT == '19/06/2023') { echo 'LANCEMENT DE LA SIGNATURE ELECTRONIQUE';} else {echo $P_DATE_DEBUT;} ?> </b></label>
                          <input type="date" id="P_DATE_DEBUT1" name="P_DATE_DEBUT1" placeholder="HH:MMam" class="form-control ui-timepicker-input" autocomplete="off">
                        </div>
                        <div class="col-md-6 col-12">
                          <label for="P_DATE_FIN1" class="form-label">Jusqu'à <b style="color: red"> <?php if ($P_DATE_FIN == '01/01/3000') {echo 'HIER';} else {echo $P_DATE_FIN;}?> </b></label>
                          <input type="date" id="P_DATE_FIN1" name="P_DATE_FIN1" placeholder="20:00:00" class="form-control ui-timepicker-input" autocomplete="off">
                        </div>

                        <div class="text-center mt-4">
                          <input type="submit" id="filter" name="filter" class="btn btn-primary waves-effect waves-light" style="background-color: orange" value="Filter">
                        </div>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
                <!-- /Color Picker-->
              </div>
            </div>







                <div class="container-xxl flex-grow-1 container-p-y">    

                


                    <!-- ######################################################## DGAPCE ############################################## -->

<?php  if ($info['FONCTION']=='MINISTRE' OR  $info['LOGINUSER']== 'X477231' OR $info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>  
<br>              
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> DGAPCE</a>
 <br>
 <?php } ?>

                <?php if ($info['LOGINUSER']== 'X477231' OR $info['FONCTION']=='MINISTRE' OR $info['LOGINUSER'] == 'Z444473'  OR $info['LOGINUSER']== 'T279354') { ?>             
                    <div class="row">
                      @php 
                      
                      $array = explode('|', $stat);

                      // Supprimer les espaces vides au début et à la fin de chaque élément du tableau
                      $array = array_map('trim', $array);

                      // Afficher le résultat
                      
                $NBRE_MF=$array[1];
                $NBRE_FF=$array[2];
                $NBRE_COMM=$array[3];
                $NBRE_ARR_ADM=$array[4];
                $NBRE_AP=$array[5];
                $NBRE_DP=$array[6];
                $NBRE_PB=$array[7];
                $NBRE_RGS=$array[8];
                $NBRE_ARSA=$array[9];
                
                @endphp
                      
                     <!-- Cards with few info -->
                     
                     <div class="col-lg-4 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                               <h5 class="m-0 me-2">Prêt bancaire</h5>
                               <hr>


                               <h6 class="mb-0">{{$NBRE_PB}} Acte(s) signé(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-primary rounded-pill p-2">
                               <i class='ti ti-files ti-sm'></i>
                             </span>
                           </div>
                         </div>
                         <a href="{{route('pret_bancair_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                     <div class="col-lg-4 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">RGS</h5>
                             <hr>
                             <h6 class="mb-0">{{$NBRE_RGS}} Acte(s) signé(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-success rounded-pill p-2">
                               <i class='ti ti-book ti-sm'></i>
                             </span>
                           </div>
                         </div>
                         <a href="{{route('rgs_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                     <div class="col-lg-4 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">ARSA</h5>
                             <hr>
                             <h6 class="mb-0">{{$NBRE_ARSA}} Acte(s) signé(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-danger rounded-pill p-2">
                               <i class='ti ti-file ti-sm'></i>
                             </span>
                           </div>
                         </div>
                         <a href="{{route('arsa_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                     
                    </div>

                    <?php } ?> 
                    <!-- ######################################################## FIN DGAPCE ############################################## -->


                   
                </div>
                <!-- / Content -->
    



<div class="content-wrapper">
  <!-- Content -->
      <div class="container-xxl flex-grow-1 container-p-y">          
          <div class="row">
              <center>
                  <div class="alert alert-danger  align-items-center" role="alert" id="animation1" style="display: none;" >
                      <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                      CHARGEMENT . . .
                  </div>
              </center>

              <div class="demo-inline-spacing " id="animation3" style="text-align: right;" hidden>
                  <button class="btn btn-danger waves-effect " type="button" >
                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                    CHARGEMENT . . .///
                  </button>
              </div>
          <!--    
              <div class="card-datatable table-responsive">
                  <table class="datatables-users table border-top">
                    <thead>
                      <tr>
                        <th><center>Liste des documents en instance de signature</center> </th>
                      </tr>
                    </thead>
                  </table>
              </div>
          -->
              <div class="row">

                  <div class="card mb-3">
                      <div class="card-datatable table-responsive">
                
                     
                        <table class="dt-multilingual table table-striped">
                          <thead>
                            <tr>
                              <td>
                                <button id='tous' type="button" onclick="selectAll()" class="btn btn-sm btn rounded-pill btn-icon btn-success waves-effect waves-light " title="COCHER TOUS"><i class="ti ti-check ti-xs"></i></button>
                                <button id='rien' type="button" onclick="selectNone()" class="btn btn-sm btn rounded-pill btn-icon btn-danger waves-effect waves-light " title="DECOCHER TOUS"><i class="ti ti-minus ti-xs"></i></button>
             
                              </td>
                              <th>N° ACTE</th>
                              <th>NATURE ACTE</th>
<?php if (!empty($doc)) { ?>
  <?php if ($doc[0]["NATURE_ACTE_CODE"] == 'A0048' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0044' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0078' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0076' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0173' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0174') { ?>
<?php if ($doc[0]["NATURE_ACTE_CODE"] != 'A0174' && $doc[0]["NATURE_ACTE_CODE"] != 'A0173' ) { ?>
                               <th>INTERESSES</th> 
<?php } ?>  
                              <th>TYPE CONCOURS</th>
                              <th>EMPLOI</th>
                              <th>ANNEE</th>
<?php }} ?>
                              <th>DATE DE SIGNATURE</th>
                              <th>VOIR</th>
                            </tr>
                          </thead>
                         <tbody>
          @foreach ($doc as $d)

          <?php 
          $le_doc= $d['NOM_FICHIER'].'.PDF';
          $fichier= '//mnt/DATEDRV/ACTESIGNE_TEST/'.$le_doc;
          $fichier = public_path('DOSSIER_SAVE/ACTESIGNE_TEST/'.$le_doc);//REPERTOIRE A SUPPRIMER
          
          if (file_exists($fichier)) { ?>
          <tr class="test" >
          <?php } else { ?>
          
          <tr class="test" style="background-color: pink;">
          <?php } ?>
          
                                                  
                          <?php 
                          app()->setLocale('fr');
                          $formattedDate = strftime('%A %e %B %Y', strtotime($d['DATE_SIGNATURE']));
                          $formattedDate1 = date('d/m/Y', strtotime($d['DATE_SIGNATURE']));

                          ?>

                                  <td><input class="form-check-input selectionnerligne" name="elements[]" type="checkbox" value="{{ $d['NOM_FICHIER']}}" alt='{{ $d['GL_ACTE_ID']}}' title='{{ $d['NUMERO_ACTE']}}' id ="{{ $d['NOM_FICHIER'].':select'}}" /></td>
                                  <td>{{$d['NUMERO_ACTE']}}</td>
                                  <td>{{$d['NATURE_ACTE_LIB']}}</td>
<?php if (!empty($doc)) { ?>
  <?php if ($d['NATURE_ACTE_CODE'] == 'A0048' OR $d['NATURE_ACTE_CODE'] == 'A0044' OR $d['NATURE_ACTE_CODE'] == 'A0078' OR $d['NATURE_ACTE_CODE'] == 'A0076' OR $d['NATURE_ACTE_CODE'] == 'A0173' OR $d['NATURE_ACTE_CODE'] == 'A0174') { ?>
<?php if ($d['NATURE_ACTE_CODE'] != 'A0174' && $d['NATURE_ACTE_CODE'] != 'A0173') { ?>
 <td>{{$d['NBR_DOSSIER']}}</td>   
<?php } ?>                                  
                                  <td>{{$d['TYPECONC_LIB']}}</td>
                                  <td>{{$d['CONC_LIB']}}</td>
                                  <td>{{$d['ANNEE']}}</td>
<?php }} ?>
                                  <td>{{ $formattedDate1 }}</td>                                        
                                  <td>
                                    <a href="javascript:;" class="bi bi-journal-text modal-click-document-signe" id="{{ ($d['NOM_FICHIER'].'.PDF') }}" name="listepresence" title=""><i class="ti ti-eye me-2 ti-sm"></i></a>
                                  </td> 
                              </tr>
                              @endforeach
                          </tbody>
                
                
                        </table>                 
                      </div>
                  </div>
              </div>

          </div>   
      </div>
      <!-- / Content -->

      <!-- Footer -->
      @include('incs.footer')
      <!-- / Footer -->

      <div class="content-backdrop fade"></div>

      <!-- Modal de cotisation mensuel -->
      <div class="modal fade" id="modaldocument" tabindex="-1">
          <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
          <div class="modal-content p-3 p-md-5">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div id="affichage-lien">
          
                  <center>
                  <div class="alert alert-danger  align-items-center" role="alert" id="animation1"  >
                      <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                      OUVERTURE DU . . .
                  </div>
                  </center>
      
              </div>
          </div>
          </div>
      </div>
      <!-- End Large Modal-->

      <!-- Modal de cotisation mensuel -->
      <div class="modal fade" id="modal-lien" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
          <div class="modal-content p-3 p-md-5">
              <div class="modal-body" id="affichage-lien">
              <div class="col-12 text-center">
                  <!--<a href="{{ route('quit') }}"  class="btn btn-success waves-effect waves-light " aria-label="Close">Retour au tableau de bord de signature</a>-->
                  <form action="{{ route('quit') }}" method="post">
                  @csrf
                  <input type ="hidden" name = "P_ACTE_ID" id ="P_ACTE_ID" />
                  <input type ="hidden" name = "P_ACTE_NUM" id ="P_ACTE_NUM" />
                  <input type ="hidden" name = "P_USERMIN" id ="P_USERMIN" value = "@php echo utf8_encode($info['NOM PRENOMS']); @endphp"/>
                  <button class="btn btn-success waves-effect waves-light " aria-label="Close">Retour au tableau de bord de signature</button>
                  </form>
              </div>               
              </div>
          </div>
          </div>
      </div>
      
      
      <!-- Modal de cotisation mensuel -->
      <div class="modal fade" id="modal-lien-groupe" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
          <div class="modal-content p-3 p-md-5">
              <div class="modal-body" id="affichage-lien">
              <div class="col-12 text-center">
                  <!--<a href="{{ route('quit') }}"  class="btn btn-success waves-effect waves-light " aria-label="Close">Retour au tableau de bord de signature</a>-->
                  <form action="{{ route('quitgroupe') }}" method="post">
                  @csrf
                  <input type ="hidden" name = "lesvaleursid" id ="lesvaleursid" value = ""/>
                  <input type ="hidden" name = "lesvaleursnum" id ="lesvaleursnum" />
                  <input type ="hidden" name = "lesvaleursnom" id ="lesvaleursnom" value = ""/>
                  <input type ="hidden" name = "P_USERMIN" id ="P_USERMIN" value = "@php echo utf8_encode($info['NOM PRENOMS']); @endphp"/>
                  <button class="btn btn-success waves-effect waves-light " aria-label="Close">Retour au tableau de bord de signature</button>
                  </form>
              </div>
              </div>
          </div>
          </div>
      </div>
      
      <!-- End Large Modal-->
      
      <!-- End Large Modal-->

 <!-- * Modal de cotisation mensuel -->

  <script
      src="https://code.jquery.com/jquery-3.6.1.min.js"
      integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
      crossorigin="anonymous">  
  </script>
  <script type="text/javascript">
  
  
  
  // fonction pour lancer le modal du document
  $(function () {
  
  // afficher le modal de laffichage du document
  
              $('.modal-click-document').click(function() {
  
                  var $id_document = $(this).attr('id')
                  $('#modaldocument').modal('show')
  
                  $.get('/document/' + $id_document, function(result) { ;
                      $('#affichage-lien').html(result)
                  });
  
                  $('#liste').html($id_document)
  
              })
  
  
  
              $('.modal-click-document-signe').click(function() {
  
              var $id_document = $(this).attr('id')
                  $('#modaldocument').modal('show')
  
                  $.get('/documentsigner/' + $id_document, function(result) { ;
                      $('#affichage-lien').html(result)
                      console.log(result);
                  });
  
                  $('#liste').html($id_document)
  
              })
  
  
  
  
  
  
  
  
              
              $('.pup').click(function() {
  
              var $id_document = $(this).attr('id')
              $('#modal-lien').modal('show')
  
              })
  
              $('.pup-groupe').click(function() {
  
          var $id_document = $(this).attr('id')
          $('#modal-lien-groupe').modal('show')
  
              })
  
      })
  
  
  
      
  </script>




  <script type="text/javascript">
  
      // fonction pour lancer le modal du document
      $(function () {
      
      // afficher le modal de laffichage du document
  
                  $(document).on("click",".click-sign",function(e) {
                  document.getElementById("animation1").style.display = "block";
                  e.preventDefault();
      
                      var $id_document = $(this).attr('id');
                      var $alt    = $(this).attr('alt');
                      var $tab    = $alt.split(':');
                      var $mail   = $tab[0];
                      var $numero = $tab[1];
                      var $docid  = $tab[2];
                      // $('#modal-lien').modal('show')
      
                      $.get('/signature/'+$mail+'/'+ $id_document, function(result) {
                          //$('#affichage-lien').html(result)
                          var rjson = JSON.parse(result);
                          console.log(rjson);
                          $("a#"+$numero).prop("href", rjson.inviteUrl);
                          window.open(rjson.inviteUrl, 'popup', 'width=2000px,height=2000px,top=20px,left=20px');    
                          document.getElementById('popup').click();
                          $("#P_ACTE_ID").val($docid);
                          $("#P_ACTE_NUM").val($numero);      
                          document.getElementById("animation1").style.display = "none";          
                      });
      
                      
      
                  });
  
              });	
  
  
  
      </script>






      <script>
          document.getElementById("rien").style.display = "none";
          // Cocher/Decocher les checkbox
          function selectAll() {
          document.getElementById("tous").style.display = "none";
          document.getElementById("rien").style.display = "block";
      var checkboxes = document.getElementsByName("elements[]");
      for (var i = 0; i < checkboxes.length; i++) {
          checkboxes[i].checked = true;
      }
      
      }
      
      function selectNone() {
      
          document.getElementById("tous").style.display = "block";
          document.getElementById("rien").style.display = "none";
      
      var checkboxes = document.getElementsByName("elements[]");
      for (var i = 0; i < checkboxes.length; i++) {
          checkboxes[i].checked = false;
      
      
      }
      
      }
      </script>


      <script>
      // jQuery
     

      $(document).on("click",".selectionnerligne",function() {
        var id_document = $(this).attr('id');
        var tab  = id_document.split(':');
        var id   = tab[0];
        var id_document_inactif = 'inactif_'+id;

        if ($('.selectionnerligne').is(":checked")) {
            //Cacher le bouton grisé
            $("#"+id_document_inactif).hide();
            //Afficher le bouton de signature
            $("#"+id).show();
            //Pour ajouter la class click-sign qui permet l'action
            $("#"+id).addClass("click-sign");
        } else {
            //Afficcher le bouton grisé
            $("#"+id_document_inactif).show();
            //Afficher le bouton de signature
            $("#"+id).hide();
            //Pour retirer la class click-sign qui permet l'action
            $("#"+id).removeClass("click-sign"); 
        }
    });

      </script>



  </div>


        
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
    
  </div>
  <!-- / Layout wrapper -->
@endsection

