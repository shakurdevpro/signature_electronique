@php
    $currentRoute = Route::currentRouteName();
    $pageTitle = config('pagetitle.' . $currentRoute, 'Signature');
@endphp

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">
                {{ $pageTitle }}
            </h3>
            @if ($currentRoute === 'instance')
                <div class="nk-block-des text-soft">
                    <p>
                        Vous avez {{ number_format($totalInstances, 0, ',', ' ') }}
                        {{ $totalInstances > 1 ? 'actes' : 'acte' }}
                        en instance de signature.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
