import Vuex from "vuex";
import Vue from "vue";
import Axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        test: "test from Vuex",
        rawData: [],
        
    },
    getters: {
        rawData: state => state.rawData,
        getTest: state => state.test,
        tableUsulan: state => state.rawData.data,
        barisPerHalaman: state => state.rawData.per_page,
    },
    mutations: {
        fillRawData(state, data) {
            state.rawData = data;
        }
    },
    actions: {
        getTableUsulan({commit},barisPerHalaman) {
            return new Promise((resolve, reject) => {
                var ini = this;
                Axios({
                    method: "get",
                    url: "/usulFilter",
                    params: {
                        itemPerPage: barisPerHalaman
                    }
                })
                    .then(function(response) {
                        console.log(response.data);
                        commit('fillRawData', response.data );

                        // ini.rawData = response.data;
                        // ini.tableUsulan = ini.rawData.data;
                        // ini.barisPerHalaman = ini.rawData.per_page;
                        // console.log(ini.rawData);
                        // console.log(ini.tableUsulan);
                        // console.log("table data loaded!");
                        resolve(response.data);
                    })
                    .catch(function(error) {
                        console.log(error);
                        reject(error);
                    });
            });
        },
        updateTableUsulan({commit, state},dataObj) {
            return new Promise((resolve, reject) => {
                console.log("woi");
                var ini = this;
                axios.post('/usul/update', {
                    id:dataObj.id,
                    usulan:dataObj.usulan,
                    kelurahan:dataObj.kelurahan,
                    pod: dataObj.pod,
                    volume: dataObj.volume,
                    satuan: dataObj.satuan,
                    alamat: dataObj.alamat,
                    alasan_usulan: dataObj.alasan_usulan,
                    informasi_tambahan: dataObj.informasi_tambahan,
                    output: dataObj.output,
                    rt: dataObj.rt,
                    rw: dataObj.rw,
                    nama_pengusul: dataObj.nama_pengusul,
                    hp_pengusul: dataObj.hp_pengusul,
                    alamat_pengusul: dataObj.alamat_pengusul,
                    itemPerPage: state.rawData.per_page
                  })
                  .then(function (response) {
                    commit('fillRawData', response.data );
                    resolve(response.data);
                    //   ini.editOverlay = false;
                    // ini.overlay = false;
                    // ini.snackbarText = "Usulan berhasil diperbarui!"
                    // ini.snackbarColor = "success"
                    // ini.snackbar = true;
                    console.log(response.data.data);
                  })
                  .catch(function (error) {
                    console.log(error);
                    reject(error);
                    // ini.editOverlay = false;
                    // ini.snackbarText = "Terjadi kesalahan coba lagi!"
                    // ini.snackbarColor = "error"
                    // ini.snackbar = true;
                  });
                //   this.dialogFisik = false;
            });
        },
        nextPage({commit,state}){
            return new Promise((resolve,reject)=>{
                var ini = this;
                Axios({
                    method:'get',
                    url: state.rawData.next_page_url+"&itemPerPage="+state.rawData.per_page
                }).then(function(response){
                    console.log(response.data);
                    commit('fillRawData', response.data );
                    console.log("table data loaded!")
                    // ini.overlayTable =false;
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
            });
        },
        prevPage({commit,state}){
            return new Promise((resolve,reject)=>{
                var ini = this;
                Axios({
                    method:'get',
                    url: state.rawData.prev_page_url+"&itemPerPage="+state.rawData.per_page
                }).then(function(response){
                    console.log(response.data);
                    commit('fillRawData', response.data );
                    console.log("table data loaded!")
                    // ini.overlayTable =false;
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
            });
        },
        updateStatus({commit,getters},obj){ //* update status ketika user "toggle" button status
        return new Promise((resolve,reject)=>{
            getters.tableUsulan[obj.index]["loading_"+obj.status] = true;
            var result = getters.tableUsulan[obj.index][obj.status];
     

            (result === "iya") ? result = "tidak" : result = "iya";

            var payload={};
            payload['id'] = getters.tableUsulan[obj.index].id;
            payload[`${obj.status}`] = result; // key object dibuat dinamik sesuai obj.status
            console.log(payload);
            axios.post('/'+obj.status, 
            payload
            )
            .then(function (response) {
                console.log(response.data);
               
                    console.log(result);
                    getters.tableUsulan[obj.index][obj.status] = result;
                    getters.tableUsulan[obj.index]["loading_"+obj.status] = false;
                    resolve(response.data);
                    // ini.snackbarText = "Status usulan berhasil diperbarui!"
                    // ini.snackbarColor = "success"
                    // ini.snackbar = true;
         
                    // ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    // ini.snackbarColor = "error"
                    // ini.snackbar = true;
                
              })
              .catch(function (error) {
                console.log(error);
                getters.tableUsulan[obj.index]["loading_"+obj.status] = false;
                    // ini.snackbarText = "Terjadi kesalahan, coba lagi"
                    // ini.snackbarColor = "error"
                    // ini.snackbar = true;
                    reject(error);
              });
        })
        
        },
    }
});
