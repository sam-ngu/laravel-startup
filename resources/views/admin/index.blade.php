@extends('admin.layouts.master')

@push('after-scripts')
    <script src="{{mix('js/admin.js')}}"></script>
@endpush

@section('content')

    @php
        $user = auth()->user() ? (new \App\Http\Resources\UserResource(auth()->user()))->toArray(null) : null
    @endphp


    <base-admin session="{{ json_encode([
            'user' => $user
    ]) }}"
    />

@endsection
