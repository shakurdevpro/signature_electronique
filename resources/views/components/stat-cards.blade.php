@if ($visible)
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
                                <div class="amount">{{ number_format($c['value'], 0, ',', ' ') }}</div>
                                <div class="nk-ecwg6-ck">
                                    <canvas class="ecommerce-line-chart-s3" id="{{ $prefix . $c['id'] }}"></canvas>
                                </div>
                            </div>
                            <div class="info">
                                @if ($c['pct'] === null)
                                    <span class="change up text-danger">—</span>
                                @elseif ($c['pct'] >= 0)
                                    <span class="change up text-danger">
                                        <em class="icon ni ni-arrow-long-up"></em>{{ abs($c['pct']) }}%
                                    </span>
                                @else
                                    <span class="change down text-danger">
                                        <em class="icon ni ni-arrow-long-down"></em>{{ abs($c['pct']) }}%
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
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif