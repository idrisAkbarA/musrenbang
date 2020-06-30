<template>
  <div>
    <v-dialog
      style="z-index:1001"
      v-model="dialogFisik"
      persistent
      max-width="700px"
    >

      <v-card
        style="z-index:1001"
        class="overflow-hidden"
      >
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
          <v-btn
            text
            @click="batal"
          >batal</v-btn>
          <v-btn
            class="primary"
            @click="send"
          >Simpan</v-btn>
          <v-progress-linear
            :value="progressValue"
            buffer-value="100"
            absolute
            bottom
            color="green"
          ></v-progress-linear>
        </v-app-bar>
        <v-progress-linear
          indeterminate
          color="green"
        ></v-progress-linear>
        <v-sheet
          id="scrolling-techniques-7"
          class="overflow-y-auto pt-5"
          max-height="600"
        >
          <v-container class="pl-10 pr-10 pb-10">
            <v-row
              id="form"
              dense
              class="mt-10"
            >
              <v-col
                cols="12"
                class="title"
              >Rincian Usulan</v-col>

              <v-col
                cols="12"
                sm="6"
                md="12"
              >
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
                  id="s6"
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
                  id="s7"
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
              <v-col
                cols="12"
                class="title"
              >Lokasi Usulan</v-col>
              <v-col
                cols="12"
                sm="6"
                md="12"
              >
                <v-text-field
                  id="s9"
                  label="Jalan/alamat"
                  v-model="alamat"
                  prepend-inner-icon="place"
                  outlined
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="3"
              >
                <v-text-field
                  id="s10"
                  label="RT"
                  v-model="rt"
                  outlined
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="3"
              >
                <v-text-field
                  id="s11"
                  label="RW"
                  v-model="rw"
                  outlined
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-autocomplete
                  id="s12"
                  v-model="kelurahan"
                  prepend-inner-icon="map"
                  outlined
                  :items="kelurahan_items"
                  label="Kelurahan"
                ></v-autocomplete>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="12"
              >
                <v-card
                  color="primary"
                  dark             
                  tile
                  outlined>
                  <v-card-text
                    class="white--text"
                  >
                    <p>Untuk Akurasi data dan pemetaan usulan, mohon mengisi latitude dan longitude usulan dibawah atau cari lokasi dan geser marker sesuai tempat lokasi</p>

                  </v-card-text>

                </v-card>
                <div
                  ref="map"
                  id="mapContainer"
                  style="width:100%; height:300px;"
                >
                </div>
              </v-col>
              <v-col cols="12">
                <v-divider></v-divider>
              </v-col>
              <v-col
                cols="12"
                class="title"
              >Rincian Pengusul</v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  id="s13"
                  label="Nama Pengusul"
                  v-model="nama_pengusul"
                  prepend-inner-icon="person"
                  outlined
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  id="s14"
                  label="No. HP Pengusul"
                  v-model="hp_pengusul"
                  prepend-inner-icon="phone"
                  outlined
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="12"
              >
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
            <div
              style="width:500px"
              class="d-flex justify-center"
            >
              <v-progress-circular
                indeterminate
                size="64"
              ></v-progress-circular>
            </div>
            <div
              style="width:500px"
              class="d-flex justify-center"
            >
              <p class="subtitle-1 mt-2">{{loadingText}}</p>
            </div>
          </v-overlay>
        </v-sheet>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import { mapActions, mapGetters, mapState, mapMutations } from "vuex";
export default {
  mounted() {},

  props: {
    value: false
  },
  model: {
    prop: "value",
    event: "editClicked"
  },
  computed: {
    ...mapState([
      "snackbar",
      "snackbarColor",
      "snackbarText",
      "isTableLoading"
    ]),
    ...mapGetters([
      "rawData",
      "kelurahan_items",
      "pod_items",
      "usulan_items",
      "barisPerHalaman"
    ]),
    dialogFisik: {
      get: function() {
        console.log(this.value);
        if (this.value == true) {
          // this.setMap();
        }
        return this.value;
      },
      set: function(value) {
        console.log("edit button clicked");
        this.$emit("editClicked", value);
      }
    }
  },
  watch: {
    dialogFisik: function() {
      this.testConsole();
      if (this.$props.value == true) {
        // this.setMap();
        console.log("anjing " + this.$props.value);
      }
    }
  },
  data() {
    return {
      lat: 0.506044,
      long: 101.397726,
      isMapCalled: false,
      map: {},
      platform: null,
      listFoto: [],
      listFile: [],
      loadingText: "memuat",
      overlay: false,
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
      jumlahFoto: 0,
      jumlahFile: 0,
      dropzoneOptions: {
        autoProcessQueue: false,
        acceptedFiles: "image/*",
        url: "/submitFoto",
        thumbnailWidth: 200,
        maxFilesize: 8,
        maxFiles: 2,
        clickable: true,
        addRemoveLinks: true,
        renameFile: function(file) {
          let newName = new Date().getTime() + "-" + file.name;
          return newName;
        },
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]")
            .content
        }
      },
      dropzoneOptionsFiles: {
        autoProcessQueue: false,
        acceptedFiles: "	application/msexcel,application/pdf,application/msword",
        url: "/submitFiles",
        thumbnailWidth: 200,
        maxFilesize: 8,
        maxFiles: 2,
        clickable: true,
        addRemoveLinks: true,
        renameFile: function(file) {
          let newName = new Date().getTime() + "-" + file.name;
          return newName;
        },
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]")
            .content
        }
      }
    };
  },
  created() {
    this.platform = new H.service.Platform({
      app_id: "qTceDkYeN1H41J9FnN2n",
      apikey: "MMJUx0m9wxG9hU7fleGImjzpwlF_U_8WjSt4wYNP3Gw"
    });
  },
  updated() {
    if (this.$props.value == true && this.isMapCalled == false) {
      setTimeout(() => {
        this.setMap();
      }, 500);
      console.log(this.$refs.map);
    }
  },
  methods: {
    ...mapActions({
      getTable: "getTableUsulan"
    }),
    ...mapMutations(["fillSnackbar", "toggleLoadingTable"]),
    moveMapTo() {},
    setMap() {
      this.isMapCalled = true;

      console.log("map called");
      var ini = this;
      console.log(ini.$refs.map);
      const maptypes = this.platform.createDefaultLayers();

      // Instantiate (and display) a map object:
      this.map = new H.Map(ini.$refs.map, maptypes.vector.normal.map, {
        zoom: 14,
        center: { lng: this.long, lat: this.lat }
      });
      var behavior = new H.mapevents.Behavior(
        new H.mapevents.MapEvents(this.map)
      );
      var ui = H.ui.UI.createDefault(this.map, maptypes);
    },
    calcProgressValue(value, index) {
      if (value == null || value == "") {
        if (this.checkProgress[index] == 0) {
          this.checkProgress[index] = 0;
        } else {
          this.checkProgress[index] = 0;
          this.progressValue = this.progressValue - 6.66666666667;
        }
      } else {
        if (this.checkProgress[index] == 0) {
          this.checkProgress[index] = 1;
          this.progressValue = this.progressValue + 6.66666666667;
        } else {
          this.checkProgress[index] = 1;
        }
      }
      console.log(this.progressValue, this.checkProgress);
    },
    batal() {
      console.log("im called");
      this.$refs.myVueDropzone.removeAllFiles();
      this.$refs.myVueDropzoneFiles.removeAllFiles();
      this.usulan = "";
      this.kelurahan = "";
      this.pod = "";
      this.volume = "";
      this.satuan = "";
      this.alamat = "";
      this.alasan_usulan = "";
      this.informasi_tambahan = "";
      this.output = "";
      this.listFoto = [];
      this.listFile = [];
      this.jumlahFile = 0;
      this.jumlahFoto = 0;
      this.rt = "";
      this.rw = "";
      this.nama_pengusul = "";
      this.hp_pengusul = "";
      this.alamat_pengusul = "";
      this.dialogFisik = false;
      this.overlay = false;
    },
    send() {
      var option = {
        duration: 300,
        offset: 10,
        container: "#scrolling-techniques-7"
      };
      var isEmpty = this.isFieldEmpty();
      if (isEmpty != -1) {
        this.$vuetify.goTo(isEmpty, option);
      } else {
        this.loadingText = "Mengunggah Foto..";
        this.overlay = true;
        this.$refs.myVueDropzone.processQueue();
      }
    },
    isFieldEmpty() {
      var target = -1;
      for (let i = 0; i < this.checkProgress.length; i++) {
        if (this.checkProgress[i] == 0) {
          target = "#s" + (i + 1);
          break;
        }
      }
      return target;
    },
    photosUploaded() {
      this.loadingText = "Mengunggah File..";
      this.$refs.myVueDropzoneFiles.processQueue();
    },
    filesUploaded() {
      this.loadingText = "Mengunggah rincian usulan..";
      setTimeout(() => {
        this.sendUsulanDetail();
      }, 1000);
    },
    afterComplete(file) {
      this.listFoto.push(file.upload.filename);
      console.log(this.listFoto);
    },
    afterCompleteFiles(file) {
      this.listFile.push(file.upload.filename);
      console.log(this.listFoto);
    },
    sendUsulanDetail() {
      console.log("woi");
      var ini = this;
      axios
        .post("/usul", {
          jenis: "Fisik",
          usulan: ini.usulan,
          kelurahan: ini.kelurahan,
          pod: ini.pod,
          volume: ini.volume,
          satuan: ini.satuan,
          alamat: ini.alamat,
          alasan_usulan: ini.alasan_usulan,
          informasi_tambahan: ini.informasi_tambahan,
          output: ini.output,
          foto1: ini.listFoto[0],
          foto2: ini.listFoto[1],
          file1: ini.listFile[0],
          file2: ini.listFile[1],
          rt: ini.rt,
          rw: ini.rw,
          nama_pengusul: ini.nama_pengusul,
          hp_pengusul: ini.hp_pengusul,
          alamat_pengusul: ini.alamat_pengusul,
          itemPerPage: ini.rawData.per_page
        })
        .then(function(response) {
          // ini.tableUsulan = response.data.data;
          ini.getTable(ini.barisPerHalaman);
          ini.$refs.myVueDropzone.removeAllFiles();
          ini.$refs.myVueDropzoneFiles.removeAllFiles();
          ini.fillSnackbar({
            snackbar: true,
            color: "success",
            text: "Usulan berhasil disimpan!"
          });
          // ini.snt = "Usulan berhasil disimpan!";
          // ini.snc = "success";
          // ini.sn = true;
          ini.batal();
          // ini.overlay = false;
          console.log(response.data.data);
        })
        .catch(function(error) {
          console.log(error);
          ini.fillSnackbar({
            snackbar: true,
            color: "error",
            text: "Terjadi kesalahan coba lagi!"
          });
          // ini.snackbarText = "Terjadi kesalahan coba lagi!";
          // ini.snackbarColor = "error";
          // ini.snackbar = true;
        });
      this.dialogFisik = false;
    },
    fotoAdded(file) {
      this.jumlahFoto += 1;
      console.log(this.jumlahFoto);
    },
    fileAdded(file) {
      this.jumlahFile += 1;
      console.log(this.jumlahFile);
    }
  },
  components: {
    vueDropzone: vue2Dropzone
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
<style scoped>
::-webkit-scrollbar {
  width: 7px;

  margin: 0px;
  transition: 1s ease;
}

/* Track */

::-webkit-scrollbar-track {
  background: transparent;

  margin: 0px;
}

/* Handle */

::-webkit-scrollbar-thumb {
  transition: 1s ease;
  background: rgb(187, 184, 184);

  border-radius: 25px;

  margin: 0px;
}

/* Handle on hover */

::-webkit-scrollbar-thumb:hover {
  transition: 1s ease;
  background: #555;
}
</style>