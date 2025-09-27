@extends($activeTemplate . 'layouts.master')

@section('content')
    @include($activeTemplate . 'partials.plan_card', ['miners' => $miners, 'class' => 'col-xl-4 col-md-6 col-sm-8'])
@endsection
