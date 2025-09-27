@extends('admin.layouts.app')

@section('panel')
    <div class="row gy-4">

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" link="{{ route('admin.users.all') }}" icon="las la-users" title="Total Users" value="{{ $widget['total_users'] }}" color="primary" icon_style="solid" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" link="{{ route('admin.users.active') }}" icon="las la-user-check" title="Active Users" value="{{ $widget['verified_users'] }}" color="success" icon_style="solid" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" link="{{ route('admin.users.email.unverified') }}" icon="lar la-envelope" title="Email Unverified Users" value="{{ $widget['email_unverified_users'] }}" color="danger" icon_style="solid" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" link="{{ route('admin.users.mobile.unverified') }}" icon="las la-comment-slash" title="Mobile Unverified Users" value="{{ $widget['mobile_unverified_users'] }}" color="warning" icon_style="solid" />
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <!-- Miner widget -->
    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_miner'] }}" title="Total Miner" style="2" color="info" icon_style="solid" link="{{ route('admin.miner.index') }}" icon="la la-hammer" icon_style="solid" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_plan'] }}" title="Total Mining Plan" style="2" color="primary" icon_style="solid" link="{{ route('admin.plan.index') }}" icon="la la-list" icon_style="solid" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_sale_count'] }}" title="Total Sale" style="2" color="success" icon_style="solid" link="{{ route('admin.order.index') }}" icon="la la-list-alt" icon_style="solid" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ showAmount($widget['total_sale_amount']) }}" title="Total Sale Amount" style="2" color="dark" icon_style="solid" link="{{ route('admin.order.index') }}" icon="la la-money-bill" icon_style="solid" />

        </div>
    </div><!-- row end-->

    <div class="row mb-none-30 mt-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap gap-3">
                        <h5 class="card-title">@lang('Returned Amount')</h5>
                        <div class="d-flex flex-wrap gap-3">
                            <select class="form-control w-auto" name="currency" id="returnAmoCurrency">
                                @foreach ($coinCodes as $coinCode)
                                    <option value="{{ $coinCode }}">{{ strtoupper($coinCode) }}</option>
                                @endforeach
                            </select>
                            <div id="returnAmoDatePicker" class="border daterangepicker-selectbox rounded">
                                <i class="la la-calendar"></i>&nbsp;
                                <span></span> <i class="la la-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <div id="returnedAmountChart"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap gap-3">
                        <h5 class="card-title">@lang('Transactions Report')</h5>

                        <div class="d-flex flex-wrap gap-3">
                            <select class="form-control w-auto" name="currency" id="trxCurrency">
                                @foreach ($transactionCurrencies as $transactionCurrency)
                                    <option value="{{ $transactionCurrency }}" @selected($transactionCurrency == gs()->cur_text)>{{ strtoupper($transactionCurrency) }}</option>
                                @endforeach
                            </select>

                            <div id="trxDatePicker" class="border daterangepicker-selectbox rounded">
                                <i class="la la-calendar"></i>&nbsp;
                                <span></span> <i class="la la-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <div id="transactionChartArea"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.cron_modal')
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm" data-bs-toggle="modal" data-bs-target="#cronModal">
        <i class="las la-server"></i>@lang('Cron Setup')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush

@push('script')
    <script>
        "use strict";

        const start = moment().subtract(14, 'days');
        const end = moment();

        const dateRangeOptions = {
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
            },
            maxDate: moment()
        }

        const changeDatePickerText = (element, startDate, endDate) => {
            $(element).html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
        }

        let returnAmoChart = barChart(
            document.querySelector("#returnedAmountChart"),
            $('#returnAmoCurrency').val(),
            [{
                name: 'Returned Amount',
                data: []
            }],
            [],
        );


        let trxChart = lineChart(
            document.querySelector("#transactionChartArea"),
            [{
                    name: "Plus Transactions",
                    data: []
                },
                {
                    name: "Minus Transactions",
                    data: []
                }
            ],
            []
        );

        const returnAmountChart = (startDate, endDate) => {

            let currency = $('#returnAmoCurrency').val();
            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD'),
                currency
            }

            const url = @json(route('admin.chart.return.amount'));

            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        returnAmoChart.updateSeries(data.data);
                        returnAmoChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            },
                            yaxis: {
                                title: {
                                    text: data.currency,
                                    style: {
                                        color: '#7c97bb'
                                    }
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(value) {
                                        return data.currency + ' ' + value.toFixed(4);
                                    }
                                }
                            }
                        });
                    }
                }
            );
        }

        const transactionChart = (startDate, endDate) => {
            let currency = $('#trxCurrency').val();

            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD'),
                currency
            }

            const url = @json(route('admin.chart.transaction'));


            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        trxChart.updateSeries(data.data);
                        trxChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }

        $('#returnAmoDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#returnAmoDatePicker span', start, end));
        $('#trxDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#trxDatePicker span', start, end));

        returnAmountChart(start, end);
        transactionChart(start, end);

        $('#returnAmoDatePicker').on('apply.daterangepicker', (event, picker) => returnAmountChart(picker.startDate, picker.endDate));
        $('#trxDatePicker').on('apply.daterangepicker', (event, picker) => transactionChart(picker.startDate, picker.endDate));

        $("#trxCurrency").on("change", function() {
            let startDate = $("#trxDatePicker").data('daterangepicker').startDate._d;
            let endDate = $("#trxDatePicker").data('daterangepicker').endDate._d;

            transactionChart(moment(startDate), moment(endDate));
        });

        $("#returnAmoCurrency").on("change", function() {
            let startDate = $("#returnAmoDatePicker").data('daterangepicker').startDate._d;
            let endDate = $("#returnAmoDatePicker").data('daterangepicker').endDate._d;

            returnAmountChart(moment(startDate), moment(endDate));
        });

        piChart(
            document.getElementById('userBrowserChart'),
            @json(@$chart['user_browser_counter']->keys()),
            @json(@$chart['user_browser_counter']->flatten())
        );

        piChart(
            document.getElementById('userOsChart'),
            @json(@$chart['user_os_counter']->keys()),
            @json(@$chart['user_os_counter']->flatten())
        );

        piChart(
            document.getElementById('userCountryChart'),
            @json(@$chart['user_country_counter']->keys()),
            @json(@$chart['user_country_counter']->flatten())
        );
    </script>
@endpush

@push('style')
    <style>
        .apexcharts-menu {
            min-width: 120px !important;
        }

        .daterangepicker-selectbox {
            height: 45px;
            padding: 0 12px;
            cursor: pointer !important;
        }

        .daterangepicker-selectbox i {
            line-height: 45px;
        }
    </style>
@endpush
