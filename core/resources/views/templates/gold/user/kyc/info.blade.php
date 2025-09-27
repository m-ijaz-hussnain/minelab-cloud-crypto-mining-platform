@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">@lang('KYC Information')</h5>
                </div>
                <div class="card-body">
                    @if ($user->kyc_data)
                        <ul class="list-group">
                            @foreach ($user->kyc_data as $val)
                                @continue(!$val->value)
                                <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center px-0">
                                    {{ __($val->name) }}
                                    <span>
                                        @if ($val->type == 'checkbox')
                                            {{ implode(',', $val->value) }}
                                        @elseif($val->type == 'file')
                                            <a class="text--base"
                                                href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}"><i
                                                    class="fa fa-file"></i> @lang('Attachment')</a>
                                        @else
                                            <p>{{ __($val->value) }}</p>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h5 class="text-center">@lang('KYC data not found')</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
