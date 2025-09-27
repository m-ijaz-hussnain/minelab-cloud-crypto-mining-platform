@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card custom--card">

                <div class="card-body">
                    <form action="{{ route('ticket.store') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Subject')</label>
                                    <input class="form-control" name="subject" required type="text" value="{{ old('subject') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Priority')</label>
                                    <select class="form-select form-control" name="priority" required>
                                        <option @selected(old('priority' == 3)) value="3">@lang('High')</option>
                                        <option @selected(old('priority' == 2)) value="2">@lang('Medium')</option>
                                        <option @selected(old('priority' == 1)) value="1">@lang('Low')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">@lang('Message')</label>
                                    <textarea class="form-control" id="inputMessage" name="message" required rows="6">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-end">
                            <button class="btn btn--base addFile" type="button">
                                <i class="fa fa-plus"></i> @lang('Add New')
                            </button>
                        </div>
                        <div class="col-12">
                            <div class="form-group"> <label class="form-label align-self-end mb-0">@lang('Attachments')</label>
                                <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                                <input accept=".png, .jpg, .jpeg,.pdf,.doc,.docx" class="form-control mb-2" id="inputAttachments" name="attachments[]" type="file" />
                            </div>
                            <div class="mt-3" id="fileUploadsContainer"></div>
                            <p class="ticket-attachments-message text-muted">
                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                            </p>
                        </div>

                        <button class="btn btn--base w-100 mt-3" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="form-group">
                        <div class="input-group">
                            <input type="file" name="attachments[]" class="form-control" required  accept=".png, .jpg, .jpeg,.pdf,.doc,.docx"/>
                            <button type="button" class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
