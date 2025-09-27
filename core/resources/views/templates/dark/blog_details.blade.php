@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-details py-100">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-9 col-lg-8 pe-xl-5">
                    <div class="blog-item">
                        <div class="blog-item__thumb blog-details">
                            <img class="transform-unset" src="{{ frontendImage('blog', @$blog->data_values->blog_image, '900x600') }}" alt="">
                            <span class="blog-item__date"> <span class="blog-item__date-icon"><i class="fas fa-calendar-alt"></i></span> {{ showDateTime($blog->created_at, 'd, M') }} </span>
                        </div>
                        <div class="blog-item__content">
                            <h4 class="blog-item__title">{{ $blog->data_values->title }} </h4>
                            @php echo $blog->data_values->description @endphp

                            <div class="follow-us d-flex align-items-center mt-4 flex-wrap gap-2">
                                <h4 class="follow-title me-2 mb-0"> @lang('Share On') </h4>
                                <ul class="social-list">
                                    <li class="social-list__item">
                                        <a class="social-list__link" href="http://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="lab la-facebook-f"></i></a>
                                    </li>

                                    <li class="social-list__item">
                                        <a class="social-list__link" href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}"><i class="lab la-twitter"></i></a>
                                    </li>

                                    <li class="social-list__item">
                                        <a class="social-list__link" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}"><i class="lab la-linkedin-in"></i></a>
                                    </li>

                                    <li class="social-list__item">
                                        <a class="social-list__link" href="https://www.instagram.com/?url={{ urlencode(url()->current()) }}"><i class="lab la-instagram"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="fb-comments mt-4" data-href="{{ url()->current() }}" data-width="" data-numposts="5"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="blog-sidebar">
                        <h5 class="blog-sidebar__title"> @lang('Latest Blog') </h5>

                        @foreach ($latestBlogs as $latestBlog)
                            <div class="latest-blog">
                                <div class="latest-blog__thumb">
                                    <a href="{{ route('blog.details', $latestBlog->slug) }}"> <img src="{{ frontendImage('blog', 'thumb_' . @$latestBlog->data_values->blog_image, '300x200') }}" alt="@lang('Blog')"></a>
                                </div>
                                <div class="latest-blog__content">
                                    <h6 class="latest-blog__title"><a href="{{ route('blog.details', $latestBlog->slug) }}">{{ strLimit($latestBlog->data_values->title, 40) }}</a></h6>
                                    <span class="latest-blog__date">{{ showDateTime(@$latestBlog->created_at, $format = 'd F, Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
