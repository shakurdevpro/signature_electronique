@props([
    'id' => 'dataTable',
    'perPage' => 10,
    'emptyMessage' => 'Aucun résultat trouvé.',
    'searchPlaceholder' => 'Rechercher...',
])

<div id="{{ $id }}" class="card card-stretch data-table" data-table data-per-page="{{ $perPage }}">
    <div class="card-inner-group">

        {{-- 1. BARRE D'OUTILS --}}
        <x-data-table.toolbar :id="$id" :search-placeholder="$searchPlaceholder">
            <x-slot:filters>
                {{ $filters ?? '' }}
            </x-slot:filters>

            <x-slot:actions>
                {{ $actions ?? '' }}
            </x-slot:actions>
        </x-data-table.toolbar>

        {{-- 2. CONTENU DU TABLEAU --}}
        <div class="card-inner p-0">
            <div class="data-table-responsive">
                <div class="nk-tb-list nk-tb-ulist">

                    {{-- EN-TÊTES --}}
                    <div class="nk-tb-item nk-tb-head">
                        {{ $header ?? '' }}
                    </div>

                    {{-- LIGNES --}}
                    <div data-table-body style="display: contents;">
                        {{ $slot }}
                    </div>

                    {{-- AUCUN RÉSULTAT --}}
                    <div class="nk-tb-item nk-tb-empty" data-table-empty style="display: none;">
                        <div class="nk-tb-col">
                            <span class="text-soft">
                                {{ $emptyMessage }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- 3. PAGINATION --}}
        <x-data-table.pagination />

    </div>
</div>

{{-- 4. JAVASCRIPT --}}
<x-data-table.scripts />
