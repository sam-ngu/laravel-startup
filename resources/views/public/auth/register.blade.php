@extends('layouts.master')

@section('title', config('app.name') . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')

    <base-registration
        enable-captcha="{{filter_var(config('access.captcha.registration'), FILTER_VALIDATE_BOOLEAN)}}"
        captcha-key="{{config('no-captcha.sitekey')}}">

        <div slot="socialite" class="row">
            <div class="col">
                <div class="text-center">
                    {!! $socialiteLinks ?? '' !!}
                </div>
            </div><!--/ .col -->
        </div><!-- / .row -->
    </base-registration>

@endsection

@push('after-scripts')
    <script src="{{mix('js/index.js')}}"></script>
    @if(config('access.captcha.registration'))
        {!! Captcha::script('vueRecaptchaApiLoaded') !!}
    @endif
@endpush
