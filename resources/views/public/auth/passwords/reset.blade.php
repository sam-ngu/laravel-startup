@extends('public.layouts.master')

@push('after-scripts')
    <script src="{{mix('js/public.js')}}"></script>
@endpush

@section('content')

<base-password-reset reset-token="{{request()->route('token')}}" />

@endsection
