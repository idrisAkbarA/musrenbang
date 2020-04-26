/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import * as easings from 'vuetify/es5/services/goto/easing-patterns'
import Vuetify from 'vuetify'
import Axios from 'axios';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import store from './store';
Vue.use(Vuetify)
import Vuesax from 'vuesax'

import 'vuesax/dist/vuesax.css' //Vuesax styles
Vue.use(Vuesax, {
  // options here
})

  

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
Vue.component('non-fisik', require('./components/nonFisik.vue').default);
Vue.component('bar', require('./components/bar.vue').default);
Vue.component('tambah-usulan', require('./components/tambah-usulan.vue').default);
Vue.component('filter-musrenbang', require('./components/filter.vue').default);
Vue.component('experiment', require('./components/experiment.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const vuetify = new Vuetify();
const app = new Vue({
    el: '#app',
    store,
    vuetify,
    components: {
        vueDropzone: vue2Dropzone
      },
    data: ()=>({
        filter:{
            tahun:null,
            usulan:null,
            pod:null,
            alamat:null,
            verifikasi:null,
            validasi:null,
            prioritas:null,
        },

        checkProgress: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
        progressValue:0,
        
        checkProgressNonFisik: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
        progressValueNonFisik:0,
        
        snackbar:false,
        snackbarText:'',
        snackbarColor:'',
        tahun:'',
        editOverlay:false,
        overlay:false,
        overlayTable : true,

        loadingText:"Memuat...",
        result:'',
        rawData:[],
        tableUsulan:[],
        tableUsulanTemp:[],
        id:'',
        listFoto:[],
        listFile:[],
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
                return newName;
            },
            headers: {  "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content }
        },
        dropzoneOptionsFiles: {
            autoProcessQueue:false,
            acceptedFiles:'	application/msexcel,application/pdf,application/msword',
            url: '/submitFiles',
            thumbnailWidth: 200,
            maxFilesize: 8,
            maxFiles:2,
            clickable:true,
            addRemoveLinks: true,
            renameFile:function(file) {
                let newName = new Date().getTime() + '-' + file.name;
                return newName;
            },
            headers: {  "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content }
        },
        barisPerHalaman: null,
        dialogDelete:false,
        dialogFoto:false,
        dialogFisik:false,
        dialogNonFisik:false,
        drawer: null,
        loading: false, //* loading halaman
        show1: false, //*password
        dialog: false, //*password
        fad:false, // transition fade
        on:"border-left: 6px solid orange; z-index:999;",
        off:"border-left: 6px solid orange;",
        hasSaved: false,
        model: null,
        usulanNonFisik:"",
        podNonFisik: "",
        alasan_usulanNonFisik: "",
        informasi_tambahanNonFisik: "",
        outputNonFisik: "",
        nama_pengusulNonFisik: "",
        hp_pengusulNonFisik: "",
        alamat_pengusulNonFisik: "",
        
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
        jumlahFoto:0,
        jumlahFile:0,
        easing: 'easeInOutCubic',
        easings: Object.keys(easings),
        deleteId: -1,
        deleteIdTable: -1,
        carousselList:[],
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
    watch:{
        podNonFisik:function(val){
            this.calcProgressValue(val,0);
        },
        usulanNonFisik:function(val){
            this.calcProgressValueNonFisik(val,1);
        },
        outputNonFisik:function(val){
            this.calcProgressValueNonFisik(val,4);
        },
        alasan_usulanNonFisik:function(val){
            this.calcProgressValueNonFisik(val,7);
        },
        nama_pengusulNonFisik:function(val){
            this.calcProgressValueNonFisik(val,12);
        },
        hp_pengusulNonFisik:function(val){
            this.calcProgressValueNonFisik(val,13);
        },
        alamat_pengusulNonFisik:function(val){
            this.calcProgressValueNonFisik(val,14);
        },


        pod:function(val){
            this.calcProgressValue(val,0);
        },
        usulan:function(val){
            this.calcProgressValue(val,1);
        },
        volume:function(val){
            this.calcProgressValue(val,2);
        },
        satuan:function(val){
            this.calcProgressValue(val,3);
        },
        output:function(val){
            this.calcProgressValue(val,4);
        },
        jumlahFoto:function(val){
            if(this.jumlahFoto>1||this.jumlahFoto<1){
                this.calcProgressValue(val,5);
            }
        },
        jumlahFile:function(val){
            if(this.jumlahFile>1||this.jumlahFile<1){
                this.calcProgressValue(val,6);
            }
        },
        alasan_usulan:function(val){
            this.calcProgressValue(val,7);
        },
        alamat:function(val){
            this.calcProgressValue(val,8);
        },
        rt:function(val){
            this.calcProgressValue(val,9);
        },
        rw:function(val){
            this.calcProgressValue(val,10);
        },
        kelurahan:function(val){
            this.calcProgressValue(val,11);
        },
        nama_pengusul:function(val){
            this.calcProgressValue(val,12);
        },
        hp_pengusul:function(val){
            this.calcProgressValue(val,13);
        },
        alamat_pengusul:function(val){
            this.calcProgressValue(val,14);
        },

    },
    methods:{
        tahunItems(){
            var awalTahun = 2020;
            var date = new Date();
            var currentTahun = Number(date.getFullYear());
            var tahunList=[];
            for (let index = awalTahun; index <= currentTahun; index++) {
                tahunList.push(index)
            }
            tahunList.push('Semua');
            console.log(tahunList);
            return tahunList;
        },
        update(){
            console.log("woi");
            var ini = this;
            axios.post('/usul/update', {
                id:ini.tableUsulanTemp.id,
                usulan:ini.tableUsulanTemp.usulan,
                kelurahan:ini.tableUsulanTemp.kelurahan,
                pod: ini.tableUsulanTemp.pod,
                volume: ini.tableUsulanTemp.volume,
                satuan: ini.tableUsulanTemp.satuan,
                alamat: ini.tableUsulanTemp.alamat,
                alasan_usulan: ini.tableUsulanTemp.alasan_usulan,
                informasi_tambahan: ini.tableUsulanTemp.informasi_tambahan,
                output: ini.tableUsulanTemp.output,
                rt: ini.tableUsulanTemp.rt,
                rw: ini.tableUsulanTemp.rw,
                nama_pengusul: ini.tableUsulanTemp.nama_pengusul,
                hp_pengusul: ini.tableUsulanTemp.hp_pengusul,
                alamat_pengusul: ini.tableUsulanTemp.alamat_pengusul,
                itemPerPage: ini.rawData.per_page
              })
              .then(function (response) {
                ini.editOverlay = false;
                ini.tableUsulan = response.data.data;
                ini.overlay = false;
                ini.snackbarText = "Usulan berhasil diperbarui!"
                ini.snackbarColor = "success"
                ini.snackbar = true;
                console.log(response.data.data);
              })
              .catch(function (error) {
                console.log(error);
                ini.editOverlay = false;
                ini.snackbarText = "Terjadi kesalahan coba lagi!"
                ini.snackbarColor = "error"
                ini.snackbar = true;
              });
              this.dialogFisik = false;
        },
        caroussel(index){
            this.carousselList = [];
            if(index == 0){
                this.carousselList.push(this.foto1());
                this.carousselList.push(this.foto2());
            }else{
                this.carousselList.push(this.foto2());
                this.carousselList.push(this.foto1());
            }
            console.log(index);
            this.dialogFoto = true;
        },
        downloadFilePendukung(id){
            if(id==1){
                window.open('/files/'+this.tableUsulanTemp.file1)
            }else{
                window.open('/files/'+this.tableUsulanTemp.file2)

            }
        },
        deleteUsulanConfirmed(){
            var ini = this;
            ini.snackbar = false;
            this.loading = true;
            this.dialogDelete = false;
            axios.post('/usul/hapus', {
                id:ini.deleteId,
              })
              .then(function (response) {
                ini.loading = false;

                ini.snackbarText = "Usulan berhasil dihapus!"
                ini.snackbarColor = "success"
                ini.snackbar = true;
                ini.tableUsulan.splice(ini.deleteIdTable, 1)
              })
              .catch(function (error) {
                this.loading = false;
                ini.snackbarText = "Terjadi kesalahan, coba lagi"
                ini.snackbarColor = "error"
                ini.snackbar = true;
              });
        },
        deleteUsulan(index){
            this.dialogDelete = true;
            var ini = this;
            ini.deleteIdTable = index;
            ini.deleteId = ini.tableUsulan[index]['id'];
        },
        calcProgressValue(value,index){
            if(value==null||value==""){
                if(this.checkProgress[index] == 0){
                    this.checkProgress[index] = 0; 
                }else{
                    this.checkProgress[index] = 0; 
                    this.progressValue = this.progressValue - 6.66666666667 ;
                }
            }else{
                if(this.checkProgress[index] == 0){
                    this.checkProgress[index] = 1; 
                    this.progressValue = this.progressValue + 6.66666666667 ;
                }else{
                    this.checkProgress[index] = 1; 
                }
            }
            console.log(this.progressValue,this.checkProgress);
        },
        calcProgressValueNonFisik(value,index){
            if(value==null||value==""){
                if(this.checkProgressNonFisik[index] == 0){
                    this.checkProgressNonFisik[index] = 0; 
                }else{
                    this.checkProgressNonFisik[index] = 0; 
                    this.progressValue = this.progressValue - 6.66666666667 ;
                }
            }else{
                if(this.checkProgressNonFisik[index] == 0){
                    this.checkProgressNonFisik[index] = 1; 
                    this.progressValue = this.progressValue + 6.66666666667 ;
                }else{
                    this.checkProgressNonFisik[index] = 1; 
                }
            }
            console.log(this.progressValue,this.checkProgressNonFisik);
        },
        filterReset(){
            this.filter= {
                tahun:null,
                usulan:null,
                pod:null,
                alamat:null,
                verifikasi:null,
                validasi:null,
                prioritas:null,
            };
        },
        filterTest(){
            var ini = this;
            ini.overlayTable =true;
            console.log(ini.rawData.per_page);
            Axios({
                method:'get',
                url: '/usul/testFilter',params:{
                    filter:ini.filter,
                    perPage:ini.rawData.per_page
                }
            }).then(function(response){
                ini.rawData = response.data;
                ini.tableUsulan = ini.rawData.data;
                console.log(response.data);
                ini.overlayTable =false;
            })
            .catch(function (error) {
                console.log(error);
            
            });
        },
        loadTableWithFilter(itemPerPage){
            var ini = this;
            ini.overlayTable =true;
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
                ini.overlayTable =false;
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
            ini.overlayTable =true;
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
                ini.overlayTable =false;
            })
            // .catch(function (error) {
            //     console.log(error);
            //     console.log("retrying to load table data!");
            //     ini.loadDataTable();
            // });
           
        },
        previousPage(){
            var ini = this;
            ini.overlayTable =true;
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
                ini.overlayTable =false;
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
            return this.tableUsulan[index].loading_verifikasi;
        },
        loader_valid(index){
            return this.tableUsulan[index].loading_validasi;
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
            this.tableUsulan[index].loading_verifikasi = true;
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
                    ini.tableUsulan[index].loading_verifikasi = false;
                    ini.snackbarText = "Status usulan berhasil diperbarui!"
                    ini.snackbarColor = "success"
                    ini.snackbar = true;
                }else{
                    ini.tableUsulan[index].loading_verifikasi = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
                }
              })
              .catch(function (error) {
                console.log(error);
                ini.tableUsulan[index].loading_verifikasi = false;
                ini.tableUsulan[index].loading_verifikasi = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
              });
        },
        validasi(index){
            
            var ini = this;
            var result = this.tableUsulan[index].validasi;
            this.tableUsulan[index].loading_validasi = true;
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
                    ini.tableUsulan[index].loading_validasi = false;
                    ini.snackbarText = "Status usulan berhasil diperbarui!"
                    ini.snackbarColor = "success"
                    ini.snackbar = true;
                }else{
                    ini.tableUsulan[index].loading_validasi = false;
                    ini.tableUsulan[index].loading_verifikasi = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
                }
              })
              .catch(function (error) {
                console.log(error);
                ini.tableUsulan[index].loading_validasi = false;
                ini.tableUsulan[index].loading_verifikasi = false;
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
                    ini.tableUsulan[index].loading_verifikasi = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
                }
              })
              .catch(function (error) {
                console.log(error);
                ini.tableUsulan[index].loading_prioritas = false;
                ini.tableUsulan[index].loading_verifikasi = false;
                    ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    ini.snackbarColor = "error"
                    ini.snackbar = true;
              });
        },
        send(){
            var option ={
                duration: 300,
                offset: 10,
                container:"#scrolling-techniques-7"
              };
            var isEmpty = this.isFieldEmpty();
            if(isEmpty != -1){
                this.$vuetify.goTo(isEmpty,option);
            }else{
                this.loadingText = "Mengunggah Foto..";
                this.overlay = true;
                this.$refs.myVueDropzone.processQueue();
            }
        },
        isFieldEmpty(){
            var target = -1; 
            for (let i = 0; i < this.checkProgress.length; i++) {
                if(this.checkProgress[i]==0){
                    target = "#s" +(i+1) ;
                    break;
                }
                
            }
            return target;
        },
        photosUploaded(){
            this.loadingText = "Mengunggah File..";
            this.$refs.myVueDropzoneFiles.processQueue();
        },
        filesUploaded(){
            this.loadingText = "Mengunggah rincian usulan..";
            setTimeout(() => {
                this.sendUsulanDetail();
              }, 1000)
        },
        afterComplete(file){
            this.listFoto.push(file.upload.filename);
            console.log(this.listFoto);
        },
        afterCompleteFiles(file){
            this.listFile.push(file.upload.filename);
            console.log(this.listFoto);
        },
        sendUsulanDetail(){
            console.log("woi");
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
                file1: ini.listFile[0],
                file2: ini.listFile[1],
                rt: ini.rt,
                rw: ini.rw,
                nama_pengusul: ini.nama_pengusul,
                hp_pengusul: ini.hp_pengusul,
                alamat_pengusul: ini.alamat_pengusul,
                itemPerPage: ini.rawData.per_page
              })
              .then(function (response) {
                ini.tableUsulan = response.data.data;
                ini.overlay = false;
                ini.snackbarText = "Usulan berhasil disimpan!"
                ini.snackbarColor = "success"
                ini.snackbar = true;
                console.log(response.data.data);
              })
              .catch(function (error) {
                console.log(error);
                ini.snackbarText = "Terjadi kesalahan coba lagi!"
                ini.snackbarColor = "error"
                ini.snackbar = true;
              });
              this.dialogFisik = false;
        },
        edit(index){
            this.tableUsulanTemp= this.tableUsulan[index];
            this.editOverlay= true;
            console.log(index, this.tableUsulanTemp);
        },
        foto1(){
            var a = 'images/'+this.tableUsulanTemp.foto1; 
            return a.replace(" ", '%20');
        },
        foto2(){
            var a = 'images/'+this.tableUsulanTemp.foto2; 
            return a.replace(" ", '%20');
        },
        fotoAdded(file){
            this.jumlahFoto+=1;
            console.log(this.jumlahFoto);
        },
        fileAdded(file){
            this.jumlahFile+=1;
            console.log(this.jumlahFile);
        },
        batalNonFisik(){
            this.dialogNonFisik = false;
            this.usulan ="";
            this.pod="";
            this.alasan_usulan="";
            this.informasi_tambahan="";
            this.output="";
            this.listFile=[];
            this.nama_pengusul="";
            this.hp_pengusul="";
            this.alamat_pengusul="";
        },
        batal(){
            this.dialogFisik = false;
            this.overlay = false;
            this.usulan ="";
            this.kelurahan="";
            this.pod="";
            this.volume="";
            this.satuan="";
            this.alamat="";
            this.alasan_usulan="";
            this.informasi_tambahan="";
            this.output="";
            this.listFoto=[];
            this.listFile=[];
            this.jumlahFile=0;
            this.jumlahFoto=0;
            this.rt="";
            this.rw="";
            this.nama_pengusul="";
            this.hp_pengusul="";
            this.alamat_pengusul="";

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
