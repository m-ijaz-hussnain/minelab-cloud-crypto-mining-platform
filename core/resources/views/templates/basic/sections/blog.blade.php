@php
    $content = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3);
@endphp
<section class="blog-section ptb-120">
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
        <div class="row justify-content-center ml-b-30">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-12 mrb-30">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ frontendImage('blog', 'thumb_'. @$blog->data_values->blog_image, '318x212') }}" alt="{{ __($blog->data_values->title) }}">
                            <span class="overlay-date">{{ strtoupper(showDateTime($blog->created_at, 'd M')) }}</span>
                        </div>
                        <div class="blog-content">
                            <h3 class="title"><a href="{{ route('blog.details', $blog->slug) }}">{{ __($blog->data_values->title) }}</a></h3>
                            <p> @php echo strLimit(strip_tags($blog->data_values->description), 80) @endphp</p>
                            <div class="blog-btn">
                                <a class="custom-btn" href="{{ route('blog.details', $blog->slug) }}">@lang('Read More') <i class="fas fa-angle-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
