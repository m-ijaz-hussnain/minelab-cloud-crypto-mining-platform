@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <section class="blog py-100">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item">
                            <div class="blog-item__thumb">
                                <a class="blog-item__thumb-link" href="{{ route('blog.details', $blog->slug) }}"><img
                                        src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->blog_image, '300x200') }}"
                                        alt=""></a>
                                <span class="blog-item__date"> <span class="blog-item__date-icon"><i
                                            class="fas fa-calendar-alt"></i></span>
                                    {{ showDateTime($blog->created_at, 'd, M') }} </span>
                            </div>
                            <div class="blog-item__content">
                                <h4 class="blog-item__title"><a class="blog-item__title-link"
                                        href="{{ route('blog.details', $blog->slug) }}">{{ __($blog->data_values->title) }}</a>
                                </h4>
                                <p class="blog-item__desc">@php echo strLimit(strip_tags($blog->data_values->description), 80) @endphp</p>
                                <a class="btn--simple" href="{{ route('blog.details', $blog->slug) }}">@lang('Read More')
                                    <span class="btn--simple__icon"><i class="las la-chevron-right"></i></span> </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="pagination-wrapper mt-4 mt-md-5">
                    {{ paginateLinks($blogs) }}
                </div>
            </div>
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection

@push('style')
    <style>
        .pagination-wrapper .d-flex.justify-content-between.flex-fill {
            display: none !important;
        }

        .pagination-wrapper .flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between {
            display: flex !important;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            width: 100%;
            justify-content: space-between;
        }

        .pagination .page-item.disabled .page-link {
            background-color: hsl(0deg 0% 100% / 40%);
        }
    </style>
@endpush
