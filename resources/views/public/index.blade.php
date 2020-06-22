@extends('layouts.master')

@push('after-scripts')
    <script src="{{mix('js/index.js')}}"></script>
@endpush

@section('content')


    <app-public session="{{ ($user = auth()->user()) ? json_encode(auth()->user()->toArray()) : null }}"/>


@endsection
