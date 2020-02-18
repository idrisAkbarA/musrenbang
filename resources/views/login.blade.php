<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <style>
        .i-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 100vh;
        }
        .landing-image{

        }
    </style>
</head>

<body>
    <v-app id="app">
        <div class="i-container">
            <div class="left" style="background-image: url({{asset('img/landing.png')}}); background-size:contain">
                    <v-container fluid fill-height>
                            <v-layout align-center justify-center>
                                <v-flex xs12 sm12 md6>
                                        {{-- <img style="width:100%" src="{{ asset('img/landing.png') }}"> --}}
                                </v-flex>
                            </v-layout>
                        </v-container>

            </div>
            <div class="right" style="background-color:#3AAF4D" >
                <v-container fluid fill-height>
                    <v-layout align-center justify-center>
                        <v-flex xs12 sm12 md6>
                            <v-form lazy-validation="true">
                                <h2 class="white--text mb-4">Masuk</h2>
                                <v-text-field {{-- background-color="white" --}} color="white" label="Nama Pengguna"
                                    name="login" filled="true" prepend-inner-icon="account_box" type="text" dark
                                    required></v-text-field>
                                <v-text-field {{-- background-color="white" --}} color="white" label="Kata sandi"
                                    name="login" filled="true" prepend-inner-icon="lock" type="password" dark required
                                    :append-icon="show1 ? 'visibility_off' : 'visibility'"
                                    @click:append="show1 = !show1" :type="show1 ? 'text' : 'password'">
                                </v-text-field>
                                <a href="/">
                                    <v-btn @click="">
                                        Masuk</v-btn>
                                </a>
                                {{-- <v-btn text dark>Lupa kata sandi?</v-btn> --}}
                            </v-form>

                        </v-flex>
                    </v-layout>
                </v-container>
            </div>
        </div>
    </v-app>


    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>
