<template>
  <v-menu
    :close-on-content-click="false"
    offset-y
    :nudge-right="200"
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
                @click="filterTest()"
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
          <v-col cols="4">
              <!-- :items="usulan_items" -->
            <v-combobox
              dense
              prepend-inner-icon="announcement"
              outlined
              v-model="filter.usulan"
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
              label="Organisasi Perangkat Daerah"
            >
            </v-combobox>
          </v-col>
          <v-col cols="4">
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
              <!-- :items="kelurahan_items" -->
            <v-autocomplete
              dense
              v-model="filter.kelurahan"
              prepend-inner-icon="map"
              outlined
              label="kelurahan"
            >
            </v-autocomplete>
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

</template>
]<script>
export default {
  data() {
    return {
      filter: {
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