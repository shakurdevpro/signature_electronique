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
  
  <?php  if ($info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>                
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> MINISTRE</a>
 <br>
 <?php } ?>
                <?php if ($info['LOGINUSER']=='X505234'  OR $info['LOGINUSER'] == 'Z444473' OR $info['LOGINUSER']== 'T279354') { ?>         
                    <div class="row">
                      @php 
                      $NBRE_COMM=$stat['NBRE_COMM'];
                      $NBRE_ARR_ADM=$stat['NBRE_ARR_ADM'];
                      $NBRE_MF=$stat['NBRE_MF'];
                      $NBRE_FF=$stat['NBRE_FF'];
                      $NBRE_COMM_OUVR=$stat['NBRE_COMM_OUVR'];
                      $NBRE_ARR_OUVR=$stat['NBRE_ARR_OUVR'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_MF}}" id="NBRE_MF">
                        <input type="hidden" value ="{{$NBRE_FF}}" id="NBRE_FF">
                        <input type="hidden" value ="{{$NBRE_COMM}}" id="NBRE_COMM">
                        <input type="hidden" value ="{{$NBRE_ARR_ADM}}" id="NBRE_ARR_ADM">

                        <input type="hidden" value ="{{$NBRE_COMM_OUVR}}" id="NBRE_COMM_OUVR">
                        <input type="hidden" value ="{{$NBRE_ARR_OUVR}}" id="NBRE_ARR_OUVR">
                      
                     <!-- Cards with few info -->
                     
                     <div class="col-lg-2 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                               <h5 class="m-0 me-2">Mise en formation</h5>
                               <hr>


                               <h2 class="mb-0">{{$NBRE_MF}}</h2>
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
                     <div class="col-lg-2 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Fin de formation</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_FF}}</h2>
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
                     <div class="col-lg-2 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Communiqué d'admission</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_COMM}}</h2>
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
                     <div class="col-lg-2 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Arreté d'Admission</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_ARR_ADM}}</h2>
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
                     <div class="col-lg-2 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Communiqué d'ouverture</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_COMM_OUVR}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('comm_ouv')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                     <div class="col-lg-2 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Arrêté d'ouverture</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_ARR_OUVR}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('arrete_ouv')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                    </div>


                    <!-- Donut Chart -->
                                        
<?php  if ($info['LOGINUSER'] != 'T279354' && $info['LOGINUSER'] != 'Z444473') { ?>  
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
                   <?php } ?> 
                    <!-- ######################################################## FIN MINISTRE ############################################## -->
                      <!-- /Donut Chart -->










                <!-- ######################################################## DFRC ############################################## -->
  
  <?php  if ($info['LOGINUSER'] == 'K349954') { ?>                
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> DFRC</a>
 <br>
 <?php } ?>
                <?php if ($info['LOGINUSER']== 'K349954') { ?>         
                    <div class="row">
                      @php 
                      $NBRE_COMM=$stat['NBRE_COMM'];
                      $NBRE_ARR_ADM=$stat['NBRE_ARR_ADM'];
                      $NBRE_MF=$stat['NBRE_MF'];
                      $NBRE_FF=$stat['NBRE_FF'];
                      $NBRE_COMM_OUVR=$stat['NBRE_COMM_OUVR'];
                      $NBRE_ARR_OUVR=$stat['NBRE_ARR_OUVR'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_MF}}" id="NBRE_MF">
                        <input type="hidden" value ="{{$NBRE_FF}}" id="NBRE_FF">
                        <input type="hidden" value ="{{$NBRE_COMM}}" id="NBRE_COMM">
                        <input type="hidden" value ="{{$NBRE_ARR_ADM}}" id="NBRE_ARR_ADM">

                        <input type="hidden" value ="{{$NBRE_COMM_OUVR}}" id="NBRE_COMM_OUVR">
                        <input type="hidden" value ="{{$NBRE_ARR_OUVR}}" id="NBRE_ARR_OUVR">
                      
                     <!-- Cards with few info -->
                     
                     <div class="col-lg-6 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                               <h5 class="m-0 me-2">Mise en formation</h5>
                               <hr>


                               <h2 class="mb-0">{{$NBRE_MF}}</h2>
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
                     <div class="col-lg-6 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Fin de formation</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_FF}}</h2>
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
                 
                  
                   
                   
                    </div>


                    <!-- Donut Chart -->
                                        
<?php  if ($info['LOGINUSER'] != 'K349954') { ?>  
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
                   <?php } ?> 
                    <!-- ######################################################## FIN DFRC ############################################## -->
                      <!-- /Donut Chart -->







<!-- ######################################################## CONCOURS ############################################## -->
  
  <?php  if ($info['LOGINUSER'] == 'E319795' OR $info['LOGINUSER'] == 'H388545') { ?>                
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> CONCOURS</a>
 <br>
 <?php } ?>
                <?php if ($info['LOGINUSER']== 'E319795'OR $info['LOGINUSER']== 'H388545') { ?>         
                    <div class="row">
                      @php 
                      $NBRE_COMM=$stat['NBRE_COMM'];
                      $NBRE_ARR_ADM=$stat['NBRE_ARR_ADM'];
                      $NBRE_MF=$stat['NBRE_MF'];
                      $NBRE_FF=$stat['NBRE_FF'];
                      $NBRE_COMM_OUVR=$stat['NBRE_COMM_OUVR'];
                      $NBRE_ARR_OUVR=$stat['NBRE_ARR_OUVR'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_MF}}" id="NBRE_MF">
                        <input type="hidden" value ="{{$NBRE_FF}}" id="NBRE_FF">
                        <input type="hidden" value ="{{$NBRE_COMM}}" id="NBRE_COMM">
                        <input type="hidden" value ="{{$NBRE_ARR_ADM}}" id="NBRE_ARR_ADM">

                        <input type="hidden" value ="{{$NBRE_COMM_OUVR}}" id="NBRE_COMM_OUVR">
                        <input type="hidden" value ="{{$NBRE_ARR_OUVR}}" id="NBRE_ARR_OUVR">
                      
                     <!-- Cards with few info -->
                     
 
                 
                     <div class="col-lg-3 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Communiqué d'admission</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_COMM}}</h2>
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
                             <h2 class="mb-0">{{$NBRE_ARR_ADM}}</h2>
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
                     <div class="col-lg-3 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Communiqué d'ouverture</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_COMM_OUVR}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('comm_ouv')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                     <div class="col-lg-3 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Arrêté d'ouverture</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_ARR_OUVR}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('arrete_ouv')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                    </div>


                    <!-- Donut Chart -->
                                        
<?php  if ($info['LOGINUSER'] != 'E319795' OR $info['LOGINUSER'] == 'H388545') { ?>  
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
                   <?php } ?> 
                    <!-- ######################################################## FIN CONCOURS ############################################## -->
                      <!-- /Donut Chart -->






                        <!-- ######################################################## DGAPCE  ############################################## -->

  <?php  if ($info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>  
  <br>              
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> DGAPCE</a>
 <br>
 <?php } ?>
                <?php if ($info['LOGINUSER']== 'X477231'  OR $info['LOGINUSER'] == 'Z444473' OR $info['LOGINUSER']== 'T279354') { ?>          
                    <div class="row">
                      @php 
                      $NBRE_PB=$stat['NBRE_PB'];
                      $NBRE_RGS=$stat['NBRE_RGS'];
                      $NBRE_ARSA=$stat['NBRE_ARSA'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_PB}}" id="NBRE_PB">
                        <input type="hidden" value ="{{$NBRE_RGS}}" id="NBRE_RGS">
                        <input type="hidden" value ="{{$NBRE_ARSA}}" id="NBRE_ARSA">
                      
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


                    <!-- Donut Chart -->
                                        
 <?php  if ($info['LOGINUSER'] != 'T279354' && $info['LOGINUSER'] != 'Z444473') { ?>  

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
                          <div id="diagramme_instance_dgapce"></div>
                        </div>
        <?php } ?>              
                   <?php } ?> 
                    <!-- ######################################################## FIN DGAPCE ############################################## -->



                       <!-- ######################################################## DAF  ############################################## -->

  <?php  if ($info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>
  <br>                
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> DAF</a>
 <br>
 <?php } ?>
                <?php if ($info['LOGINUSER']== 'J435402' OR $info['LOGINUSER'] == 'Z444473' OR $info['LOGINUSER']== 'T279354' ) { ?>         
                    <div class="row">
                      @php 
                      $NBRE_AP=$stat['NBRE_AP'];
                      $NBRE_DP=$stat['NBRE_DP'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_AP}}" id="NBRE_AP">
                        <input type="hidden" value ="{{$NBRE_DP}}" id="NBRE_DP">
                      
                     <!-- Cards with few info -->
                     
                     <div class="col-lg-6 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                               <h5 class="m-0 me-2">Attestation de Prime</h5>
                               <hr>


                               <h2 class="mb-0">{{$NBRE_AP}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-primary rounded-pill p-2">
                               <i class='ti ti-files ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('att_prime')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                     <div class="col-lg-6 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Domiciliation de Prime</h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_DP}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-success rounded-pill p-2">
                               <i class='ti ti-book ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('dom_prime')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                   
                     
                    </div>


                    <!-- Donut Chart -->
                                        
     <?php  if ($info['LOGINUSER'] != 'T279354' && $info['LOGINUSER'] != 'Z444473') { ?>  

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
                          <div id="diagramme_instance_daf"></div>
                        </div>
    <?php } ?> 
                   <?php } ?> 
                    <!-- ######################################################## FIN DAF ############################################## -->



                     <!-- ######################################################## CCM  ############################################## AND $info['LOGINUSER'] != 'X505234' -->

          <?php  if ($info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473' OR $info['FONCTION']== 'MINISTRE' ) { ?>
          <br>                
         <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> ACTES DE MISE EN FORMATION HORS CÔTE D'IVOIRE</a>
         <br>
         <?php } ?>
                <?php if ($info['FONCTION']== 'MINISTRE'  ) { ?>         
                    <div class="row">
                      @php 
                      $NBRE_AP=$stat['NBRE_AP'];
                      $NBRE_DP=$stat['NBRE_DP'];
                      @endphp

                        <input type="hidden" value ="{{$NBRE_CCM_INSTANCE}}" id="NBRE_CCM_INSTANCE">
                        <input type="hidden" value ="{{$NBRE_CCM_SIGNE}}" id="NBRE_CCM_SIGNE">
                      
                     <!-- Cards with few info -->
                     
                     <div class="col-lg-6 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0" id="actualiser">
                               <h5 class="m-0 me-2">Mes documents a signer</h5>
                               <hr>


                               <h2 class="mb-0">{{$NBRE_CCM_INSTANCE}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-primary rounded-pill p-2">
                               <i class='ti ti-files ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('ccm_instance')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                     <div class="col-lg-6 col-sm-6 mb-4" >
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0" id="actualiser1">
                             <h5 class="m-0 me-2">documents signés </h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_CCM_SIGNE}}</h2>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-success rounded-pill p-2">
                               <i class='ti ti-book ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('ccm_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                   
                     
                    </div>


                    <!-- Donut Chart -->
                                        
     <?php  if ($info['FONCTION'] == 'MINISTRE' && $info['LOGINUSER'] != 'Z444473') { ?>  

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
                          <div id="diagramme_instance_ccm"></div>
                        </div>
    <?php } ?> 
                   <?php } ?> 
                    <!-- ######################################################## FIN CCM ############################################## -->
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

<script >
    var auto_refresh = setInterval(
    function() {
      $('#actualiser').load('# #actualiser');
      $('#actualiser1').load('# #actualiser1');
    },4000);


    </script>