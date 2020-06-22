@extends('layouts.master')

@section('title', config('app.name') . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')
    <base-login>
        <template v-slot:socialite>
            <div class="row">
                <div class="col">
                    <div class="text-center"> 
                        {!! $socialiteLinks ?? ''!!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </template>
    </base-login>
@endsection

@push('after-scripts')
    <script src="{{mix('js/index.js')}}"></script>
@endpush
