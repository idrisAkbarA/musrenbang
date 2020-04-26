<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{asset("img/logo.gif")}}">
    <style>
        .kelA {
            left: 10px;
            top: -18px;
            position: relative;
        }

        .belum-validasi {
            height: 70px;
            transition: .5s ease;
            border-left: 6px solid rgb(255, 114, 114);
            background: rgb(255, 114, 114);
            background: linear-gradient(-90deg, rgba(255, 114, 114, 1) 0%, rgba(255, 255, 255, 0.2777485994397759) 59%);

        }

        .validasi {
            height: 70px;
            transition: .5s ease;
            border-left: 6px solid rgb(255, 189, 114);
            background: rgb(255, 189, 114);
            background: linear-gradient(-90deg, rgba(255, 189, 114, 1) 0%, rgba(255, 255, 255, 0.2777485994397759) 59%);
        }

        .verifikasi {
            height: 70px;
            transition: .5s ease;
            border-left: 6px solid #CED2A2;
            background: rgb(206, 210, 162);
            background: linear-gradient(-90deg, rgba(206, 210, 162, 1) 0%, rgba(255, 255, 255, 0.2777485994397759) 59%);
        }

        .prioritasx {
            height: 70px;
            transition: .5s ease;
            z-index: 0;
            border-left: 6px solid rgb(142, 241, 108);
            background: rgb(142, 241, 162);
            background: linear-gradient(-90deg, rgba(142, 241, 162, 1) 0%, rgba(255, 255, 255, 0.2777485994397759) 59%);
        }

        .belum-validasi:hover {
            height: 100px;
            background: linear-gradient(-90deg, rgb(255, 114, 114), rgb(231, 231, 231));
        }

        .prioritasx:hover {
            height: 100px;
            background: linear-gradient(-90deg, rgb(142, 241, 108), rgb(231, 231, 231));
        }

        .verifikasi:hover {
            background: linear-gradient(-90deg, #CED2A2, rgb(231, 231, 231));
            height: 100px;
        }

        .validasi:hover {
            background: linear-gradient(-90deg, rgb(255, 189, 114), rgb(231, 231, 231));
            height: 100px;
        }

        .kepala th {
            padding: 1em;
        }

        .number {
            text-align: center;
        }

        .prioritas {
            border-left: 6px solid orange;
        }

        .on {
            border-left: 6px solid orange;
            z-index: 999;
        }

        .off {
            border-left: 6px solid orange;
        }

        table {
            text-align: left;
            position: relative;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 0.25rem;
        }

        tr.red th {
            background: white;
            color: black;
        }

        tr.green th {
            background: green;
            color: white;
        }

        tr.purple th {
            background: purple;
            color: white;
        }

        th {
            background: white;
            position: sticky;
            top: 0;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        }

        .editGrid {
            height: 100vh;
            padding: 5em;
            display: grid;
            grid-gap: 1.5em;
            grid-template-columns: 55% 22.5% 22.5%;
            grid-template-rows: 33.33% 33.33% 33.33%;
            grid-template-areas:
                "rincian gambar1 gambar2"
                "rincian lokasi lokasi"
                "rincian pengusul pengusul";
        }

        .headDetail {
            z-index: 100;
            left: 10px;
            top: -18px;
            position: relative;
        }

        body::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body>
    <div id="app">

        <v-app id="inspire">
            <v-dialog max-width="700px" style="z-index:1004" v-model="dialogFoto">
                <v-carousel>
                    <v-carousel-item v-for="n in 2" :key="n" :src="carousselList[n-1]"
                        reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                </v-carousel>

            </v-dialog>
            <v-overlay z-index="1002" opacity="0.6" :value="editOverlay" @click="editOverlay = false">
                <v-slide-y-reverse-transition>
                    <div v-if="editOverlay" style="width:100vw; height:100vh;" class="editGrid">
                        <div style="position: fixed; top:2em; right:2em">
                            <v-btn text @click="editOverlay = false">batal</v-btn>
                            <v-btn color="primary" @click="update()">Simpan</v-btn>
                        </div>
                        <v-hover>
                            <template v-slot="{ hover }">

                                <v-card style="grid-area: rincian; " light :elevation="hover ? 20 : 6"
                                    class="overflow-y-auto">

                                    <v-sheet style="position: sticky;" class="title ml-4 mt-2">
                                        Rincian Usulan
                                    </v-sheet>

                                    <v-container fluid>

                                        <v-row no-gutters>

                                            <v-col cols="12" sm="6" md="12">
                                                <v-combobox dense prepend-inner-icon="account_balance"
                                                    v-model="tableUsulanTemp.pod" outlined :items="pod_items"
                                                    label="Organisasi Perangkat Daerah">
                                                </v-combobox>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-combobox dense prepend-inner-icon="announcement" outlined
                                                    v-model="tableUsulanTemp.usulan" :items="usulan_items"
                                                    label="Usulan"></v-combobox>
                                            </v-col>
                                            <v-col cols="6">

                                                <v-text-field dense Label="Volume" class="mr-1"
                                                    v-model="tableUsulanTemp.volume"
                                                    prepend-inner-icon="mdi-scale-balance" outlined></v-text-field>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-text-field dense Label="Satuan" class="ml-1"
                                                    v-model="tableUsulanTemp.satuan" prepend-inner-icon="linear_scale"
                                                    outlined></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-textarea dense
                                                    prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                                    v-model="tableUsulanTemp.output" outlined auto-grow label="Output"
                                                    rows="3" row-height="30">
                                                </v-textarea>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-textarea dense
                                                    prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                                    v-model="tableUsulanTemp.alasan_usulan" outlined auto-grow
                                                    label="Alasan diusulkan" rows="3" row-height="30"></v-textarea>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-textarea dense
                                                    prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                                    v-model="tableUsulanTemp.informasi_tambahan" outlined auto-grow
                                                    label="Informasi Tambahan" rows="3" row-height="30"></v-textarea>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-btn @click="downloadFilePendukung(1)" class="ma-2" tile outlined
                                                    color="success">
                                                    <v-icon left>cloud_download</v-icon> File Pendukung 1
                                                </v-btn>
                                                <v-btn @click="downloadFilePendukung(2)" class="ma-2" tile outlined
                                                    color="success">
                                                    <v-icon left>cloud_download</v-icon> File Pendukung 2
                                                </v-btn>
                                            </v-col>



                                        </v-row>


                                    </v-container>
                                </v-card>

                            </template>
                        </v-hover>
                        <v-hover>
                            <template v-slot="{ hover }">
                                <v-card @click="caroussel(0)" width="100%" ripple light :elevation="hover ? 20 : 6"
                                    style="grid-area: gambar1">
                                    <v-img aspect-ratio :src="foto1()"></v-img>
                                </v-card>
                            </template>
                        </v-hover>
                        <v-hover>
                            <template v-slot="{ hover }">
                                <v-card @click="caroussel(1)" width="100%" ripple light :elevation="hover ? 20 : 6"
                                    style="grid-area: gambar2">
                                    <v-img :src="foto2()"></v-img>
                                </v-card>
                            </template>
                        </v-hover>
                        <v-hover>
                            <template v-slot="{ hover }">
                                <v-card light :elevation="hover ? 20 : 6" class="overflow-y-hidden"
                                    style="grid-area: lokasi">
                                    <v-sheet class="title ml-4 mt-2">
                                        Lokasi
                                    </v-sheet>
                                    <v-container>
                                        <v-row no-gutters>
                                            <v-col cols="12">
                                                <v-text-field dense Label="Jalan/alamat"
                                                    v-model="tableUsulanTemp.alamat" prepend-inner-icon="place"
                                                    outlined></v-text-field>
                                            </v-col>
                                            <v-col cols="3">
                                                <v-text-field dense class="mr-1" Label="RT" v-model="tableUsulanTemp.rt"
                                                    outlined>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="3">
                                                <v-text-field dense Label="RW" v-model="tableUsulanTemp.rw" outlined>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-autocomplete dense class="ml-1" v-model="tableUsulanTemp.kelurahan"
                                                    prepend-inner-icon="map" outlined :items="kelurahan_items"
                                                    label="Kelurahan">
                                                </v-autocomplete>
                                            </v-col>
                                        </v-row>
                                    </v-container>

                                </v-card>
                            </template>
                        </v-hover>
                        <v-hover>
                            <template v-slot="{ hover }">
                                <v-card class="overflow-y-hidden" light :elevation="hover ? 20 : 6"
                                    style="grid-area: pengusul">
                                    <v-sheet class="title ml-4 mt-2">
                                        Rincian Pengusul
                                    </v-sheet>
                                    <v-container>
                                        <v-row no-gutters>
                                            <v-col cols="12" sm="6" md="6">
                                                <v-text-field dense class="mr-1" Label="Nama Pengusul"
                                                    v-model="tableUsulanTemp.nama_pengusul" prepend-inner-icon="person"
                                                    outlined>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="6">
                                                <v-text-field dense class="ml-1" Label="No. HP Pengusul"
                                                    v-model="tableUsulanTemp.hp_pengusul" prepend-inner-icon="phone"
                                                    outlined>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="12">
                                                <v-text-field dense Label="Alamat Pengusul"
                                                    v-model="tableUsulanTemp.alamat_pengusul" prepend-inner-icon="place"
                                                    outlined></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card>
                            </template>
                        </v-hover>
                    </div>
                </v-slide-y-reverse-transition>
            </v-overlay>
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
            <v-navigation-drawer floating color="white" class="print" v-model="drawer" style="z-index:1001;" app>
                <v-card class="d-flex justify-center pt-4 pr-2 pl-2" flat tile>
                    <v-img max-width="70" src="{{asset('img/logo.gif')}}">
                    </v-img>
                    <v-card-text> E-MUSRENBANG KECAMATAN PAYUNG SEKAKI</v-card-title>
                </v-card>
                <v-divider></v-divider>
                <div class="pt-2 pl-4 pr-4">
                    Selamat Datang Operator Kelurahan {{$userInfo['kelurahan']}}
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
                <div class="text-center" style="z-index:100">
                    <v-menu :close-on-content-click="false" offset-y :nudge-right="200">
                        <template v-slot:activator="{ on }">
                            <v-btn class="ml-2 mr-2" small icon color="indigo" dark v-on="on">
                                <v-icon>
                                    search
                                </v-icon>
                            </v-btn>
                        </template>

                        <v-card width="100vw">
                            <v-container>
                                <v-row class="ml-2 mr-2" dense>
                                    <v-col cols="12">
                                        <div class="title d-flex">
                                            Pencarian/Filter
                                            <v-spacer></v-spacer>
                                            <v-btn @click="filterReset()" small text>
                                                <v-icon left>
                                                    close
                                                </v-icon>
                                                Reset
                                            </v-btn>
                                            <v-btn @click="filterTest()" small class="primary" dark>
                                                <v-icon left>
                                                    search
                                                </v-icon>
                                                Cari
                                            </v-btn>
                                        </div>


                                    </v-col>
                                    <v-col cols="12" sm="6" md="2">
                                        <v-autocomplete dense v-model="filter.tahun" prepend-inner-icon="event" outlined
                                            :items="tahunItems()" label="Tahun">
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-combobox dense prepend-inner-icon="announcement" outlined
                                            v-model="filter.usulan" :items="usulan_items" label="Usulan"></v-combobox>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-combobox dense prepend-inner-icon="account_balance" v-model="filter.pod"
                                            outlined :items="pod_items" label="Organisasi Perangkat Daerah">
                                        </v-combobox>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-text-field v-model="filter.alamat" outlined dense prepend-inner-icon="place"
                                            label="Alamat">
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-autocomplete dense v-model="filter.kelurahan" prepend-inner-icon="map"
                                            outlined :items="kelurahan_items" label="kelurahan">
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-autocomplete dense v-model="filter.verifikasi" prepend-inner-icon="done"
                                            outlined :items="['-','Tidak','Iya']" label="Verifikasi">
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-autocomplete dense v-model="filter.validasi" prepend-inner-icon="done_all"
                                            outlined :items="['-','Tidak','Iya']" label="Validasi">
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-autocomplete dense v-model="filter.prioritas"
                                            prepend-inner-icon="library_add_check" outlined :items="['-','Tidak','Iya']"
                                            label="Prioritas">
                                        </v-autocomplete>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                    </v-menu>
                </div>
                <div style="z-index:100" class="text-center">
                    <v-menu open-on-hover offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn small color="primary" dark v-on="on">
                                <v-icon left>
                                    add
                                </v-icon>
                                Tambah Usulan
                            </v-btn>
                        </template>

                        <v-list>
                            <v-list-item style="z-index:9999" @click.stop="initUsulFisik()">
                                <v-list-item-title> Fisik</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click.stop="dialogNonFisik = true;">
                                <v-list-item-title>Non Fisik</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
                <v-btn class="ml-2 mr-2" small icon color="grey darken-1">
                    <v-icon>notifications</v-icon>
                </v-btn>
                <v-btn text color="grey darken-1">
                    <v-icon left>logout</v-icon><span>Keluar</span>
                </v-btn>
                {{-- <v-progress-linear :active="loading" indeterminate absolute bottom color="white accent-4">
                </v-progress-linear> --}}
            </v-app-bar>
            <v-content fluid class="grey lighten-3">
                <v-slide-y-reverse-transition group></v-slide-y-reverse-transition>
                <div>
                    <v-container fluid v-if="!fad">
                        <v-sheet class="overflow-y-auto" color="white" height="76vh" elevation="10">

                            <v-skeleton-loader type="table" class="mx-auto" :loading="overlayTable"
                                transition="fade-transition">

                                <table>
                                    <thead>
                                        <tr class="red kepala" style="z-index:1000">
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Kelompok</th>
                                            <th>Volume</th>
                                            <th>Kelurahan</th>
                                            <th style="width:200px">Organisasi Perangkat Daerah</th>
                                            <th style="z-index:10">Verifikasi</th>
                                            <th style="z-index:10">Validasi</th>
                                            <th style="z-index:10">Prioritas</th>
                                            <th style="z-index:10">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr :class="styling(index)" v-for="(item, index) in tableUsulan" :key="item.id">
                                            <td class="number">@{{index+rawData.from}}</td>
                                            <td>@{{item.usulan}}</td>
                                            <td>Fisik</td>
                                            <td>@{{item.volume}}</td>
                                            <td>Air Hitam</td>
                                            <td>@{{item.pod}}</td>

                                            <td>
                                                <v-btn :loading="loader_verif(index)" @click="verifikasi(index)" text>
                                                    @{{item.verifikasi}}
                                                </v-btn>
                                            </td>
                                            <td>
                                                <v-btn :loading="loader_valid(index)" @click="validasi(index)" text>
                                                    @{{item.validasi}}
                                                </v-btn>
                                            </td>
                                            <td>
                                                <v-btn :loading="loader_prioritas(index)" @click="prioritas(index)"
                                                    text>
                                                    @{{item.prioritas}}
                                                </v-btn>
                                            </td>
                                            <td style="width:100px">
                                                <v-btn icon @click="edit(index)">
                                                    <v-icon>
                                                        edit
                                                    </v-icon>
                                                </v-btn>
                                                <v-btn icon @click="deleteUsulan(index)">
                                                    <v-icon>
                                                        delete
                                                    </v-icon>
                                                </v-btn>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-skeleton-loader>

                        </v-sheet>
                        <div style=" z-index:1000;">
                            <v-row>
                                <v-col cols="12">
                                    <v-hover>
                                        <template v-slot="{ hover }">
                                            <v-card width="490" class="d-flex" :elevation="hover ? 17 : 6">
                                                <v-menu top>
                                                    <template v-slot:activator="{ on }">
                                                        <v-card-text style="cursor: pointer;" v-on="on">
                                                            <div style="width:200px">
                                                                Baris per halaman: @{{barisPerHalaman}} <v-icon>
                                                                    arrow_drop_down</v-icon>
                                                            </div>
                                                        </v-card-text>
                                                    </template>

                                                    <v-list>
                                                        <v-list-item @click="barisTiapHalaman(5)">
                                                            <v-list-item-title>5</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="barisTiapHalaman(15)">
                                                            <v-list-item-title>15</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="barisTiapHalaman('semua')">
                                                            <v-list-item-title>semua</v-list-item-title>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>

                                                <v-divider vertical></v-divider>
                                                <v-card-text> @{{rawData.from}} - @{{rawData.to}} dari
                                                    @{{rawData.total}}</v-card-text>
                                                <v-btn :disabled="isPrevDisabled()" @click="previousPage()" class="mt-2"
                                                    icon>
                                                    <v-icon>keyboard_arrow_left</v-icon>
                                                </v-btn>
                                                <v-btn :disabled="isNextDisabled()" @click="nextPage()"
                                                    class="mt-2 mr-2" icon>
                                                    <v-icon>keyboard_arrow_right</v-icon>
                                                </v-btn>
                                            </v-card>
                                        </template>
                                    </v-hover>
                                </v-col>
                            </v-row>
                        </div>
                    </v-container>
                </div>
                <v-dialog width="400" v-model="dialogDelete">
                    <v-card>
                        <v-card-title class=" error">
                            <v-icon color="white">
                                delete
                            </v-icon>
                            <span class="white--text">
                                Hapus Usulan
                            </span>
                        </v-card-title>
                        <v-card-text class="mt-2">
                            Apakah anda yakin ingin menghapus usulan?
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="dialogDelete = false">
                                Batal
                            </v-btn>
                            <v-btn dark class="error" @click="deleteUsulanConfirmed">
                                <v-icon left> delete</v-icon>
                                Hapus
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog style="z-index:1001" v-model="dialogNonFisik" persistent max-width="700px">
                    <v-card style="z-index:1001" class="overflow-hidden">
                        <v-app-bar style="z-index:1001; background: linear-gradient(-90deg, rgb(142, 241, 108), rgb(255, 255, 255));
                                background-position:50px 0px;
                                background-repeat: no-repeat;
" absolute color="white" elevate-on-scroll scroll-target="#scrolling-techniques-8">


                            <v-toolbar-title>Tambah Usulan Non Fisik </v-toolbar-title>

                            <v-spacer></v-spacer>

                            <v-btn text @click="batalNonFisik">
                                batal
                            </v-btn>

                            <v-btn class="primary" @click="send">
                                Simpan
                            </v-btn>
                            <v-progress-linear :value="progressValueNonFisik" buffer-value="100" absolute bottom
                                color="green">
                            </v-progress-linear>
                        </v-app-bar>
                        <v-progress-linear indeterminate color="green"></v-progress-linear>

                        <v-sheet id="scrolling-techniques-7" class="overflow-y-auto pt-5" max-height="600">
                            <v-container class="pl-10 pr-10 pb-10">
                                <v-row id="form" dense class="mt-10">
                                    <v-col cols="12" class="title">
                                        Rincian Usulan
                                    </v-col>

                                    <v-col cols="12" sm="6" md="12">
                                        <v-combobox id="s1" prepend-inner-icon="account_balance" v-model="podNonFisik"
                                            outlined :items="pod_items" label="Organisasi Perangkat Daerah">
                                        </v-combobox>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-text-field id="s2" prepend-inner-icon="announcement" outlined
                                            v-model="usulanNonFisik" label="Usulan"></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea id="s5"
                                            prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                            v-model="outputNonFisik" outlined auto-grow label="Output" rows="3"
                                            row-height="30">
                                        </v-textarea>
                                    </v-col>
                                    <v-col cols="12">
                                        File Pendukung maksimal 2
                                        <vue-dropzone id="s7" @vdropzone-file-added="fileAdded"
                                            @vdropzone-queue-complete="filesUploaded"
                                            @vdropzone-complete="afterCompleteFiles" ref="myVueDropzoneFiles"
                                            id="dropzoneFile" :options="dropzoneOptionsFiles"></vue-dropzone>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea id="s8"
                                            prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                            v-model="alasan_usulanNonFisik" outlined auto-grow label="Alasan diusulkan"
                                            rows="3" row-height="30"></v-textarea>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                            v-model="informasi_tambahanNonFisik" outlined auto-grow
                                            label="Informasi Tambahan" rows="3" row-height="30"></v-textarea>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-divider> </v-divider>
                                    </v-col>

                                    <v-col cols="12" class="title">
                                        Rincian Pengusul
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field id="s13" Label="Nama Pengusul" v-model="nama_pengusulNonFisik"
                                            prepend-inner-icon="person" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field id="s14" Label="No. HP Pengusul" v-model="hp_pengusulNonFisik"
                                            prepend-inner-icon="phone" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="12">
                                        <v-text-field id="s15" Label="Alamat Pengusul" v-model="alamat_pengusulNonFisik"
                                            prepend-inner-icon="place" outlined></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                            <v-overlay :value="overlay">
                                <div style="width:500px" class="d-flex justify-center">
                                    <v-progress-circular indeterminate size="64"></v-progress-circular>

                                </div>
                                <div style="width:500px" class="d-flex justify-center">

                                    <p class="subtitle-1 mt-2">@{{loadingText}}</p>
                                </div>
                            </v-overlay>
                        </v-sheet>
                    </v-card>
                </v-dialog>

                <v-dialog style="z-index:1001" v-model="dialogFisik" persistent max-width="700px">
                    <v-card style="z-index:1001" class="overflow-hidden">
                        <v-app-bar style="z-index:1001; background: linear-gradient(-90deg, rgb(142, 241, 108), rgb(255, 255, 255));
                                background-position:50px 0px;
                                background-repeat: no-repeat;
" absolute color="white" elevate-on-scroll scroll-target="#scrolling-techniques-7">


                            <v-toolbar-title>Tambah Usulan Fisik </v-toolbar-title>

                            <v-spacer></v-spacer>

                            <v-btn text @click="batal">
                                batal
                            </v-btn>

                            <v-btn class="primary" @click="send">
                                Simpan
                            </v-btn>
                            <v-progress-linear :value="progressValue" buffer-value="100" absolute bottom color="green">
                            </v-progress-linear>
                        </v-app-bar>
                        <v-progress-linear indeterminate color="green"></v-progress-linear>

                        <v-sheet id="scrolling-techniques-7" class="overflow-y-auto pt-5" max-height="600">
                            <v-container class="pl-10 pr-10 pb-10">
                                <v-row id="form" dense class="mt-10">
                                    <v-col cols="12" class="title">
                                        Rincian Usulan
                                    </v-col>

                                    <v-col cols="12" sm="6" md="12">
                                        <v-combobox id="s1" prepend-inner-icon="account_balance" v-model="pod" outlined
                                            :items="pod_items" label="Organisasi Perangkat Daerah"></v-combobox>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-combobox id="s2" prepend-inner-icon="announcement" outlined v-model="usulan"
                                            :items="usulan_items" label="Usulan"></v-combobox>
                                    </v-col>
                                    <v-col cols="6">

                                        <v-text-field id="s3" Label="Volume" v-model="volume"
                                            prepend-inner-icon="mdi-scale-balance" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-text-field id="s4" Label="Satuan" v-model="satuan"
                                            prepend-inner-icon="linear_scale" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea id="s5"
                                            prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                            v-model="output" outlined auto-grow label="Output" rows="3" row-height="30">
                                        </v-textarea>
                                    </v-col>

                                    <v-col cols="12">
                                        Foto minimal 2
                                        <vue-dropzone id="s6" @vdropzone-file-added="fotoAdded"
                                            @vdropzone-queue-complete="photosUploaded"
                                            @vdropzone-complete="afterComplete" ref="myVueDropzone" id="dropzone"
                                            :options="dropzoneOptions"></vue-dropzone>
                                    </v-col>
                                    <v-col cols="12">
                                        File Pendukung maksimal 2
                                        <vue-dropzone id="s7" @vdropzone-file-added="fileAdded"
                                            @vdropzone-queue-complete="filesUploaded"
                                            @vdropzone-complete="afterCompleteFiles" ref="myVueDropzoneFiles"
                                            id="dropzoneFile" :options="dropzoneOptionsFiles"></vue-dropzone>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea id="s8"
                                            prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                            v-model="alasan_usulan" outlined auto-grow label="Alasan diusulkan" rows="3"
                                            row-height="30"></v-textarea>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                                            v-model="informasi_tambahan" outlined auto-grow label="Informasi Tambahan"
                                            rows="3" row-height="30"></v-textarea>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-divider> </v-divider>
                                    </v-col>
                                    <v-col cols="12" class="title">
                                        Lokasi Usulan
                                    </v-col>
                                    <v-col cols="12" sm="6" md="12">
                                        <v-text-field id="s9" Label="Jalan/alamat" v-model="alamat"
                                            prepend-inner-icon="place" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-text-field id="s10" Label="RT" v-model="rt" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-text-field id="s11" Label="RW" v-model="rw" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-autocomplete id="s12" v-model="kelurahan" prepend-inner-icon="map" outlined
                                            :items="kelurahan_items" label="Kelurahan">
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col cols="12">

                                        <v-divider> </v-divider>
                                    </v-col>
                                    <v-col cols="12" class="title">
                                        Rincian Pengusul
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field id="s13" Label="Nama Pengusul" v-model="nama_pengusul"
                                            prepend-inner-icon="person" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field id="s14" Label="No. HP Pengusul" v-model="hp_pengusul"
                                            prepend-inner-icon="phone" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="12">
                                        <v-text-field id="s15" Label="Alamat Pengusul" v-model="alamat_pengusul"
                                            prepend-inner-icon="place" outlined></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                            <v-overlay :value="overlay">
                                <div style="width:500px" class="d-flex justify-center">
                                    <v-progress-circular indeterminate size="64"></v-progress-circular>

                                </div>
                                <div style="width:500px" class="d-flex justify-center">

                                    <p class="subtitle-1 mt-2">@{{loadingText}}</p>
                                </div>
                            </v-overlay>
                        </v-sheet>
                    </v-card>
                </v-dialog>
                </v-slide-y-reverse-transition>
            </v-content>
            <v-snackbar v-model="snackbar" :color="snackbarColor" dark multi-line>
                @{{ snackbarText }}
                <v-btn color="white" text @click="snackbar = false">
                    Tutup
                </v-btn>
            </v-snackbar>
        </v-app>
    </div>
    <script src="{{asset('js/app.js')}}">


    </script>
</body>

</html>