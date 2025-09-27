@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Time')</th>
                                    <th scope="col">@lang('Received By')</th>
                                    <th scope="col">@lang('Referee')</th>
                                    <th scope="col">@lang('Level')</th>
                                    <th scope="col">@lang('Percent')</th>
                                    <th scope="col">@lang('Amount')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>
                                            {{ showDateTime($log->created_at) }}
                                        </td>
                                        <td>{{ $log->user->username }}</td>
                                        <td>{{ $log->referee->username }}</td>

                                        <td>
                                            {{ $log->level }}
                                        </td>
                                        <td>
                                            {{ showAmount($log->percent) }}%
                                        </td>

                                        <td>
                                            <strong>
                                                {{ showAmount($log->amount) }}
                                            </strong>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($logs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($logs) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection
