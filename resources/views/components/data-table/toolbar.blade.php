@props([
    'id' => 'dataTable',
    'searchPlaceholder' => 'Rechercher...',
])

<div class="card-inner position-relative card-tools-toggle">

    <div class="card-title-group">

        {{-- À GAUCHE : Icône de recherche --}}
        <div class="card-tools">
            <div class="d-flex align-items-center">
                <ul class="btn-toolbar gx-1 mr-2">
                    <li>
                        <a href="#" class="btn btn-icon search-toggle toggle-search"
                            data-target="search-{{ $id }}" aria-label="Afficher la recherche">
                            <em class="icon ni ni-search"></em>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- À DROITE : Actions et filtres --}}
        <div class="card-tools mr-n1">
            <ul class="btn-toolbar gx-1">

                {{-- Actions personnalisées --}}
                {{ $actions ?? '' }}

                {{-- Filtres personnalisés --}}
                {{ $filters ?? '' }}

            </ul>
        </div>

    </div>

    {{-- Champ de recherche dépliable --}}
    <div class="card-search search-wrap" data-search="search-{{ $id }}">
        <div class="card-body">
            <div class="search-content">

                <a href="#" class="search-back btn btn-icon toggle-search"
                    data-target="search-{{ $id }}" aria-label="Fermer la recherche">
                    <em class="icon ni ni-arrow-left"></em>
                </a>

                <input type="text" id="{{ $id }}Search"
                    class="form-control border-transparent form-focus-none" placeholder="{{ $searchPlaceholder }}"
                    data-table-search autocomplete="off">

                <button type="button" class="search-submit btn btn-icon" aria-label="Rechercher">
                    <em class="icon ni ni-search"></em>
                </button>

            </div>
        </div>
    </div>

</div>
