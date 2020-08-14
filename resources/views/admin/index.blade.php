@extends('admin.layouts.master')

@push('after-scripts')
    <script src="{{mix('js/admin.js')}}"></script>
@endpush

@section('content')

    <base-admin/>
@endsection
