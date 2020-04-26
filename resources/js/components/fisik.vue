<template>
  <v-dialog style="z-index:1001" v-model="dialogFisik" persistent max-width="700px">
    <v-card style="z-index:1001" class="overflow-hidden">
      <v-app-bar
        style="z-index:1001; background: linear-gradient(-90deg, rgb(142, 241, 108), rgb(255, 255, 255));
                                background-position:50px 0px;
                                background-repeat: no-repeat;
"
        absolute
        color="white"
        elevate-on-scroll
        scroll-target="#scrolling-techniques-7"
      >
        <v-toolbar-title>Tambah Usulan Fisik</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn text @click="batal">batal</v-btn>
        <v-btn class="primary" @click="send">Simpan</v-btn>
        <v-progress-linear :value="progressValue" buffer-value="100" absolute bottom color="green"></v-progress-linear>
      </v-app-bar>
      <v-progress-linear indeterminate color="green"></v-progress-linear>
      <v-sheet id="scrolling-techniques-7" class="overflow-y-auto pt-5" max-height="600">
        <v-container class="pl-10 pr-10 pb-10">
          <v-row id="form" dense class="mt-10">
            <v-col cols="12" class="title">Rincian Usulan</v-col>

            <v-col cols="12" sm="6" md="12">
              <v-combobox
                id="s1"
                prepend-inner-icon="account_balance"
                v-model="pod"
                outlined
                :items="pod_items"
                label="Organisasi Perangkat Daerah"
              ></v-combobox>
            </v-col>

            <v-col cols="12">
              <v-combobox
                id="s2"
                prepend-inner-icon="announcement"
                outlined
                v-model="usulan"
                :items="usulan_items"
                label="Usulan"
              ></v-combobox>
            </v-col>
            <v-col cols="6">
              <v-text-field
                id="s3"
                label="Volume"
                v-model="volume"
                prepend-inner-icon="mdi-scale-balance"
                outlined
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                id="s4"
                label="Satuan"
                v-model="satuan"
                prepend-inner-icon="linear_scale"
                outlined
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-textarea
                id="s5"
                prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                v-model="output"
                outlined
                auto-grow
                label="Output"
                rows="3"
                row-height="30"
              ></v-textarea>
            </v-col>

            <v-col cols="12">
              Foto minimal 2
              <vue-dropzone
                @vdropzone-file-added="fotoAdded"
                @vdropzone-queue-complete="photosUploaded"
                @vdropzone-complete="afterComplete"
                ref="myVueDropzone"
                id="dropzone"
                :options="dropzoneOptions"
              ></vue-dropzone>
            </v-col>
            <v-col cols="12">
              File Pendukung maksimal 2
              <vue-dropzone
                @vdropzone-file-added="fileAdded"
                @vdropzone-queue-complete="filesUploaded"
                @vdropzone-complete="afterCompleteFiles"
                ref="myVueDropzoneFiles"
                id="dropzoneFile"
                :options="dropzoneOptionsFiles"
              ></vue-dropzone>
            </v-col>
            <v-col cols="12">
              <v-textarea
                id="s8"
                prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                v-model="alasan_usulan"
                outlined
                auto-grow
                label="Alasan diusulkan"
                rows="3"
                row-height="30"
              ></v-textarea>
            </v-col>
            <v-col cols="12">
              <v-textarea
                prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                v-model="informasi_tambahan"
                outlined
                auto-grow
                label="Informasi Tambahan"
                rows="3"
                row-height="30"
              ></v-textarea>
            </v-col>
            <v-col cols="12">
              <v-divider></v-divider>
            </v-col>
            <v-col cols="12" class="title">Lokasi Usulan</v-col>
            <v-col cols="12" sm="6" md="12">
              <v-text-field
                id="s9"
                label="Jalan/alamat"
                v-model="alamat"
                prepend-inner-icon="place"
                outlined
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <v-text-field id="s10" label="RT" v-model="rt" outlined></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <v-text-field id="s11" label="RW" v-model="rw" outlined></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-autocomplete
                id="s12"
                v-model="kelurahan"
                prepend-inner-icon="map"
                outlined
                :items="kelurahan_items"
                label="Kelurahan"
              ></v-autocomplete>
            </v-col>
            <v-col cols="12">
              <v-divider></v-divider>
            </v-col>
            <v-col cols="12" class="title">Rincian Pengusul</v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field
                id="s13"
                label="Nama Pengusul"
                v-model="nama_pengusul"
                prepend-inner-icon="person"
                outlined
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field
                id="s14"
                label="No. HP Pengusul"
                v-model="hp_pengusul"
                prepend-inner-icon="phone"
                outlined
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="12">
              <v-text-field
                id="s15"
                label="Alamat Pengusul"
                v-model="alamat_pengusul"
                prepend-inner-icon="place"
                outlined
              ></v-text-field>
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
</template>
<script>
export default {
  data: {
    checkProgress: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    progressValue: 0,
    usulan: "",
    pod: "",
    volume: "",
    satuan: "",
    alamat: "",
    alasan_usulan: "",
    informasi_tambahan: "",
    output: "",
    rt: "",
    rw: "",
    nama_pengusul: "",
    hp_pengusul: "",
    alamat_pengusul: "",
    kelurahan: "",
    pod_items: [],
    usulan_items: [],
    kelurahan_items: [],
    jumlahFoto: 0,
    jumlahFile: 0
  },
  watch: {
    pod: function(val) {
      this.calcProgressValue(val, 0);
    },
    usulan: function(val) {
      this.calcProgressValue(val, 1);
    },
    volume: function(val) {
      this.calcProgressValue(val, 2);
    },
    satuan: function(val) {
      this.calcProgressValue(val, 3);
    },
    output: function(val) {
      this.calcProgressValue(val, 4);
    },
    jumlahFoto: function(val) {
      if (this.jumlahFoto > 1 || this.jumlahFoto < 1) {
        this.calcProgressValue(val, 5);
      }
    },
    jumlahFile: function(val) {
      if (this.jumlahFile > 1 || this.jumlahFile < 1) {
        this.calcProgressValue(val, 6);
      }
    },
    alasan_usulan: function(val) {
      this.calcProgressValue(val, 7);
    },
    alamat: function(val) {
      this.calcProgressValue(val, 8);
    },
    rt: function(val) {
      this.calcProgressValue(val, 9);
    },
    rw: function(val) {
      this.calcProgressValue(val, 10);
    },
    kelurahan: function(val) {
      this.calcProgressValue(val, 11);
    },
    nama_pengusul: function(val) {
      this.calcProgressValue(val, 12);
    },
    hp_pengusul: function(val) {
      this.calcProgressValue(val, 13);
    },
    alamat_pengusul: function(val) {
      this.calcProgressValue(val, 14);
    }
  }
};
</script>