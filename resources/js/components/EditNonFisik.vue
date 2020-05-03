<template>

  <div>
    <v-dialog
      max-width="700px"
      style="z-index:1008"
      v-model="dialogFoto"
    >
      <v-carousel
        v-model="carousselIndex"
        show-arrows-on-hover
      >
        <!-- reverse-transition="fade-transition"
          transition="fade-transition" -->
        <v-carousel-item
          v-for="n in 2"
          :key="n"
          :src="carousselList[n-1]"
        ></v-carousel-item>
      </v-carousel>

    </v-dialog>
    <v-overlay
      z-index="20"
      opacity="0.6"
      :value="editOverlay"
      @click="editOverlay = false"
    >

      <v-slide-y-reverse-transition>
        <div
          v-if="editOverlay"
          style="width:100vw; height:100vh;"
          class="editGrid"
        >
          <div style="position: fixed; top:2em; right:6em">
            <v-btn
              text
              @click="batal()"
            >batal</v-btn>
            <v-btn
              color="primary"
              @click="update()"
            >Simpan</v-btn>
          </div>
          <v-hover>
            <template v-slot="{ hover }">

              <v-card
                style="grid-area: rincian; "
                light
                :elevation="hover ? 20 : 6"
                class="overflow-y-auto"
              >

                <v-container fluid>

                  <v-row no-gutters>

                    <v-col
                      cols="12"
                      sm="6"
                      md="12"
                    >
                      <h3 class="mt-2 mb-2">
                        Rincian Usulan
                      </h3>

                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="12"
                    >
                      <v-combobox
                        prepend-inner-icon="account_balance"
                        v-model="tableUsulanTemp.pod"
                        outlined
                        :items="pod_items"
                        label="Organisasi Perangkat Daerah"
                      >
                      </v-combobox>
                    </v-col>

                    <v-col cols="12">
                      <v-text-field
                        label="Usulan"
                        v-model="tableUsulanTemp.usulan"
                        prepend-inner-icon="announcement"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-autocomplete
                        class="ml-1"
                        v-model="tableUsulanTemp.kelurahan"
                        prepend-inner-icon="map"
                        outlined
                        :items="kelurahan_items"
                        label="Kelurahan"
                      >
                      </v-autocomplete>
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                        v-model="tableUsulanTemp.output"
                        outlined
                        auto-grow
                        label="Output"
                        rows="3"
                        row-height="30"
                      >
                      </v-textarea>
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                        v-model="tableUsulanTemp.alasan_usulan"
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
                        v-model="tableUsulanTemp.informasi_tambahan"
                        outlined
                        auto-grow
                        label="Informasi Tambahan"
                        rows="3"
                        row-height="30"
                      ></v-textarea>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="6"
                    >
                      <v-text-field
                        class="mr-1"
                        label="Nama Pengusul"
                        v-model="tableUsulanTemp.nama_pengusul"
                        prepend-inner-icon="person"
                        outlined
                      >
                      </v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="6"
                    >
                      <v-text-field
                        class="ml-1"
                        label="No. HP Pengusul"
                        v-model="tableUsulanTemp.hp_pengusul"
                        prepend-inner-icon="phone"
                        outlined
                      >
                      </v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="12"
                    >
                      <v-text-field
                        label="Alamat Pengusul"
                        v-model="tableUsulanTemp.alamat_pengusul"
                        prepend-inner-icon="place"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-btn
                        @click="downloadFilePendukung(1)"
                        class="ma-2"
                        tile
                        outlined
                        color="success"
                      >
                        <v-icon left>cloud_download</v-icon> File Pendukung 1
                      </v-btn>
                      <v-btn
                        @click="downloadFilePendukung(2)"
                        class="ma-2"
                        tile
                        outlined
                        color="success"
                      >
                        <v-icon left>cloud_download</v-icon> File Pendukung 2
                      </v-btn>
                    </v-col>

                  </v-row>

                </v-container>
              </v-card>

            </template>
          </v-hover>
        </div>
      </v-slide-y-reverse-transition>
    </v-overlay>
    <v-snackbar
      v-model="snackbar"
      :color="snackbarColor"
      dark
      multi-line
    >
      {{ snackbarText }}
      <v-btn
        color="white"
        text
        @click="snackbar = false"
      >
        Tutup
      </v-btn>
    </v-snackbar>
  </div>

</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  props: {
    value: false,
    index: null
  },
  model: {
    prop: "value",
    event: "editClicked"
  },
  watch: {
    tableUsulan: value => {
      console.log(value);
    },
    value: function(value) {
      console.log(value);
      if (value) {
        this.tableUsulanTemp = JSON.parse(
          JSON.stringify(this.tableUsulan[this.$props.index])
        );
        this.temp = this.tableUsulan[this.$props.index];
      } else {
        console.log("called");
        // this.tableUsulanTemp = this.temp;
        this.tableUsulanTemp = {};
        console.log(this.tableUsulanTemp);
        console.log(this.tableUsulan[this.$props.index]);
        console.log(this.$store.state.rawData.data[this.$props.index]);
        // this.tableUsulan = this.temp;
      }
    }
  },
  computed: {
    ...mapGetters([
      "tableUsulan",
      "rawData",
      "kelurahan_items",
      "pod_items",
      "usulan_items"
    ]),
    editOverlay: {
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
      temp: null,
      tableUsulanTemp: {},
      snackbar: false,
      snackbarText: "",
      snackbarColor: "",
      dialogFoto: false,
      carousselList: [],
      carousselIndex: 0
    };
  },
  // beforeUpdate(){
  //   console.log("before update");
  //   this.tableUsulanTemp = this.tableUsulan[this.$props.index];
  // },
  methods: {
    ...mapActions(["updateTableUsulan"]),
    batal() {
      this.editOverlay = false;
    },
    update() {
      var ini = this;
      this.updateTableUsulan(ini.tableUsulanTemp)
        .then(() => {
          ini.editOverlay = false;
          ini.snackbarText = "Usulan berhasil diperbarui!";
          ini.snackbarColor = "success";
          ini.snackbar = true;
        })
        .catch(() => {
          ini.snackbarText = "Terjadi kesalahan coba lagi!";
          ini.snackbarColor = "error";
          ini.snackbar = true;
        });
    },
    foto1() {
      var a = "images/" + this.tableUsulanTemp.foto1;
      return a.replace(" ", "%20");
    },
    foto2() {
      var a = "images/" + this.tableUsulanTemp.foto2;
      return a.replace(" ", "%20");
    },
    caroussel(index) {
      this.carousselList = [];
      this.carousselIndex = 0;
      if (index == 0) {
        this.carousselList.push(this.foto1());
        this.carousselList.push(this.foto2());
      } else {
        this.carousselList.push(this.foto2());
        this.carousselList.push(this.foto1());
      }
      console.log(index);
      this.dialogFoto = true;
    },
    downloadFilePendukung(id) {
      console.log(this.kelurahan_items);
      if (id == 1) {
        window.open("/files/" + this.tableUsulanTemp.file1);
      } else {
        window.open("/files/" + this.tableUsulanTemp.file2);
      }
    }
  }
};
</script>
<style  scoped>
.editGrid {
  height: 100vh;
  padding-top: 5em;
  padding-bottom: 5em;
  padding-left: 10em;
  padding-right: 10em;
  display: grid;
  grid-gap: 1.5em;
  grid-template-columns: 55% 22.5% 22.5%;
  grid-template-rows: 33.33% 33.33% 33.33%;
  grid-template-areas:
    "rincian rincian rincian"
    "rincian rincian rincian"
    "rincian rincian rincian";
}
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