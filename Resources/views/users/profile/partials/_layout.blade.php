@extends('layouts.app')

@section('content_title','HR - Persons')
@section('content_description','View Person Info')


@section('styles')
{{--    @include('hr::partials.hr-styles')--}}
    @yield('element-styles')
@endsection

@section('scripts')
    @if(is_module_enabled('hr'))
        @include('hr::partials.hr-scripts')
        <script src="{{  Module::asset('hr:js/persons.js') }}"></script>
    @endif
    
    @yield('element-scripts')
@endsection

@section('content')
    @if(is_module_enabled('hr'))
        @include('hr::partials.response')
    @endif

    <div class="row">
        <div class="sidebar-nav col-sm-3">
            @include("users::users.profile.partials._navigation")
        </div>

        <div class="col-md-9">
            <v-card>
                <v-card-title class="pb-0 mb-0">
                    <h3 class="title text-uppercase">@yield('heading')</h3>
                    <div class="ml-auto"><i class="fa fa-user"></i> {{ $user->profile->fullName }}</div>
                </v-card-title>
                
                <v-card-text>
                    <v-divider></v-divider>

                    <div class="row">
                        @yield('element')
                    </div>
                </v-card-text>
            </v-card>
        </div>
    </div>
@endsection

