@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two custom-data-table table">
                            <thead>
                                <thead>
                                    <tr>
                                        <th>@lang('S.N.')</th>
                                        <th>@lang('Image')</th>
                                        <th>@lang('Name')</th>
                                        <th>@lang('Earning Amount')</th>
                                        <th>@lang('Discount on Maintenance')</th>
                                        <th>@lang('Discount On Plan Purchase')</th>
                                        <th>@lang('Boost Return Amount')</th>
                                        <th>@lang('Boost Referral Bonus')</th>
                                        <th>@lang('Actions')</th>
                                    </tr>
                                </thead>

                            </thead>
                            <tbody class="list">
                                @forelse($badges as $badge)
                                    <tr>
                                        @php
                                            $badge->image_with_path = getImage(getFilePath('badge') . '/' . $badge->image, getFileSize('badge'));
                                        @endphp
                                        <td> {{ $badges->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('badge') . '/' . $badge->image, getFileSize('badge')) }}" alt="@lang('image')">
                                                </div>
                                            </div>
                                        </td>
                                        <td> {{ __($badge->name) }} </td>

                                        <td> {{ showAmount($badge->earning_amount, 8, exceptZeros: true, currencyFormat: false) }}
                                        </td>

                                        <td>
                                            {{ $badge->discount_maintenance_cost ? $badge->discount_maintenance_cost . ' ' . __('%') : 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $badge->plan_price_discount ? $badge->plan_price_discount . ' ' . __('%') : 'N/A' }}
                                        </td>


                                        <td>
                                            {{ $badge->earning_boost ? $badge->earning_boost . ' ' . __('%') : 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $badge->referral_bonus_boost ? $badge->referral_bonus_boost . ' ' . __('%') : 'N/A' }}
                                        </td>

                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--primary editBtn" data-badge="{{ $badge }}" data-action="{{ route('admin.badge.save', $badge->id) }}">
                                                    <i class="las la-pen"></i>@lang('Edit')</button>

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
                @if ($badges->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($badges) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div class="modal fade" id="showModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.badge.save') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="d-flex justify-content-center">
                                    <div class="form-group">
                                        <label for="">@lang('Image')</label>
                                        <x-image-uploader name="image" :imagePath="getImage(getFilePath('badge'), getFileSize('badge'))" :size="getFileSize('badge')" class="w-100" id="badge" :required="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>@lang('Badge Name')</label>
                                    <input class="form-control" name="name" type="text" value="{{ old('name') }}" placeholder="@lang('Badge Name')" required />
                                </div>

                                <div class="form-group">
                                    <label>@lang('Earning Amount')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="earning_amount" type="number" value="{{ old('earning_amount') }}" step="any" placeholder="@lang('Earning Amount')" required />
                                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="alert alert-info p-3">
                                        <ul class="d-flex flex-column gap-3">
                                            <li>1. @lang('If a feature is not checked, the user retains the percentage benefits from their') <strong>@lang('previous badge')</strong>.</li>
                                            <li>2. @lang('If a feature is checked and set to') <strong>0</strong>, @lang('it remains off.')</li>
                                        </ul>
                                    </div>

                                    <label class="mb-2">@lang('Features')</label>
                                    <div class="d-flex flex-column">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="maintenanceCostDiscount">
                                            <label class="form-check-label" for="maintenanceCostDiscount">@lang('Discount on Maintenance Cost')</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="planDiscount">
                                            <label class="form-check-label" for="planDiscount">@lang('Discount on Plan Purchase')</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="earningBoost">
                                            <label class="form-check-label" for="earningBoost">@lang('Boost Return Amount')</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="referralBonus">
                                            <label class="form-check-label" for="referralBonus">@lang('Boost Referral Bonus	')</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group" id="maintenanceCost">
                                    <label>@lang('Discount On Maintenance Amount')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="discount_maintenance_cost" type="number" step="any" value="{{ old('discount_maintenance_cost') }}" />
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>

                                <div class="form-group" id="planDiscountField">
                                    <label>@lang('Discount on Plan Purchase')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="plan_price_discount" type="number" step="any" min="0" value="{{ old('plan_price_discount') }}" />
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>

                                <div class="form-group" id="earningBoostPlan">
                                    <label>@lang('Boost Return Amount')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="earning_boost" type="number" step="any" value="{{ old('earning_boost') }}" />
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>

                                <div class="form-group" id="referralBonusField">
                                    <label>@lang('Boost Referral Bonus')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="referral_bonus_boost" type="number" value="{{ old('referral_bonus_boost') }}" step="any" />
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary h-45 addBtn"><i class="las la-plus"></i>@lang('Add New')</button>
    <x-search-form placeholder="Search by Name" />
@endpush

@push('script')
    <script>
        "use strict";

        function toggleField(checkbox, field) {
            if ($(checkbox).is(":checked")) {
                $(field).show().find("input").prop("disabled", false);
            } else {
                $(field).hide().find("input").prop("disabled", true);
            }
        }

        $("#maintenanceCostDiscount").change(function() {
            toggleField(this, "#maintenanceCost");
        });

        $("#planDiscount").change(function() {
            toggleField(this, "#planDiscountField");
        });

        $("#earningBoost").change(function() {
            toggleField(this, "#earningBoostPlan");
        });

        $("#referralBonus").change(function() {
            toggleField(this, "#referralBonusField");
        });

        $('input[type="checkbox"]').on('change', function() {
            toggleFields();
        });

        $('.addBtn').on('click', function() {
            var modal = $('#showModal');
            var imagePath = `{{ getImage(getFilePath('badge'), getFileSize('badge')) }}`;

            $('.modal-title').text('Add Badge');
            modal.find('form')[0].reset();
            modal.find('form').attr('action', "{{ route('admin.badge.save') }}");
            modal.find('.image-upload-preview').css("background-image", "url(" + imagePath + ")");
            modal.find('[name="image"]').attr('required', true);

            toggleField("#maintenanceCostDiscount", "#maintenanceCost");
            toggleField("#planDiscount", "#planDiscountField");
            toggleField("#earningBoost", "#earningBoostPlan");
            toggleField("#referralBonus", "#referralBonusField");

            modal.modal('show');
        });


        $('.editBtn').on('click', function() {
            var data = $(this).data('badge');
            var modal = $('#showModal');
            $('.modal-title').text('Edit Badge');
            modal.find('form')[0].reset();
            modal.find('[name="name"]').val(data.name);
            modal.find('[name="earning_amount"]').val(parseFloat(data.earning_amount).toFixed(2));
            modal.find('[name="discount_maintenance_cost"]').val(parseFloat(data.discount_maintenance_cost).toFixed(
                2));
            modal.find('[name="plan_price_discount"]').val(parseFloat(data.plan_price_discount).toFixed(2));
            modal.find('[name="earning_boost"]').val(parseFloat(data.earning_boost).toFixed(2));
            modal.find('[name="referral_bonus_boost"]').val(parseFloat(data.referral_bonus_boost).toFixed(2));

            let imagePath = @json(asset(@getFilePath('badge')));
            var image = imagePath + '/' + data.image;

            modal.find('.image-upload-preview').css("background-image", "url(" + image + ")");
            modal.find('[name="image"]').attr('required', false);
            modal.find('form').prop('action', $(this).data('action'));

            $("#maintenanceCostDiscount").prop("checked", data.discount_maintenance_cost != null);
            $("#planDiscount").prop("checked", data.plan_price_discount != null);
            $("#earningBoost").prop("checked", data.earning_boost != null);
            $("#referralBonus").prop("checked", data.referral_bonus_boost != null);

            toggleField("#maintenanceCostDiscount", "#maintenanceCost");
            toggleField("#planDiscount", "#planDiscountField");
            toggleField("#earningBoost", "#earningBoostPlan");
            toggleField("#referralBonus", "#referralBonusField");

            modal.modal('show');
        });
    </script>
@endpush

@push('style')
    <style>
        .badge-image .thumb {
            width: 220px;
            position: relative;
            margin-bottom: 30px;
        }

        .badge-image .thumb .profilePicPreview {
            width: 210px;
            height: 210px;
            display: block;
            border: 3px solid #f1f1f1;
            box-shadow: 0 0 5px 0 rgb(0 0 0 / 25%);
            border-radius: 10px;
            background-size: cover;
            background-position: center;
        }

        .badge-image .thumb .avatar-edit {
            position: absolute;
            bottom: -15px;
            right: 0;
        }

        .badge-image .thumb .profilePicUpload {
            font-size: 0;
            opacity: 0;
            width: 0;
        }

        .badge-image .thumb .avatar-edit label {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
            border: 2px solid #fff;
            font-size: 18px;
            cursor: pointer;
        }

        table .user {
            justify-content: center;
        }
    </style>
@endpush
