@php
    $content = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3);
@endphp

<section class="blog py-100">
    <div class="container">
        <div class="row">
            <div class="section-heading">
                <h3 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h3>
                <p class="section-heading__desc">{{ __(@$content->data_values->description) }}</p>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <a class="blog-item__thumb-link" href="{{ route('blog.details', $blog->slug) }}"><img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->blog_image, '300x200') }}" alt="{{ $blog->data_values->title }}"></a>
                            <span class="blog-item__date"> <span class="blog-item__date-icon"><i class="fas fa-calendar-alt"></i></span> {{ showDateTime($blog->created_at, 'd, M') }} </span>
                        </div>
                        <div class="blog-item__content">
                            <h4 class="blog-item__title"><a class="blog-item__title-link" href="{{ route('blog.details', $blog->slug) }}">{{ __($blog->data_values->title) }}</a></h4>
                            <p class="blog-item__desc">@php echo strLimit(strip_tags($blog->data_values->description), 80) @endphp</p>
                            <a class="btn--simple" href="{{ route('blog.details', $blog->slug) }}">@lang('Read More') <span class="btn--simple__icon"><i class="las la-chevron-right"></i></span> </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
