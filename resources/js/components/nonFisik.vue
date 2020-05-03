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
          <v-toolbar-title>Tambah Usulan Non Fisik</v-toolbar-title>
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
                sm="12"
                md="12"
              >
                <v-autocomplete
                  id="s1"
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
                <v-combobox
                  id="s2"
                  prepend-inner-icon="account_balance"
                  v-model="pod"
                  outlined
                  :items="pod_items"
                  label="Organisasi Perangkat Daerah"
                ></v-combobox>
              </v-col>

              <v-col cols="12">
                <v-text-field
                  id="s3"
                  label="Usulan"
                  v-model="usulan"
                  prepend-inner-icon="announcement"
                  outlined
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  id="s4"
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
                File Pendukung maksimal 2
                <vue-dropzone
                  @vdropzone-file-added="fileAdded"
                  @vdropzone-queue-complete="filesUploaded"
                  @vdropzone-complete="afterCompleteFiles"
                  ref="myVueDropzoneFiles"
                  id="s5"
                  :options="dropzoneOptionsFiles"
                ></vue-dropzone>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  id="s6"
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
              >Rincian Pengusul</v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  id="s7"
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
                  id="s8"
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
                  id="s9"
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
        return this.value;
      },
      set: function(value) {
        console.log("edit button clicked");
        this.$emit("editClicked", value);
      }
    }
  },
  data() {
    return {
      listFoto: [],
      listFile: [],
      loadingText: "memuat",
      overlay: false,
      checkProgress: [0, 0, 0, 0, 0, 0, 0, 0, 0],
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
      // pod_items: [],
      // usulan_items: [],
      // kelurahan_items: [],
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
  methods: {
    ...mapActions({
      getTable: "getTableUsulan"
    }),
    ...mapMutations(["fillSnackbar", "toggleLoadingTable"]),
    calcProgressValue(value, index) {
      if (value == null || value == "") {
        if (this.checkProgress[index] == 0) {
          this.checkProgress[index] = 0;
        } else {
          this.checkProgress[index] = 0;
          this.progressValue = this.progressValue - 11.11111111111;
        }
      } else {
        if (this.checkProgress[index] == 0) {
          this.checkProgress[index] = 1;
          this.progressValue = this.progressValue + 11.11111111111;
        } else {
          this.checkProgress[index] = 1;
        }
      }
      console.log(this.progressValue, this.checkProgress);
    },
    batal() {
      console.log("im called");
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
        this.$refs.myVueDropzoneFiles.processQueue();
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
          jenis: "Non Fisik",
          usulan: ini.usulan,
          kelurahan: ini.kelurahan,
          pod: ini.pod,
          volume: "-",
          satuan: "-",
          alamat: "-",
          alasan_usulan: ini.alasan_usulan,
          informasi_tambahan: ini.informasi_tambahan,
          output: ini.output,
          foto1: "-",
          foto2: "-",
          file1: ini.listFile[0],
          file2: ini.listFile[1],
          rt: "-",
          rw: "-",
          nama_pengusul: ini.nama_pengusul,
          hp_pengusul: ini.hp_pengusul,
          alamat_pengusul: ini.alamat_pengusul,
          itemPerPage: ini.rawData.per_page
        })
        .then(function(response) {
          // ini.tableUsulan = response.data.data;
          ini.getTable(ini.barisPerHalaman);
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
    kelurahan: function(val) {
      this.calcProgressValue(val, 0);
    },
    pod: function(val) {
      this.calcProgressValue(val, 1);
    },
    usulan: function(val) {
      this.calcProgressValue(val, 2);
    },
    output: function(val) {
      this.calcProgressValue(val, 3);
    },
    jumlahFile: function(val) {
      if (this.jumlahFile > 1 || this.jumlahFile < 1) {
        this.calcProgressValue(val, 4);
      }
    },
    alasan_usulan: function(val) {
      this.calcProgressValue(val, 5);
    },
    nama_pengusul: function(val) {
      this.calcProgressValue(val, 6);
    },
    hp_pengusul: function(val) {
      this.calcProgressValue(val, 7);
    },
    alamat_pengusul: function(val) {
      this.calcProgressValue(val, 8);
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