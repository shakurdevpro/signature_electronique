@extends('layouts.base')

@section('title', 'Mise en formation')

@section('styles')
    <style>
        /* Défilement horizontal du tableau sur petits écrans */
        .data-table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .data-table-responsive .nk-tb-list {
            min-width: 900px;
        }

        /* Colonnes à largeur fixe */
        .data-table-responsive .nk-tb-item>.nk-tb-col-check {
            flex: 0 0 48px !important;
            width: 48px !important;
            min-width: 48px !important;
        }

        .data-table-responsive .nk-tb-item>.nk-tb-col-voir {
            flex: 0 0 70px !important;
            width: 70px !important;
            min-width: 70px !important;
            white-space: nowrap;
        }

        .data-table-responsive .nk-tb-item>.nk-tb-col-tools {
            flex: 0 0 130px !important;
            width: 130px !important;
            min-width: 130px !important;
            padding-right: 0.75rem !important;
            white-space: nowrap;
            overflow: hidden;
        }

        /* Boutons d'action alignés à gauche */
        .data-table-responsive .nk-tb-actions {
            display: flex;
            flex-wrap: nowrap;
            justify-content: flex-start;
            margin: 0;
            padding: 0;
        }

        .data-table-responsive .nk-tb-actions .btn {
            white-space: nowrap;
        }

        /* Espacement des éléments de la barre d'outils */
        .data-table-filters {
            gap: 8px;
        }

        .data-table-actions {
            gap: 8px;
        }

        .data-table-filters .dropdown-menu {
            min-width: 280px;
        }
    </style>
@endsection

@section('content')

    @php
        // Données des cartes statistiques et graphiques
        extract(\App\Support\StatCardsData::build($stat));

        // Utilisateurs en lecture seule
        $isReadOnly = in_array($info['LOGINUSER'], ['T279354', 'Z444473']);

        // Titre de la page selon la route courante
        $titresRoutes = [
            'mise_formation' => 'LISTE DES ACTES DE MISE EN FORMATION',
            'fin_formation' => 'LISTE DES ACTES DE FIN DE FORMATION',
            'communique' => "LISTE DES COMMUNIQUÉS D'ADMISSION",
            'arrete' => "LISTE DES ARRÊTÉS D'ADMISSION",
            'comm_ouv' => "LISTE DES COMMUNIQUÉS D'OUVERTURE",
            'arrete_ouv' => "LISTE DES ARRÊTÉS D'OUVERTURE",
        ];

        $titrePage = $titresRoutes[Route::currentRouteName()] ?? 'LISTE DES ACTES EN INSTANCE DE SIGNATURE';

        // Valeurs des listes déroulantes des filtres
        $listeTypes = collect($doc)->pluck('TYPECONC_LIB')->filter()->unique()->sort()->values();
        $listeEmplois = collect($doc)->pluck('CONC_LIB')->filter()->unique()->sort()->values();
        $listeAnnees = collect($doc)->pluck('ANNEE')->filter()->unique()->sortDesc()->values();
    @endphp

    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    @include('components.pagetitle')

                    {{-- Cartes de statistiques --}}
                    <div class="nk-block">
                        <div class="row g-gs">
                            <x-stat-cards :stat="$stat" :info="$info" />
                        </div>
                    </div>

                    {{-- Titre de la liste --}}
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
                        </div>
                    </div>

                    {{-- Tableau réutilisable --}}
                    <div class="nk-block">

                        <x-data-table id="tableMiseFormation" :per-page="10" empty-message="Aucun résultat."
                            search-placeholder="Rechercher par n° acte, nature acte, type concours, emploi ou année">

                            {{-- FILTRES PERSONNALISÉS --}}
                            <x-slot:filters>

                                <div class="dropdown">
                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle"
                                        data-toggle="dropdown">

                                        <div class="dot dot-primary" id="dotFiltre" style="display: none;"></div>

                                        <em class="icon ni ni-filter-alt"></em>
                                    </a>

                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">

                                        <div class="dropdown-head">
                                            <span class="sub-title dropdown-title">
                                                Filtrer les actes
                                            </span>
                                        </div>

                                        <div class="dropdown-body dropdown-body-rg">
                                            <div class="row gx-6 gy-3">

                                                {{-- Filtre par type de concours --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="overline-title overline-title-alt">
                                                            Type concours
                                                        </label>

                                                        <select class="form-control form-control-sm" id="filtreType"
                                                            data-table-filter="type">
                                                            <option value="">Tous</option>

                                                            @foreach ($listeTypes as $v)
                                                                <option value="{{ $v }}">
                                                                    {{ $v }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Filtre par emploi --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="overline-title overline-title-alt">
                                                            Emploi
                                                        </label>

                                                        <select class="form-control form-control-sm" id="filtreEmploi"
                                                            data-table-filter="emploi">
                                                            <option value="">Tous</option>

                                                            @foreach ($listeEmplois as $v)
                                                                <option value="{{ $v }}">
                                                                    {{ $v }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Filtre par année --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="overline-title overline-title-alt">
                                                            Année
                                                        </label>

                                                        <select class="form-control form-control-sm" id="filtreAnnee"
                                                            data-table-filter="annee">
                                                            <option value="">Toutes</option>

                                                            @foreach ($listeAnnees as $v)
                                                                <option value="{{ $v }}">
                                                                    {{ $v }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Bouton de validation --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-primary" id="btnFiltrer"
                                                            data-table-apply-filters>
                                                            Filtrer
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="dropdown-foot between">
                                            <a class="clickable text-danger" href="#" id="resetFiltres"
                                                data-table-reset-filters>
                                                Réinitialiser
                                            </a>
                                        </div>

                                    </div>
                                </div>

                            </x-slot:filters>

                            {{-- ACTIONS --}}
                            <x-slot:actions>
                                @unless ($isReadOnly)
                                    <div class="btn-wrap" id="applyWrap" style="display: none;">

                                        <span class="d-none d-md-block">
                                            <button type="button" id="btnApply" class="btn btn-primary"
                                                onclick="envoyerRequete()">
                                                <em class="icon ni ni-edit me-2"></em>
                                                <span>Signer les documents</span>
                                            </button>
                                        </span>

                                        <span class="d-md-none">
                                            <button type="button" id="btnApplyMobile" class="btn btn-primary btn-icon"
                                                onclick="envoyerRequete()">
                                                <em class="icon ni ni-arrow-right"></em>
                                            </button>
                                        </span>

                                    </div>
                                @endunless
                            </x-slot:actions>

                            {{-- EN-TÊTE DU TABLEAU --}}
                            <x-slot:header>

                                @unless ($isReadOnly)
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="selectAllRows">
                                            <label class="custom-control-label" for="selectAllRows"></label>
                                        </div>
                                    </div>
                                @endunless

                                <div class="nk-tb-col">
                                    <span class="sub-text">N° ACTE</span>
                                </div>

                                <div class="nk-tb-col">
                                    <span class="sub-text">NATURE ACTE</span>
                                </div>

                                <div class="nk-tb-col">
                                    <span class="sub-text">TYPE CONCOURS</span>
                                </div>

                                <div class="nk-tb-col">
                                    <span class="sub-text">EMPLOI</span>
                                </div>

                                <div class="nk-tb-col">
                                    <span class="sub-text">ANNÉE</span>
                                </div>

                                <div class="nk-tb-col nk-tb-col-voir">
                                    <span class="sub-text">VOIR</span>
                                </div>

                                @unless ($isReadOnly)
                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <span class="sub-text">ACTIONS</span>
                                    </div>
                                @endunless

                            </x-slot:header>

                            {{-- LIGNES DU TABLEAU --}}
                            @foreach ($doc as $d)
                                @php
                                    $leDoc = $d['NOM_FICHIER'] . '.PDF';

                                    $disponible = file_exists(public_path('DOSSIER_SAVE/A_SIGNER_TEST/' . $leDoc));
                                @endphp

                                <div class="nk-tb-item" data-type="{{ $d['TYPECONC_LIB'] ?? '' }}"
                                    data-emploi="{{ $d['CONC_LIB'] ?? '' }}" data-annee="{{ $d['ANNEE'] ?? '' }}"
                                    @if (!$disponible) style="background-color: pink;" @endif>

                                    {{-- CASE DE SÉLECTION --}}
                                    @unless ($isReadOnly)
                                        <div class="nk-tb-col nk-tb-col-check">

                                            @if ($disponible)
                                                <div class="custom-control custom-control-sm custom-checkbox notext">

                                                    <input type="checkbox" class="custom-control-input selectionnerligne"
                                                        name="elements[]" value="{{ $d['NOM_FICHIER'] }}"
                                                        alt="{{ $d['GL_ACTE_ID'] }}" title="{{ $d['NUMERO_ACTE'] }}"
                                                        id="{{ $d['NOM_FICHIER'] . ':select' }}">

                                                    <label class="custom-control-label"
                                                        for="{{ $d['NOM_FICHIER'] . ':select' }}"></label>

                                                </div>
                                            @endif

                                        </div>
                                    @endunless

                                    {{-- NUMÉRO ACTE --}}
                                    <div class="nk-tb-col">
                                        <span class="tb-amount">
                                            {{ $d['NUMERO_ACTE'] }}
                                        </span>
                                    </div>

                                    {{-- NATURE ACTE --}}
                                    <div class="nk-tb-col">
                                        <span class="tb-amount">
                                            {{ $d['NATURE_ACTE_LIB'] }}
                                        </span>
                                    </div>

                                    {{-- TYPE CONCOURS --}}
                                    <div class="nk-tb-col">
                                        <span>
                                            {{ $d['TYPECONC_LIB'] ?? '' }}
                                        </span>
                                    </div>

                                    {{-- EMPLOI --}}
                                    <div class="nk-tb-col">
                                        <ul class="list-status">
                                            <li>
                                                <span>
                                                    {{ $d['CONC_LIB'] ?? '' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- ANNÉE --}}
                                    <div class="nk-tb-col">
                                        <span>
                                            {{ $d['ANNEE'] ?? '' }}
                                        </span>
                                    </div>

                                    {{-- VISUALISATION DU DOCUMENT --}}
                                    <div class="nk-tb-col nk-tb-col-voir">
                                        <a href="javascript:;" class="modal-click-document tb-amount"
                                            id="{{ $d['NOM_FICHIER'] . '.PDF' }}" name="listepresence"
                                            title="PROCES VERBAL">
                                            <em class="icon ni ni-eye"></em>
                                        </a>
                                    </div>

                                    {{-- ACTIONS DE SIGNATURE --}}
                                    @unless ($isReadOnly)
                                        <div class="nk-tb-col nk-tb-col-tools">

                                            <ul class="nk-tb-actions gx-1">
                                                <li>

                                                    @if ($disponible)
                                                        {{-- Bouton désactivé par défaut --}}
                                                        <a href="javascript:;" id="{{ 'inactif_' . $d['NOM_FICHIER'] }}"
                                                            alt="so.cisse@fonctionpublique.gouv.ci:{{ $d['NUMERO_ACTE'] }}:{{ $d['GL_ACTE_ID'] }}"
                                                            rel="noopener noreferrer">
                                                            <button class="btn btn-sm btn-primary" disabled>
                                                                <em class="icon ni ni-edit"></em>
                                                                <span>Signer</span>
                                                            </button>
                                                        </a>

                                                        {{-- Bouton activé lorsque la ligne est cochée --}}
                                                        <a href="javascript:;" id="{{ $d['NOM_FICHIER'] }}"
                                                            alt="so.cisse@fonctionpublique.gouv.ci:{{ $d['NUMERO_ACTE'] }}:{{ $d['GL_ACTE_ID'] }}"
                                                            rel="noopener noreferrer" style="display: none;">
                                                            <button class="btn btn-sm btn-primary"
                                                                id="{{ $d['GL_ACTE_ID'] }}">
                                                                <em class="icon ni ni-edit"></em>
                                                                <span>Signer</span>
                                                            </button>
                                                        </a>
                                                    @else
                                                        <a href="javascript:;" class="btn btn-sm btn-danger">
                                                            <em class="icon ni ni-na"></em>
                                                            <span>INDISPONIBLE</span>
                                                        </a>
                                                    @endif

                                                </li>
                                            </ul>

                                        </div>
                                    @endunless

                                </div>
                            @endforeach

                        </x-data-table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ================= MODALS ET ÉLÉMENTS CACHÉS ================= --}}

    {{-- Modal : visualisation du document --}}
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

    {{-- Indicateur de chargement --}}
    <div id="animation1" class="alert alert-danger text-center" role="alert"
        style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 2000;">
        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
        CHARGEMENT . . .
    </div>

    {{-- Liens cachés qui déclenchent les modals de retour --}}
    <div hidden>
        <a href="javascript:;" id="popup" class="pup">POPUP</a>
        <a href="javascript:;" id="popup-groupe" class="pup-groupe">POPUP</a>
    </div>

    {{-- Retour après signature individuelle --}}
    <div class="modal fade" id="modal-lien" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content p-4">

                <div class="text-center">
                    <form action="{{ route('quit') }}" method="post">
                        @csrf

                        <input type="hidden" name="P_ACTE_ID" id="P_ACTE_ID">
                        <input type="hidden" name="P_ACTE_NUM" id="P_ACTE_NUM">

                        <input type="hidden" name="P_USERMIN" value="{{ utf8_encode($info['NOM PRENOMS']) }}">

                        <button class="btn btn-success">
                            Retour au tableau de bord de signature
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Retour après signature groupée --}}
    <div class="modal fade" id="modal-lien-groupe" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content p-4">

                <div class="text-center">
                    <form action="{{ route('quitgroupe') }}" method="post">
                        @csrf

                        <input type="hidden" name="lesvaleursid" id="lesvaleursid">
                        <input type="hidden" name="lesvaleursnum" id="lesvaleursnum">
                        <input type="hidden" name="lesvaleursnom" id="lesvaleursnom">

                        <input type="hidden" name="P_USERMIN" value="{{ utf8_encode($info['NOM PRENOMS']) }}">

                        <button class="btn btn-success">
                            Retour au tableau de bord de signature
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')

    {{-- Données des mini-graphiques des cartes du haut --}}
    <script>
        window.dashCharts = window.dashCharts || {};

        (function() {
            var cards = @json($chartData);
            var labels = @json($chartLabels);

            cards.forEach(function(c) {
                window.dashCharts[c.id] = {
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
            });
        })();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var table = document.getElementById('tableMiseFormation');
            var applyWrap = document.getElementById('applyWrap');

            if (!table) {
                return;
            }

            /*
             * 1. GESTION DES BOUTONS DE SIGNATURE
             */

            // Active ou désactive le bouton de signature d'une ligne
            function majLigne(cb) {
                var id = cb.id.split(':')[0];

                var inactif = document.getElementById('inactif_' + id);
                var actif = document.getElementById(id);

                if (!inactif || !actif) {
                    return;
                }

                inactif.style.display = cb.checked ? 'none' : '';
                actif.style.display = cb.checked ? '' : 'none';
                actif.classList.toggle('click-sign', cb.checked);
            }

            // Affiche le bouton de signature groupée à partir de 2 sélections
            function majApply() {
                if (!applyWrap) {
                    return;
                }

                var nombre = table.querySelectorAll('.selectionnerligne:checked').length;

                applyWrap.style.display = nombre >= 2 ? '' : 'none';
            }

            // Synchronise la case d'en-tête avec les lignes visibles
            function majEntete() {
                var visibles = Array.from(
                    table.querySelectorAll('.selectionnerligne')
                ).filter(function(cb) {
                    return cb.closest('.nk-tb-item').style.display !== 'none';
                });

                var coches = visibles.filter(function(cb) {
                    return cb.checked;
                }).length;

                var selectAll = document.getElementById('selectAllRows');

                if (selectAll) {
                    selectAll.checked = visibles.length > 0 && visibles.length === coches;
                    selectAll.indeterminate = coches > 0 && coches < visibles.length;
                }
            }

            /*
             * 2. ÉVÉNEMENTS DE SÉLECTION
             */

            // Sélection individuelle
            $(document).on('change', '#tableMiseFormation .selectionnerligne', function() {
                majLigne(this);
                majApply();
                majEntete();
            });

            // Sélection de toutes les lignes visibles de la page courante
            $('#selectAllRows').on('change', function() {
                var etat = this.checked;

                table.querySelectorAll('.selectionnerligne').forEach(function(cb) {

                    var ligne = cb.closest('.nk-tb-item');

                    if (ligne.style.display === 'none') {
                        return;
                    }

                    cb.checked = etat;
                    majLigne(cb);
                });

                majApply();
                majEntete();
            });

            /*
             * 3. SYNCHRONISATION AVEC LE DATATABLE
             */

            table.addEventListener('data-table:rendered', function(event) {

                var lignesFiltrees = event.detail.filteredRows;

                // Une ligne exclue par la recherche ou les filtres
                // ne doit pas rester sélectionnée pour une signature.
                table.querySelectorAll('.selectionnerligne:checked').forEach(function(cb) {

                    var ligne = cb.closest('.nk-tb-item');

                    if (!lignesFiltrees.includes(ligne)) {
                        cb.checked = false;

                        // Met à jour le bouton de signature de cette ligne
                        majLigne(cb);
                    }
                });

                majApply();
                majEntete();
            });

            /*
             * 4. INDICATEUR DES FILTRES
             */

            var dotFiltre = document.getElementById('dotFiltre');

            function majIndicateurFiltres() {
                if (!dotFiltre) {
                    return;
                }

                var type = document.getElementById('filtreType').value;
                var emploi = document.getElementById('filtreEmploi').value;
                var annee = document.getElementById('filtreAnnee').value;

                dotFiltre.style.display =
                    (type || emploi || annee) ? '' : 'none';
            }

            // Après validation des filtres
            $('#btnFiltrer').on('click', function() {
                majIndicateurFiltres();

                // Ferme le menu après validation
                try {
                    $(this)
                        .closest('.dropdown')
                        .find('[data-toggle="dropdown"]')
                        .dropdown('toggle');
                } catch (err) {}
            });

            // Réinitialisation des filtres
            $('#resetFiltres').on('click', function() {
                setTimeout(majIndicateurFiltres, 0);
            });

            // Empêche la fermeture du menu lors d'un clic à l'intérieur
            $('.filter-wg').on('click', function(e) {
                e.stopPropagation();
            });

            /*
             * 5. VOIR LE DOCUMENT
             */

            $(document).on('click', '.modal-click-document', function(e) {
                e.preventDefault();

                var idDocument = $(this).attr('id');

                $('#affichage-lien').html(
                    '<div class="alert alert-danger" role="alert">' +
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>' +
                    'OUVERTURE DU DOCUMENT . . .' +
                    '</div>'
                );

                $('#modaldocument').modal('show');

                $.get('/document/' + encodeURIComponent(idDocument), function(result) {
                    $('#affichage-lien').html(result);
                }).fail(function() {
                    $('#affichage-lien').html(
                        '<div class="alert alert-warning">Impossible d\'ouvrir le document.</div>'
                    );
                });
            });

            $('#modaldocument').on('hidden.bs.modal', function() {
                $('#affichage-lien').empty();
            });

            /*
             * 6. SIGNATURE INDIVIDUELLE
             */

            $(document).on('click', '.click-sign', function(e) {
                e.preventDefault();

                $('#animation1').show();

                var idDocument = $(this).attr('id');
                var tab = $(this).attr('alt').split(':');

                var mail = tab[0];
                var numero = tab[1];
                var docid = tab[2];

                $.get('/signature/' + mail + '/' + idDocument, function(result) {

                    var rjson = JSON.parse(result);

                    window.open(
                        rjson.inviteUrl,
                        'popup',
                        'width=2000,height=2000,top=20,left=20'
                    );

                    document.getElementById('popup').click();

                    $('#P_ACTE_ID').val(docid);
                    $('#P_ACTE_NUM').val(numero);

                    $('#animation1').hide();

                }).fail(function() {
                    $('#animation1').hide();
                });
            });

            /*
             * 7. MODALS DE RETOUR APRÈS SIGNATURE
             */

            $(document).on('click', '.pup', function() {
                $('#modal-lien').modal('show');
            });

            $(document).on('click', '.pup-groupe', function() {
                $('#modal-lien-groupe').modal('show');
            });

            /*
             * 8. INITIALISATION DES SÉLECTIONS
             */

            table.querySelectorAll('.selectionnerligne:checked').forEach(function(cb) {
                majLigne(cb);
            });

            majApply();
            majEntete();
            majIndicateurFiltres();

        });

        /*
         * 9. SIGNATURE MULTIPLE
         */

        function envoyerRequete() {

            var coches = $('#tableMiseFormation .selectionnerligne:checked');

            if (coches.length === 0) {

                var msg = 'Veuillez svp sélectionner les actes !';

                if (window.Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ATTENTION',
                        text: msg
                    });
                } else {
                    alert(msg);
                }

                return;
            }

            $('#animation1').show();

            var noms = [];
            var nums = [];
            var ids = [];

            coches.each(function() {
                noms.push($(this).val());
                nums.push($(this).attr('title'));
                ids.push($(this).attr('alt'));
            });

            $('#lesvaleursid').val(ids.join('@@'));
            $('#lesvaleursnum').val(nums.join('@@'));
            $('#lesvaleursnom').val(noms.join('@@'));

            $.get('/Tgrouper/' + noms.join('@@'), function(result) {

                var rjson = JSON.parse(result);

                window.open(
                    rjson.inviteUrl,
                    'popup',
                    'width=2000,height=2000,top=20,left=20'
                );

                document.getElementById('popup-groupe').click();

                $('#animation1').hide();

            }).fail(function() {
                $('#animation1').hide();
            });
        }
    </script>

@endsection
