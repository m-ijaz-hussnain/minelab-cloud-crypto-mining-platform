@php
    $content = getContent('plan.content', true);
    $miners = App\Models\Miner::with('activePlans')
        ->whereHas('activePlans')
        ->orderBy('name', 'ASC')
        ->get();
@endphp
@if (count($miners))
    <section class="plan py-100 section-bg">
        <div class="container">
            <div class="row">
                <div class="section-heading">
                    <h3 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h3>
                    <p class="section-heading__desc">{{ __(@$content->data_values->description) }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include($activeTemplate . 'partials.plan_card', ['miners' => $miners])
                </div>
            </div>
        </div>
    </section>
@endif
