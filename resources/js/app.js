/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify'
import Axios from 'axios';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
Vue.use(Vuetify)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('drawer', require('./components/drawer.vue').default);
Vue.component('toolbar', require('./components/toolbar.vue').default);
Vue.component('timeline', require('./components/timeline.vue').default);
Vue.component('musrenbang', require('./components/musrenbang.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const vuetify = new Vuetify();
const app = new Vue({
    el: '#app',
    vuetify,
    components: {
        vueDropzone: vue2Dropzone
      },
    data: ()=>({
        snackbar:false,
        snackbarText:'',
        snackbarColor:'',
        editOverlay:true,
        overlay:false,
        loadingText:"Memuat...",
        result:'',
        rawData:[],
        tableUsulan:[],
        id:'',
        listFoto:[],
        dropzoneOptions: {
            autoProcessQueue:false,
            acceptedFiles:'image/*',
            url: '/submitFoto',
            thumbnailWidth: 200,
            maxFilesize: 8,
            maxFiles:2,
            clickable:true,
            addRemoveLinks: true,
            renameFile:function(file) {
                let newName = new Date().getTime() + '-' + file.name;
                //this.listFoto.push(newName);
                console.log(this.listFoto);
                return newName;
            },
            headers: {  "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content }
        },
        barisPerHalaman: null,
        dialogFisik:false,
        dialogNonFisik:false,
        drawer: true,
        loading: false, //* loading halaman
        show1: false, //*password
        dialog: false, //*password
        fad:false, // transition fade
        on:"border-left: 6px solid orange; z-index:999;",
        off:"border-left: 6px solid orange;",
        hasSaved: false,
        model: null,
        usulan:"",
        pod: "",
        volume: "",
        satuan: "",
        alamat: "",
        alasan_usulan: "",
        informasi_tambahan: "",
        output: "",
        rt: "",
        rw: "",
        nama_pengusul: "",
        hp_pengusul: "",
        alamat_pengusul: "",
        kelurahan:'',
        pod_items: [
        ],
        usulan_items: [
        ],
        kelurahan_items:[],
    }),
    beforeMount(){
        var ini = this;
        this.loadTableWithFilter(15);
        // this.loadDataTable();
        this.loadInitData();
        console.log(window.innerWidth);
        var that= this;
        this.transitionEndFunction(function() {
            that.fad=!that.fad;  
        });
        
    },
    
    methods:{
        loadTableWithFilter(itemPerPage){
            var ini = this;
            Axios({
                method:'get',
                url: '/usulFilter',params:{
                    itemPerPage: itemPerPage,
                }
            }).then(function(response){
                console.log(response.data);
                ini.rawData = response.data;
                ini.tableUsulan = ini.rawData.data;
                ini.barisPerHalaman = ini.rawData.per_page;
                console.log(ini.rawData);
                console.log(ini.tableUsulan);
                console.log("table data loaded!")
            })
            .catch(function (error) {
                console.log(error);
                console.log("retrying to load table data!");
                ini.loadTableWithFilter(itemPerPage);
            });
           
        },
        barisTiapHalaman(jumlah){
            var itemPerPage;
            if(jumlah == '5'){
                itemPerPage = 5;
            }else if(jumlah == '15'){
                itemPerPage = 15;
            }else{
                itemPerPage = this.rawData.total;
            }
            console.log(itemPerPage);
    
            this.loadTableWithFilter(itemPerPage);
        },
        isNextDisabled(){
            if(this.rawData.next_page_url == null){
                return true;
            }else{
                return false;
            }
        },
        isPrevDisabled(){
            if(this.rawData.prev_page_url == null){
                return true;
            }else{
                return false;
            }
        },
        nextPage(){
            var ini = this;
            //console.log(ini.rawData.next_page_url+"$itemPerPage="+ini.barisPerHalaman);
            Axios({
                method:'get',
                url: ini.rawData.next_page_url+"&itemPerPage="+ini.barisPerHalaman
            }).then(function(response){
                console.log(response.data);
                ini.rawData = response.data;
                ini.tableUsulan = ini.rawData.data;
                console.log(ini.rawData);
                console.log(ini.tableUsulan);
                console.log("table data loaded!")
            })
            // .catch(function (error) {
            //     console.log(error);
            //     console.log("retrying to load table data!");
            //     ini.loadDataTable();
            // });
           
        },
        previousPage(){
            var ini = this;
            Axios({
                method:'get',
                url: ini.rawData.prev_page_url+"&itemPerPage="+ini.barisPerHalaman
            }).then(function(response){
                console.log(response.data);
                ini.rawData = response.data;
                ini.tableUsulan = ini.rawData.data;
                console.log(ini.rawData);
                console.log(ini.tableUsulan);
                console.log("table data loaded!")
            })
            // .catch(function (error) {
            //     console.log(error);
            //     console.log("retrying to load table data!");
            //     ini.loadDataTable();
            // });
           
        },
        loadDataTable(){
            var ini = this;
            Axios({
                method:'get',
                url: '/usul'
            }).then(function(response){
                console.log(response.data);
                ini.rawData = response.data;
                ini.tableUsulan = ini.rawData.data;
                console.log(ini.rawData);
                console.log(ini.tableUsulan);
                console.log("table data loaded!")
            })
            .catch(function (error) {
                console.log(error);
                console.log("retrying to load table data!");
                ini.loadDataTable();
            });
           
        },
        loadInitData(){
            var ini = this;
            Axios({
                method:'get',
                url: '/itemPilihan'
            }).then(function(response){
                ini.kelurahan_items = response.data['kelurahan'];
                ini.pod_items = response.data['pod'];
                ini.usulan_items = response.data['itemUsulan'];
                console.log("init data loaded!")
            }).catch(function (error) {
                console.log(error);
                console.log("retrying to load init data!");
                ini.loadInitData();
            });
        },
        loader_verif(index){
            return this.tableUsulan[index].loading_verif;
        },
        loader_valid(index){
            return this.tableUsulan[index].loading_valid;
        },
        loader_prioritas(index){
            return this.tableUsulan[index].loading_prioritas;
        },
        styling(index){
            //console.log("index: "+index + " " + this.tableUsulan[index].validasi)
            if(this.tableUsulan[index].validasi == null || this.tableUsulan[index].validasi == "tidak" ){
                return "belum-validasi"
            }else if(this.tableUsulan[index].verifikasi == null || this.tableUsulan[index].verifikasi == "tidak"){
                return "validasi";
            }else if(this.tableUsulan[index].prioritas == null || this.tableUsulan[index].prioritas == "tidak"){
                return "verifikasi";
            }else{
                return "prioritasx";
            }
        },
        verifikasi(index){
            var ini = this;
            var result = this.tableUsulan[index].verifikasi;
            this.tableUsulan[index].loading_verif = true;
            if(this.tableUsulan[index].verifikasi == "iya"){
                result = "tidak"
            }else{
                result = "iya" 
            }
            ini.snackbar = false;
            console.log(ini.tableUsulan[index].verifikasi);
            axios.post('/verif', {
                id:ini.tableUsulan[index].id,
                verifikasi: result
              })
              .then(function (response) {
                console.log(response);
                if(response.data == true){
                    console.log(result);
                    ini.tableUsulan[index].verifikasi = result;
                    ini.tableUsulan[index].loading_verif = false;
                    ini.snackbarText = "Status usulan berhasil diperbarui!"
                    ini.snackbarColor = "success"
                    ini.snackbar = true;
                }else{
                    ini.tableUsulan[index].loading_verif = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
                }
              })
              .catch(function (error) {
                console.log(error);
                ini.tableUsulan[index].loading_verif = false;
                ini.tableUsulan[index].loading_verif = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
              });
        },
        validasi(index){
            
            var ini = this;
            var result = this.tableUsulan[index].validasi;
            this.tableUsulan[index].loading_valid = true;
            if(this.tableUsulan[index].validasi == "iya"){
                result = "tidak"
            }else{
                result = "iya" 
            }
            ini.snackbar = false;
            axios.post('/valid', {
                id:ini.tableUsulan[index].id,
                validasi: result
              })
              .then(function (response) {
                console.log(response);
                if(response.data == true){
                    console.log(result);
                    ini.tableUsulan[index].validasi = result;
                    ini.tableUsulan[index].loading_valid = false;
                    ini.snackbarText = "Status usulan berhasil diperbarui!"
                    ini.snackbarColor = "success"
                    ini.snackbar = true;
                }else{
                    ini.tableUsulan[index].loading_valid = false;
                    ini.tableUsulan[index].loading_verif = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
                }
              })
              .catch(function (error) {
                console.log(error);
                ini.tableUsulan[index].loading_valid = false;
                ini.tableUsulan[index].loading_verif = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
              });
        },
        prioritas(index){
            this.tableUsulan[index].loading_prioritas = true;
            var ini = this;
            var result = this.tableUsulan[index].prioritas;
            if(this.tableUsulan[index].prioritas == "iya"){
                result = "tidak"
            }else{
                result = "iya" 
            }
            ini.snackbar = false;
            axios.post('/prioritas', {
                id:ini.tableUsulan[index].id,
                prioritas: result
              })
              .then(function (response) {
                console.log(response.data);
                if(response.data == true){
                    console.log(result);
                    ini.tableUsulan[index].prioritas = result;
                    ini.tableUsulan[index].loading_prioritas = false;
                    ini.snackbarText = "Status usulan berhasil diperbarui!"
                    ini.snackbarColor = "success"
                    ini.snackbar = true;
                }else{
                    ini.tableUsulan[index].loading_prioritas = false;
                    ini.tableUsulan[index].loading_verif = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
                }
              })
              .catch(function (error) {
                console.log(error);
                ini.tableUsulan[index].loading_prioritas = false;
                ini.tableUsulan[index].loading_verif = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
              });
        },
        send(){
            this.loadingText = "Mengunggah Foto..";
            this.overlay = true;
            this.$refs.myVueDropzone.processQueue();
        },
        photosUploaded(){
            this.loadingText = "Menyimpan rincian usulan..";
            setTimeout(() => {
                this.sendUsulanDetail();
              }, 1000)
            
        },
        afterComplete(file){
            this.listFoto.push(file.upload.filename);
            console.log(this.listFoto);
        },
        sendUsulanDetail(){
            var ini = this;
            axios.post('/usul', {
                usulan:ini.usulan,
                kelurahan:ini.kelurahan,
                pod: ini.pod,
                volume: ini.volume,
                satuan: ini.satuan,
                alamat: ini.alamat,
                alasan_usulan: ini.alasan_usulan,
                informasi_tambahan: ini.informasi_tambahan,
                output: ini.output,
                foto1: ini.listFoto[0],
                foto2: ini.listFoto[1],
                rt: ini.rt,
                rw: ini.rw,
                nama_pengusul: ini.nama_pengusul,
                hp_pengusul: ini.hp_pengusul,
                alamat_pengusul: ini.alamat_pengusul,
              })
              .then(function (response) {
                ini.tableUsulan = response.data;
                ini.overlay = false;
                ini.snackbarText = "Usulan berhasil disimpan!"
                ini.snackbarColor = "success"
                ini.snackbar = true;
                console.log(response);
              })
              .catch(function (error) {
                console.log(error);
              });
              this.dialogFisik = false;
        },
        fileAdded(file){
            console.log(file.upload.filename);
        },
        batal(){
         this.dialogFisik = false;
         this.overlay = false;
        },
        
        initUsulFisik(){ //get user info ketika ingin mengajukan usulan
            var ini = this;
            Axios.get('/init').then(response=>{
                ini.id = response.data['id'];
                ini.kelurahan = response.data['kelurahan'];
                console.log(ini.id,ini.kelurahan);
                console.log('dialog');
                this.dialogFisik=true

            })
        },
        test(){
            console.log('dialog');
            this.dialogFisik=true
        },
        //method callback transisi halaman
        transitionEndFunction(_callback){
            this.fad= true;
        console.log(this.fad);
        setTimeout(() => { _callback(); }, 100);
            
        },
        transitionFunction(_callback){
            this.loading=true;
            this.fad=!this.fad;
            console.log('test'+this.drawer);
            _callback();
        },

        // dibawah fungsi link pindah halaman
        dashboard(){
            this.transitionFunction(function() {
                window.location.href = '/dashboard';
            });
        },
        musrenbang(){
            this.transitionFunction(function() {
                window.location.href = '/musrenbang';
            });
        },
        pengumuman(){
            this.transitionFunction(function() {
                window.location.href = '/';
            });
        },
    }


});
