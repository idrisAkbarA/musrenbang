<template>
  <div>
    <v-btn
      v-if="false"
      text
    >Reset Pencarian/Filter</v-btn>
    <v-menu
      :close-on-content-click="false"
      offset-y
      :nudge-right="200"
      v-model="toggle"
    >
      <template v-slot:activator="{ on }">
        <v-btn
          class="ml-2 mr-2"
          small
          icon
          color="indigo"
          dark
          v-on="on"
        >
          <v-icon>
            search
          </v-icon>
        </v-btn>
      </template>

      <v-card width="100vw">
        <v-container>
          <v-row
            class="ml-2 mr-2"
            dense
          >
            <v-col cols="12">
              <div class="title d-flex">
                Pencarian/Filter
                <v-spacer></v-spacer>
                <v-btn
                  @click="filterReset()"
                  small
                  text
                >
                  <v-icon left>
                    close
                  </v-icon>
                  Reset
                </v-btn>
                <v-btn
                  @click="filterGet()"
                  small
                  class="primary"
                  dark
                >
                  <v-icon left>
                    search
                  </v-icon>
                  Cari
                </v-btn>
              </div>

            </v-col>
            <v-col
              cols="12"
              sm="6"
              md="2"
            >
              <v-autocomplete
                :items="tahunItems()"
                dense
                v-model="filter.tahun"
                prepend-inner-icon="event"
                outlined
                label="Tahun"
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="3">
              <!-- :items="kelurahan_items" -->
              <v-autocomplete
                dense
                v-model="filter.kelurahan"
                prepend-inner-icon="map"
                outlined
                :items="kelurahan_items_final"
                label="kelurahan"
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="2">
              <!-- :items="usulan_items" -->
              <v-autocomplete
                dense
                prepend-inner-icon="announcement"
                outlined
                v-model="filter.jenis"
                :items="['-','Fisik','Non Fisik']"
                label="Jenis"
              ></v-autocomplete>
            </v-col>
            <v-col cols="5">
              <!-- :items="usulan_items" -->
              <v-combobox
                dense
                prepend-inner-icon="announcement"
                outlined
                v-model="filter.usulan"
                :items="usulan_items"
                label="Usulan"
              ></v-combobox>
            </v-col>

            <v-col cols="6">
              <!-- :items="pod_items" -->
              <v-combobox
                dense
                prepend-inner-icon="account_balance"
                v-model="filter.pod"
                outlined
                :items="pod_items"
                label="Organisasi Perangkat Daerah"
              >
              </v-combobox>
            </v-col>
            <v-col cols="6">
              <v-text-field
                v-model="filter.alamat"
                outlined
                dense
                prepend-inner-icon="place"
                label="Alamat"
              >
              </v-text-field>
            </v-col>

            <v-col cols="2">
              <v-autocomplete
                dense
                v-model="filter.verifikasi"
                prepend-inner-icon="done"
                outlined
                :items="['-','Tidak','Iya']"
                label="Verifikasi"
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="2">
              <v-autocomplete
                dense
                v-model="filter.validasi"
                prepend-inner-icon="done_all"
                outlined
                :items="['-','Tidak','Iya']"
                label="Validasi"
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="2">
              <v-autocomplete
                dense
                v-model="filter.prioritas"
                prepend-inner-icon="library_add_check"
                outlined
                :items="['-','Tidak','Iya']"
                label="Prioritas"
              >
              </v-autocomplete>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-menu>
  </div>
</template>
]<script>
import { mapGetters,mapActions, mapMutations,mapState } from "vuex";
export default {
  computed: {
    ...mapState(['isItemsLoaded']),
    ...mapGetters([      
      "kelurahan_items",
      "pod_items",
      "usulan_items",
      "barisPerHalaman"]),
      isFiltered(){
        for (let index = 0; index < this.filter.length; index++) {
          const element = this.filter[index];
          if (element != null){
            return true;
          }
        }
        return false
      }
  },
  watch:{
    isItemsLoaded:function(value){
      if(value == true){
        this.kelurahan_items_final = this.kelurahan_items;
        this.kelurahan_items_final.unshift('-');
        console.log(this.kelurahan_items);
      } 
    }
  },
  data() {
    return {
      kelurahan_items_final:[],
      toggle:false,
      filter: {
        jenis: null,
        tahun: null,
        usulan: null,
        pod: null,
        alamat: null,
        verifikasi: null,
        validasi: null,
        prioritas: null
      }
    };
  },
  methods: {
    ...mapActions(['getFilter','getTableUsulan']),
    ...mapMutations(['fillFilter']),
    filterGet() {
      this.fillFilter(this.filter);
      this.toggle = false;
      this.getFilter(this.filter);
   
    },
    filterReset() {
      this.fillFilter(null);
      this.getTableUsulan(this.barisPerHalaman);
      this.filter = {
        jenis: "Non Fisik",
        tahun: null,
        usulan: null,
        pod: null,
        alamat: null,
        verifikasi: null,
        validasi: null,
        prioritas: null
      };
    },
    tahunItems() {
      var awalTahun = 2020;
      var date = new Date();
      var currentTahun = Number(date.getFullYear());
      var tahunList = [];
      for (let index = awalTahun; index <= currentTahun; index++) {
        tahunList.push(index);
      }
      tahunList.push("Semua");
      console.log(tahunList);
      return tahunList;
    }
  }
};
</script>