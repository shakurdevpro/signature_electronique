


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
            <i class='ti ti-files ti-sm'></i>
          </span>
        </div>
      </div>
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
            <i class='ti ti-book ti-sm'></i>
          </span>
        </div>
      </div>
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
            <i class='ti ti-file ti-sm'></i>
          </span>
        </div>
      </div>
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
            <i class='ti ti-folder ti-sm'></i>
          </span>
        </div>
      </div>
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




<div class="card-header border-bottom">
</div>
<div class="card-datatable table-responsive">
  <table class="datatables-users table border-top">
    <thead>
      <tr>
        <th><center>Liste des documents en instance de signature</center> </th>
      </tr>
    </thead>
  </table>
</div>



{{--  {{phpinfo()}} --}}
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
                                            <td>
                                              <input class="form-check-input selectionnerligne" name="elements[]" type="checkbox" value="{{ $d['NOM_FICHIER']}}" alt='{{ $d['GL_ACTE_ID']}}' title='{{ $d['NUMERO_ACTE']}}' /></td>
                                            <td>{{$d['NUMERO_ACTE']}}</td>
                                            <td>{{$d['NATURE_ACTE_LIB']}}</td>
                                            <td>{{$d['TYPECONC_LIB']}}</td>
                                            <td>{{$d['CONC_LIB']}}</td>
                                            <td>{{$d['ANNEE']}}</td>
                                            <td hidden>
                                              <a href="javascript:;" class="bi bi-journal-text modal-click-document" id="{{ ($d['NOM_FICHIER'].'.PDF') }}" name="listepresence" title="PROCES VERBAL"><i class="ti ti-eye me-2 ti-sm"></i></a>
                                            </td>                                         
                                            <td>
                                              <a href="javascript:;" id="{{ $d['NOM_FICHIER']}}" alt='so.cisse@fonctionpublique.gouv.ci:{{ $d['NUMERO_ACTE']}}:{{$d['GL_ACTE_ID']}}' rel="noopener noreferrer" class="click-sign"><button class="btn btn-primary "><i class="ti ti-pencil me-2 ti-sm"></i> Signer</button></a>
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
                                   
                                    <a href ="javascript:;" class="btn btn-info" onclick="envoyerRequete()"  style = "background-color: #036D00 !important"><i class="ti ti-check me-2 ti-sm"></i> Signer les documents </a> 
                                                     
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
  
                  $.get('/SIGNATURE/1/test/public/signature/'+$mail+'/'+ $id_document, function(result) {
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
const url = '/SIGNATURE/1/test/public/Tgrouper/' + elementtab;

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
</script>


                </div>
                <!--/ Content wrapper -->
            </div>
        <!--/ Layout container -->
        </div>
    </div>
    <!--/ Layout wrapper -->
@endsection

