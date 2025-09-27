@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two custom-data-table table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Miner')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Speed')</th>
                                    <th>@lang('Period')</th>
                                    <th>@lang('Return /Day')</th>
                                    <th>@lang('Maintenance')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($plans as $plan)
                                    <tr>
                                        <td> {{ $plans->firstItem() + $loop->index }}</td>
                                        <td> {{ __($plan->title) }} </td>
                                        <td> {{ __(@$plan->miner->name) }} </td>
                                        <td> {{ showAmount($plan->price) }}</td>
                                        <td> {{ $plan->speed }} {{ $plan->speedUnitText }} </td>
                                        <td> {{ $plan->period }} {{ $plan->periodUnitText }}</td>
                                        <td> {{ $plan->returnPerDay }} {{ strtoupper(@$plan->miner->coin_code) }} </td>
                                        <td> {{ getAmount($plan->maintenance_cost) }} % </td>
                                        <td>
                                            @php
                                                echo $plan->statusBadge;
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-outline--primary btn-sm editBtn"
                                                    data-plan="{{ $plan }}">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>

                                                @if ($plan->status == Status::DISABLE)
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline--success  confirmationBtn"
                                                        data-action="{{ route('admin.plan.status', $plan->id) }}"
                                                        data-question="@lang('Are you sure to enable this plan?')">
                                                        <i class="la la-eye"></i>@lang('Enable')
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-action="{{ route('admin.plan.status', $plan->id) }}"
                                                        data-question="@lang('Are you sure to disable this plan?')">
                                                        <i class="la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                @if ($plans->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($plans) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div class="modal fade" id="addModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add Plan')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.plan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('Title')</label>
                                <input class="form-control" name="title" type="text" value="{{ old('title') }}"
                                    placeholder="@lang('Enter Plan Title')" required />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>@lang('Miner')</label>
                                <select class="form-control" name="miner">
                                    <option value="">@lang('Select One')</option>
                                    @foreach ($miners as $miner)
                                        <option data-coin_code={{ $miner->coin_code }} value="{{ $miner->id }}"
                                            @selected($miner->id == old('miner'))> {{ __($miner->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>@lang('Price')</label>
                                <div class="input-group">
                                    <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                    <input class="form-control" name="price" type="number" value="{{ old('price') }}"
                                        step="any" placeholder="@lang('Enter Price')" required />
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>@lang('Return Amount Type')</label>
                                <select class="form-control" name="return_type">
                                    <option value="1" @selected(old('return_type') == 1)>@lang('Fixed')</option>
                                    <option value="2" @selected(old('return_type') == 2)>@lang('Random')</option>
                                </select>
                            </div>

                            <div class="col-12 return-type-wrapper">
                                <div class="form-group">
                                    <label>@lang('Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="return_per_day" type="number"
                                            value="{{ old('return_per_day') }}" step="any"
                                            placeholder="@lang('Enter Return Per Day')" required />
                                        <span class="input-group-text rpd_cur_sym">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>@lang('Speed')</label>
                                <div class="input-group">
                                    <input class="form-control" name="speed" type="number" step="any"
                                        placeholder="@lang('Enter Speed Value')" required />
                                    <select class="input-group-text" name="speed_unit">
                                        <option value="0">@lang('hash/s')</option>
                                        <option value="1">@lang('Khash/s')</option>
                                        <option value="2" selected>@lang('Mhash/s')</option>
                                        <option value="3">@lang('Ghash/s')</option>
                                        <option value="4">@lang('Thash/s')</option>
                                        <option value="5">@lang('Phash/s')</option>
                                        <option value="6">@lang('Ehash/s')</option>
                                        <option value="7">@lang('Zhash/s')</option>
                                        <option value="8">@lang('Yhash/s')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>@lang('Period')</label>
                                <div class="input-group">
                                    <input class="form-control" name="period" type="number" step="any"
                                        placeholder="@lang('Enter Period Value')" required />
                                    <select class="input-group-text" name="period_unit">
                                        <option value="0" @selected(old('period') == 0)>@lang('Day')</option>
                                        <option value="1" @selected(old('period') == 1)>@lang('Month')</option>
                                        <option value="2" @selected(old('period') == 2)>@lang('Year')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>@lang('Maintenance Cost')</label>
                                <div class="input-group">
                                    <input class="form-control" name="maintenance_cost" type="number" step="any"
                                        value="{{ old('maintenance_cost') }}" required />
                                    <span class="input-group-text">@lang('% Per Day')</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Features')</label>
                            <select class="form-control select2-auto-tokenize" name="features[]" multiple>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea class="form-control" name="description" rows="5">{{ old('descripiton') }}</textarea>
                        </div>

                        <button class="btn btn-block btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Method Modal --}}
    <div class="modal fade" id="editModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="editForm" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('Title')</label>
                                <input class="form-control" name="title" type="text" value="{{ old('title') }}"
                                    placeholder="@lang('Enter Plan Title')" required />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>@lang('Miner')</label>
                                <select class="form-control" name="miner">
                                    <option value="">@lang('Select One')</option>
                                    @foreach ($miners as $miner)
                                        <option data-coin_code={{ $miner->coin_code }} value="{{ $miner->id }}"
                                            @selected(old('miner') == $miner->id)> {{ __($miner->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>@lang('Price')</label>
                                <div class="input-group">
                                    <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                    <input class="form-control" name="price" type="number"
                                        value="{{ old('price') }}" step="any" placeholder="@lang('Enter Price')"
                                        required />
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>@lang('Return Amount Type')</label>
                                <select class="form-control" name="return_type">
                                    <option value="1" @selected(old('return_type') == 1)>@lang('Fixed')</option>
                                    <option value="2" @selected(old('return_type') == 2)>@lang('Random')</option>
                                </select>
                            </div>

                            <div class="col-12 return-type-wrapper">
                                <div class="form-group">
                                    <label>@lang('Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="return_per_day" type="number"
                                            value="{{ old('return_per_day') }}" step="any"
                                            placeholder="@lang('Enter Return Per Day')" required />
                                        <span class="input-group-text rpd_cur_sym">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>@lang('Speed')</label>
                                <div class="input-group">
                                    <input class="form-control" name="speed" type="number" step="any"
                                        placeholder="@lang('Enter Speed Value')" required />
                                    <select class="input-group-text" name="speed_unit">
                                        <option value="0">@lang('hash/s')</option>
                                        <option value="1">@lang('Khash/s')</option>
                                        <option value="2" selected>@lang('Mhash/s')</option>
                                        <option value="3">@lang('Ghash/s')</option>
                                        <option value="4">@lang('Thash/s')</option>
                                        <option value="5">@lang('Phash/s')</option>
                                        <option value="6">@lang('Ehash/s')</option>
                                        <option value="7">@lang('Zhash/s')</option>
                                        <option value="8">@lang('Yhash/s')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>@lang('Period')</label>
                                <div class="input-group">
                                    <input class="form-control" name="period" type="number" step="any"
                                        placeholder="@lang('Enter Period Value')" required />
                                    <select class="input-group-text" name="period_unit">
                                        <option value="0" @selected(old('period') == 0)>@lang('Day')</option>
                                        <option value="1" @selected(old('period') == 1)>@lang('Month')</option>
                                        <option value="2" @selected(old('period') == 2)>@lang('Year')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>@lang('Maintenance Cost')</label>
                                <div class="input-group">
                                    <input class="form-control" name="maintenance_cost" type="number" step="any"
                                        required />
                                    <span class="input-group-text">@lang('% Per Day')</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Features')</label>
                            <select class="form-control select2-auto-tokenize" name="features[]"
                                multiple="multiple"></select>
                        </div>

                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea class="form-control" name="description" rows="5">{{ old('descripiton') }}</textarea>
                        </div>

                        <button class="btn btn-block btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary @if (request()->routeIs('admin.plan.index')) h-45 @else btn-sm @endif addBtn"><i
            class="las la-plus"></i>@lang('Add New')</button>
    @if (request()->routeIs('admin.plan.index'))
        <x-search-form placeholder="Search by title/Miner" />
    @else
        <a class="btn btn-sm btn-outline--dark" href="{{ route('admin.miner.index') }}"><i
                class="las la-undo"></i>@lang('Back')</a>
    @endif
@endpush

@push('script')
    <script>
        'use strict';
        (function($) {
            $('.addBtn').on('click', function() {
                var modal = $('#addModal');
                modal.find('form').trigger("reset");
                let currentMiner = @json(@$currentMiner->id);
                modal.find('select[name=miner]').val(currentMiner).trigger("change");
                initSelect2AutoTokenize(modal);

                modal.modal('show');
            });


            $('.editBtn').on('click', function() {
                var modal = $('#editModal');
                var plan = $(this).data('plan');
                var form = document.getElementById('editForm');

                modal.find('.modal-title').text(`@lang('Edit Plan -') ${plan.title}`);

                modal.find('input[name=title]').val(plan.title);
                modal.find('input[name=price]').val(parseFloat(plan.price));
                modal.find('.rpd_cur_sym').text(plan.miner.coin_code);
                modal.find('select[name=miner]').val(plan.miner_id);
                modal.find('input[name=speed]').val(plan.speed);
                modal.find('select[name=speed_unit]').val(plan.speed_unit);

                modal.find('input[name=period]').val(plan.period);
                modal.find('input[name=maintenance_cost]').val(plan.maintenance_cost);
                modal.find('select[name=period_unit]').val(plan.period_unit);


                if (!plan.max_return_per_day) {
                    modal.find('select[name=return_type]').val(1);
                    modal.find('.return-type-wrapper').html(`
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Return Amount /Day')</label>
                            <div class="input-group">
                                <input type="number" step="any" class="form-control" placeholder="@lang('Enter Return Per Day')" name="return_per_day" required/>
                                <span class="input-group-text rpd_cur_sym">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                `)
                    modal.find('input[name=return_per_day]').val(parseFloat(plan.min_return_per_day));

                } else {
                    modal.find('select[name=return_type]').val(2);
                    modal.find('.return-type-wrapper').html(`<div class="row">
                            <div class="form-group col-lg-6">
                                <label class="font-weight-bold">@lang('Minimum Return Amount /Day')</label>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="@lang('Enter Return Per Day')" name="min_return_per_day" required/>
                                    <span class="input-group-text rpd_cur_sym">{{ gs('cur_text') }}</span>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="font-weight-bold">@lang('Maximum Return Amount /Day')</label>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="@lang('Enter Return Per Day')" name="max_return_per_day" required/>
                                    <span class="input-group-text rpd_cur_sym">{{ gs('cur_text') }}</span>
                                </div>
                            </div>
                        </div>`)

                    modal.find('input[name=min_return_per_day]').val(parseFloat(plan.min_return_per_day));
                    modal.find('input[name=max_return_per_day]').val(parseFloat(plan.max_return_per_day));
                }

                var coinCode = modal.find('select[name=miner]').find(':selected').attr('data-coin_code');
                modal.find('.rpd_cur_sym').text(coinCode);

                if (plan.status == 0) {
                    modal.find('[name=status]').bootstrapToggle('off');
                } else {
                    modal.find('[name=status]').bootstrapToggle('on');
                }

                let selectedValues = '';
                $.each(plan.features, function(i, v) {
                    selectedValues += `<option value="${v}" selected>${v}</option>`;
                });

                modal.find('select[name="features[]"]').html(selectedValues);

                initSelect2AutoTokenize(modal);

                modal.find('textarea[name=description]').val(plan.description);


                form.action = '{{ route('admin.plan.update', '') }}' + '/' + plan.id;

                modal.modal('show');
            });



            $(document).on('change', 'select[name=miner]', function() {
                var coinCode = $(this).find(':selected').attr('data-coin_code');
                $(this).parents('.modal-body').find('.rpd_cur_sym').text(coinCode);
            });

            $(document).on('change', 'select[name=return_type]', function() {
                if ($(this).val() == 2) {
                    $(this).parents('.modal-body').find('.return-type-wrapper').html(`<div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="font-weight-bold">@lang('Minimum Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" placeholder="@lang('Enter Return Per Day')" name="min_return_per_day" required/>
                                        <span class="input-group-text rpd_cur_sym">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label class="font-weight-bold">@lang('Maximum Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" placeholder="@lang('Enter Return Per Day')" name="max_return_per_day" required/>
                                        <span class="input-group-text rpd_cur_sym">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>
                            </div>`).hide().show();
                } else {
                    $(this).parents('.modal-body').find('.return-type-wrapper').html(`
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Return Amount /Day')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" placeholder="@lang('Enter Return Per Day')" name="return_per_day" required/>
                                        <span class="input-group-text rpd_cur_sym">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>
                            `).hide().show();
                }
                var coinCode = $(this).parents('.modal-body').find('select[name=miner]').find(':selected').attr(
                    'data-coin_code');
                $(this).parents('.modal-body').find('.rpd_cur_sym').text(coinCode);
            });

            function initSelect2AutoTokenize(modal) {
                modal.find('.select2-auto-tokenize').select2({
                    dropdownParent: modal,
                    tags: true,
                    tokenSeparators: [',']
                });
            }
        })(jQuery)
    </script>
@endpush
