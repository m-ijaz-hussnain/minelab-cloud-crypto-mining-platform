@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if ($user->kyc_data)
                    <ul class="list-group">
                        @foreach ($user->kyc_data as $val)
                            @continue(!$val->value)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __($val->name) }}
                                <span>
                                    @if ($val->type == 'checkbox')
                                        {{ implode(',', $val->value) }}
                                    @elseif($val->type == 'file')
                                        <a class="text-base" href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}"><i class="fa fa-file"></i> @lang('Attachment') </a>
                                    @else
                                        {{ __($val->value) }}
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
@endsection
