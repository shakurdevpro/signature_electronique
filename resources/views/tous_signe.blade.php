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
                    <!--    
                        <div class="card-datatable table-responsive">
                            <table class="datatables-users table border-top">
                              <thead>
                                <tr>
                                    <th><center>Liste des documents signés</center> </th>
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
                                        <th>DATE DE SIGNATURE</th>
                                        <th>VOIR</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                        @foreach ($docsigne as $ds)

<?php 
$le_doc= $ds['NOM_FICHIER'].'.PDF';
$fichier= '//mnt/DATEDRV/ACTESIGNE_TEST/'.$le_doc;
$fichier = public_path('DOSSIER_SAVE/ACTESIGNE_TEST/'.$le_doc);//REPERTOIRE A SUPPRIMER

//var_dump($fichier); die;

if (file_exists($fichier)) { ?>
<tr class="test" >
<?php } else { ?>

<tr class="test" style="background-color: pink;">
<?php } ?>

                                        
                                            <?php 
                                            app()->setLocale('fr');
                                            $formattedDate = strftime('%A %e %B %Y', strtotime($ds['DATE_SIGNATURE']));
                                            $formattedDate1 = date('d/m/Y', strtotime($ds['DATE_SIGNATURE']));

                                            ?>
                                            <td>{{$ds['NUMERO_ACTE']}}</td>
                                            <td>{{$ds['NATURE_ACTE_LIB']}}</td>
  <?php if ($ds['NATURE_ACTE_CODE'] == 'A0048' OR $ds['NATURE_ACTE_CODE'] == 'A0044' OR $ds['NATURE_ACTE_CODE'] == 'A0078' OR $ds['NATURE_ACTE_CODE'] == 'A0076' OR $ds['NATURE_ACTE_CODE'] == 'A0173' OR $ds['NATURE_ACTE_CODE'] == 'A0174') { ?>
                                            <td>{{$ds['TYPECONC_LIB']}}</td>
                                            <td>{{$ds['CONC_LIB']}}</td>
                                            <td>{{$ds['ANNEE']}}</td>
<?php }else{ ?>
<?php if ($info['LOGINUSER'] == 'Z444473') { ?>                                           
                                            <td>--------</td>
                                            <td>--------</td>
                                            <td>--------</td>   
<?php } } ?>  
                                            <td>{{ $formattedDate1 }}</td>
                                            <td>
                                              <a href="javascript:;" class="bi bi-journal-text modal-click-document-signe" id="{{ ($ds['NOM_FICHIER'].'.PDF') }}" name="listepresence" title=""><i class="ti ti-eye me-2 ti-sm"></i></a>
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



                <script
                src="https://code.jquery.com/jquery-3.6.1.min.js"
                integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
                crossorigin="anonymous">  
               </script>

                <script type="text/javascript">
                    // fonction pour lancer le modal du document
                    $(function () {
                       // afficher le modal de laffichage du document
                       $('.modal-click-document-signe').click(function() {
            
                            var $id_document = $(this).attr('id')
                            $('#modaldocument').modal('show')
            
                            $.get('/documentsigner/' + $id_document, function(result) { ;
                                $('#affichage-lien').html(result)
                            });
            
                            $('#liste').html($id_document)

                        })
                    
                    })
                </script>

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

