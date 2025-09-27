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
                                    <th>@lang('Image')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Coin Code')</th>
                                    <th>@lang('Plans')</th>
                                    <th>@lang('Withdrawal Limit')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($miners as $miner)
                                    @php
                                        $miner->image_with_path = getImage(getFilePath('miner') . '/' . @$miner->coin_image, getFileSize('miner'));
                                    @endphp
                                    <tr>
                                        <td> {{ $miners->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ $miner->image_with_path }}" alt="@lang('image')">
                                                </div>
                                            </div>
                                        </td>
                                        <td> {{ __($miner->name) }} </td>
                                        <td> {{ strtoupper($miner->coin_code) }} </td>
                                        <td> {{ $miner->plans->count() }} </td>
                                        <td> {{ showAmount($miner->min_withdraw_limit, 8, exceptZeros: true, currencyFormat: false) }} - {{ showAmount($miner->max_withdraw_limit, 8, exceptZeros: true, currencyFormat: false) }} {{ strtoupper($miner->coin_code) }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end flex-wrap gap-2">
                                                <a class="btn btn-outline--dark btn-sm" href="{{ route('admin.miner.plans', $miner->id) }}">
                                                    <i class="las la-list"></i>@lang('View Plans')
                                                </a>

                                                <button class="btn btn-outline--primary btn-sm editBtn cuModalBtn" data-resource="{{ $miner }}" data-modal_title="@lang('Update Miner')">
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>
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
                @if ($miners->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($miners) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.miner.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="d-flex justify-content-center">
                                    <div class="form-group">
                                        <label class="required">@lang('Image')</label>
                                        <div class="miner-image">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview" style="background-image: url('{{ getImage(null, getFileSize('miner')) }}')"></div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input class="profilePicUpload" id="image" name="coin_image" type="file" accept=".png, .jpg, .jpeg">
                                                    <label class="bg--primary" for="image"><i class="la la-pencil"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>@lang('Miner Name')</label>
                                    <input class="form-control" name="name" type="text" value="{{ old('name') }}" placeholder="@lang('Enter Miner Name')" required />
                                </div>

                                <div class="form-group">
                                    <label>@lang('Coin Code')</label>
                                    <input class="form-control" name="coin_code" type="text" value="{{ old('coin_code') }}" placeholder="@lang('Enter Coin Code')" required />
                                </div>
                                <div class="form-group">
                                    <label>@lang('Minimum Withdrawal Limit')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="min_withdraw_limit" type="number" value="{{ old('min_withdraw_limit') }}" step="any" placeholder="@lang('Enter Minimum withdrawal Limit')" required />
                                        <span class="input-group-text"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Maximum Withdrawal Limit')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="max_withdraw_limit" type="number" value="{{ old('max_withdraw_limit') }}" step="any" placeholder="@lang('Enter Maximum Withdrawal Limit')" required />
                                        <span class="input-group-text"></span>
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
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary h-45 cuModalBtn" data-modal_title="@lang('Add Miner')" type="button">
        <i class="las la-plus"></i>@lang('Add New ')
    </button>
    <x-search-form placeholder="Search by Name" />
@endpush

@push('script')
    <script>
        "use strict";

        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).closest('.miner-image').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".profilePicUpload").on('change', function() {
            proPicURL(this);
        });
    </script>
@endpush

@push('style')
    <style>
        .miner-image .thumb {
            width: 220px;
            position: relative;
            margin-bottom: 30px;
        }

        .miner-image .thumb .profilePicPreview {
            width: 210px;
            height: 210px;
            display: block;
            border: 3px solid #f1f1f1;
            box-shadow: 0 0 5px 0 rgb(0 0 0 / 25%);
            border-radius: 10px;
            background-size: cover;
            background-position: center;
        }

        .miner-image .thumb .avatar-edit {
            position: absolute;
            bottom: -15px;
            right: 0;
        }

        .miner-image .thumb .profilePicUpload {
            font-size: 0;
            opacity: 0;
            width: 0;
        }

        .miner-image .thumb .avatar-edit label {
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

@push('script')
    <script>
        (function($) {
            "use strict";

            $('[name=coin_code]').on('input', function() {
                $('#cuModal').find('.input-group-text').text($(this).val());
            });

            $('.editBtn').on('click', function() {
                let resource = $(this).data('resource');
                $('#cuModal').find('.input-group-text').text(resource.coin_code);
            });

            $("#cuModal").on('hidden.bs.modal', function() {
                $(this).find('.input-group-text').text('');
                $(this).find('.profilePicPreview').css("background-image", "url('{{ getImage(null, getFileSize('miner')) }}')");
            });
        })(jQuery);
    </script>
@endpush
