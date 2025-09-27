@php
    $blogContent = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3);
@endphp

<section class="blog py-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading">
                    <h2 class="section-heading__title"> {{ __(@$blogContent->data_values->heading) }} </h2>
                    <p class="section-heading__desc">{{ __(@$blogContent->data_values->description) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-sm-6">
                    <div class="blog-item">
                        <div class="blog-item__inner">
                            <div class="blog-item__thumb">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="blog-item__thumb-link">
                                    <img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->image, '405x225') }}" class="fit-image" alt="">
                                </a>
                                <span class="blog-item__date before-shadow flex-center"> <span class="d-block"> {{ showDateTime($blog->created_at, 'd') }}</span> <span class="fs-16 d-block w-100">{{ showDateTime($blog->created_at, 'M') }}</span></span>
                            </div>
                            <div class="blog-item__content">
                                <h5 class="blog-item__title"><a href="{{ route('blog.details', $blog->slug) }}" class="blog-item__title-link border-effect">{{ __($blog->data_values->title) }}</a></h5>
                                <p class="blog-item__desc fs-18">@php echo strLimit(strip_tags($blog->data_values->description), 80) @endphp</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
