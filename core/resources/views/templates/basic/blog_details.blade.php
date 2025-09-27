@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- blog-section start -->
    <section class="blog-section ptb-120">
        <div class="container">
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-8 mrb-30">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ frontendImage('blog', @$blog->data_values->blog_image, '708x472') }}" alt="Blog">
                            <span class="overlay-date">{{ showDateTime($blog->created_at, 'd, M') }}</span>
                        </div>
                        <div class="blog-content">
                            <h3 class="title">{{ $blog->data_values->title }}</h3>
                            @php echo $blog->data_values->description @endphp
                            <div class="follow-us d-flex align-items-center flex-wrap gap-2">
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
                        </div>
                    </div>

                    <div class="fb-comments mt-4" data-href="{{ url()->current() }}" data-width="" data-numposts="5"></div>

                </div>
                <div class="col-lg-4 mrb-30">
                    <div class="sidebar">
                        <div class="widget-box">
                            <h5 class="widget-title">@lang('Latest Blogs')</h5>
                            <div class="popular-widget-box">
                                @foreach ($latestBlogs as $latestBlog)
                                    <div class="single-popular-item d-flex align-items-center flex-wrap">
                                        <div class="popular-item-thumb">
                                            <img src="{{ frontendImage('blog', 'thumb_'.@$blog->data_values->blog_image, '318x212') }}" alt="@lang('blog')">
                                        </div>
                                        <div class="popular-item-content">
                                            <h5 class="title mb-0"><a href="{{ route('blog.details', $latestBlog->slug) }}">{{ __($latestBlog->data_values->title) }}</a></h5>
                                            <span class="blog-date">{{ showDateTime(@$latestBlog->created_at, $format = 'd F, Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-section end -->
@endsection
