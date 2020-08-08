@extends('public.layouts.master')

@push('after-scripts')
    <script src="{{mix('js/index.js')}}"></script>
@endpush

@section('content')


    <base-public session="{{ ($user = auth()->user()) ? json_encode(auth()->user()->toArray()) : null }}"/>


@endsection
