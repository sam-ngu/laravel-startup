@extends('public.layouts.master')

@push('after-scripts')
    <script src="{{mix('js/index.js')}}"></script>
@endpush

@section('content')

    <base-send-password-reset/>

@endsection
