@extends('admin.layouts.master')

@push('after-scripts')
    <script src="{{mix('js/admin.js')}}"></script>
@endpush

@section('content')

    @php

        $user = auth()->user();
        if($user){
            $user = new \App\Http\Resources\UserResource($user->loadMissing(['roles']));
        }
    @endphp


    <base-admin session="{{ json_encode([
            'user' => $user
    ]) }}"
    />

@endsection
