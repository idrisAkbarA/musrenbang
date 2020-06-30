<template>
  <div>
      <slot name="activator" v-bind:open="open">
          
      </slot>
    <v-dialog v-model="test" max-width="400px" persistent>
      <v-card>
         <v-app-bar
          style="background: linear-gradient(-90deg, rgb(142, 241, 108), rgb(255, 255, 255));
                                background-position:50px 0px;
                                background-repeat: no-repeat;
"
          
          color="white"
        >
          <v-toolbar-title>Ubah Kata Sandi</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn
            text
            @click="batal"
          >batal</v-btn>
          <v-btn
            :loading="loading"
            class="primary"
            @click="ubah"
          >Ubah</v-btn>
        </v-app-bar>
        
        <v-card-text>
          <v-text-field outlined v-model="old" label="Kata sandi lama" class="mt-10"></v-text-field>
          <v-text-field outlined v-model="newPass" label="Kata sandi baru"></v-text-field>
          <v-text-field outlined v-model="confirm" label="Konfirmasi kata sandi baru"></v-text-field>
          <!-- <v-card-actions>
            <v-btn text>batal</v-btn>
            <v-btn color="primary">Ubah kata sandi</v-btn>
          </v-card-actions> -->
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      test:false,
      old:"",
      newPass:"",
      confirm:"",
      loading: false,
    }
  },
  methods:{
    open(){
      this.test = true;
    },
    ubah(){
      this.loading = true;
      axios.post('/changepass',{
        old:this.old,
        new:this.newPass
        }).then(response=>{
          if(response.data.status == 'ok'){
            this.loading = false;
            this.batal();
          }else{
            this.loading = false;
          }
        })
    },
    batal(){
      this.test = false;
      this.old = "";
      this.newPass = "";
      this.confirm = "";
    }
  }
};
</script>

<style>
</style>