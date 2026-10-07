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

                  <!-- ######################################################## MINISTRE ############################################## -->

                <?php if ($info['FONCTION']=='MINISTRE') { ?>         
                    <div class="row">
                      @php 
                      $NBRE_COMM=$stat['NBRE_COMM'];
                      $NBRE_ARR_ADM=$stat['NBRE_ARR_ADM'];
                      $NBRE_MF=$stat['NBRE_MF'];
                      $NBRE_FF=$stat['NBRE_FF'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_MF}}" id="NBRE_MF">
                        <input type="hidden" value ="{{$NBRE_FF}}" id="NBRE_FF">
                        <input type="hidden" value ="{{$NBRE_COMM}}" id="NBRE_COMM">
                        <input type="hidden" value ="{{$NBRE_ARR_ADM}}" id="NBRE_ARR_ADM">
                      
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

 <a href="{{route('mise_formation')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
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

 <a href="{{route('fin_formation')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
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
 <a href="{{route('communique')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

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
 <a href="{{route('arrete')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                    </div>


                    <!-- Donut Chart -->
                                        
                    
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <div class="dropdown d-none d-sm-flex">
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a></li>
                              <li>
                                <hr class="dropdown-divider">
                              </li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="card-body">
                          <div id="diagramme_instance"></div>
                        </div>
                     
                   <?php } ?> 
                    <!-- ######################################################## FIN MINISTRE ############################################## -->
                      <!-- /Donut Chart -->



                        <!-- ######################################################## DGAPCE  ############################################## -->

                <?php if ($info['FONCTION']=='DIRECTEUR') { ?>         
                    <div class="row">
                      @php 
                      $NBRE_COMM=$stat['NBRE_COMM'];
                      $NBRE_ARR_ADM=$stat['NBRE_ARR_ADM'];
                      $NBRE_MF=$stat['NBRE_MF'];
                      $NBRE_FF=$stat['NBRE_FF'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_MF}}" id="NBRE_MF">
                        <input type="hidden" value ="{{$NBRE_FF}}" id="NBRE_FF">
                        <input type="hidden" value ="{{$NBRE_COMM}}" id="NBRE_COMM">
                        <input type="hidden" value ="{{$NBRE_ARR_ADM}}" id="NBRE_ARR_ADM">
                      
                     <!-- Cards with few info -->
                     
                     <div class="col-lg-4 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                               <h5 class="m-0 me-2">Prêt bancaire</h5>
                               <hr>


                               <h6 class="mb-0">{{$NBRE_MF}} Acte(s) en instance de signature</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-primary rounded-pill p-2">
                               <i class='ti ti-files ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('mise_formation')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                     <div class="col-lg-4 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">RJS</h5>
                             <hr>
                             <h6 class="mb-0">{{$NBRE_FF}} Acte(s) en instance de signature</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-success rounded-pill p-2">
                               <i class='ti ti-book ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('fin_formation')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h6 class="mb-0">{{$NBRE_COMM}} Acte(s) en instance de signature</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-danger rounded-pill p-2">
                               <i class='ti ti-file ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('communique')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                     <div class="col-lg-3 col-sm-6 mb-4" hidden>
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
 <a href="{{route('arrete')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                    </div>


                    <!-- Donut Chart -->
                                        
                    
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <div class="dropdown d-none d-sm-flex">
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a></li>
                              <li>
                                <hr class="dropdown-divider">
                              </li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="card-body">
                          <div id="diagramme_instance"></div>
                        </div>
                     
                   <?php } ?> 
                    <!-- ######################################################## FIN DGAPCE ############################################## -->



                       <!-- ######################################################## DAF  ############################################## -->

                <?php if ($info['FONCTION']=="DIRECTEUR D'ADMINISTRATION CENTRALE") { ?>         
                    <div class="row">
                      @php 
                      $NBRE_COMM=$stat['NBRE_COMM'];
                      $NBRE_ARR_ADM=$stat['NBRE_ARR_ADM'];
                      $NBRE_MF=$stat['NBRE_MF'];
                      $NBRE_FF=$stat['NBRE_FF'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_MF}}" id="NBRE_MF">
                        <input type="hidden" value ="{{$NBRE_FF}}" id="NBRE_FF">
                        <input type="hidden" value ="{{$NBRE_COMM}}" id="NBRE_COMM">
                        <input type="hidden" value ="{{$NBRE_ARR_ADM}}" id="NBRE_ARR_ADM">
                      
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

 <a href="{{route('mise_formation')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
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

 <a href="{{route('fin_formation')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
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
 <a href="{{route('communique')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

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
 <a href="{{route('arrete')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                    </div>


                    <!-- Donut Chart -->
                                        
                    
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <div class="dropdown d-none d-sm-flex">
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a></li>
                              <li>
                                <hr class="dropdown-divider">
                              </li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a></li>
                              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="card-body">
                          <div id="diagramme_instance"></div>
                        </div>
                     
                   <?php } ?> 
                    <!-- ######################################################## FIN DAF ############################################## -->
                </div>
                <!-- / Content -->


                            




    
                <!-- Footer -->
                @include('incs.footer')
                <!-- / Footer -->
    
                <div class="content-backdrop fade"></div>
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

