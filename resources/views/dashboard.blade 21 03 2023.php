


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
                            $NBRE_NOMIN_INST_MIN=$stat['NBRE_NOMIN_INST_MIN'];
                            $NBRE_NOMIN_SIGNE_MIN=$stat['NBRE_NOMIN_SIGNE_MIN'];
                            $NBRE_PROM_INST_MIN=$stat['NBRE_PROM_INST_MIN'];
                            $NBRE_PROM_SIGNE_MIN=$stat['NBRE_PROM_SIGNE_MIN'];

                            $TOTAL_NOMINATION= $NBRE_NOMIN_INST_MIN + $NBRE_NOMIN_SIGNE_MIN ;
                            $TOTAL_PROMOTION=$NBRE_PROM_INST_MIN + $NBRE_PROM_SIGNE_MIN ;



                             @endphp
                             
                            <!-- Cards with few info -->
                            
  <div class="col-lg-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="card-title mb-0">
            <h5 class="m-0 me-2">Mise en formation</h5>
            <hr>


            <h6 class="mb-0">{{substr($NBRE_NOMIN_SIGNE_MIN*100/$TOTAL_NOMINATION,0,5)}}% Signé(s) : {{$NBRE_NOMIN_SIGNE_MIN}} Acte(s)</h6>
            <h6 class="mb-0">{{substr($NBRE_NOMIN_INST_MIN*100/$TOTAL_NOMINATION,0,5)}}% En instance : {{$NBRE_NOMIN_INST_MIN}} Acte(s) </h6>
        </div>
        <div class="card-icon">
          <span class="badge bg-label-primary rounded-pill p-2">
            <i class='ti ti-cpu ti-sm'></i>
          </span>
        </div>
      </div>
      <button type="button" class="btn btn-primary waves-effect waves-light" style = "background-color: #7367f0 !important; border-color:#7367f0; border-radius: 1px 0 3px 4px !important;">
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
          <h6 class="mb-0">80% Signé(s) : {{$NBRE_PROM_INST_MIN}} Acte(s)</h6>
          <h6 class="mb-0">20% En instance : {{$NBRE_PROM_SIGNE_MIN}} Acte(s) </h6>
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
          <h5 class="m-0 me-2">Commission d'Admission</h5>
          <hr>
          <h6 class="mb-0">80% Signé(s) : 10 Acte(s)</h6>
          <h6 class="mb-0">20% En instance : 2 Acte(s) </h6>
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
          <h6 class="mb-0">80% Signé(s) : 10 Acte(s)</h6>
          <h6 class="mb-0">20% En instance : 2 Acte(s) </h6>
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





                          <div class="row">

                            <div class="card">
                                <h5 class="card-header">Liste de tous les documents</h5>
                                <div class="card-datatable table-responsive">
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
                                        @foreach ($doc as $d)
                                        <tr>
                                            <td>{{$d['MAT']}}</td>
                                            <td>{{$d['NOMPREN']}}</td>
                                            <td>{{$d['ACTE']}}</td>
                                            <td>{{$d['ETAT']}}</td>
                                            <td>{{$d['NUM']}}</td>
                                            @php $filename=$d['NOMACTE'].'.pdf'  @endphp
                                            <td>
                                                <a href = "javascript:void(0)" class="btn btn-primary lien_document" data-bs-toggle="modal" data-bs-target="#addNewAddress" alt = "{{ url('//192.168.6.12/sigfae_test/DOSSIER_SAVE/A%20SIGNER/'.$d['NOMACTE'].'.pdf') }}"> Show </a>
						<a href="{{ url('//192.168.6.12/sigfae_test/DOSSIER_SAVE/A%20SIGNER/'.$d['NOMACTE'].'.pdf') }}" target="_blank"><i class="ti ti-eye me-2 ti-sm"></i></a>
					    </td>
                                            <td><a href="<?php echo '?file='.$filename; ?>" id="btnPopup" rel="noopener noreferrer"><button class="btn btn-primary"><i class="ti ti-pencil me-2 ti-sm"></i> Signer</button></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>


                                  </table>
                                </div>
                              </div>
                          </div>
                    </div>
                    <!-- Footer -->
                    @include('incs.footer')
                    <!-- / Footer -->
                    <div class="content-backdrop fade"></div>

<!-- Add New Address Modal -->
<div class="modal fade" id="addNewAddress" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <iframe src="https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf" width="100%" height="550"></iframe>
      </div>
    </div>
  </div>
</div>
<!--/ Add New Address Modal -->

                </div>
                <!--/ Content wrapper -->
            </div>
        <!--/ Layout container -->
        </div>
    </div>
    <!--/ Layout wrapper -->
@endsection

