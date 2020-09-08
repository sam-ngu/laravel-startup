@extends('public.layouts.master')

@section('title', config('app.name') . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')

    <base-registration
        enable-captcha="{{filter_var(config('access.captcha.registration'), FILTER_VALIDATE_BOOLEAN)}}"
        captcha-key="{{config('no-captcha.sitekey')}}">

        <template v-slot:socialite>
            {!! $socialiteLinks ?? '' !!}
        </template>
    </base-registration>

@endsection

@push('after-scripts')
    <script src="{{mix('js/public.js')}}"></script>
    @if(config('access.captcha.registration'))
        {!! no_captcha('v2')->script('vueRecaptchaApiLoaded') !!}
    @endif
@endpush
