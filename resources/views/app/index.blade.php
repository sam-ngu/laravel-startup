@extends('app.layouts.master')

@push('after-scripts')
    <script src="{{mix('js/app.js')}}"></script>
@endpush

@section('content')

    @php
        $user = auth()->user();
        if($user){
            $user = new \App\Http\Resources\UserResource($user->loadMissing(['roles']));
        }
    @endphp

    <base-app session="{{ json_encode([
            'user' => $user
    ]) }}" />
@endsection
