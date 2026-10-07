


@extends('layouts.base')
@section('content')





    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    @include('incs.header')
                    <!-- / Menu -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            
                            @php 
                             $NBRE_COMM=$stat['NBRE_COMM'];
                             $NBRE_ARR_ADM=$stat['NBRE_ARR_ADM'];
                             $NBRE_MF=$stat['NBRE_MF'];
                             $NBRE_FF=$stat['NBRE_FF'];
                             @endphp
                             
                            <!-- Cards with few info -->
                            
  <div class="col-lg-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="card-title mb-0">
            <h5 class="m-0 me-2">Mise en formation</h5>
            <hr>


            <h6 class="mb-0">{{$NBRE_MF}} Acte(s) en instance de signature</h6>
        </div>
        <div class="card-icon">
          <span class="badge bg-label-primary rounded-pill p-2">
            <i class='ti ti-cpu ti-sm'></i>
          </span>
        </div>
      </div>
      <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#pricingModal" style = "background-color: #7367f0 !important; border-color:#7367f0; border-radius: 1px 0 3px 4px !important;">
        <span class="ti-xs ti ti-eye me-1"></span>Documents à signer
      </button>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Fin de formation</h5>
          <hr>
          <h6 class="mb-0">{{$NBRE_FF}} Acte(s) en instance de signature</h6>
        </div>
        <div class="card-icon">
          <span class="badge bg-label-success rounded-pill p-2">
            <i class='ti ti-server ti-sm'></i>
          </span>
        </div>
      </div>
      <button type="button" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
        <span class="ti-xs ti ti-eye me-1"></span>Documents à signer
      </button>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Communiqué</h5>
          <hr>
          <h6 class="mb-0">{{$NBRE_COMM}} Acte(s) en instance de signature</h6>
        </div>
        <div class="card-icon">
          <span class="badge bg-label-danger rounded-pill p-2">
            <i class='ti ti-chart-pie-2 ti-sm'></i>
          </span>
        </div>
      </div>
      <button type="button" class="btn btn-primary waves-effect waves-light" style = "background-color: #ea5455 !important; border-color:#ea5455; border-radius: 1px 0 3px 4px !important;">
        <span class="ti-xs ti ti-eye me-1"></span>Documents à signer
      </button>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Arreté d'Admission</h5>
          <hr>
          <h6 class="mb-0">{{$NBRE_ARR_ADM}} Acte(s) en instance de signature</h6>
        </div>
        <div class="card-icon">
          <span class="badge bg-label-warning rounded-pill p-2">
            <i class='ti ti-alert-octagon ti-sm'></i>
          </span>
        </div>
      </div>
      <button type="button" class="btn btn-primary waves-effect waves-light" style = "background-color: #ff9f43  !important; border-color:#ff9f43; border-radius: 1px 0 3px 4px !important;">
        <span class="ti-xs ti ti-eye me-1"></span>Documents à signer
      </button>
    </div>
  </div>

</div>











   


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








{{--  {{phpinfo()}} --}}
                          <div class="row">

                            <div class="card mb-3">
                                <h5 class="card-header">Liste de tous les documents</h5>
                                <div class="card-datatable table-responsive">
                                  <table class="dt-multilingual table table-striped">
                                    <thead>
                                      <tr>
                                        <th><input class="form-check-input" type="checkbox" value="1" id="tousselectionner" /></th>
                                        <th>N° ACTE</th>
                                        <th>NATURE ACTE</th>
                                        <th>TYPE CONCOURS</th>
                                        <th>EMPLOI</th>
                                        <th>ANNEE</th>
                                        <th hidden>VOIR</th>
                                        <th>ACTION</th>
                                        <th hidden>POPUP</th>
                                      </tr>
                                    </thead>
                                   <tbody>
                                        @foreach ($doc as $d)
                                        <tr>
                                            <td><input class="form-check-input selectionnerligne" type="checkbox" value="1" /></td>
                                            <td>{{$d['NUMERO_ACTE']}}</td>
                                            <td>{{$d['NATURE_ACTE_LIB']}}</td>
                                            <td>{{$d['TYPECONC_LIB']}}</td>
                                            <td>{{$d['CONC_LIB']}}</td>
                                            <td>{{$d['ANNEE']}}</td>
                                            <td hidden><a href="javascript:;" class="bi bi-journal-text modal-click-document" id="{{ ($d['NOM_FICHIER'].'.PDF') }}" name="listepresence" title="PROCES VERBAL"><i class="ti ti-eye me-2 ti-sm"></i></a></td>                                         
                                            <td>
                                              <a href="javascript:;" id="{{ $d['NOM_FICHIER']}}" alt='so.cisse@fonctionpublique.gouv.ci:{{ $d['NUMERO_ACTE']}}:{{$d['GL_ACTE_ID']}}' rel="noopener noreferrer" class="click-sign"><button class="btn btn-primary "><i class="ti ti-pencil me-2 ti-sm"></i> Signer</button></a>
                                            </td>
                                            <td hidden>   
                                              <a href="javascript:;" id="popup" alt='' rel="noopener noreferrer" class="pup">POPUP</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>


                                  </table>
                                </div>
                              </div>

                              <div class="card">
                                <div class="row mb-3 mt-3">

<!--                                   <h5 class="card-header">Option de recherche</h5>
                                  <div class="col-lg-6 col-sm-6">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <select id="typeconcours" class="select2 form-select form-select-lg">
                                          <option>TYPE CONCOURS</option>
                                          <option value="FORMATION A TITRE PERSONNEL">FORMATION A TITRE PERSONNEL</option>
                                          <option value="CONCOURS PROFESSIONNEL">CONCOURS PROFESSIONNEL</option>
                                          <option value="CONCOURS DE RECRUTEMENT">CONCOURS DE RECRUTEMENT</option>
                                        </select>
                                      </div>
                                      <div class="col-md-6">
                                      <select id="emploi" class="select2 form-select form-select-lg">
                                          <option>EMPLOI</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div> -->
                                   
                                  <div class="col-lg-12 col-sm-6" style = "text-align:right">
                                    <a href ="#" class="btn btn-info" style = "background-color: #036D00 !important"><i class="ti ti-check me-2 ti-sm"></i> Voir les documents signés</a>
                                    <a href ="javascript:void(0)" class="btn btn-primary" id ="btn_doc_select"><i class="ti ti-pencil me-2 ti-sm"></i> Signer les documents selectionnés</a>                     
                                  </div> 
                                </div>
                              </div>


                          </div>
                    </div>






                    <div class="modal fade" id="pricingModal" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-xl modal-simple modal-pricing">
                        <div class="modal-content p-2 p-md-5">
                          <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <!-- Pricing Plans -->
                            <div class="pb-sm-5 pb-2 rounded-top">
                              <h2 class="text-center mb-2">Mise en formation</h2>
                              <p class="text-center"> toutes les mise en formation en attente de signature. </p>
                              <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 pt-3 mb-4">
                               
                                <div class="mt-n5 ms-n5 d-none d-sm-block">
                                  <table class="dt-multilingual table">
                                    <thead>
                                      <tr>
                                        <th>MATRICULE</th>
                                        <th>NOM & PRENOMS</th>
                                        <th>ACTES</th>
                                        <th>ETAT</th>
                                        <th>N° ACTE</th>
                                        <th>VOIR</th>
                                        <th>ACTION</th>
                                      </tr>
                                    </thead>

                                    <tbody>
                                        {{-- @foreach ($doc as $d)
                                        <tr>
                                            <td>{{$d['MAT']}}</td>
                                            <td>{{$d['NOMPREN']}}</td>
                                            <td>{{$d['ACTE']}}</td>
                                            <td>{{$d['ETAT']}}</td>
                                            <td>{{$d['NUM']}}</td>
                                            @php $filename=$d['NOMACTE'].'.pdf'  @endphp
                                            <td><a href="{{ asset('//192.168.6.12/sigfae_test/DOSSIER_SAVE/A%20SIGNER/'.$d['NOMACTE'].'.pdf') }}" target="_blank"><i class="ti ti-eye me-2 ti-sm"></i></a></td>
                                            <td><a href="<?php echo '?file='.$filename; ?>" id="btnPopup" rel="noopener noreferrer"><button class="btn btn-primary"><i class="ti ti-pencil me-2 ti-sm"></i> Signer</button></a></td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>


                                  </table>
                                </div>
                              </div>
                                </div>
                    
                                <!-- Enterprise -->
                              </div>
                            </div>
                            <!--/ Pricing Plans -->
                          </div>
                        </div>
                      </div>
                    </div>


                    
                    <!-- Footer -->
                    @include('incs.footer')
                    <!-- / Footer -->
                    
                      <!--/ Add New Address Modal -->







<!-- Modal de cotisation mensuel -->
<div class="modal fade" id="modaldocument" tabindex="-1">
  <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body" id="doc-modal">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    
       le document saffiche ici
      
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
            <input type ="hidden" name = "P_USERMIN" id ="P_USERMIN" value = "@php echo utf8_encode($info['NOM PRENOMS']); @endphp"/>
            <button class="btn btn-success waves-effect waves-light " aria-label="Close">Retour au tableau de bord de signature</button>
          </form>
        </div>

  </div>
</div>
</div>
</div>

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

              
                $('#modaldocument').modal('show')

                $.get('../resources/views/doc.php?id_document=' + $id_document, function(result) { ;
                    $('#affichage-lien').html(result)
                });

                $('#liste').html($id_document)

            })



            
                              $('.pup').click(function() {

                              var $id_document = $(this).attr('id')
                              $('#modal-lien').modal('show')

                              })

  })



  
</script>




<script type="text/javascript">

  // fonction pour lancer le modal du document
   $(function () {
  
  // afficher le modal de laffichage du document

              $('.click-sign').click(function(e) {
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
                      document.getElementById("animation1").style.display = "none";          
                  });
  
                  
  
              });

              // Cocher/Decocher les checkbox
              $('#tousselectionner').click(function () {	
			          $('.selectionnerligne').prop('checked', this.checked);
		          });	

              // Signature groupée
              $('#btn_doc_select').click(function () {

                if ($('.selectionnerligne').is(":checked")) {
                  /** Code pour signer les docs*/
                  
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
              });

              // Recherche
/*               $('#typeconcours').on( 'change', function () {
                //alert($(this).val());
                //$(".dt-multilingual").columns(3).search($(this).val()).draw();
              });	 */



/*


              $('.pup').click(function(e) {
                e.preventDefault();
  
                  var $id_document = $(this).attr('id');
                  var $alt    = $(this).attr('alt');
                  var $tab    = $alt.split(':');
                  var $mail   = $tab[0];
                  var $numero = $tab[1];
                  // $('#modal-lien').modal('show')
  
                  $.get('/SIGNATURE/1/test/public/signature/'+$mail+'/'+ $id_document, function(result) {
                      //$('#affichage-lien').html(result)
                      var rjson = JSON.parse(result);
                      console.log(rjson);
                      $("a#"+$numero).prop("href", rjson.inviteUrl);
                      let params = `directories=no,modal=yes,scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=2000,height=2000,left=0,top=0`;
                      window.open(rjson.inviteUrl, 'modal', params); 
                     // window.open(rjson.inviteUrl, 'popup', params); 
                     // window.open('https://www.example.com', 'Nom de la fenêtre', 'modal=yes,toolbar=no,scrollbars=yes,resizable=yes,width=400,height=400');
           
                  });
  
              })

*/

  
    })
  
  
  
    
  </script>



                </div>
                <!--/ Content wrapper -->
            </div>
        <!--/ Layout container -->
        </div>
    </div>
    <!--/ Layout wrapper -->
@endsection

