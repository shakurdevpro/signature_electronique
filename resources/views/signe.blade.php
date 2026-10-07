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
                          <input type="submit" id="filter" name="filter" class="btn btn-primary waves-effect waves-light" style="background-color: orange" value="Filtrer">
                        </div>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
                <!-- /Color Picker-->
              </div>
            </div>






           



              
         <div class="row">



 <?php  if ($info['LOGINUSER'] != 'T279354' && $info['LOGINUSER'] != 'Z444473') { ?>                

<!-- ######################################################## MINISTRE ############################################## -->

 
 

                <?php if ($info['FONCTION']=='MINISTRE') { ?>  
               <!-- Donut Chart -->
              <div class="col-md-4 col-12 mb-4">
                <div class="card">
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
                    <div id="diagramme_signe"></div>
                  </div>
                </div>
              </div>
              <!-- /Donut Chart -->


                <!-- Bar Chart -->
                <div class="col-md-8 col-12 mb-4">
                  <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                       <div class="dropdown">
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
                      <div id="diagramme_annee"></div>
                    </div>
                  </div>
                </div>
                <!-- /Bar Chart -->


<?php } ?> 
<!-- ######################################################## FIN MINISTRE ############################################## -->




<!-- ######################################################## DGAPCE ############################################## -->
                <?php if ($info['LOGINUSER']== 'X477231') { ?>   
               <!-- Donut Chart -->
              <div class="col-md-4 col-12 mb-4">
                <div class="card">
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
                    <div id="diagramme_dgapce_signe"></div>
                  </div>
                </div>
              </div>
              <!-- /Donut Chart -->


                <!-- Bar Chart -->
                <div class="col-md-8 col-12 mb-4">
                  <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                       <div class="dropdown">
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
                      <div id="diagramme_dgapce_annee"></div>
                    </div>
                  </div>
                </div>
                <!-- /Bar Chart -->


<?php } ?> 
<!-- ######################################################## FIN DGAPCE ############################################## -->



<!-- ######################################################## DAF ############################################## -->
               <?php if ($info['LOGINUSER']== 'J435402' ) { ?>  
               <!-- Donut Chart -->
              <div class="col-md-4 col-12 mb-4">
                <div class="card">
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
                    <div id="diagramme_daf_signe"></div>
                  </div>
                </div>
              </div>
              <!-- /Donut Chart -->


                <!-- Bar Chart -->
                <div class="col-md-8 col-12 mb-4">
                  <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                       <div class="dropdown">
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
                      <div id="diagramme_daf_annee"></div>
                    </div>
                  </div>
                </div>
                <!-- /Bar Chart -->


<?php } ?> 
<!-- ######################################################## FIN DAF ############################################## -->

<?php } ?>
           
         </div>


              
            
            
            
            

             




                <div class="container-xxl flex-grow-1 container-p-y">
                 <!-- ######################################################## MINISTRE ############################################## -->


<?php  if ($info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>                
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> MINISTRE</a>
 <br>
 <?php } ?>


                <?php if ($info['FONCTION']=='MINISTRE' OR $info['LOGINUSER'] == 'Z444473'  OR $info['LOGINUSER']== 'T279354') { ?>            <?php //var_dump($stat_impact); die; ?>     
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

                          $NBRE_COMM_OUVR=$array[10];
                          $NBRE_ARR_OUVR=$array[11];


                          // liste des personnes impacté

                          $array_impact = explode('|', $stat_impact);

                          $array_impact = array_map('trim', $array_impact);

                            $impact_MF=$array_impact[1];
                            $impact_FF=$array_impact[2];
                            $impact_COMM=$array_impact[3];
                            $impact_ARR_ADM=$array_impact[4];
                            $impact_AP=$array_impact[5];
                            $impact_DP=$array_impact[6];
                            $impact_PB=$array_impact[7];
                            $impact_RGS=$array_impact[8];
                           // $impact_ARSA=$array_impact[9];

                         // $impact_COMM_OUVR=$array_impact[10];
                        //  $impact_ARR_OUVR=$array_impact[11];


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
                               <h6 class="mb-0">{{$impact_MF}} Personne(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-primary rounded-pill p-2">
                               <i class='ti ti-files ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('mise_formation_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h6 class="mb-0">{{$impact_FF}} Personne(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-success rounded-pill p-2">
                               <i class='ti ti-book ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('fin_formation_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h6 class="mb-0">{{$impact_COMM}} Personne(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-danger rounded-pill p-2">
                               <i class='ti ti-file ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('communique_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                     <div class="col-lg-2 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Arreté d'Admission </h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_ARR_ADM}}</h2>
                             <h6 class="mb-0">{{$impact_ARR_ADM}} Personne(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('arrete_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h6 class="mb-0">Concours</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('comm_ouv_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h6 class="mb-0">Concours</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('arrete_ouv_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                    </div>

<?php } ?> 
                    <!-- ######################################################## FIN MINISTRE ############################################## -->









                 <!-- ######################################################## DFRC ############################################## -->


<?php  if ( $info['LOGINUSER'] == 'K349954') { ?>                
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> DFRC</a>
 <br>
 <?php } ?>


                <?php if ( $info['LOGINUSER']== 'K349954') { ?>            <?php //var_dump($stat_impact); die; ?>     
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

                          $NBRE_COMM_OUVR=$array[10];
                          $NBRE_ARR_OUVR=$array[11];


                          // liste des personnes impacté

                          $array_impact = explode('|', $stat_impact);

                          $array_impact = array_map('trim', $array_impact);

                            $impact_MF=$array_impact[1];
                            $impact_FF=$array_impact[2];
                            $impact_COMM=$array_impact[3];
                            $impact_ARR_ADM=$array_impact[4];
                            $impact_AP=$array_impact[5];
                            $impact_DP=$array_impact[6];
                            $impact_PB=$array_impact[7];
                            $impact_RGS=$array_impact[8];
                           // $impact_ARSA=$array_impact[9];

                         // $impact_COMM_OUVR=$array_impact[10];
                        //  $impact_ARR_OUVR=$array_impact[11];


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
                               <h6 class="mb-0">{{$impact_MF}} Personne(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-primary rounded-pill p-2">
                               <i class='ti ti-files ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('mise_formation_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h6 class="mb-0">{{$impact_FF}} Personne(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-success rounded-pill p-2">
                               <i class='ti ti-book ti-sm'></i>
                             </span>
                           </div>
                         </div>

 <a href="{{route('fin_formation_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                    
                   
                   
                    
                    </div>

<?php } ?> 
                    <!-- ######################################################## FIN DFRC ############################################## -->





                 <!-- ######################################################## CONCOURS ############################################## -->


<?php  if ($info['LOGINUSER'] == 'E319795' OR $info['LOGINUSER'] == 'H388545' ) { ?>                
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> CONCOURS</a>
 <br>
 <?php } ?>


                <?php if ( $info['LOGINUSER']== 'E319795' OR $info['LOGINUSER'] == 'H388545') { ?>            <?php //var_dump($stat_impact); die; ?>     
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

                          $NBRE_COMM_OUVR=$array[10];
                          $NBRE_ARR_OUVR=$array[11];


                          // liste des personnes impacté

                          $array_impact = explode('|', $stat_impact);

                          $array_impact = array_map('trim', $array_impact);

                            $impact_MF=$array_impact[1];
                            $impact_FF=$array_impact[2];
                            $impact_COMM=$array_impact[3];
                            $impact_ARR_ADM=$array_impact[4];
                            $impact_AP=$array_impact[5];
                            $impact_DP=$array_impact[6];
                            $impact_PB=$array_impact[7];
                            $impact_RGS=$array_impact[8];
                           // $impact_ARSA=$array_impact[9];

                         // $impact_COMM_OUVR=$array_impact[10];
                        //  $impact_ARR_OUVR=$array_impact[11];


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
                             <h6 class="mb-0">{{$impact_COMM}} Personne(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-danger rounded-pill p-2">
                               <i class='ti ti-file ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('communique_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                     <div class="col-lg-3 col-sm-6 mb-4">
                       <div class="card">
                         <div class="card-body d-flex justify-content-between align-items-center">
                           <div class="card-title mb-0">
                             <h5 class="m-0 me-2">Arreté d'Admission </h5>
                             <hr>
                             <h2 class="mb-0">{{$NBRE_ARR_ADM}}</h2>
                             <h6 class="mb-0">{{$impact_ARR_ADM}} Personne(s)</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('arrete_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h6 class="mb-0">Concours</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('comm_ouv_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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
                             <h6 class="mb-0">Concours</h6>
                           </div>
                           <div class="card-icon">
                             <span class="badge bg-label-warning rounded-pill p-2">
                               <i class='ti ti-folder ti-sm'></i>
                             </span>
                           </div>
                         </div>
 <a href="{{route('arrete_ouv_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>

                       </div>
                     </div>
                    </div>

<?php } ?> 
                    <!-- ######################################################## FIN CONCOURS ############################################## -->


 <!-- ######################################################## DGAPCE ############################################## -->

 <?php  if ($info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>  
<br>              
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> DGAPCE</a>
 <br>
 <?php } ?>

                <?php if ($info['LOGINUSER']== 'X477231' OR $info['LOGINUSER'] == 'Z444473'  OR $info['LOGINUSER']== 'T279354') { ?>         
                    <div class="row">
                      @php 
                          $array = explode('|', $stat);
                          // Supprimer les espaces vides au début et à la fin de chaque élément du tableau
                           $array = array_map('trim', $array);
                          // Afficher le résultat
                          $NBRE_COMM=$array[1];
                          $NBRE_ARR_ADM=$array[2];
                          $NBRE_MF=$array[3];
                          $NBRE_FF=$array[4];
                           $NBRE_AP=$array[5];
                          $NBRE_DP=$array[6];
                          $NBRE_PB=$array[7];
                          $NBRE_RGS=$array[8];
                          $NBRE_ARSA=$array[9];
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
                             <h2 class="mb-0">{{$NBRE_RGS}}</h2>
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
                             <h2 class="mb-0">{{$NBRE_ARSA}}</h2>
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




 <!-- ######################################################## DAF ############################################## -->

 <?php  if ($info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>  
<br>              
 <a class="btn btn-primary d-block mx-auto waves-effect waves-light" style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;"> DGAPCE</a>
 <br>
 <?php } ?>

               <?php if ($info['LOGINUSER']== 'J435402' OR $info['LOGINUSER'] == 'Z444473'  OR $info['LOGINUSER']== 'T279354' ) { ?>           
                    <div class="row">
                      @php 
                          $array = explode('|', $stat);
                          // Supprimer les espaces vides au début et à la fin de chaque élément du tableau
                           $array = array_map('trim', $array);
                          // Afficher le résultat
                          $NBRE_COMM=$array[1];
                          $NBRE_ARR_ADM=$array[2];
                          $NBRE_MF=$array[3];
                          $NBRE_FF=$array[4];
                           $NBRE_AP=$array[5];
                          $NBRE_DP=$array[6];
                          $NBRE_PB=$array[7];
                          $NBRE_RGS=$array[8];
                          $NBRE_ARSA=$array[9];
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

 <a href="{{route('att_prime_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
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

 <a href="{{route('dom_prime_signe')}}" class="btn btn-primary waves-effect waves-light" style = "background-color: #28c76f !important; border-color:#28c76f; border-radius: 1px 0 3px 4px !important;" >
                          <span class="ti-xs ti ti-eye me-1"></span>VOIR LA LISTE
                         </a>
                       </div>
                     </div>
                     
                   
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

