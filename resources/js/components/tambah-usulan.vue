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
    <fisik v-model="dialogFisik"></fisik>
    <non-fisik v-model="dialogNonFisik"></non-fisik>
  </div>
</template>
<script>
export default {
    data() {
        return {
            dialogFisik:false,
            dialogNonFisik:false
        }
    },
};
</script>