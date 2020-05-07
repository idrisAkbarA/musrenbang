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
          <div style="position: fixed; top:2em; right:2em">
            <v-btn
              text
              @click="batal()"
            >batal</v-btn>
            <v-btn
              color="primary"
              @click="send()"
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
                  <input
                    type="file"
                    ref="foto1Temp"
                    accept="image/*"
                    @change="setFoto(1)"
                    style="display:none"
                    label="temp"
                  >
                  <input
                    type="file"
                    ref="foto2Temp"
                    accept="image/*"
                    @change="setFoto(2)"
                    style="display:none"
                    label="temp"
                  >

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
                color="primary"
                width="100%"
                light
                :elevation="hover ? 20 : 6"
                style="grid-area: gambar1"
              >
                <v-btn
                  block
                  color="primary"
                  style="position:absolute; bottom:0; left:0;right:0"
                  @click="changeFoto1"
                >Ganti Foto</v-btn>
                <v-img
                  v-ripple
                  @click="caroussel(0)"
                  :style="hover? 'top:-35px; transition:.3s ease;cursor:pointer;':'top:0;cursor:pointer;transition:1s ease;'"
                  min-height="100%"
                  min-width="100%"
                  max-height="100%"
                  :src="foto1()"
                ></v-img>
              </v-card>
            </template>
          </v-hover>
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                color="primary"
                width="100%"
                light
                :elevation="hover ? 20 : 6"
                style="grid-area: gambar2"
              >
                <v-btn
                  @click="changeFoto2"
                  block
                  color="primary"
                  style="position:absolute; bottom:0; left:0;right:0"
                >Ganti Foto</v-btn>
                <v-img
                  v-ripple
                  :style="hover? 'top:-35px; transition:.3s ease;cursor:pointer;':'top:0;cursor:pointer;transition:1s ease;'"
                  @click="caroussel(1)"
                  min-height="100%"
                  min-width="100%"
                  max-height="100%"
                  :src="foto2()"
                ></v-img>
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
    <v-overlay
      style="z-index:100;"
      :value="editSendOverlay"
    >
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
        <p class="title mt-2">{{loadingText}}</p>
      </div>
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
      "usulan_items",
      "barisPerHalaman"
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
      loadingText: null,
      editSendOverlay: false,
      foto1Temp: null,
      foto2Temp: null,
      foto1EditedPath: null,
      foto2EditedPath: null,
      foto1TempUrl: null,
      foto2TempUrl: null,
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
    ...mapActions(["updateTableUsulan", "getTableUsulan"]),
    batal() {
      this.foto1TempUrl = null;
      this.foto2TempUrl = null;
      this.editOverlay = false;
    },
    // async send() {
    //   let sendFoto1;
    //   this.editSendOverlay = true;
    //   this.loadingText = "Mengunggah Foto..";
    //   var promiseArr = [];
    //    if(this.foto1TempUrl) {
    //     await this.storeFoto(this.foto1Temp, 1);
    //     promiseArr.push(sendFoto1);
    //   }
    //   if (this.foto2TempUrl) {
    //     await this.storeFoto(this.foto2Temp, 2);
    //     // promiseArr.push(sendFoto2);
    //   }
    //   this.update();
    // },
    a(){
      return new Promise((resolve)=>{
        axios.get("https://jsonplaceholder.typicode.com/todos/1").then(()=>{
          console.log("sukses");
          resolve();
        })
      })
    },
    b(){
      console.log("b")
    },
    async send() {
      var ini = this;
      // var a = function(){console.log("a")};
      // var b = function(){console.log("b")};
      // var x = [];
      // x.push(this.a);
      // x.push(this.b);
      // await x[0]();
      // x[1]();
      // console.log(x);
  
      function storeFoto(foto, fotoKe){
        var formData = new FormData();
        var filename = new Date().getTime() + "-" + foto.name;
        formData.append("file", foto, filename);
        return new Promise((resolve)=>{
          axios
          .post("/submitFoto", formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(function() {
            console.log("SUCCESS!!");
            if (fotoKe == 1) {
              ini.foto1EditedPath = filename;
              console.log(ini.foto1EditedPath);
              resolve();
              // ini.tableUsulanTemp.foto1 = ini.foto1EditedPath;
            } else {
              ini.foto2EditedPath = filename;
              console.log(ini.foto1EditedPath);
              resolve();
              // ini.tableUsulanTemp.foto2 = ini.foto2EditedPath;
            }
          })
          .catch(function(error) {
            console.log("FAILURE!! RETRYING!!");
            console.log(error);
            storeFoto(foto, fotoKe);
          });
        });
        
      };
     
            var sendFoto1;
      var sendFoto2;
      this.editSendOverlay = true;
      this.loadingText = "Mengunggah Foto..";
      var promiseArr = [];
      if (this.foto1TempUrl) {
        sendFoto1 = storeFoto(this.foto1Temp, 1);
        promiseArr.push(sendFoto1);
      }
      if (this.foto2TempUrl) {
        sendFoto2 = storeFoto(this.foto2Temp, 2);
        promiseArr.push(sendFoto2);
      }
      if (promiseArr.length < 1) {
        console.log("nothing to upload");
        this.update();
      } else {
        console.log(promiseArr);
        Promise.all(promiseArr).then(()=>{
          ini.loadingText = "Menyimpan perubahan..";
          ini.update();
        })
        // for (let index = 0; index < promiseArr.length; index++) {
        //   await promiseArr[index]();
        // }
        // ini.loadingText = "Menyimpan perubahan..";
        // ini.update();
        // axios.all(promiseArr)
        //   .then(axios.spread(function (acct, perms) {
        //     console.log("all foto Uploaded!");
        //     console.log(acct,perms);
        //     ini.loadingText = "Menyimpan perubahan..";
        //     ini.update();
        //   }));
      }
    },
    // send() {
    //   var sendFoto1;
    //   var sendFoto2;
    //   this.editSendOverlay = true;
    //   this.loadingText = "Mengunggah Foto..";
    //   var promiseArr = [];
    //   if (this.foto1TempUrl) {
    //     sendFoto1 = this.storeFoto(this.foto1Temp, 1);
    //     promiseArr.push(sendFoto1);
    //   }
    //   if (this.foto2TempUrl) {
    //     sendFoto2 = this.storeFoto(this.foto2Temp, 2);
    //     promiseArr.push(sendFoto2);
    //   }
    //   if (promiseArr.length < 1) {
    //     console.log("nothing to upload");
    //     this.update();
    //   } else {
    //     Promise.all(promiseArr)
    //       .then((values) => {
    //         console.log("all foto Uploaded!");
    //         console.log(values);
    //         this.loadingText = "Menyimpan perubahan..";
    //         this.update();
    //       })
    //       .catch(error => {
    //         console.log(error);
    //       });
    //   }
    // },
    storeFoto(foto, fotoKe) {
      var ini = this;
      var formData = new FormData();
      var filename = new Date().getTime() + "-" + foto.name;
      formData.append("file", foto, filename);
      axios
        .post("/submitFoto", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(function() {
          console.log("SUCCESS!!");
          if (fotoKe == 1) {
            ini.foto1EditedPath = filename;
            console.log(ini.foto1EditedPath);
            // ini.tableUsulanTemp.foto1 = ini.foto1EditedPath;
          } else {
            ini.foto2EditedPath = filename;
            console.log(ini.foto1EditedPath);
            // ini.tableUsulanTemp.foto2 = ini.foto2EditedPath;
          }
        })
        .catch(function(error) {
          console.log("FAILURE!! RETRYING!!");
          console.log(error);
          ini.storeFoto(foto, fotoKe);
        });
    },
    setFoto(foto) {
      if (foto == 1) {
        this.foto1Temp = this.$refs.foto1Temp.files[0];
        const reader = new FileReader();
        var ini = this;
        reader.addEventListener(
          "load",
          function() {
            // convert image file to base64 string
            ini.foto1TempUrl = reader.result;
          },
          false
        );
        if (this.foto1Temp) {
          reader.readAsDataURL(this.foto1Temp);
        }
        console.log(this.foto1Temp);
      } else {
        this.foto2Temp = this.$refs.foto2Temp.files[0];
        const reader = new FileReader();
        var ini = this;
        reader.addEventListener(
          "load",
          function() {
            // convert image file to base64 string
            ini.foto2TempUrl = reader.result;
          },
          false
        );
        if (this.foto2Temp) {
          reader.readAsDataURL(this.foto2Temp);
        }
        console.log(this.foto2Temp);
      }
    },
    changeFoto1() {
      console.log(this.$refs.foto1Temp.files);
      this.$refs.foto1Temp.click();
    },
    changeFoto2() {
      console.log(this.$refs.foto2Temp.files);
      this.$refs.foto2Temp.click();
    },
    update() {
      console.log("-----------------------");
      if (this.foto1EditedPath) {
        this.tableUsulanTemp.foto1 = this.foto1EditedPath;
        console.log(this.tableUsulanTemp.foto1);
      }
      if (this.foto2EditedPath) {
        this.tableUsulanTemp.foto2 = this.foto2EditedPath;
        console.log(this.tableUsulanTemp.foto2);
      }
      console.log("-----------------------");
      var ini = this;
      this.updateTableUsulan(ini.tableUsulanTemp)
        .then(() => {
          ini.getTableUsulan(ini.barisPerHalaman);
          ini.editOverlay = false;
          ini.snackbarText = "Usulan berhasil diperbarui!";
          ini.snackbarColor = "success";
          ini.snackbar = true;
          ini.editSendOverlay = false;
        })
        .catch(() => {
          ini.editSendOverlay = false;
          ini.snackbarText = "Terjadi kesalahan coba lagi!";
          ini.snackbarColor = "error";
          ini.snackbar = true;
        });
    },
    foto1() {
      if (!this.foto1TempUrl) {
        var a = "images/" + this.tableUsulanTemp.foto1;
        return a.replace(" ", "%20");
      }
      return this.foto1TempUrl;
    },
    foto2() {
      if (!this.foto2TempUrl) {
        var a = "images/" + this.tableUsulanTemp.foto2;
        return a.replace(" ", "%20");
      }
      return this.foto2TempUrl;
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