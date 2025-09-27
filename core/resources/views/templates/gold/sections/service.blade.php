@php
    $serviceContent = getContent('service.content', true);
    $services = getContent('service.element');
@endphp

<section class="service py-120 section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading">
                    <h2 class="section-heading__title"> {{ __(@$serviceContent->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$serviceContent->data_values->description) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            @foreach ($services as $service)
                <div class="col-lg-4 col-sm-6 col-xsm-6">
                    <div class="service-item">
                        <span class="service-item__icon flex-center before-shadow">
                            @php echo $service->data_values->icon @endphp
                        </span>
                        <h4 class="service-item__title">{{ __($service->data_values->title) }}</h4>
                        <p class="service-item__desc fs-18">{{ __($service->data_values->description) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
