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





                 <!-- ######################################################## DGAPCE ############################################## -->
<?php  if ($info['FONCTION']=='MINISTRE'  OR $info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>  
<br>              
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> DGAPCE</a>
 <br>
 <?php } ?>
               <?php if ($info['FONCTION']=='MINISTRE'  OR $info['LOGINUSER']== 'X477231'  OR $info['LOGINUSER'] == 'Z444473'  OR $info['LOGINUSER']== 'T279354') { ?>             
                    <div class="row">
                      @php 
                      $NBRE_PB=$stat['NBRE_PB'];
                      $NBRE_RGS=$stat['NBRE_RGS'];
                      $NBRE_ARSA=$stat['NBRE_ARSA'];
                      @endphp
                      
                     <!-- Cards with few info -->
                     
                     <div class="col-lg-4 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                               <h5 class="m-0 me-2">Prêt bancaire</h5>
                               <hr>


                               <h2 class="mb-0">{{$NBRE_PB}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-primary rounded-pill p-2">
                               <i class='ti ti-files ti-sm'></i>
                             </span>
                           </div>
                         </div>
                         <a href="{{route('pret_banc')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h2 class="mb-0">{{$NBRE_RGS}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-success rounded-pill p-2">
                               <i class='ti ti-book ti-sm'></i>
                             </span>
                           </div>
                         </div>
                         <a href="{{route('rgs')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h2 class="mb-0">{{$NBRE_ARSA}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-danger rounded-pill p-2">
                               <i class='ti ti-file ti-sm'></i>
                             </span>
                           </div>
                         </div>
                         <a href="{{route('arsa')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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


                              <th>N° ACTE</th>
                              <th>NATURE ACTE</th>
<?php if (!empty($doc)) { ?>
  <?php if ($doc[0]["NATURE_ACTE_CODE"] == 'A0048' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0044' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0078' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0076' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0173' OR $doc[0]["NATURE_ACTE_CODE"] == 'A0174') { ?>
                              <th>TYPE CONCOURS</th>
                              <th>EMPLOI</th>
                              <th>ANNEE</th>
<?php } } ?>
                              <th>VOIR</th>

                              <th hidden>POPUP</th>
                            </tr>
                          </thead>
                         <tbody>
                              @foreach ($doc as $d)
                       
                <?php 
$le_doc= $d['NOM_FICHIER'].'.PDF';
$fichier= '//mnt/DATEDRV/A_SIGNER_TEST/'.$le_doc;
$fichier = public_path('DOSSIER_SAVE/A_SIGNER_TEST/'.$le_doc);//REPERTOIRE A SUPPRIMER

if (file_exists($fichier)) { ?>
<tr class="test" >
<?php } else { ?>

<tr class="test" style="background-color: pink;">
<?php } ?>



                          
                                  <td>{{$d['NUMERO_ACTE']}}</td>
                                  <td>{{$d['NATURE_ACTE_LIB']}}</td>
  <?php if ($d['NATURE_ACTE_CODE'] == 'A0048' OR $d['NATURE_ACTE_CODE'] == 'A0044' OR $d['NATURE_ACTE_CODE'] == 'A0078' OR $d['NATURE_ACTE_CODE'] == 'A0076' OR $d['NATURE_ACTE_CODE'] == 'A0173' OR $d['NATURE_ACTE_CODE'] == 'A0174') { ?>
                                  <td>{{$d['TYPECONC_LIB']}}</td>
                                  <td>{{$d['CONC_LIB']}}</td>
                                  <td>{{$d['ANNEE']}}</td>
<?php } ?>
                                  <td>
                                    <a href="javascript:;" class="bi bi-journal-text modal-click-document" id="{{ ($d['NOM_FICHIER'].'.PDF') }}" name="listepresence" title="PROCES VERBAL"><i class="ti ti-eye me-2 ti-sm"></i></a>
                                  </td>   

                                 
                                  <td hidden>   
                                    <a href="javascript:;" id="popup" alt='' rel="noopener noreferrer" class="pup">POPUP</a>
                                    <a href="javascript:;" id="popup-groupe" alt='' rel="noopener noreferrer" class="pup-groupe">POPUP</a>
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
      function envoyerRequete() {
      
      if ($('.selectionnerligne').is(":checked")) {
      
      document.getElementById("animation1").style.display = "block";
      const elementsCoches = $('input[type="checkbox"]:checked');
      const valeurs = [];
      var elementtab = "";
      var elementtab1 = "";
      var elementtab2 = "";
      
      var i = 1;
      
      elementsCoches.each(function() {
          if (i==1) {
          var concat = "";
          } else {
          var concat = "@@";
          }
          elementtab = elementtab+concat+$(this).val();
          elementtab1 = elementtab1+concat+$(this).attr('title');
          elementtab2 = elementtab2+concat+$(this).attr('alt');
          i = i+1;
          //elementtab = elementtab + valeurs.push($(this).val());
      });
      
      
      
                  // var $tab    = valeurs.split(':');
                  // var $doc_nom   = $tab[0];
                  //  var $doc_num = $tab[1];
                  //  var $doc_id  = $tab[2];
      
      console.log(elementtab1);
      
      $("#lesvaleursid").val(elementtab2);
      $("#lesvaleursnum").val(elementtab1);
      $("#lesvaleursnom").val(elementtab);
      const url = '/Tgrouper/' + elementtab;
      
      //window.location.href = url;
      
      $.get( url, function(result) {
          //$('#affichage-lien').html(result)
          var rjson = JSON.parse(result);
          console.log(rjson);
          // $("a#"+$numero).prop("href", rjson.inviteUrl);
          window.open(rjson.inviteUrl, 'popup', 'width=2000px,height=2000px,top=20px,left=20px');    
          document.getElementById('popup-groupe').click();
      //    $("#P_ACTE_ID").val($docid);    
          document.getElementById("animation1").style.display = "none";          
      });
      
      
      
      
      } else {
      Swal.fire({
      icon: 'warning',
      title: 'ATTENTION',
      text: 'Veuillez svp selectionner les actes !',
      customClass:{confirmButton:"btn btn-primary"},
      buttonsStyling:!1
      })
      //alert("non ok");
      }
      }

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

