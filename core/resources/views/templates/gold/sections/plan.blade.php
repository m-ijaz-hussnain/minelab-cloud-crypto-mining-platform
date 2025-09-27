@php
    $content = getContent('plan.content', true);
    $miners = App\Models\Miner::with('activePlans')
        ->whereHas('activePlans')
        ->orderBy('name', 'ASC')
        ->get();
@endphp


@if ($miners->isNotEmpty())
    <section class="pricing py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="section-heading">
                        <h2 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h2>
                        <p class="section-heading__desc">{{ __(@$content->data_values->description) }}</p>
                    </div>
                </div>
            </div>
            @include($activeTemplate . 'partials.plan_card', ['miners' => $miners])
        </div>
    </section>
@endif
