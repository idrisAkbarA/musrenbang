<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>

</head><link rel="icon" href="{{asset("img/logo.gif")}}">

<body>
    <div id="app">

        <v-app id="inspire">
            <v-system-bar app dark color="black">
                <v-slide-y-reverse-transition>
                    <div v-if="!fad">
                        <v-icon>messages</v-icon> 10 Usulan belum divalidasi
                    </div>
                </v-slide-y-reverse-transition>
                <v-slide-y-reverse-transition>
                    <div v-if="fad">
                         Memuat...
                    </div>
                </v-slide-y-reverse-transition>
                        
                <v-spacer></v-spacer>
                <span>12:30</span>
                <v-progress-linear :active="loading" indeterminate absolute bottom color="orange">
                </v-progress-linear>
              </v-system-bar>
            <v-navigation-drawer floating color="white" class="print" v-model="drawer" app>
                <v-card class="d-flex justify-center pt-4 pr-2 pl-2" flat tile>
                    <v-img max-width="70" src="{{asset('img/logo.gif')}}">
                    </v-img>
                        <v-card-text> E-MUSRENBANG KECAMATAN PAYUNG SEKAKI</v-card-title>
                    </v-card>
                    <v-divider></v-divider>
                    <div class="pt-2 pl-4 pr-4">
                        Selamat Datang Operator Kelurahan A
                    </div>
                <v-list tile dense>
                    <v-list-item @click="" class="@yield('dashboard')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">dashboard</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Dashboard</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="musrenbang()" class="@yield('musrenbang')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">people</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Musrenbang</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="pengumuman()" class="@yield('pengumuman')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">info</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Pengumuman</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="" class="@yield('laporan')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">description</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Laporan</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="" class="@yield('sandi')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">lock</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Ganti Kata Sandi</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="" class="@yield('tanyaJawab')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">contact_support</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Tanya Jawab</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                </v-list>
            </v-navigation-drawer>
            <bar v-model="drawer">
                @yield('bar-components')
            </bar>
            {{-- <v-app-bar class="print" app color="grey lighten-3" elevate-on-scroll dense>
                <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
                <v-toolbar-title class="grey--text text--darken-1">
                    <span class="font-weight-bold"> E-MUSRENBANG </span>
                    @yield('jurusan')
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon color="grey darken-1">
                    <v-icon>notifications</v-icon>
                </v-btn>
                <v-btn text color="grey darken-1">
                    <v-icon left>logout</v-icon><span>Keluar</span>
                </v-btn>
            </v-app-bar> --}}
            <v-content class="grey lighten-3">
                <v-slide-y-reverse-transition>
                    <div style="height:98%; padding-bottom:1em;" class="mt-2 ml-4 mr-10" v-if="!fad">
                        @yield('content')
                    </div>
                </v-slide-y-reverse-transition>
                </v-content>
        </v-app>
    </div>
    <script src="{{asset('js/app.js')}}">


    </script>
</body>

</html>
