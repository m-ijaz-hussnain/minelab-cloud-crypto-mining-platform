@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-detials py-120">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-item">
                        <div class="blog-item__inner">
                            <div class="blog-item__thumb blog-details__thumb">
                                <img src="{{ frontendImage('blog', @$blog->data_values->image, '810x450') }}" class="fit-image" alt="@lang('image')">
                                <span class="blog-item__date before-shadow flex-center"> <span class="d-block"> {{ showDateTime($blog->created_at, 'd') }}</span> <span class="fs-16 d-block w-100">{{ showDateTime($blog->created_at, 'M') }}</span></span>
                            </div>
                            <div class="blog-item__content">
                                <h4 class="blog-item__title">{{ $blog->data_values->title }}</h4>
                                @php echo $blog->data_values->description @endphp
                                <div class="blog-details__share flex-between gap-2">
                                    <h6 class="mb-0">@lang('Share This Post')</h6>
                                    <ul class="social-list">
                                        <li class="social-list__item">
                                            <a class="social-list__link flex-center" href="http://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="lab la-facebook-f"></i></a>
                                        </li>

                                        <li class="social-list__item">
                                            <a class="social-list__link flex-center" href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}"><i class="lab la-twitter"></i></a>
                                        </li>

                                        <li class="social-list__item">
                                            <a class="social-list__link flex-center" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}"><i class="lab la-linkedin-in"></i></a>
                                        </li>

                                        <li class="social-list__item">
                                            <a class="social-list__link flex-center" href="https://www.instagram.com/?url={{ urlencode(url()->current()) }}"><i class="lab la-instagram"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="fb-comments mt-4" data-href="{{ url()->current() }}" data-width="" data-numposts="5"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h4 class="blog-sidebar__title"> @lang('Latest Blog') </h4>
                            @foreach ($latestBlogs as $latestBlog)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a href="{{ route('blog.details', $latestBlog->slug) }}">
                                            <img src="{{ frontendImage('blog', 'thumb_' . @$latestBlog->data_values->image, '405x225') }}" class="fit-image" alt="@lang('image')">
                                        </a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title"><a href="{{ route('blog.details', $latestBlog->slug) }}">{{ strLimit($latestBlog->data_values->title, 40) }}</a></h6>
                                        <div class="blog-meta flex-align">
                                            <div class="blog-meta__item"><span class="icon text--gradient"><i class="fas fa-calendar-check"></i></span><span class="text">{{ showDateTime(@$latestBlog->created_at, $format = 'd F, Y') }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
