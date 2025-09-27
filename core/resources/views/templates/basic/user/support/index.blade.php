@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="order-section pd-b-80">
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-12 mrb-30">
                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $support)
                                <tr>
                                    <td> <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}"> <small>[@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}</small>
                                        </a></td>
                                    <td>
                                        @php echo $support->statusBadge; @endphp
                                    </td>
                                    <td>
                                        @php echo $support->priorityBadge; @endphp
                                    </td>
                                    <td><small>{{ diffForHumans($support->last_reply) }}</small></td>

                                    <td>
                                        <a class="btn btn-icon btn-sm" href="{{ route('ticket.view', $support->ticket) }}">
                                            <i class="las la-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ paginateLinks($supports) }}
                </div>
            </div>
        </div>
    </div>
@endsection
