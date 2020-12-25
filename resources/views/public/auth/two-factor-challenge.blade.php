@extends('public.layouts.master')

@section('title', config('app.name') . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')
    <base-two-factor-challenge/>
@endsection

@push('after-scripts')
    <script src="{{mix('js/public.js')}}"></script>
@endpush
