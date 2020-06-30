<template>
  <div>
    <div class="d-flex flex-row mb-5" style="width:100%" >
      <v-icon>
        announcement
      </v-icon>
      <span class="mt-2">
        Daftar Items Usulan
      </span>
      <v-spacer></v-spacer>
      <v-btn
        @click="dialogTambah=true"
        color="primary"
      >Tambah Item</v-btn>
    </div>
    <v-skeleton-loader
      type="table"
      :loading="isTableLoading"
      transition="fade-transition"
    >
      <div>

        <v-data-table
          class="elevation-10"
          :fixed-header="true"
          height="65vh"
          :headers="headers"
          :items="items"
          hide-default-footer
          :page.sync="page"
          :items-per-page="itemsPerPage"
          @page-count="pageCount = $event"
        >

          <template v-slot:item.nama="{ item }">
           
                <div
                 
                  class="d-flex flex-row"
                  style="width:100%"
                > <v-tooltip top open-delay="500" v-model="item.tooltip">
              <template v-slot:activator="{ on, attrs }">
                  <input
                    v-bind="attrs"
                    v-on="on"
                    @click="showBtn(item)"
                    @keyup="isDifference(item)"
                    @focus="focused(item)"
                    style="width:100%"
                    class="custom-input"
                    type="text"
                    v-model="item.nama"
                    spellcheck="false"
                  >
                   </template>
              <span>Click untuk meng-edit item</span>
            </v-tooltip>
                  <v-spacer></v-spacer>
                  <v-btn
                    text
                    :ref="'rowB'+item.index"
                    class="ml-1"
                    :class="{ 'opacity-0': !item.isShown }"
                    @click="batal(item)"
                  >
                    batal
                  </v-btn>
                  <v-btn
                    :disabled="item.isDisabled"
                    :class="{ 'opacity-0': !item.isShown }"
                    class="ml-1"
                    color="primary"
                    @click="simpan(item)"
                  >
                    Simpan
                  </v-btn>
                  <v-btn
                    icon
                    @click="deleteItem(item)"
                  >
                    <v-icon>delete</v-icon>
                  </v-btn>
                </div>
             

          </template>
        </v-data-table>
        <div>
          <v-row>
            <v-col cols="12">
              <v-hover>
                <template v-slot="{ hover }">
                  <v-card
                    width="600"
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
                            Baris per halaman: {{itemsPerPage}} <v-icon>
                              arrow_drop_down</v-icon>
                          </div>
                        </v-card-text>
                      </template>

                      <v-list>
                        <v-list-item @click="itemsPerPage = 10">
                          <v-list-item-title>10</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="itemsPerPage = 25">
                          <v-list-item-title>25</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="itemsPerPage = items.length">
                          <v-list-item-title>semua</v-list-item-title>
                        </v-list-item>
                      </v-list>
                    </v-menu>

                    <v-divider vertical></v-divider>
                    <!-- <v-card-text> {{rawData.from}} - {{rawData.to}} dari -->
                    <v-card-text>Halaman {{page}} dari {{pageCount}},
                      Total items: {{items.length}}</v-card-text>
                    <v-btn
                      :disabled="isPrevDisabled()"
                      @click="page--"
                      class="mt-2"
                      icon
                    >
                      <v-icon>keyboard_arrow_left</v-icon>
                    </v-btn>
                    <v-btn
                      :disabled="isNextDisabled()"
                      @click="page++"
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
      </div>
    </v-skeleton-loader>
    <v-dialog
      width="550"
      v-model="dialogTambah"
    >
      <v-card>
        <v-card-title class="add-header">
          <v-icon color="black">
            add
          </v-icon>
          <span>
            Tambah Usulan
          </span>
          <v-spacer></v-spacer>
          <v-btn
            text
            @click="dialogTambah = false"
          >
            Batal
          </v-btn>
          <v-btn
            dark
            class="primary"
            @click="tambah()"
          >
            Tambah
          </v-btn>
        </v-card-title>
        <v-card-text >
         <v-text-field class="mt-8" v-model="tambahField" outlined label="Nama usulan"></v-text-field>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog
      width="400"
      v-model="dialogDelete"
    >
      <v-card>
        <v-card-title class="delete-header">
          <v-icon color="black">
            delete
          </v-icon>
          <span>
            Hapus Item
          </span>
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
            @click="deleteConfirmed()"
          >
            <v-icon left> delete</v-icon>
            Hapus
          </v-btn>
        </v-card-title>
        <v-card-text class="mt-2">
          Apakah anda yakin ingin menghapus item:
          <p style="font-weight:bold">
            {{itemtoDelete.nama}}?
          </p>
        </v-card-text>
      </v-card>
    </v-dialog>
        <v-snackbar
      v-model="sn"
      :color="snackbarColor"
      dark
      
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
import { mapMutations, mapState } from "vuex";
export default {
  data() {
    return {
      headers: [
        {
          text: "No.",
          value: "index",
          align: "center",
          width: 80
        },
        {
          text: "Nama",
          value: "nama"
        }
        // { text: "Aksi", value: "actions", sortable: false }
      ],
      isDisabled: true,
      tempInput: "",
      page: 1,
      pageCount: 0,
      itemsPerPage: 10,
      baseUrl: "/usulan/",
      items: [],
      itemsDefault: [],
      dialogDelete: false,
      dialogTambah: false,
      itemtoDelete: "",
      tambahField:'',
    };
  },
  computed: {
    ...mapState(["snackbar", "snackbarColor", "snackbarText", "isTableLoading"]),
    sn: {
      get: function() {
        console.log(this.snackbar);
        return this.snackbar;
      },
      set: function(value) {
        this.fillSnackbar({ snackbar: value, color: "", text: "" });
      }
    },
  },
  beforeMount() {
    this.getData();
  },
  methods: {
    ...mapMutations(["fillSnackbar", "toggleLoadingTable"]),
    tambah(){
      this.toggleLoadingTable();
      axios.get(this.baseUrl + "add",{ params:{
        nama:this.tambahField
      }}).then(response=>{
        this.initData(response);
        this.fillSnackbar({ snackbar: true, color: "success", text: "Item berhasil di tambahkan!" });
        this.toggleLoadingTable();
        this.dialogTambah = false;
      }).catch(error=>{
        this.fillSnackbar({ snackbar: true, color: "error", text: "Terjadi kesalahan, coba lagi!" });
      })
    },
    deleteConfirmed() {
      this.toggleLoadingTable();
      axios.get(this.baseUrl + "delete",{params:{
        id: this.itemtoDelete.id
      }}).then(response=>{
        this.initData(response);
        this.toggleLoadingTable();
        this.fillSnackbar({ snackbar: true, color: "success", text: "Item berhasil di hapus!" });
        this.dialogDelete = false;
      }).catch(error=>{
        this.initData();
        this.toggleLoadingTable();
        this.fillSnackbar({ snackbar: true, color: "error", text: "Terjadi kesalahan! coba lagi" });
      })
    },
    deleteItem(item) {
      this.dialogDelete = true;
      this.itemtoDelete = item;
    },
    showBtn(item) {
      this.items = JSON.parse(JSON.stringify(this.itemsDefault));
      this.items[item.index - 1].isShown = true;

      for (let index = 0; index < this.items.length; index++) {
        const element = this.items[index];
        if (element.index == item.index) {
          continue;
        } else {
          element.isShown = false;
        }
      }
      console.log(this.tempInput);
      console.log(item);
    },
    isDifference(item) {
      var row = "row" + item.index;

      if (item.nama == this.tempInput) {
        this.items[item.index - 1].isDisabled = true;
      } else {
        this.items[item.index - 1].isDisabled = false;
      }
      console.log(item.nama);
      console.log(this.itemsDefault[item.index - 1].nama);
    },
    focused(item) {
      this.tempInput = item.nama;
      this.items[item.index - 1].tooltip = false;
    },
    batal(item) {
      this.items[item.index - 1].nama = this.tempInput;
      this.items[item.index - 1].isShown = false;
      this.items[item.index - 1].isDisabled = true;
    },
    blured(item) {
      this.items[item.index - 1].nama = this.tempInput;
      // this.items[item.index-1].isShown=false;
      // this.items[item.index-1].isDisabled=true;
    },
    simpan(item) {
      this.toggleLoadingTable();
      axios
        .get(this.baseUrl + "update", {
          params: {
            id: item.id,
            nama: item.nama
          }
        })
        .then(response => {
          this.initData(response);
          this.toggleLoadingTable();

          this.fillSnackbar({ snackbar: true, color: "success", text: "Item berhasil di update!" });
        this.dialogDelete = false;
        })
        .catch(error => {
          this.fillSnackbar({ snackbar: true, color: "success", text: "Item berhasil di update!" });
        this.dialogDelete = false;
        });
    },
    getData() {
      this.toggleLoadingTable();
      axios
        .get(this.baseUrl + "items")
        .then(response => {
          this.initData(response);
          this.toggleLoadingTable();
        })
        .catch(error => {
          console.log("uhm error?");
        });
    },
    initData(response) {
      var itemTemp = response.data;
      var i = 1;
      itemTemp.forEach(element => {
        element["index"] = i++;
        element["isDisabled"] = true;
        element["isShown"] = false;
        element["tooltip"] = false;
      });

      this.items = itemTemp;
      this.itemsDefault = JSON.parse(JSON.stringify(itemTemp));
      console.log(this.items);
    },
    isPrevDisabled() {
      return this.page == 1 ? true : false;
    },
    isNextDisabled() {
      return this.page == this.pageCount ? true : false;
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
.simp-enter-active {
  animation: simp 2s;
}
.simp-leave-active {
  animation: simp 2s reverse;
}
.opacity-1 {
  opacity: 1;
  transition: 0.2s ease;
}
.opacity-0 {
  opacity: 0;
  transition: 0.2s ease;
}
.custom-input {
  border-top: 2px solid transparent;
  border-bottom: 2px solid transparent;
  transition: 0.2s ease;
}
.custom-input:focus {
  /* padding: 12px 12px; */
  border-bottom: 2px solid rgb(64, 184, 64);
  transition: 0.2s ease;
  /* border: 3px solid #555; */
}
.delete-header {
  background: linear-gradient(-90deg, rgb(255, 70, 70), rgb(255, 255, 255));
  background-position: 50px 0px;
  background-repeat: no-repeat;
}
.add-header {
  background: linear-gradient(-90deg, rgb(70, 255, 110), rgb(255, 255, 255));
  background-position: 50px 0px;
  background-repeat: no-repeat;
}
</style>
