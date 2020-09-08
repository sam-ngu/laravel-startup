@extends('public.layouts.master')

@push('after-scripts')
    <script type="application/javascript" src="{{mix('js/public.js')}}"></script>
@endpush

@section('content')

    @php
        $session =  session()->only(['admin_user_id', 'admin_user_name', 'temp_user_id']);
        $user = auth()->user() ? (new \App\Http\Resources\UserResource(auth()->user())) : null
    @endphp

    <base-public session="{{ json_encode(array_merge([
        'user' => $user,

    ], $session)) }}"/>


@endsection
