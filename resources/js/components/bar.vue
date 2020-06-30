<template>
  <v-app-bar
    class="print"
    app
    color="grey lighten-3"
    elevate-on-scroll
    dense
  >
    <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
    <v-toolbar-title class="grey--text text--darken-1">
      <span class="font-weight-bold"> E-MUSRENBANG </span>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <slot></slot>
    <v-btn
      icon
      color="grey darken-1"
    >
      <v-icon>notifications</v-icon>
    </v-btn>
    <v-btn
      text
      color="grey darken-1"
      @click="logout"
    >
      <v-icon left>logout</v-icon><span>Keluar</span>
    </v-btn>

  </v-app-bar>
</template>
<script>
export default {
    props:{
        value:null,
        title:null,
    },
    model: {
        prop: 'value',
        event: 'drawerClicked'
    },
    computed:{
        drawer:{
            get: function(){
                console.log(this.value);
                return this.value;
            },
            set: function(value){
                console.log("clicked")
                this.$emit('drawerClicked', value)
            }
        }
    },
    methods:{
      logout(){
        console.log("im called")
        axios.get("/logout").then(()=>{
          window.location = "login"
        });
      }
    }
};
</script>