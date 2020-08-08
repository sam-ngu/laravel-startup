@extends('public.layouts.master')

@push('after-scripts')
    <script type="application/javascript" src="{{mix('js/public.js')}}"></script>
@endpush

@section('content')


    <base-public session="{{ ($user = auth()->user()) ? json_encode(auth()->user()->toArray()) : null }}"/>


@endsection
