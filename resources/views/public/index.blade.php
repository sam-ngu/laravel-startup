@extends('public.layouts.master')

@push('after-scripts')
    <script type="application/javascript" src="{{mix('js/public.js')}}"></script>
@endpush

@section('content')

    @php

        $user = auth()->user() ? (new \App\Http\Resources\UserResource(auth()->user())) : null
    @endphp

    <base-public session="{{ json_encode([
        'user' => $user
        ]) }}"/>


@endsection
