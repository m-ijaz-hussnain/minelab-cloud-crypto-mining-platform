@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table--responsive--md">
                <thead>
                    <tr>
                        <th>@lang('User')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Level')</th>
                        <th>@lang('Percent')</th>
                        <th>@lang('Time')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $k => $data)
                        <tr>
                            <td>{{ $data->referee->username }}</td>
                            <td>
                                {{ showAmount($data->amount) }}
                            </td>
                            <td>
                                {{ $data->level }}
                            </td>
                            <td>
                                {{ showAmount($data->percent) }}%
                            </td>

                            <td>
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
@endsection
