<template>
  <div>
    <v-menu
      open-on-hover
      offset-y
      style="z-index:11"
    >
      <template v-slot:activator="{ on }">
        <v-btn
          small
          color="primary"
          dark
          v-on="on"
        >
          <v-icon left>
            add
          </v-icon>
          Tambah Usulan
        </v-btn>
      </template>

      <v-list style="z-index:11">
        <v-list-item
          style="z-index:11"
          @click.stop="dialogFisik=true"
        >
          <v-list-item-title> Fisik</v-list-item-title>
        </v-list-item>
        <v-list-item
          style="z-index:11"
          @click.stop="dialogNonFisik = true;"
        >
          <v-list-item-title>Non Fisik</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
    <fisik v-model="dialogFisik">
      <div ref="map2" style="heigh:400px; width:100%"></div>
    </fisik>
    <non-fisik v-model="dialogNonFisik"></non-fisik>
  </div>
</template>
<script>
export default {
    data() {
        return {
          platform:null,
          map:null,
            dialogFisik:false,
            dialogNonFisik:false
        }
    },
    mounted(){
      // this.setMap();
    },
    methods:{
      setMap(){
        this.platform = new H.service.Platform({
      app_id: "qTceDkYeN1H41J9FnN2n",
      apikey: "MMJUx0m9wxG9hU7fleGImjzpwlF_U_8WjSt4wYNP3Gw",
      useCIT: true,
      useHTTPS: true
    });
      console.log("map called");
      var ini = this;
      console.log(ini.$refs.map);
      const maptypes = this.platform.createDefaultLayers();

      // Instantiate (and display) a map object:
      this.map = new H.Map(ini.$refs.map, maptypes.vector.normal.map, {
        zoom: 10,
        center: { lng: 13.4, lat: 52.51 }
      });
      }
    }
};
</script>