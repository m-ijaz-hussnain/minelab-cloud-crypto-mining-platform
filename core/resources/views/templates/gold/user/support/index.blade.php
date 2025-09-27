@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table--responsive--md table">
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
                            <td> <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}">[@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                </a>
                            </td>
                            <td>
                                @php echo $support->statusBadge; @endphp
                            </td>
                            <td>
                                @php echo $support->priorityBadge; @endphp
                            </td>
                            <td>{{ diffForHumans($support->last_reply) }}</td>

                            <td>
                                <a class="btn btn--base btn--sm" href="{{ route('ticket.view', $support->ticket) }}">
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
@endsection
