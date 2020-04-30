<template>

  <div>
    <v-dialog
      max-width="700px"
      style="z-index:1008"
      v-model="dialogFoto"
    >
      <v-carousel v-model="carousselIndex">
        <v-carousel-item
          v-for="n in 2"
          :key="n"
          :src="carousselList[n-1]"
          
          reverse-transition="fade-transition"
          transition="fade-transition"
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
          <div style="position: fixed; top:2em; right:2em">
            <v-btn
              text
              @click="editOverlay = false"
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

                <v-sheet
                  style="position: sticky;"
                  class="title ml-4 mt-2"
                >
                  Rincian Usulan
                </v-sheet>

                <v-container fluid>

                  <v-row no-gutters>

                    <v-col
                      cols="12"
                      sm="6"
                      md="12"
                    >
                      <v-combobox
                        dense
                        prepend-inner-icon="account_balance"
                        v-model="tableUsulanTemp.pod"
                        outlined
                        :items="pod_items"
                        label="Organisasi Perangkat Daerah"
                      >
                      </v-combobox>
                    </v-col>

                    <v-col cols="12">
                      <v-combobox
                        dense
                        prepend-inner-icon="announcement"
                        outlined
                        v-model="tableUsulanTemp.usulan"
                        :items="usulan_items"
                        label="Usulan"
                      ></v-combobox>
                    </v-col>
                    <v-col cols="6">

                      <v-text-field
                        dense
                        label="Volume"
                        class="mr-1"
                        v-model="tableUsulanTemp.volume"
                        prepend-inner-icon="mdi-scale-balance"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        dense
                        label="Satuan"
                        class="ml-1"
                        v-model="tableUsulanTemp.satuan"
                        prepend-inner-icon="linear_scale"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        dense
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
                        dense
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
                        dense
                        prepend-inner-icon="mdi-checkbox-multiple-marked-circle-outline"
                        v-model="tableUsulanTemp.informasi_tambahan"
                        outlined
                        auto-grow
                        label="Informasi Tambahan"
                        rows="3"
                        row-height="30"
                      ></v-textarea>
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
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                @click="caroussel(0)"
                width="100%"
                ripple
                light
                :elevation="hover ? 20 : 6"
                style="grid-area: gambar1"
              >
                <v-img
                  aspect-ratio
                  :src="foto1()"
                ></v-img>
              </v-card>
            </template>
          </v-hover>
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                @click="caroussel(1)"
                width="100%"
                ripple
                light
                :elevation="hover ? 20 : 6"
                style="grid-area: gambar2"
              >
                <v-img :src="foto2()"></v-img>
              </v-card>
            </template>
          </v-hover>
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                light
                :elevation="hover ? 20 : 6"
                class="overflow-y-hidden"
                style="grid-area: lokasi"
              >
                <v-sheet class="title ml-4 mt-2">
                  Lokasi
                </v-sheet>
                <v-container>
                  <v-row no-gutters>
                    <v-col cols="12">
                      <v-text-field
                        dense
                        label="Jalan/alamat"
                        v-model="tableUsulanTemp.alamat"
                        prepend-inner-icon="place"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="3">
                      <v-text-field
                        dense
                        class="mr-1"
                        label="RT"
                        v-model="tableUsulanTemp.rt"
                        outlined
                      >
                      </v-text-field>
                    </v-col>
                    <v-col cols="3">
                      <v-text-field
                        dense
                        label="RW"
                        v-model="tableUsulanTemp.rw"
                        outlined
                      >
                      </v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-autocomplete
                        dense
                        class="ml-1"
                        v-model="tableUsulanTemp.kelurahan"
                        prepend-inner-icon="map"
                        outlined
                        :items="kelurahan_items"
                        label="Kelurahan"
                      >
                      </v-autocomplete>
                    </v-col>
                  </v-row>
                </v-container>

              </v-card>
            </template>
          </v-hover>
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                class="overflow-y-hidden"
                light
                :elevation="hover ? 20 : 6"
                style="grid-area: pengusul"
              >
                <v-sheet class="title ml-4 mt-2">
                  Rincian Pengusul
                </v-sheet>
                <v-container>
                  <v-row no-gutters>
                    <v-col
                      cols="12"
                      sm="6"
                      md="6"
                    >
                      <v-text-field
                        dense
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
                        dense
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
                        dense
                        label="Alamat Pengusul"
                        v-model="tableUsulanTemp.alamat_pengusul"
                        prepend-inner-icon="place"
                        outlined
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card>
            </template>
          </v-hover>
        </div>
      </v-slide-y-reverse-transition>
    </v-overlay>
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
  computed: {
    ...mapGetters([
      "tableUsulan",
      "rawData",
      "kelurahan_items",
      "pod_items",
      "usulan_items"
    ]),
    tableUsulanTemp: function() {
      return this.tableUsulan[this.$props.index];
    },
    editOverlay: {
      get: function() {
        console.log(this.value);
        return this.value;
      },
      set: function(value) {
        console.log("clicked");
        this.$emit("editClicked", value);
      }
    }
  },
  data() {
    return {
      dialogFoto: false,
      carousselList: [],
      carousselIndex:0,
    };
  },
  methods: {
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
</style>