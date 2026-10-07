


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
                            <!-- Donut Chart -->
                            <div class="col-md-3 col-12 mb-4">
                              <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                  <div>
                                    <h5 class="card-title mb-0">Mise en formation</h5>
                                  </div>
                                  <!--
                                  <div class="dropdown d-none d-sm-flex">
                                    <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-calendar"></i></button>
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
                                  -->
                                </div>
                                <div class="card-body">
                                  <div id="donutChart"></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3 col-12 mb-4">
                                <div class="card">
                                  <div class="card-header d-flex align-items-center justify-content-between">
                                    <div>
                                      <h5 class="card-title mb-0">Fin de formation</h5>
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <div id="donutChart2"></div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3 col-12 mb-4">
                                <div class="card">
                                  <div class="card-header d-flex align-items-center justify-content-between">
                                    <div>
                                      <h5 class="card-title mb-0">Commission d'admission</h5>
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <div id="donutChart3"></div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3 col-12 mb-4">
                                <div class="card">
                                  <div class="card-header d-flex align-items-center justify-content-between">
                                    <div>
                                      <h5 class="card-title mb-0">Arreté d'admmission</h5>
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <div id="donutChart4"></div>
                                  </div>
                                </div>
                              </div>
                            <!-- /Donut Chart -->
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
                                            <td></td>
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
                </div>
                <!--/ Content wrapper -->
            </div>
        <!--/ Layout container -->
        </div>
    </div>
    <!--/ Layout wrapper -->
@endsection

