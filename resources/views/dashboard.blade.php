@extends('layouts.base')

@section('title', 'Tableau de bord')

@section('styles')


@endsection

@section('content')
    <!-- content -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('components.pagetitle')
                    <div class="nk-block">

                        <div class="row g-gs">

                            @php
                                $cards = [
                                    [
                                        'id' => 'MF',
                                        'title' => 'Mise <br/> en formation',
                                        'key' => 'NBRE_MF',
                                        'color' => '#F4A261', // Mise en formation
                                    ],
                                    [
                                        'id' => 'FF',
                                        'title' => 'Fin <br/> de formation',
                                        'key' => 'NBRE_FF',
                                        'color' => '#2A9D8F', // Fin de formation
                                    ],
                                    [
                                        'id' => 'COMM',
                                        'title' => "Communiqué <br/> d'admission",
                                        'key' => 'NBRE_COMM',
                                        'color' => '#E9C46A', // Communiqué d'admission
    ],
    [
        'id' => 'ARR_ADM',
        'title' => "Arrêté <br/> d'admission",
        'key' => 'NBRE_ARR_ADM',
        'color' => '#E76F51', // Arrêté d'admission
    ],
    [
        'id' => 'COMM_OUVR',
        'title' => "Communiqué <br/> d'ouverture",
        'key' => 'NBRE_COMM_OUVR',
        'color' => '#264653', // Communiqué d'ouverture
                                    ],
                                    [
                                        'id' => 'ARR_OUVR',
                                        'title' => "Arrêté <br/> d'ouverture",
                                        'key' => 'NBRE_ARR_OUVR',
                                        'color' => '#913D30', // Arrêté d'ouverture
    ],
];

$chartData = [];

foreach ($cards as $i => $c) {
    $value = (int) $stat[$c['key']];
    $serieKey = 'SERIE_' . $c['id'];

    // Série réelle si le contrôleur la fournit,
    // sinon ligne plate sur la vraie valeur.
    if (isset($stat[$serieKey]) && count($stat[$serieKey]) >= 2) {
        $serie = array_values($stat[$serieKey]);

        $last = end($serie);
        $prev = prev($serie);

        $pct = $prev != 0 ? round((($last - $prev) / $prev) * 100, 2) : null;
    } else {
        $serie = array_fill(0, 7, $value);
        $pct = null;
    }

    $cards[$i]['value'] = $value;
    $cards[$i]['pct'] = $pct;

    $chartData[] = [
        'id' => 'chart_' . $c['id'],
        'title' => $c['title'],
        'color' => $c['color'],
        'data' => $serie,
    ];
}

// Cartes DFRC : on réutilise les données déjà calculées pour MF et FF
$dfrcRoutes = [
    'MF' => 'mise_formation',
    'FF' => 'fin_formation',
];

$routesCards = [
    'MF' => 'mise_formation',
    'FF' => 'fin_formation',
    'COMM' => 'communique',
    'ARR_ADM' => 'arrete',
    'COMM_OUVR' => 'comm_ouv',
    'ARR_OUVR' => 'arrete_ouv',
];
$dfrcTitres = [
    'MF' => 'Mise en formation',
    'FF' => 'Fin de formation',
];
$dfrcCards = array_values(
    array_filter($cards, function ($c) use ($dfrcRoutes) {
        return isset($dfrcRoutes[$c['id']]);
    }),
);

$chartLabels = isset($stat['SERIE_LABELS']) ? $stat['SERIE_LABELS'] : null;
                            @endphp


                            @if (in_array($info['LOGINUSER'], ['X505234', 'Z444473', 'T279354']))
                                @foreach ($cards as $c)
                                    <div class="col-xxl-2 col-sm-6">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">{!! $c['title'] !!}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount">
                                                                {{ number_format($c['value'], 0, ',', ' ') }}</div>
                                                            <div class="nk-ecwg6-ck">
                                                                <canvas class="ecommerce-line-chart-s3"
                                                                    id="chart_{{ $c['id'] }}"></canvas>
                                                            </div>
                                                        </div>
                                                        <div class="info">
                                                            @if ($c['pct'] === null)
                                                                <span class="change up text-danger">—</span>
                                                            @elseif ($c['pct'] >= 0)
                                                                <span class="change up text-danger">
                                                                    <em
                                                                        class="icon ni ni-arrow-long-up"></em>{{ abs($c['pct']) }}%
                                                                </span>
                                                            @else
                                                                <span class="change down text-danger">
                                                                    <em
                                                                        class="icon ni ni-arrow-long-down"></em>{{ abs($c['pct']) }}%
                                                                </span>
                                                            @endif
                                                            <span class="ms-2">par rapport à la semaine dernière</span>
                                                        </div>

                                                        @if (isset($routesCards[$c['id']]) && Route::has($routesCards[$c['id']]))
                                                            <div class="mt-3">
                                                                <a href="{{ route($routesCards[$c['id']]) }}"
                                                                    class="btn btn-sm btn-round flex-shrink-0"
                                                                    style="background-color: {{ $c['color'] }}1A; color: {{ $c['color'] }}; border: 1px solid {{ $c['color'] }}33;">
                                                                    <em class="icon ni ni-eye"></em>
                                                                    <span>Voir la liste</span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                @endforeach
                            @endif

                            <div class="col-xxl-6">
                                <div class="card card-full">
                                    <div class="nk-ecwg nk-ecwg8 h-100">
                                        <div class="card-inner">
                                            <div class="card-title-group mb-3">
                                                <div class="card-title">
                                                    <h6 class="title">Actes en instance et signés</h6>
                                                </div>
                                            </div>
                                            <ul class="nk-ecwg8-legends">
                                                <li>
                                                    <div class="title">
                                                        <span class="dot dot-lg sq" data-bg="#F35B04"></span>
                                                        <span>Actes en instance</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">
                                                        <span class="dot dot-lg sq" data-bg="#4c956c"></span>
                                                        <span>Actes signés</span>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="nk-ecwg8-ck">
                                                <canvas class="ecommerce-line-chart-s4" id="chart_actes"></canvas>
                                            </div>
                                            <div class="chart-label-group pl-5">
                                                <div class="chart-label">{{ $chartActes['labels'][0] }}</div>
                                                <div class="chart-label">{{ end($chartActes['labels']) }}</div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->




                            @php
                                // Correspondance entre la nature du document et sa couleur.
                                $donutColors = [
                                    'communique_ouverture' => '#264653',
                                    'fin_formation' => '#2A9D8F',
                                    'communique_admission' => '#E9C46A',
                                    'mise_formation' => '#F4A261',

                                    // Correspondances proposées, à confirmer.
                                    'arrete_admission' => '#E76F51',
                                    'arrete_ouverture' => '#913D30',
                                    'autres_actes' => '#9A031E',
                                ];

                                $donutBg = [];

                                foreach ($chartDonut['labels'] as $i => $label) {
                                    $labelNormalise = mb_strtolower($label, 'UTF-8');

                                    if (
                                        str_contains($labelNormalise, 'communiqué d’ouverture') ||
                                        str_contains($labelNormalise, "communique d'ouverture") ||
                                        str_contains($labelNormalise, 'communique ouverture')
                                    ) {
                                        $colorKey = 'communique_ouverture';
                                    } elseif (str_contains($labelNormalise, 'fin de formation')) {
                                        $colorKey = 'fin_formation';
                                    } elseif (
                                        str_contains($labelNormalise, 'communiqué d’admission') ||
                                        str_contains($labelNormalise, "communique d'admission") ||
                                        str_contains($labelNormalise, 'communique admission')
                                    ) {
                                        $colorKey = 'communique_admission';
                                    } elseif (str_contains($labelNormalise, 'mise en formation')) {
                                        $colorKey = 'mise_formation';
                                    } elseif (
                                        str_contains($labelNormalise, 'arrêté d’admission') ||
                                        str_contains($labelNormalise, "arrete d'admission") ||
                                        str_contains($labelNormalise, 'arrete admission')
                                    ) {
                                        $colorKey = 'arrete_admission';
                                    } elseif (
                                        str_contains($labelNormalise, 'arrêté d’ouverture') ||
                                        str_contains($labelNormalise, "arrete d'ouverture") ||
                                        str_contains($labelNormalise, 'arrete ouverture')
                                    ) {
                                        $colorKey = 'arrete_ouverture';
                                    } else {
                                        $colorKey = 'autres_actes';
                                    }

                                    $donutBg[$i] = $donutColors[$colorKey];
                                }
                            @endphp

                            @if ($info['LOGINUSER'] != 'E319795' || $info['LOGINUSER'] == 'H388545')
                                <div class="col-xxl-6">
                                    <div class="card card-full overflow-hidden">
                                        <div class="nk-ecwg nk-ecwg7 h-100">
                                            <div class="card-inner flex-grow-1">
                                                <div class="card-title-group mb-4">
                                                    <div class="card-title">
                                                        <h6 class="title">Actes en instance par nature</h6>
                                                    </div>
                                                </div>
                                                <div class="nk-ecwg7-ck">
                                                    <canvas class="ecommerce-doughnut-s1" id="chart_instance"></canvas>
                                                </div>
                                                <ul class="nk-ecwg7-legends">
                                                    @foreach ($chartDonut['labels'] as $i => $label)
                                                        <li>
                                                            <div class="title">
                                                                <span class="dot dot-lg sq"
                                                                    data-bg="{{ $donutBg[$i] }}"></span>
                                                                <span>{{ $label }}
                                                                    ({{ $chartDonut['data'][$i] }})
                                                                </span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div><!-- .card-inner -->
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->


                            @endif




                            @if ($info['LOGINUSER'] == 'K349954')
                                <div class="col-12">
                                    <a class="btn btn-primary d-block mx-auto"
                                        style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;">DFRC</a>
                                </div>
                            @endif

                            @foreach ($dfrcCards as $c)
                                <div class="col-xxl-6 col-sm-6">
                                    <div class="card">
                                        <div class="nk-ecwg nk-ecwg6">
                                            <div class="card-inner">
                                                <div class="card-title-group">

                                                    <div
                                                        class="card-title d-flex justify-content-between align-items-center">
                                                        <h6 class="title mb-0 ">{{ $dfrcTitres[$c['id']] }}</h6>
                                                    </div>

                                                </div>
                                                <div class="data">
                                                    <div class="data-group">
                                                        <div class="amount">
                                                            {{ number_format($c['value'], 0, ',', ' ') }}</div>
                                                        <div class="nk-ecwg6-ck">
                                                            <canvas class="ecommerce-line-chart-s3"
                                                                id="chart_dfrc_{{ $c['id'] }}"></canvas>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="info d-flex justify-content-between align-items-center w-100">

                                                        {{-- Partie gauche : évolution par rapport à la semaine dernière --}}
                                                        <div class="d-flex align-items-center flex-wrap">
                                                            @if ($c['pct'] === null)
                                                                <span class="change up text-danger">—</span>
                                                            @elseif ($c['pct'] >= 0)
                                                                <span class="change up text-danger">
                                                                    <em
                                                                        class="icon ni ni-arrow-long-up"></em>{{ abs($c['pct']) }}%
                                                                </span>
                                                            @else
                                                                <span class="change down text-danger">
                                                                    <em
                                                                        class="icon ni ni-arrow-long-down"></em>{{ abs($c['pct']) }}%
                                                                </span>
                                                            @endif

                                                            <span style="margin-left: 4px;">par rapport à la semaine
                                                                dernière</span>
                                                        </div>

                                                        {{-- Partie droite : bouton Voir la liste --}}
                                                        <a href="{{ route($dfrcRoutes[$c['id']]) }}"
                                                            class="btn btn-sm btn-round flex-shrink-0"
                                                            style="background-color: {{ $c['color'] }}1A; color: {{ $c['color'] }}; border: 1px solid {{ $c['color'] }}33;">
                                                            <em class="icon ni ni-eye"></em>
                                                            <span>Voir la liste</span>
                                                        </a>

                                                    </div>

                                                </div>

                                            </div><!-- .card-inner -->
                                        </div><!-- .nk-ecwg -->
                                    </div><!-- .card -->
                                </div><!-- .col -->
                            @endforeach

                            @php
                                $chartDfrc = $chartDfrc ?? ['labels' => [], 'data' => []];

                                $paletteDfrc = [
                                    '#FFE66D',
                                    '#FF6B6B',
                                    '#4ECDC4',
                                    '#d00000',
                                    '#a31621',
                                    '#40434e',
                                    '#8b786d',
                                ];
                                $nbDfrc = count($paletteDfrc);

                                $dfrcBg = [];
                                foreach ($chartDfrc['labels'] as $i => $label) {
                                    $dfrcBg[] = $paletteDfrc[$i % $nbDfrc];
                                }
                            @endphp

                            @if ($info['LOGINUSER'] != 'K349954')
                                <div class="col-xxl-12">
                                    <div class="card card-full overflow-hidden">
                                        <div class="nk-ecwg nk-ecwg7 h-100">
                                            <div class="card-inner flex-grow-1">
                                                <div class="card-title-group mb-4">
                                                    <div class="card-title">
                                                        <h6 class="title">Actes en instance par type de concours</h6>
                                                    </div>
                                                </div>
                                                <div class="nk-ecwg7-ck">
                                                    <canvas class="ecommerce-doughnut-s1" id="chart_dfrc"></canvas>
                                                </div>
                                                <ul class="nk-ecwg7-legends">
                                                    @foreach ($chartDfrc['labels'] as $i => $label)
                                                        <li>
                                                            <div class="title">
                                                                <span class="dot dot-lg sq"
                                                                    data-bg="{{ $dfrcBg[$i] }}"></span>
                                                                <span>{{ $label }}
                                                                    ({{ $chartDfrc['data'][$i] }})
                                                                </span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div><!-- .card-inner -->
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->


                            @endif


                            @php
                                // Cartes CONCOURS : mêmes données que l'ancienne vue (COMM, ARR_ADM, COMM_OUVR, ARR_OUVR)
$concoursIds = ['COMM', 'ARR_ADM', 'COMM_OUVR', 'ARR_OUVR'];
$concoursCards = array_values(
    array_filter($cards, function ($c) use ($concoursIds) {
        return in_array($c['id'], $concoursIds);
                                    }),
                                );
                            @endphp

                            @if (in_array($info['LOGINUSER'], ['E319795', 'H388545']))
                                <div class="col-12 nk-block-head">
                                    <div class="nk-block-head-content"
                                        style="background: #FFFFFF; border: 1px solid #E5E9F2; border-radius: 5px; padding: 18px 20px 0;">
                                        <h5 class="title nk-block-title mt-1 mb-3" style="text-align: center;">
                                            CONCOURS
                                        </h5>
                                        <div style="display: flex; height: 4px; margin: 0 -20px;">
                                            <div style="background: #F59E0B; flex: 1;"></div>
                                            <div style="background: #FFFFFF; flex: 1;"></div>
                                            <div style="background: #28A745; flex: 1;"></div>
                                        </div>
                                    </div>
                                </div>





                                @foreach ($concoursCards as $c)
                                    <div class="col-xxl-3">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">{!! $c['title'] !!}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount">
                                                                {{ number_format($c['value'], 0, ',', ' ') }}</div>
                                                            <div class="nk-ecwg6-ck">
                                                                <canvas class="ecommerce-line-chart-s3"
                                                                    id="chart_concours_{{ $c['id'] }}"></canvas>
                                                            </div>
                                                        </div>
                                                        <div class="info">
                                                            @if ($c['pct'] === null)
                                                                <span class="change up text-danger">—</span>
                                                            @elseif ($c['pct'] >= 0)
                                                                <span class="change up text-danger">
                                                                    <em
                                                                        class="icon ni ni-arrow-long-up"></em>{{ abs($c['pct']) }}%
                                                                </span>
                                                            @else
                                                                <span class="change down text-danger">
                                                                    <em
                                                                        class="icon ni ni-arrow-long-down"></em>{{ abs($c['pct']) }}%
                                                                </span>
                                                            @endif
                                                            <span class="ms-2">par rapport à la semaine dernière</span>
                                                        </div>

                                                        @if (isset($routesCards[$c['id']]) && Route::has($routesCards[$c['id']]))
                                                            <div class="mt-3">
                                                                <a href="{{ route($routesCards[$c['id']]) }}"
                                                                    class="btn btn-sm btn-round flex-shrink-0"
                                                                    style="background-color: {{ $c['color'] }}1A; color: {{ $c['color'] }}; border: 1px solid {{ $c['color'] }}33;">
                                                                    <em class="icon ni ni-eye"></em>
                                                                    <span>Voir la liste</span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                @endforeach
                            @endif


                            @php
                                $dgapceDef = [
                                    [
                                        'id' => 'PB',
                                        'title' => 'Prêt bancaire',
                                        'key' => 'NBRE_PB',
                                        'route' => 'pret_banc',
                                        'color' => '#2A9D8F',
                                    ],
                                    [
                                        'id' => 'RGS',
                                        'title' => 'RGS',
                                        'key' => 'NBRE_RGS',
                                        'route' => 'rgs',
                                        'color' => '#E9C46A',
                                    ],
                                    [
                                        'id' => 'ARSA',
                                        'title' => 'ARSA',
                                        'key' => 'NBRE_ARSA',
                                        'route' => 'arsa',
                                        'color' => '#E76F51',
                                    ],
                                ];

                                $dgapceCards = [];
                                $dgapceChart = [];
                                foreach ($dgapceDef as $d) {
                                    $val = isset($stat[$d['key']]) ? (int) $stat[$d['key']] : 0;
                                    $serieKey = 'SERIE_' . $d['id'];

                                    if (isset($stat[$serieKey]) && count($stat[$serieKey]) >= 2) {
                                        $serie = array_values($stat[$serieKey]);
                                        $last = end($serie);
                                        $prev = prev($serie);
                                        $pct = $prev != 0 ? round((($last - $prev) / $prev) * 100, 2) : null;
                                    } else {
                                        $serie = array_fill(0, 7, $val);
                                        $pct = null;
                                    }

                                    $d['value'] = $val;
                                    $d['pct'] = $pct;
                                    $dgapceCards[] = $d;

                                    $dgapceChart[] = [
                                        'id' => 'chart_dgapce_' . $d['id'],
                                        'title' => $d['title'],
                                        'color' => $d['color'],
                                        'data' => $serie,
                                    ];
                                }
                            @endphp

                            @if (in_array($info['LOGINUSER'], ['X477231', 'Z444473', 'T279354']))
                                @if (in_array($info['LOGINUSER'], ['T279354', 'Z444473']))
                                    <div class="col-12 nk-block-head">
                                        <div class="nk-block-head-content"
                                            style="background: #FFFFFF; border: 1px solid #E5E9F2; border-radius: 5px; padding: 18px 20px 0;">
                                            <h5 class="title nk-block-title mt-1 mb-3" style="text-align: center;">
                                                DGAPCE
                                            </h5>
                                            <div style="display: flex; height: 4px; margin: 0 -20px;">
                                                <div style="background: #F59E0B; flex: 1;"></div>
                                                <div style="background: #FFFFFF; flex: 1;"></div>
                                                <div style="background: #28A745; flex: 1;"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @foreach ($dgapceCards as $c)
                                    <div class="col-xxl-4">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">{{ $c['title'] }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount">
                                                                {{ number_format($c['value'], 0, ',', ' ') }}</div>
                                                            <div class="nk-ecwg6-ck">
                                                                <canvas class="ecommerce-line-chart-s3"
                                                                    id="chart_dgapce_{{ $c['id'] }}"></canvas>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="info d-flex justify-content-between align-items-center w-100">
                                                            <div class="d-flex align-items-center flex-wrap">
                                                                @if ($c['pct'] === null)
                                                                    <span class="change up text-danger">—</span>
                                                                @elseif ($c['pct'] >= 0)
                                                                    <span class="change up text-danger"><em
                                                                            class="icon ni ni-arrow-long-up"></em>{{ abs($c['pct']) }}%</span>
                                                                @else
                                                                    <span class="change down text-danger"><em
                                                                            class="icon ni ni-arrow-long-down"></em>{{ abs($c['pct']) }}%</span>
                                                                @endif
                                                                <span style="margin-left: 4px;">par rapport à la semaine
                                                                    dernière</span>
                                                            </div>

                                                            @if (Route::has($c['route']))
                                                                <a href="{{ route($c['route']) }}"
                                                                    class="btn btn-sm btn-round flex-shrink-0"
                                                                    style="background-color: {{ $c['color'] }}1A; color: {{ $c['color'] }}; border: 1px solid {{ $c['color'] }}33;">
                                                                    <em class="icon ni ni-eye"></em>
                                                                    <span>Voir la liste</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                @endforeach
                            @endif

                            @php
                                $dafDef = [
                                    [
                                        'id' => 'AP',
                                        'title' => 'Attestation de Prime',
                                        'key' => 'NBRE_AP',
                                        'route' => 'att_prime',
                                        'color' => '#2A9D8F',
                                    ],
                                    [
                                        'id' => 'DP',
                                        'title' => 'Domiciliation de Prime',
                                        'key' => 'NBRE_DP',
                                        'route' => 'dom_prime',
                                        'color' => '#F4A261',
                                    ],
                                ];

                                $dafCards = [];
                                $dafChart = [];
                                foreach ($dafDef as $d) {
                                    $val = isset($stat[$d['key']]) ? (int) $stat[$d['key']] : 0;
                                    $serieKey = 'SERIE_' . $d['id'];

                                    if (isset($stat[$serieKey]) && count($stat[$serieKey]) >= 2) {
                                        $serie = array_values($stat[$serieKey]);
                                        $last = end($serie);
                                        $prev = prev($serie);
                                        $pct = $prev != 0 ? round((($last - $prev) / $prev) * 100, 2) : null;
                                    } else {
                                        $serie = array_fill(0, 7, $val);
                                        $pct = null;
                                    }

                                    $d['value'] = $val;
                                    $d['pct'] = $pct;
                                    $dafCards[] = $d;

                                    $dafChart[] = [
                                        'id' => 'chart_daf_' . $d['id'],
                                        'title' => $d['title'],
                                        'color' => $d['color'],
                                        'data' => $serie,
                                    ];
                                }
                            @endphp

                            @if (in_array($info['LOGINUSER'], ['J435402', 'Z444473', 'T279354']))
                                @if (in_array($info['LOGINUSER'], ['T279354', 'Z444473']))
                                    <div class="col-12">
                                        <a class="btn btn-primary d-block mx-auto"
                                            style="background-color: silver; border-color: silver; border-radius: 1px 0 3px 4px !important;">DAF</a>
                                    </div>
                                @endif

                                @foreach ($dafCards as $c)
                                    <div class="col-xxl-6">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">{{ $c['title'] }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount">
                                                                {{ number_format($c['value'], 0, ',', ' ') }}</div>
                                                            <div class="nk-ecwg6-ck">
                                                                <canvas class="ecommerce-line-chart-s3"
                                                                    id="chart_daf_{{ $c['id'] }}"></canvas>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="info d-flex justify-content-between align-items-center w-100">
                                                            <div class="d-flex align-items-center flex-wrap">
                                                                @if ($c['pct'] === null)
                                                                    <span class="change up text-danger">—</span>
                                                                @elseif ($c['pct'] >= 0)
                                                                    <span class="change up text-danger"><em
                                                                            class="icon ni ni-arrow-long-up"></em>{{ abs($c['pct']) }}%</span>
                                                                @else
                                                                    <span class="change down text-danger"><em
                                                                            class="icon ni ni-arrow-long-down"></em>{{ abs($c['pct']) }}%</span>
                                                                @endif
                                                                <span style="margin-left: 4px;">par rapport à la semaine
                                                                    dernière</span>
                                                            </div>

                                                            @if (Route::has($c['route']))
                                                                <a href="{{ route($c['route']) }}"
                                                                    class="btn btn-sm btn-round flex-shrink-0"
                                                                    style="background-color: {{ $c['color'] }}1A; color: {{ $c['color'] }}; border: 1px solid {{ $c['color'] }}33;">
                                                                    <em class="icon ni ni-eye"></em>
                                                                    <span>Voir la liste</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                @endforeach
                            @endif


                            @php
                                $dafDonut = ['labels' => [], 'data' => [], 'colors' => []];
                                foreach ($dafCards as $d) {
                                    $dafDonut['labels'][] = $d['title'];
                                    $dafDonut['data'][] = $d['value'];
                                    $dafDonut['colors'][] = $d['color'];
                                }
                            @endphp

                            @if ($info['LOGINUSER'] != 'T279354' && $info['LOGINUSER'] != 'Z444473')
                                <div class="col-xxl-12">
                                    <div class="card card-full overflow-hidden">
                                        <div class="nk-ecwg nk-ecwg7 h-100">
                                            <div class="card-inner flex-grow-1">
                                                <div class="card-title-group mb-4">
                                                    <div class="card-title">
                                                        <h6 class="title">Répartition des primes</h6>
                                                    </div>
                                                </div>
                                                <div class="nk-ecwg7-ck">
                                                    <canvas class="ecommerce-doughnut-s1" id="chart_daf"></canvas>
                                                </div>
                                                <ul class="nk-ecwg7-legends">
                                                    @foreach ($dafDonut['labels'] as $i => $label)
                                                        <li>
                                                            <div class="title">
                                                                <span class="dot dot-lg sq"
                                                                    data-bg="{{ $dafDonut['colors'][$i] }}"></span>
                                                                <span>{{ $label }}
                                                                    ({{ $dafDonut['data'][$i] }})
                                                                </span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div><!-- .card-inner -->
                                        </div>
                                    </div><!-- .card -->
                                </div><!-- .col -->
                            @endif

                            @php
                                $fonction = isset($info['FONCTION']) ? $info['FONCTION'] : '';

                                $ccmDef = [
                                    [
                                        'id' => 'INST',
                                        'title' => 'Mes documents à signer',
                                        'value' => (int) $NBRE_CCM_INSTANCE,
                                        'route' => 'ccm_instance',
                                        'color' => '#F4A261',
                                    ],
                                    [
                                        'id' => 'SIGNE',
                                        'title' => 'Documents signés',
                                        'value' => (int) $NBRE_CCM_SIGNE,
                                        'route' => 'ccm_signe',
                                        'color' => '#2A9D8F',
                                    ],
                                ];

                                $ccmChart = [];
                                foreach ($ccmDef as $d) {
                                    $ccmChart[] = [
                                        'id' => 'chart_ccm_' . $d['id'],
                                        'title' => $d['title'],
                                        'color' => $d['color'],
                                        'data' => array_fill(0, 7, $d['value']),
                                    ];
                                }
                            @endphp

                            @if (in_array($info['LOGINUSER'], ['T279354', 'Z444473']) || $fonction == 'MINISTRE')
                                <div class="col-12 nk-block-head">
                                    <div class="nk-block-head-content"
                                        style="background: #FFFFFF; border: 1px solid #E5E9F2; border-radius: 5px; padding: 18px 20px 0;">
                                        <h5 class="title nk-block-title mt-1 mb-1" style="text-align: center;">
                                            ACTES DE MISE EN FORMATION
                                        </h5>
                                        <p class="text-soft mb-2" style="text-align: center;">Hors Côte d'Ivoire</p>
                                        <div style="display: flex; height: 4px; margin: 0 -20px;">
                                            <div style="background: #F59E0B; flex: 1;"></div>
                                            <div style="background: #FFFFFF; flex: 1;"></div>
                                            <div style="background: #28A745; flex: 1;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($fonction == 'MINISTRE')
                                @foreach ($ccmDef as $c)
                                    <div class="col-xxl-6">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">{{ $c['title'] }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <div class="amount">
                                                                {{ number_format($c['value'], 0, ',', ' ') }}</div>
                                                            <div class="nk-ecwg6-ck">
                                                                <canvas class="ecommerce-line-chart-s3"
                                                                    id="chart_ccm_{{ $c['id'] }}"></canvas>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="info d-flex justify-content-between align-items-center w-100">
                                                            <div class="d-flex align-items-center flex-wrap">
                                                                <span class="change up text-danger">—</span>
                                                                <span style="margin-left: 4px;">par rapport à la semaine
                                                                    dernière</span>
                                                            </div>

                                                            @if (Route::has($c['route']))
                                                                <a href="{{ route($c['route']) }}"
                                                                    class="btn btn-sm btn-round flex-shrink-0"
                                                                    style="background-color: {{ $c['color'] }}1A; color: {{ $c['color'] }}; border: 1px solid {{ $c['color'] }}33;">
                                                                    <em class="icon ni ni-eye"></em>
                                                                    <span>Voir la liste</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                @endforeach
                            @endif

                            

                        </div><!-- .row -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content -->


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
        window.dashCharts = window.dashCharts || {};
        window.dashCharts['chart_actes'] = {
            labels: @json($chartActes['labels']),
            dataUnit: 'actes',
            lineTension: .4,
            datasets: [{
                label: "Actes en instance",
                color: "#F35B04",
                dash: 0,
                background: "rgba(243, 91, 4,.15)",
                data: @json($chartActes['instance'])
            }, {
                label: "Actes signés",
                color: "#4c956c",
                dash: [5],
                background: "transparent",
                data: @json($chartActes['signe'])
            }]
        };
    </script>
    <script>
        window.dashCharts = window.dashCharts || {};
        window.dashCharts['chart_instance'] = {
            labels: @json($chartDonut['labels']),
            dataUnit: 'actes',
            legend: false,
            datasets: [{
                borderColor: "#fff",
                background: @json($donutBg),
                data: @json($chartDonut['data'])
            }]
        };
    </script>
    <script>
        window.dashCharts = window.dashCharts || {};
        window.dashCharts['chart_dfrc'] = {
            labels: @json($chartDfrc['labels']),
            dataUnit: 'actes',
            legend: false,
            datasets: [{
                borderColor: "#fff",
                background: @json($dfrcBg),
                data: @json($chartDfrc['data'])
            }]
        };
    </script>
    <script>
        window.dashCharts = window.dashCharts || {};
        (function() {
            var cards = @json($dgapceChart);
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
        window.dashCharts = window.dashCharts || {};
        (function() {
            var cards = @json($dafChart);
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
        window.dashCharts = window.dashCharts || {};
        window.dashCharts['chart_daf'] = {
            labels: @json($dafDonut['labels']),
            dataUnit: 'documents',
            legend: false,
            datasets: [{
                borderColor: "#fff",
                background: @json($dafDonut['colors']),
                data: @json($dafDonut['data'])
            }]
        };
    </script>
    <script>
        window.dashCharts = window.dashCharts || {};
        (function() {
            var cards = @json($ccmChart);
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
@endsection
