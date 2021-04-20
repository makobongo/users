@extends('layouts.auth')

@section('title')
    Login | @parent
@stop

@section('content')
    <v-container fluid class="pa-0">
        <v-layout wrap row>
            <v-flex xs12 md5>
                <div class="full-height mx-4 px-5 mt-5" dark>
                    <img class="logo-large" src="{{ asset(str_replace('public', '', mconfig('settings.config.logo'))) }}" alt="logo">
                    <form class="login-form-splash" method="POST">
                        @csrf

                        <v-layout row wrap>
                            <v-flex xs12>
                                <div class="pb-3">
                                    <p class="body-2">Welcome back {{ doe()->profile->full_name }}</p>
                                </div>
                            </v-flex>

                            <v-flex xs12>
                                <v-card>
                                    <v-list two-line subheader @click="">
                                        <v-subheader inset>Please choose a facility to proceed.</v-subheader>

                                        @foreach($clinics as $clinic)
                                            <a href="{{ route("public.clinic.post", ["clinic_id" => $clinic->id]) }}" class="clean">
                                                <v-list-tile avatar>
                                                    <v-list-tile-avatar>
                                                        <v-icon medium class="blue lighten-1 white--text med-center">local_hospital</v-icon>
                                                    </v-list-tile-avatar>
                                                    <v-list-tile-content>
                                                        <v-list-tile-title>{{ $clinic->name }}</v-list-tile-title>
                                                        <v-list-tile-sub-title>{{ $clinic->town }}</v-list-tile-sub-title>
                                                    </v-list-tile-content>
                                                </v-list-tile>
                                            </a>

                                            @if($loop->iteration < count(user_clinics()) )
                                                <v-divider></v-divider>
                                            @endif
                                        @endforeach
                                    </v-list>
                                </v-card>
                            </v-flex>

                            <v-flex xs12>
                                <div class="pt-5 text-xs-right">
                                    <a href="{{ route('public.logout') }}" class="body-1">Or sign in as a different user</a>
                                </div>
                            </v-flex>
                        </v-layout>
                    </form>

                    <div class="disclaimer">
                        <p class="body-2 fw900"><a href="https://collabmed.com">Collabmed Solutions</a></p>
                        <p class="caption">Copyright , All rights reserved</p>
                    </div>
                </div>
            </v-flex>

            @include('partials.facility-splash')
        </v-layout>
    </v-container>
@stop

