<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>

<link rel="icon" href="{{asset("img/logo.gif")}}">

<body style="font-size:0.8em !important">
    <div id="app">

        <v-app id="inspire" >
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
                    
                    @if (Session::get('user') == "Administrator")
                        Selamat Datang Administrator
                    @else
                        Selamat Datang Operator Kelurahan {{ucfirst(Session::get('user'))}}
                    @endif
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
                    @if (Session::get('user') == "Administrator")
                    <v-list-item @click="musrenbang_admin()" class="@yield('musrenbang')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">people</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Musrenbang</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    @else
                    <v-list-item @click="musrenbang()" class="@yield('musrenbang')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">people</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Musrenbang</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    @endif
                    
                    <v-list-item @click="pengumuman()" class="@yield('pengumuman')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">info</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Pengumuman</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    @if (Session::get('user') == "Administrator")
                    <v-list-item @click="opd" class="@yield('opd')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">account_balance</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Daftar Item OPD</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="usulan_page" class="@yield('usulan')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">announcement</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Daftar Item Usulan</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="kelurahan_page" class="@yield('kelurahan')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">map</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Kelurahan</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    @endif
                    

                    <v-list-item @click="" class="@yield('laporan')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">description</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Laporan</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <change-pass>
                         <template v-slot:activator="{ open }">
                            <v-list-item @click="open" class="@yield('sandi')">
                                <v-list-item-action>
                                    <v-icon color="grey darken-1">lock</v-icon>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title class="">Ganti Kata Sandi</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                         </template>
                    </change-pass>
                    
                    {{-- <v-list-item @click="" class="@yield('tanyaJawab')">
                        <v-list-item-action>
                            <v-icon color="grey darken-1">contact_support</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="">Tanya Jawab</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item> --}}

                </v-list>
            </v-navigation-drawer>
            <bar v-model="drawer">
                @yield('bar-components')
            </bar>
            <v-content class="grey lighten-3">
                <v-slide-y-reverse-transition>
                    <div style="height:98%; padding-bottom:1em;" class="mt-2 ml-4 mr-10" v-if="!fad">
                        @yield('content')
                    </div>
                </v-slide-y-reverse-transition>
            </v-content>
        </v-app>
    </div>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"
    type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"
    type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"
    type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css"
    href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <script src="{{asset('js/app.js')}}">
    </script>
</body>

</html>