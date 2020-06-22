@extends('layouts.master')

@push('after-scripts')
    <script src="{{mix('js/app.js')}}"></script>
@endpush

@section('content')

    <AppPublic/>


@endsection
