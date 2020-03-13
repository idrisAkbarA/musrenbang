<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        .kelA {
            left: 10px;
            top: -18px;
            position: relative;
        }

        .prioritas {
            border-left: 6px solid orange;
        }
        .on{
            border-left: 6px solid orange;
            z-index:999;
        }
        .off{
            border-left: 6px solid orange;
        }

    </style>
</head>

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
            <v-navigation-drawer color="white" class="print" v-model="drawer" style="z-index:1001;" app>
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
                    <v-list-item @click="musrenbang()" class="green lighten-5">
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

            <v-app-bar class="print" app color="grey lighten-3" elevate-on-scroll dense>
                <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
                <v-toolbar-title class="grey--text text--darken-1">
                    <span class="font-weight-bold"> E-MUSRENBANG </span>
                    @yield('jurusan')
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn small class="mr-2 ml-2" color="primary" v-if="!fad">Tambah Usulan Fisik</v-btn>
                <v-btn small color="primary" v-if="!fad">Tambah Usulan Non Fisik</v-btn>
                <v-btn icon color="grey darken-1">
                    <v-icon>notifications</v-icon>
                </v-btn>
                <v-btn text color="grey darken-1">
                    <v-icon left>logout</v-icon><span>Keluar</span>
                </v-btn>
                {{-- <v-progress-linear :active="loading" indeterminate absolute bottom color="white accent-4">
                </v-progress-linear> --}}
            </v-app-bar>
            <v-content fluid class="grey lighten-3">
                <v-slide-y-reverse-transition>
                    <div >
                        <v-container fluid class="mt-2 " v-if="!fad">
                            <v-card class="overflow-hidden" flat outlined >

                                {{-- kepala tabel --}}
                                <v-system-bar></v-system-bar>
                                <v-app-bar absolute style="z-index:1000" color="white"
                                    scroll-target="#scrolling-techniques">
                                    
                                    <v-row>
                                        <v-col cols="8">
                                            <v-card flat style="background-color: transparent">
                                                <v-row>
                                                    
                                                    <v-col cols="1">
                                                        <p class="caption">
                                                            No.
                                                        </p>
                                                    </v-col>
                                                    <v-divider></v-divider>
                                                    <v-col cols="3">
                                                        <p class="caption">
                                                            Nama
                                                        </p>
                                                    </v-col>
                                                    <v-col cols="2">
                                                        <p class="caption">
                                                            Kelompok
                                                        </p>
                                                    </v-col>
                                                    <v-col cols="2">
                                                        <p class="caption">
                                                            Volume
                                                        </p>
                                                    </v-col>
                                                    <v-col cols="2">
                                                        <p class="caption">
                                                            Kelurahan
                                                        </p>
                                                    </v-col>
                                                    <v-col cols="2">
                                                        <p class="caption">
                                                            Organisasi Perangkat Daereah
                                                        </p>
                                                    </v-col>
                                                </v-row>
                                            </v-card>
                                        </v-col>
                                       
                                    </v-row>
                                </v-app-bar>
                                <v-sheet id="scrolling-techniques" class="overflow-y-auto" color="grey lighten-3" max-height="600">
                                    <v-container  class="mt-7" color="grey lighten-3">
                                        {{-- baris tabel --}}
                                        <v-row class=""  v-for="index in 20" :key="index">
                                            <v-col cols="12" style="padding-bottom:0; padding-top:0;">
                                                <v-hover open-delay="50" close-delay="200">
                                                    <template v-slot="{ hover }">
                                                        <v-card :style="hover ? on : off" outlined max-height="50" :elevation="hover ? 17 : 0" dense>
                                                            <v-row >
                                                                <v-col cols="3">
                                                                    <v-card-text style="margin-top:-15px">test</v-card-text>
                                                                </v-col>
                                                                <v-col cols="3">
                                                                    <v-card-text style="margin-top:-15px">test</v-card-text>
                                                                </v-col>
                                                                <v-col cols="3">
                                                                    <v-card-text style="margin-top:-15px">test</v-card-text>
                                                                </v-col>
                                                            </v-row>
                                                        </v-card>
                                                    </template>
                                                </v-hover>
                                            </v-col>
                                        </v-row>
                                        <div style="height:30px">

                                        </div>
                                    </v-container>
                                </v-sheet>
                                  {{-- // tombol halaman dibawah --}}
                            <div style="bottom:0; position:fixed; z-index:1000;">
                                <v-row>
                                    <v-col cols="12">
                                        <v-hover>
                                            <template v-slot="{ hover }">
                                                <v-card width="400" class="d-flex" :elevation="hover ? 17 : 6">
                                                    <v-card-text>
                                                        baris per halaman 5
                                                    </v-card-text>
                                                    <v-divider vertical></v-divider>
                                                    <v-card-text> 1 - 5 dari 10</v-card-text>
                                                    
                                                        <v-btn class="mt-2" icon>
                                                            <v-icon>keyboard_arrow_left</v-icon>
                                                        </v-btn>
                                                        <v-btn class="mt-2 mr-2" icon>
                                                            <v-icon>keyboard_arrow_right</v-icon>
                                                        </v-btn>
                                                    
                                                </v-card>
                                            </template>
                                        </v-hover>
                                    </v-col>
                                </v-row>
                            </div>
                            </v-card>

                            </v-row>
                          
                        </v-container>
                    </div>
                </v-slide-y-reverse-transition>
            </v-content>
        </v-app>
    </div>
    <script src="{{asset('js/app.js')}}">


    </script>
</body>

</html>
