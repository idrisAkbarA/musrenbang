<template>
    <div>
        <div>
            <v-icon>
                info
            </v-icon>
            <span class="mt-2">
                Pengumuman
            </span>
        </div>
        <v-timeline dense>
            <v-timeline-item v-for="(item, index) in items" :key="index" color="red" small>
                <v-row>
                    <v-col cols="2">
                        <strong>1 January 2019</strong>
                    </v-col>
                    <v-col>
                        <v-card elevation="10" style="border-left: 4px solid red;">
                            <v-card-title>
                        <strong>New Icon</strong>
                            </v-card-title>
                        <v-card-text>
                            {{item.nama}}
                        </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-timeline-item>
        </v-timeline>
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

</style>
