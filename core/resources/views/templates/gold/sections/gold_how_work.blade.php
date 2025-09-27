@php
    $workContent = getContent('gold_how_work.content', true);
    $workElement = getContent('gold_how_work.element', false, 4, true);
@endphp
<section class="how-work py-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading">
                    <h2 class="section-heading__title">{{ __(@$workContent->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$workContent->data_values->description) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 how-work-item-wrapper">
            @foreach ($workElement as $key => $element)
                <div class="col-lg-3 col-sm-6 col-xsm-6">
                    <div class="how-work-item flex-center">
                        <div class="how-work-item__number flex-center">
                            <span class="how-work-item__hexagon"></span>
                            <h2 class="text mb-0">{{ $key + 1 }}</h2>
                        </div>
                        <div class="how-work-item__content">
                            <h5 class="how-work-item__title">{{ __(@$element->data_values->title) }}</h5>
                            <p class="how-work-item__desc">{{ __(@$element->data_values->description) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
