<template>

  <v-container
    fluid
    style=" height:100%; position:relative"
  >
    <edit-fisik
      v-model="editOverlay"
      :index="index"
    ></edit-fisik>
    <edit-non-fisik
      v-model="editNonFisikOverlay"
      :index="index"
    ></edit-non-fisik>
    <!-- <transition name="simp"> -->

    <!-- v-if="show" -->

    <v-sheet
      :style="sheetHeightClass.sheetStyle"
      class="overflow-y-auto"
      color="white"
      :height="sheetHeightClass.sheetHeight"
      width="100%"
      elevation="10"
    >

      <v-skeleton-loader
        type="table"
        :loading="isTableLoading"
        transition="fade-transition"
      >

        <table>
          <thead>
            <tr class="red kepala">
              <th>No.</th>
              <th>Nama</th>
              <th>Kelompok</th>
              <th>Volume</th>
              <th>Kelurahan</th>
              <th style="width:200px">Organisasi Perangkat Daerah</th>
              <th style="z-index:2">Verifikasi</th>
              <th style="z-index:2">Validasi</th>
              <th style="z-index:2">Prioritas</th>
              <th style="z-index:2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <!-- :class="styling(index)" -->
            <tr
              :class="styling(index)"
              v-for="(item, index) in tableUsulan"
              :key="item.id"
            >
              <td class="number">{{index+rawData.from}}</td>
              <td>{{item.usulan}}</td>
              <td>{{item.jenis}}</td>
              <td>{{item.volume}}</td>
              <td>{{item.kelurahan}}</td>
              <td>{{item.pod}}</td>

              <td>
                <v-btn
                  :loading="tableUsulan[index]['loading_verifikasi']"
                  @click="toggleStatus(index,'verifikasi')"
                  text
                >
                  {{item.verifikasi}}
                </v-btn>
              </td>
              <td>
                <v-btn
                  :loading="tableUsulan[index]['loading_validasi']"
                  @click="toggleStatus(index,'validasi')"
                  text
                >
                  {{item.validasi}}
                </v-btn>
              </td>
              <td>
                <v-btn
                  :loading="tableUsulan[index]['loading_prioritas']"
                  @click="toggleStatus(index,'prioritas')"
                  text
                >
                  {{item.prioritas}}
                </v-btn>
              </td>
              <!-- @click="edit(index)" -->
              <td style="width:100px">
                <v-btn
                  @click="edit(index)"
                  icon
                >
                  <v-icon>
                    edit
                  </v-icon>
                </v-btn>
                <v-btn
                  icon
                  @click="deleteUsulan(index)"
                >
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
    <div :style="sheetHeightClass.footer">
      <v-row>
        <v-col cols="12">
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                width="490"
                class="d-flex"
                :elevation="hover ? 17 : 6"
              >
                <v-menu top>
                  <template v-slot:activator="{ on }">
                    <v-card-text
                      style="cursor: pointer;"
                      v-on="on"
                    >
                      <div style="width:200px">
                        Baris per halaman: {{rawData.per_page}} <v-icon>
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
                <v-card-text> {{rawData.from}} - {{rawData.to}} dari
                  {{rawData.total}}</v-card-text>
                <v-btn
                  :disabled="isPrevDisabled()"
                  @click="prev()"
                  class="mt-2"
                  icon
                >
                  <v-icon>keyboard_arrow_left</v-icon>
                </v-btn>
                <v-btn
                  :disabled="isNextDisabled()"
                  @click="next()"
                  class="mt-2 mr-2"
                  icon
                >
                  <v-icon>keyboard_arrow_right</v-icon>
                </v-btn>
              </v-card>
            </template>
          </v-hover>
        </v-col>
      </v-row>
    </div>
    <v-dialog
      width="400"
      v-model="dialogDelete"
    >
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
          <v-btn
            text
            @click="dialogDelete = false"
          >
            Batal
          </v-btn>
          <v-btn
            dark
            class="error"
            @click="deleteUsulanConfirmed"
          >
            <v-icon left> delete</v-icon>
            Hapus
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-snackbar
      v-model="sn"
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

    <!-- </transition> -->

  </v-container>

</template>
<script>
import { mapActions, mapGetters, mapState, mapMutations } from "vuex";
export default {
  beforeMount() {
    var ini = this;
    this.getTable(15).then(function(response) {
      console.log("yeay!");
    });
    // .catch(function(error) {
    //   console.log(" wak error ");
    //   ini.getTable(15);
    // });
    this.loadInitData();
  },
  computed: {
    ...mapState([
      "snackbar",
      "snackbarColor",
      "snackbarText",
      "isTableLoading"
    ]),
    ...mapGetters(["tableUsulan", "rawData"]),
    sn: {
      get: function() {
        console.log(this.snackbar);
        return this.snackbar;
      },
      set: function(value) {
        this.fillSnackbar({ snackbar: value, color: "", text: "" });
      }
    },

    //* Jika tabel usulan = 5 maka kecilkan tampilan tabel
    isFive: function() {
      if (this.tableUsulan) {
        var bool = this.tableUsulan.length === 5 ? true : false;
        if (bool) {
          this.sheetHeightClass = {
            sheetStyle: "position:relative;",
            sheetHeight: "",
            footer: ""
          };
          return true;
        } else {
          this.sheetHeightClass = {
            sheetStyle: "position:absolute;",
            sheetHeight: "87%",
            footer: "position:absolute; top:89%;"
          };
          return false;
        }
      }
      console.log(this.sheetHeightClass);
      return false;
    }
  },
  data() {
    return {
      deleteId: -1,
      deleteIdTable: -1,
      dialogDelete: false,
      index: null,
      editOverlay: false,
      editNonFisikOverlay: false,
      show: false,
      overlayTable: true,
      sheetHeightClass: {
        sheetStyle: "position:absolute;",
        sheetHeight: "87%",
        footer: "position:absolute; top:89%;"
      }
    };
  },
  methods: {
    ...mapMutations(["fillSnackbar", "toggleLoadingTable"]),
    ...mapActions(["nextPage", "prevPage", "updateStatus", "loadInitData"]),
    ...mapActions({
      getTable: "getTableUsulan",
      updateTable: "updateTableUsulan"
    }),
    deleteUsulanConfirmed() {
      var ini = this;
      this.loading = true;
      this.dialogDelete = false;
      axios
        .post("/usul/hapus", {
          id: ini.deleteId
        })
        .then(function(response) {
          ini.loading = false;
          ini.fillSnackbar({ snackbar: true, color: "success", text: "Usulan berhasil di hapus!" });
          ini.tableUsulan.splice(ini.deleteIdTable, 1);
        })
        .catch(function(error) {
          ini.loading = false;
          ini.fillSnackbar({ snackbar: true, color: "success", text: "Usulan berhasil di hapus!" });
        });
    },
    deleteUsulan(index) {
      this.dialogDelete = true;
      var ini = this;
      ini.deleteIdTable = index;
      ini.deleteId = ini.tableUsulan[index]["id"];
    },
    edit(index) {
      if (this.tableUsulan[index].jenis == "Fisik") {
        this.editOverlay = true;
        this.index = index;
      } else {
        this.editNonFisikOverlay = true;
        this.index = index;
        console.log("non fisik called");
      }
    },
    toggleStatus(index, status) {
      var ini = this;
      var obj = { index: index, status: status };
      this.updateStatus(obj)
        .then(function(response) {
          const capitalized = status.charAt(0).toUpperCase() + status.slice(1);
          const noti = ini.$vs.notification({
            square: true,
            color: "success",
            position: "top-right",
            title: `${capitalized} sukses`,
            text: `${capitalized}  berhasil diperbarui!`
          });
          console.log("reached");
        })
        .catch(error => {
          const capitalized = status.charAt(0).toUpperCase() + status.slice(1);
          const noti = ini.$vs.notification({
            square: true,
            color: "danger",
            position: "top-right",
            title: `${capitalized} gagal`,
            text: `Terjadi kesalahan, coba refresh halaman`
          });
        });
    },
    next() {
      this.toggleLoadingTable();
      this.overlayTable = true;
      var ini = this;
      this.nextPage().then(function(response) {
        ini.toggleLoadingTable();
      });
    },
    prev() {
      this.toggleLoadingTable();
      var ini = this;
      this.prevPage().then(function(response) {
        ini.toggleLoadingTable();
      });
    },
    barisTiapHalaman(jumlah) {
      var ini = this;
      var itemPerPage;
      if (jumlah == "5") {
        itemPerPage = 5;
      } else if (jumlah == "15") {
        itemPerPage = 15;
      } else {
        itemPerPage = this.rawData.total;
      }
      console.log(itemPerPage);

      this.getTable(itemPerPage).then(function(response) {
        console.log(ini.sheetHeightClass);
      });
    },
    loader_verif(index) {
      return this.tableUsulan[index].loading_verifikasi;
    },
    loader_valid(index) {
      return this.tableUsulan[index].loading_validasi;
    },
    loader_prioritas(index) {
      return this.tableUsulan[index].loading_prioritas;
    },
    isNextDisabled() {
      if (this.rawData.next_page_url == null) {
        return true;
      } else {
        return false;
      }
    },
    isPrevDisabled() {
      if (this.rawData.prev_page_url == null) {
        return true;
      } else {
        return false;
      }
    },
    boolConvert(bool) {
      var result = bool === "true" ? "iya" : "tidak";
      return result;
    },
    styling(index) {
      var style =
        this.tableUsulan[index].verifikasi +
        "-" +
        this.tableUsulan[index].validasi +
        "-" +
        this.tableUsulan[index].prioritas;
      // console.log(style);
      return style;
    }
  },
  watch: {}
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
.simp-enter-active {
  animation: simp 2s;
}
.simp-leave-active {
  animation: simp 2s reverse;
}
@keyframes simp {
  0% {
    opacity: 0;
  }
  30% {
    opacity: 0.3;
  }
  100% {
    opacity: 1;
  }
}
.kelA {
  left: 10px;
  top: -18px;
  position: relative;
}

.belum-validasi {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(255, 114, 114);
  background: rgb(255, 114, 114);
  background: linear-gradient(
    -90deg,
    rgba(255, 114, 114, 1) 0%,
    rgba(255, 255, 255, 0.2777485994397759) 59%
  );
}

/* AAA BBB */

.tidak-tidak-tidak {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(255, 60, 60);
  background-color: rgb(255, 255, 255);
  background: rgb(255, 254, 254);
  background: linear-gradient(
    90deg,
    rgba(255, 254, 254, 1) 0%,
    rgba(255, 253, 253, 1) 53%,
    /* rgba(255, 202, 185, 1) 71%, */ rgba(255, 202, 185, 1) 79%,
    /* rgba(255, 202, 185, 1) 87%, */ rgba(255, 255, 255, 1) 100%
  );
}
.tidak-tidak-tidak:hover {
  transition: 0.5s ease;
  height: 100px;
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgba(240, 240, 240, 1) 0%,
    rgba(240, 240, 240, 1) 53%,
    /* rgba(255, 202, 185, 1) 71%, */ rgba(255, 202, 185, 1) 79%,
    /* rgba(255, 202, 185, 1) 87%, */ rgba(255, 255, 255, 1) 100%
  );
}
.iya-iya-iya {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(8, 226, 0);
  background-color: rgb(255, 255, 255);
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgb(255, 255, 255) 0%,
    rgb(255, 255, 255) 53%,
    /* rgba(142, 255, 197, 1) 71%, */ rgba(142, 255, 197, 1) 79%,
    /* rgba(142, 255, 197, 1) 87%, */ rgba(255, 255, 255, 1) 100%
  );
}
.iya-iya-iya:hover {
  transition: 0.5s ease;
  height: 100px;
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgba(240, 240, 240, 1) 0%,
    rgba(240, 240, 240, 1) 53%,
    /* rgba(142, 255, 197, 1) 71%, */ rgba(142, 255, 197, 1) 79%,
    /* rgba(142, 255, 197, 1) 87%, */ rgba(255, 255, 255, 1) 100%
  );
}

/* AAB BBA */

.tidak-tidak-iya {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(89, 60, 255);
  background-color: rgb(255, 255, 255);
  background: rgb(255, 254, 254);
  background: linear-gradient(
    90deg,
    rgba(255, 254, 254, 1) 0%,
    rgba(255, 253, 253, 1) 53%,
    /* rgba(255, 202, 185, 1) 71%, */ rgba(255, 202, 185, 1) 79%,
    rgba(142, 255, 197, 1) 87%,
    rgba(255, 255, 255, 1) 100%
  );
}
.tidak-tidak-iya:hover {
  transition: 0.5s ease;
  height: 100px;
  background: rgb(255, 254, 254);
  background: linear-gradient(
    90deg,
    rgba(240, 240, 240, 1) 0%,
    rgba(240, 240, 240, 1) 53%,
    /* rgba(255, 202, 185, 1) 71%, 
      rgba(255, 202, 185, 1)
    */
      rgba(255, 202, 185, 1) 79%,
    rgba(142, 255, 197, 1) 87%,
    rgba(255, 255, 255, 1) 100%
  );
}
.iya-iya-tidak {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(199, 189, 255);
  background-color: rgb(255, 255, 255);
  background: rgb(255, 254, 254);
  background: linear-gradient(
    90deg,
    rgba(255, 254, 254, 1) 0%,
    rgba(255, 253, 253, 1) 53%,
    /* rgba(142, 255, 197, 1) 71%, */ rgba(142, 255, 197, 1) 79%,
    rgba(255, 202, 185, 1) 87%,
    rgba(255, 255, 255, 1) 100%
  );
}
.iya-iya-tidak:hover {
  transition: 0.5s ease;
  height: 100px;
  background: rgb(255, 254, 254);
  background: linear-gradient(
    90deg,
    rgba(240, 240, 240, 1) 0%,
    rgba(240, 240, 240, 1) 53%,
    /* rgba(142, 255, 197, 1) 71%, */ rgba(142, 255, 197, 1) 79%,
    rgba(255, 202, 185, 1) 87%,
    rgba(255, 255, 255, 1) 100%
  );
}

.iya-tidak-tidak {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(73, 71, 73);
  background-color: rgb(255, 255, 255);
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgb(255, 255, 255) 0%,
    rgb(255, 255, 255) 53%,
    rgba(142, 255, 197, 1) 71%,
    rgba(255, 202, 185, 1) 79%,
    /* rgba(255, 202, 185, 1) 87%, */ rgba(255, 255, 255, 1) 100%
  );
}
.iya-tidak-tidak:hover {
  transition: 0.5s ease;
  height: 100px;
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgba(240, 240, 240, 1) 0%,
    rgba(240, 240, 240, 1) 53%,
    rgba(142, 255, 197, 1) 71%,
    rgba(255, 202, 185, 1) 79%,
    /* rgba(255, 202, 185, 1) 87%, */ rgba(255, 255, 255, 1) 100%
  );
}

/* ABA BAB */

.tidak-iya-tidak {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(224, 206, 184);
  background-color: rgb(255, 255, 255);
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgb(255, 255, 255) 0%,
    rgb(255, 255, 255) 53%,
    rgba(255, 202, 185, 1) 71%,
    rgba(142, 255, 197, 1) 79%,
    rgba(255, 202, 185, 1) 87%,
    rgba(255, 255, 255, 1) 100%
  );
}
.tidak-iya-tidak:hover {
  transition: 0.5s ease;
  height: 100px;
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgba(240, 240, 240, 1) 0%,
    rgba(240, 240, 240, 1) 53%,
    rgba(255, 202, 185, 1) 71%,
    rgba(142, 255, 197, 1) 79%,
    rgba(255, 202, 185, 1) 87%,
    rgba(255, 255, 255, 1) 100%
  );
}
.iya-tidak-iya {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(255, 150, 22);
  background-color: rgb(255, 255, 255);
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgb(255, 255, 255) 0%,
    rgb(255, 255, 255) 53%,
    rgba(142, 255, 197, 1) 71%,
    rgba(255, 202, 185, 1) 79%,
    rgba(142, 255, 197, 1) 87%,
    rgba(255, 255, 255, 1) 100%
  );
}
.iya-tidak-iya:hover {
  transition: 0.5s ease;
  height: 100px;
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgba(240, 240, 240, 1) 0%,
    rgba(240, 240, 240, 1) 53%,
    rgba(142, 255, 197, 1) 71%,
    rgba(255, 202, 185, 1) 79%,
    rgba(142, 255, 197, 1) 87%,
    rgba(255, 255, 255, 1) 100%
  );
}

.tidak-iya-iya {
  height: 70px;
  transition: 0.5s ease;
  border-left: 6px solid rgb(114, 255, 168);
  background-color: rgb(255, 255, 255);
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgb(255, 255, 255) 0%,
    rgb(255, 255, 255) 53%,
    rgba(255, 202, 185, 1) 71%,
    rgba(142, 255, 197, 1) 79%,
    /* rgba(142, 255, 197, 1) 87%, */ rgba(255, 255, 255, 1) 100%
  );
}
.tidak-iya-iya:hover {
  transition: 0.5s ease;
  height: 100px;
  background: rgb(240, 240, 240);
  background: linear-gradient(
    90deg,
    rgba(240, 240, 240, 1) 0%,
    rgba(240, 240, 240, 1) 53%,
    rgba(255, 202, 185, 1) 71%,
    rgba(142, 255, 197, 1) 79%,
    /* rgba(142, 255, 197, 1) 87%, */ rgba(255, 255, 255, 1) 100%
  );
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
  left: 10px;
  top: -18px;
  position: relative;
}

body::-webkit-scrollbar {
  display: none;
}
</style>