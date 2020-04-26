<template>
    <div>
         <v-menu open-on-hover offset-y style="z-index:11"> 
                        <template v-slot:activator="{ on }">
                            <v-btn small color="primary" dark v-on="on">
                                <v-icon left>
                                    add
                                </v-icon>
                                Tambah Usulan
                            </v-btn>
                        </template>

                        <v-list style="z-index:11">
                            <v-list-item style="z-index:11" @click.stop="initUsulFisik()">
                                <v-list-item-title> Fisik</v-list-item-title>
                            </v-list-item>
                            <v-list-item style="z-index:11" @click.stop="dialogNonFisik = true;">
                                <v-list-item-title>Non Fisik</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
    </div>
</template>
<script>
export default {
    
}
</script>