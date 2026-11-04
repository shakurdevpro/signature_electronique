@extends('layouts.base')

@section('title', 'Mise en formation')

@section('styles')


@endsection

@section('content')

    @php
        extract(\App\Support\StatCardsData::build($stat));
    @endphp

    <!-- content -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('components.pagetitle')
                    <div class="nk-block">
                        <div class="row g-gs">
                            <x-stat-cards :stat="$stat" :info="$info" />
                        </div><!-- .row -->
                    </div><!-- .nk-block -->
                    @php
                        $titresRoutes = [
                            'mise_formation' => 'LISTE DES ACTES DE MISE EN FORMATION',
                            'fin_formation' => 'LISTE DES ACTES DE FIN DE FORMATION',
                            'communique' => "LISTE DES COMMUNIQUÉS D'ADMISSION",
                            'arrete' => "LISTE DES ARRÊTÉS D'ADMISSION",
                            'comm_ouv' => "LISTE DES COMMUNIQUÉS D'OUVERTURE",
                            'arrete_ouv' => "LISTE DES ARRÊTÉS D'OUVERTURE",
                        ];
                        $titrePage =
                            $titresRoutes[Route::currentRouteName()] ?? 'LISTE DES ACTES EN INSTANCE DE SIGNATURE';
                    @endphp
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-12 nk-block-head">
                                <div class="nk-block-head-content"
                                    style="background: #FFFFFF; border: 1px solid #E5E9F2; border-radius: 5px; padding: 18px 20px 0;">
                                    <h5 class="title nk-block-title mt-1 mb-3" style="text-align: center;">
                                        {{ $titrePage }}
                                    </h5>
                                    <div style="display: flex; height: 4px; margin: 0 -20px;">
                                        <div style="background: #F59E0B; flex: 1;"></div>
                                        <div style="background: #FFFFFF; flex: 1;"></div>
                                        <div style="background: #28A745; flex: 1;"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .row -->
                    </div><!-- .nk-block -->
                    <div class="nk-block">
                        <div class="card card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner position-relative card-tools-toggle">
                                    <div class="card-title-group">
                                        <div class="card-tools">
                                            <div class="form-inline flex-nowrap gx-3">
                                                <div class="form-wrap w-150px">
                                                    <select class="form-select form-select-sm" data-search="off"
                                                        data-placeholder="Bulk Action">
                                                        <option value="">Bulk Action</option>
                                                        <option value="email">Send Email</option>
                                                        <option value="group">Change Group</option>
                                                        <option value="suspend">Suspend User</option>
                                                        <option value="delete">Delete User</option>
                                                    </select>
                                                </div>
                                                <div class="btn-wrap">
                                                    <span class="d-none d-md-block"><button
                                                            class="btn btn-dim btn-outline-light disabled">Apply</button></span>
                                                    <span class="d-md-none"><button
                                                            class="btn btn-dim btn-outline-light btn-icon disabled"><em
                                                                class="icon ni ni-arrow-right"></em></button></span>
                                                </div>
                                            </div><!-- .form-inline -->
                                        </div><!-- .card-tools -->
                                        <div class="card-tools mr-n1">
                                            <ul class="btn-toolbar gx-1">
                                                <li>
                                                    <a href="#" class="btn btn-icon search-toggle toggle-search"
                                                        data-target="search"><em class="icon ni ni-search"></em></a>
                                                </li><!-- li -->
                                                <li class="btn-toolbar-sep"></li><!-- li -->
                                                <li>
                                                    <div class="toggle-wrap">
                                                        <a href="#" class="btn btn-icon btn-trigger toggle"
                                                            data-target="cardTools"><em
                                                                class="icon ni ni-menu-right"></em></a>
                                                        <div class="toggle-content" data-content="cardTools">
                                                            <ul class="btn-toolbar gx-1">
                                                                <li class="toggle-close">
                                                                    <a href="#"
                                                                        class="btn btn-icon btn-trigger toggle"
                                                                        data-target="cardTools"><em
                                                                            class="icon ni ni-arrow-left"></em></a>
                                                                </li><!-- li -->
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#"
                                                                            class="btn btn-trigger btn-icon dropdown-toggle"
                                                                            data-toggle="dropdown">
                                                                            <div class="dot dot-primary"></div>
                                                                            <em class="icon ni ni-filter-alt"></em>
                                                                        </a>
                                                                        <div
                                                                            class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                                            <div class="dropdown-head">
                                                                                <span
                                                                                    class="sub-title dropdown-title">Filter
                                                                                    Users</span>
                                                                                <div class="dropdown">
                                                                                    <a href="#"
                                                                                        class="btn btn-sm btn-icon">
                                                                                        <em class="icon ni ni-more-h"></em>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="dropdown-body dropdown-body-rg">
                                                                                <div class="row gx-6 gy-3">
                                                                                    <div class="col-6">
                                                                                        <div
                                                                                            class="custom-control custom-control-sm custom-checkbox">
                                                                                            <input type="checkbox"
                                                                                                class="custom-control-input"
                                                                                                id="hasBalance">
                                                                                            <label
                                                                                                class="custom-control-label"
                                                                                                for="hasBalance"> Have
                                                                                                Balance</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div
                                                                                            class="custom-control custom-control-sm custom-checkbox">
                                                                                            <input type="checkbox"
                                                                                                class="custom-control-input"
                                                                                                id="hasKYC">
                                                                                            <label
                                                                                                class="custom-control-label"
                                                                                                for="hasKYC"> KYC
                                                                                                Verified</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="overline-title overline-title-alt">Role</label>
                                                                                            <select
                                                                                                class="form-select form-select-sm">
                                                                                                <option value="any">Any
                                                                                                    Role</option>
                                                                                                <option value="investor">
                                                                                                    Investor</option>
                                                                                                <option value="seller">
                                                                                                    Seller</option>
                                                                                                <option value="buyer">Buyer
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="overline-title overline-title-alt">Status</label>
                                                                                            <select
                                                                                                class="form-select form-select-sm">
                                                                                                <option value="any">Any
                                                                                                    Status</option>
                                                                                                <option value="active">
                                                                                                    Active</option>
                                                                                                <option value="pending">
                                                                                                    Pending</option>
                                                                                                <option value="suspend">
                                                                                                    Suspend</option>
                                                                                                <option value="deleted">
                                                                                                    Deleted</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="form-group">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary">Filter</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="dropdown-foot between">
                                                                                <a class="clickable" href="#">Reset
                                                                                    Filter</a>
                                                                                <a href="#">Save Filter</a>
                                                                            </div>
                                                                        </div><!-- .filter-wg -->
                                                                    </div><!-- .dropdown -->
                                                                </li><!-- li -->
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#"
                                                                            class="btn btn-trigger btn-icon dropdown-toggle"
                                                                            data-toggle="dropdown">
                                                                            <em class="icon ni ni-setting"></em>
                                                                        </a>
                                                                        <div
                                                                            class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                            <ul class="link-check">
                                                                                <li><span>Show</span></li>
                                                                                <li class="active"><a
                                                                                        href="#">10</a></li>
                                                                                <li><a href="#">20</a></li>
                                                                                <li><a href="#">50</a></li>
                                                                            </ul>
                                                                            <ul class="link-check">
                                                                                <li><span>Order</span></li>
                                                                                <li class="active"><a
                                                                                        href="#">DESC</a></li>
                                                                                <li><a href="#">ASC</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div><!-- .dropdown -->
                                                                </li><!-- li -->
                                                            </ul><!-- .btn-toolbar -->
                                                        </div><!-- .toggle-content -->
                                                    </div><!-- .toggle-wrap -->
                                                </li><!-- li -->
                                            </ul><!-- .btn-toolbar -->
                                        </div><!-- .card-tools -->
                                    </div><!-- .card-title-group -->
                                    <div class="card-search search-wrap" data-search="search">
                                        <div class="card-body">
                                            <div class="search-content">
                                                <a href="#" class="search-back btn btn-icon toggle-search"
                                                    data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                                <input type="text"
                                                    class="form-control border-transparent form-focus-none"
                                                    placeholder="Search by user or email">
                                                <button class="search-submit btn btn-icon"><em
                                                        class="icon ni ni-search"></em></button>
                                            </div>
                                        </div>
                                    </div><!-- .card-search -->
                                </div><!-- .card-inner -->
                                <div class="card-inner p-0">
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="uid">
                                                    <label class="custom-control-label" for="uid"></label>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col"><span class="sub-text">N° ACTE</span></div>
                                            <div class="nk-tb-col tb-col-mb"><span class="sub-text">NATURE ACTE</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-md"><span class="sub-text">TYPE CONCOURS</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-lg"><span class="sub-text">EMPLOI</span></div>
                                            <div class="nk-tb-col tb-col-lg"><span class="sub-text">ANNÉE</span></div>
                                            <div class="nk-tb-col tb-col-md"><span class="sub-text">VOIR</span></div>
                                            <div class="nk-tb-col nk-tb-col-tools text-right"><span
                                                    class="sub-text">ACTIONS</span></div>
                                        </div><!-- .nk-tb-item -->

                                        @foreach ($doc as $d)
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="uid{{ $loop->iteration }}">
                                                        <label class="custom-control-label"
                                                            for="uid{{ $loop->iteration }}"></label>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="tb-amount">{{ $d['NUMERO_ACTE'] }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-mb">
                                                    <span class="tb-amount">{{ $d['NATURE_ACTE_LIB'] }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span>{{ $d['TYPECONC_LIB'] ?? '' }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-lg">
                                                    <ul class="list-status">
                                                        <li>
                                                            <span>{{ $d['CONC_LIB'] ?? '' }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="nk-tb-col tb-col-lg">
                                                    <span>{{ $d['ANNEE'] ?? '' }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <a href="javascript:;" class="modal-click-document"
                                                        id="{{ $d['NOM_FICHIER'] . '.PDF' }}" name="listepresence"
                                                        title="PROCES VERBAL"
                                                        data-file="{{ rawurlencode($d['NOM_FICHIER'] . '.PDF') }}"
                                                        data-title="{{ $d['NATURE_ACTE_LIB'] }} N° {{ $d['NUMERO_ACTE'] }}">
                                                        <em class="icon ni ni-eye"></em>
                                                    </a>
                                                </div>
                                                <div class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">

                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#"
                                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-toggle="dropdown"><em
                                                                        class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><em
                                                                                    class="icon ni ni-focus"></em><span>Quick
                                                                                    View</span></a></li>
                                                                        <li><a href="#"><em
                                                                                    class="icon ni ni-eye"></em><span>View
                                                                                    Details</span></a></li>
                                                                        <li><a href="#"><em
                                                                                    class="icon ni ni-repeat"></em><span>Transaction</span></a>
                                                                        </li>
                                                                        <li><a href="#"><em
                                                                                    class="icon ni ni-activity-round"></em><span>Activities</span></a>
                                                                        </li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#"><em
                                                                                    class="icon ni ni-shield-star"></em><span>Reset
                                                                                    Pass</span></a></li>
                                                                        <li><a href="#"><em
                                                                                    class="icon ni ni-shield-off"></em><span>Reset
                                                                                    2FA</span></a></li>
                                                                        <li><a href="#"><em
                                                                                    class="icon ni ni-na"></em><span>Suspend
                                                                                    User</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div><!-- .nk-tb-item -->
                                        @endforeach

                                    </div><!-- .nk-tb-list -->
                                </div><!-- .card-inner -->
                                <div class="card-inner">
                                    <div class="nk-block-between-md g-3">
                                        <div class="g">
                                            <ul class="pagination justify-content-center justify-content-md-start">
                                                <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><span class="page-link"><em
                                                            class="icon ni ni-more-h"></em></span></li>
                                                <li class="page-item"><a class="page-link" href="#">6</a></li>
                                                <li class="page-item"><a class="page-link" href="#">7</a></li>
                                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                            </ul><!-- .pagination -->
                                        </div>
                                        <div class="g">
                                            <div
                                                class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                                <div>Page</div>
                                                <div>
                                                    <select class="form-select form-select-sm" data-search="on"
                                                        data-dropdown="xs center">
                                                        <option value="page-1">1</option>
                                                        <option value="page-2">2</option>
                                                        <option value="page-4">4</option>
                                                        <option value="page-5">5</option>
                                                        <option value="page-6">6</option>
                                                        <option value="page-7">7</option>
                                                        <option value="page-8">8</option>
                                                        <option value="page-9">9</option>
                                                        <option value="page-10">10</option>
                                                        <option value="page-11">11</option>
                                                        <option value="page-12">12</option>
                                                        <option value="page-13">13</option>
                                                        <option value="page-14">14</option>
                                                        <option value="page-15">15</option>
                                                        <option value="page-16">16</option>
                                                        <option value="page-17">17</option>
                                                        <option value="page-18">18</option>
                                                        <option value="page-19">19</option>
                                                        <option value="page-20">20</option>
                                                    </select>
                                                </div>
                                                <div>OF 102</div>
                                            </div>
                                        </div><!-- .pagination-goto -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .card-inner -->
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->

                </div>
            </div>
        </div>
    </div>
    <!-- content -->
    <div class="modal fade" tabindex="-1" id="modaldocument">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Document</h5>
                </div>
                <div class="modal-body" id="affichage-lien">
                    <div class="alert alert-danger" role="alert">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        OUVERTURE DU DOCUMENT . . .
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        console.log('[VUE] script dashCharts exécuté');
        window.dashCharts = window.dashCharts || {};

        (function() {
            var cards = @json($chartData);
            var labels = @json($chartLabels);

            console.log('[VUE] cartes reçues :', cards);
            cards.forEach(function(c) {
                var conf = {
                    labels: labels || c.data.map(function(_, i) {
                        return i + 1;
                    }),
                    dataUnit: 'Documents',
                    lineTension: .3,
                    datasets: [{
                        label: c.title,
                        color: c.color,
                        background: 'transparent',
                        data: c.data
                    }]
                };

                window.dashCharts[c.id] = conf;

                // même config pour la version DFRC (ids : chart_dfrc_MF, chart_dfrc_FF)
                window.dashCharts[c.id.replace('chart_', 'chart_dfrc_')] = conf;

                // même config pour la version CONCOURS (ids : chart_concours_COMM, chart_concours_ARR_ADM, ...)
                window.dashCharts[c.id.replace('chart_', 'chart_concours_')] = conf;

                console.log('[VUE] enregistré :', c.id, 'canvas présent ?', !!document.getElementById(c.id));
            });
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function ouvrirDocument(idDocument) {
                var modalEl = document.getElementById('modaldocument');
                var cible = document.getElementById('affichage-lien');
                var url = '/document/' + encodeURIComponent(idDocument);

                cible.innerHTML =
                    '<iframe src="' + url + '" style="width:100%; height:75vh; border:0;"></iframe>';

                // Bootstrap 4 (via jQuery) ou Bootstrap 5, selon ce que le layout charge
                if (window.jQuery && jQuery.fn.modal) {
                    jQuery(modalEl).modal('show');
                } else if (window.bootstrap) {
                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                } else {
                    console.error('Bootstrap JS introuvable : le modal ne peut pas s\'ouvrir.');
                }
            }

            document.addEventListener('click', function(e) {
                var lien = e.target.closest('.modal-click-document');
                if (!lien) return;
                e.preventDefault();
                ouvrirDocument(lien.getAttribute('id'));
            });

            document.getElementById('modaldocument').addEventListener('hidden.bs.modal', function() {
                document.getElementById('affichage-lien').innerHTML = '';
            });
        });
    </script>
@endsection
