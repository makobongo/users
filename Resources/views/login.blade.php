@extends('layouts.auth')

@section('title')
    Login | @parent
@stop

@section('content')
    <v-container fluid class="pa-0" v-cloak>
        <v-layout wrap row>
            <v-flex xs12 md5>
                <div class="full-height mx-4 px-5 mt-5" dark>
                    <img class="logo-large" src="{{ asset(str_replace('public', '', mconfig('settings.config.logo'))) }}" alt="logo">
                    <form class="login-form" method="POST" action="{{ route('public.login.post') }}" autocomplete="off">
                        @csrf

                        @if(request('deactivation'))
                            <v-alert class="mb-5" outline color="error" icon="{{ count($errors) > 0 ? 'error' : 'info' }}" :value="true">
                                Your account is deactivated. Get in touch with the Administrator.
                            </v-alert>
                        @endif

                        @if($errors->has('customs_error'))
                            <v-alert class="mb-5" outline type="error" :value="true">
                                {{ $errors->first('customs_error') }}
                            </v-alert>
                        @endif


                        <v-alert class="mb-5" outline color="{{ count($errors) > 0 ? 'error' : 'info' }}"
                                 icon="{{ count($errors) > 0 ? 'error' : 'info' }}" :value="true">
                            @if(count($errors) > 0)
                                Invalid login credentials
                            @else
                                Please enter your credentials to proceed
                            @endif
                        </v-alert>

                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-text-field label="Username" name="username" outline value=""></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field name="password" type="password" label="Password" outline value=""></v-text-field>
                            </v-flex>

                            <v-flex xs6 pt2>
                                <a href="#" class="caption">Forgot Password?</a>
                            </v-flex>

                            <v-flex xs6 class="text-xs-right">
                                <v-btn round type="submit" class="light-blue darken-1 white--text">Log In</v-btn>
                            </v-flex>
                        </v-layout>
                    </form>

                    <div class="disclaimer">
                        <p class="body-2 fw900">Collabmed Solutions</p>
                        <p class="caption">Copyright , All rights reserved</p>
                    </div>
                </div>
            </v-flex>

            @include('partials.facility-splash')
        </v-layout>
    </v-container>
    
    {{-- clear localStorage --}}
    <users-passport-customs-clear></users-passport-customs-clear>
    
@stop
