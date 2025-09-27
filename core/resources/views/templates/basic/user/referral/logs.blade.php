@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="order-section pd-t-30 pd-b-30">
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-12 mrb-30">

                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th scope="col">@lang('User')</th>
                                <th class="text-center" scope="col">@lang('Amount')</th>
                                <th class="text-center" scope="col">@lang('Level')</th>
                                <th class="text-center" scope="col">@lang('Percent')</th>
                                <th class="text-end" scope="col">@lang('Time')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $data)
                                <tr>
                                    <td>{{ $data->referee->username }}</td>
                                    <td class="text-center">
                                        {{ showAmount($data->amount) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data->level }}
                                    </td>
                                    <td class="text-center">
                                        {{ showAmount($data->percent) }}%
                                    </td>

                                    <td class="text-end">
                                        {{ showDateTime($data->created_at) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ paginateLinks($logs) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        document.querySelectorAll('.copybtn').forEach((element) => {
            element.addEventListener('click', copy, true);
        })

        function copy(e) {
            var
                t = e.target,
                c = t.dataset.copytarget,
                inp = (c ? document.querySelector(c) : null);
            if (inp && inp.select) {
                inp.select();
                try {
                    document.execCommand('copy');
                    inp.blur();
                    t.classList.add('copied');
                    setTimeout(function() {
                        t.classList.remove('copied');
                    }, 1500);
                } catch (err) {
                    alert(`@lang('Please press Ctrl/Cmd+C to copy')`);
                }
            }
        }
    </script>
@endpush

@push('style')
    <style>
        .copyInput {
            display: inline-block;
            line-height: 50px;
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            text-align: center;
            font-size: 14px;
            cursor: pointer;
            -webkit-transition: all .3s;
            -o-transition: all .3s;
            transition: all .3s;
        }

        .copied::after {
            position: absolute;
            top: 10px;
            right: 12%;
            width: 100px;
            display: block;
            content: "COPIED";
            font-size: 1em;
            padding: 2px 5px;
            color: #fff;
            border-radius: 3px;
            opacity: 0;
            will-change: opacity, transform;
            animation: showcopied 1.5s ease;
            background-color: #{{ gs('base_color') }};
        }

        @keyframes showcopied {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }

            50% {
                opacity: 0.7;
                transform: translateX(40%);
            }

            70% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
            }
        }
    </style>
@endpush
