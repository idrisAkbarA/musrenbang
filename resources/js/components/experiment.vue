<template>
  <div>
    <v-card>

      <v-card-text>
        Experiment preview gambar berhasil
        <v-img
          :src="img"
          height="125"
          width="125"
        >
        </v-img>
        <!-- @change="seeme()" -->
        <v-file-input
          accept="image/*"
          label="photo"
          v-model="imgtest"
        >

        </v-file-input>
        <v-divider>
        </v-divider>

        Experiment calling axios in vuex
        <v-btn
          class="primary"
          @click="getVuex()"
        >get data</v-btn>
        <v-textarea v-model="tableUsulan"></v-textarea>

        Experiment update via axios in vuex
        <v-btn
          class="primary"
          @click="storeVuex()"
        >get data</v-btn>
        Experiment update via axios in vuex (table)
        <table>
          <thead>
            <tr
              class="red kepala"
              style="z-index:1000"
            >
              <th>No.</th>
              <th>Nama</th>
              <th>Kelompok</th>
              <th>Volume</th>
              <th>Kelurahan</th>
              <th style="width:200px">Organisasi Perangkat Daerah</th>
              <th style="z-index:10">Verifikasi</th>
              <th style="z-index:10">Validasi</th>
              <th style="z-index:10">Prioritas</th>
              <th style="z-index:10">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, index) in tableUsulan"
              :key="item.id"
            >
              <td class="number">@{{index+rawData.from}}</td>
              <td>@{{item.usulan}}</td>
              <td>Fisik</td>
              <td>@{{item.volume}}</td>
              <td>Air Hitam</td>
              <td>@{{item.pod}}</td>

              <td>
                <v-btn
                  :loading="loader_verif(index)"
                  @click="verifikasi(index)"
                  text
                >
                  @{{item.verifikasi}}
                </v-btn>
              </td>
              <td>
                <v-btn
                  :loading="loader_valid(index)"
                  @click="validasi(index)"
                  text
                >
                  @{{item.validasi}}
                </v-btn>
              </td>
              <td>
                <v-btn
                  :loading="loader_prioritas(index)"
                  @click="prioritas(index)"
                  text
                >
                  @{{item.prioritas}}
                </v-btn>
              </td>
              <td style="width:100px">
                <v-btn
                  icon
                  @click="edit(index)"
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
      </v-card-text>

    </v-card>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["tableUsulan", "rawData"])
  },
  data() {
    return {
      img: "/img/logo.gif",
      imgtest: null
    };
  },
  watch: {
    imgtest: function(val) {
      const reader = new FileReader();
      var ini = this;
      reader.addEventListener(
        "load",
        function() {
          // convert image file to base64 string
          ini.img = reader.result;
        },
        false
      );
      if (val) {
        reader.readAsDataURL(val);
      }
      console.log(val);
    }
  },
  methods: {
    loader_verif(index) {
      return this.tableUsulan[index].loading_verifikasi;
    },
    loader_valid(index) {
      return this.tableUsulan[index].loading_validasi;
    },
    loader_prioritas(index) {
      return this.tableUsulan[index].loading_prioritas;
    },
    ...mapActions({
      init: "getTableUsulan",
      update: "updateTableUsulan"
    }),
    
    getVuex() {
      var ini = this;
      this.init(15).then(function(response) {
        console.log(ini.rawData);
      });
    },
    storeVuex() {
      var data = {
        id: "1",
        usulan: "makan",
        kelurahan: "delima",
        pod: "popod",
        volume: "0.1m x 0.1mm",
        satuan: "m",
        alamat: "alamat",
        alasan_usulan: "iseng",
        informasi_tambahan: "hmmm",
        output: "have fun",
        rt: "03",
        rw: "-1",
        nama_pengusul: "idris",
        hp_pengusul: "honor",
        alamat_pengusul: "alamat"
      };
      this.update(data);
    }
  }
};
</script>