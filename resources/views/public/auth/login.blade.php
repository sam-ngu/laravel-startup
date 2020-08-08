@extends('public.layouts.master')

@section('title', config('app.name') . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')
    <base-login>
        <template v-slot:socialite>
            <div class="text-center"> 
                {!! $socialiteLinks ?? ''!!}
            </div>
        </template>
    </base-login>
@endsection

@push('after-scripts')
    <script src="{{mix('js/index.js')}}"></script>
@endpush
