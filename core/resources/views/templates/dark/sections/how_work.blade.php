@php
    $content = getContent('how_work.content', true);
    $elements = getContent('how_work.element', false, 4, true);
@endphp

<section class="work py-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-heading">
                    <h3 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h3>
                    <p class="section-heading__desc">{{ __(@$content->data_values->description) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            @foreach ($elements as $item)
                <div class="col-xl-3 col-sm-6">
                    <div class="work-item">
                        <span class="work-item__border"></span>
                        <span class="work-item__number"> {{ __($loop->iteration) }}</span>
                        <span class="work-item__icon">@php echo $item->data_values->icon @endphp</span>
                        <h4 class="work-item__title">{{ __($item->data_values->title) }}</h4>
                        <p class="work-item__desc">{{ __($item->data_values->description) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
