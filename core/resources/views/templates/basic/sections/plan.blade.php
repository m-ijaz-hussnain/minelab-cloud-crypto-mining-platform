@php
    $content = getContent('plan.content', true);
    $miners = App\Models\Miner::with('activePlans')->whereHas('activePlans')->orderBy('name', 'ASC')->get();
@endphp

@if (count($miners))
    <section class="pricing-section ptb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-header">
                        <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                        <span class="title-border"></span>
                        <p>{{ __(@$content->data_values->description) }} </p>
                    </div>
                </div>
            </div>
            @include($activeTemplate . 'partials.plan_card', ['miners' => $miners])
        </div>
    </section>
@endif
