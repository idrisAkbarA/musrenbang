import Vuex from "vuex";
import Vue from "vue";
import Axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        test: "test from Vuex",
        rawData: [],
        items:{},
        snackbar: false,
        snackbarText: "",
        snackbarColor: "",
        isTableLoading: false,
    },
    getters: {
        rawData: state => state.rawData,
        getTest: state => state.test,
        tableUsulan: state => state.rawData.data,
        barisPerHalaman: state => state.rawData.per_page,
        kelurahan_items : state => state.items["kelurahan_items"],
        pod_items :state => state.items["pod_items"],
        usulan_items: state => state.items["usulan_items"],
    },
    mutations: {
        fillRawData(state, data) {
            state.rawData = data;
        },
        fillItems(state,data){
            state.items = {
                kelurahan_items : data['kelurahan'],
                pod_items : data['pod'],
                usulan_items: data['itemUsulan'],
            };
        },
        fillSnackbar(state,dataObj){
            state.snackbarColor = dataObj.color;
            state.snackbarText = dataObj.text;
            state.snackbar = dataObj.snackbar;
        },
        toggleLoadingTable(state){
            state.isTableLoading = !state.isTableLoading; 
        }
    },
    actions: {
        loadInitData({commit,dispatch,state}){
            var ini = this;
            Axios({
                method:'get',
                url: '/itemPilihan'
            }).then(function(response){
                commit('fillItems',response.data);
                // ini.kelurahan_items = response.data['kelurahan'];
                // ini.pod_items = response.data['pod'];
                // ini.usulan_items = response.data['itemUsulan'];
                console.log("init data loaded!")
            }).catch(function (error) {
                // console.log(error);
                console.log("retrying to load init data!");
                dispatch('loadInitData');
            });
        },
        getTableUsulan({commit,dispatch,state},barisPerHalaman) {
            return new Promise((resolve, reject) => {
                commit('toggleLoadingTable');
                console.log("loading state " +state.isTableLoading);
                var ini = this;
                Axios({
                    method: "get",
                    url: "/usulFilter",
                    params: {
                        itemPerPage: barisPerHalaman
                    }
                })
                    .then(function(response) {
                        // console.log(response.data);
                        commit('fillRawData', response.data );
                        resolve(response.data);
                        commit('toggleLoadingTable');
                        console.log("loading state "+state.isTableLoading);
                    })
                    .catch(function(error) {
                        console.log("retrying load table");
                        dispatch('getTableUsulan',15);
                        // reject(error);
                    });
            });
        },
        store({commit},dataObj){
            return new Promise((resolve,reject)=>{

            })
        },
        updateTableUsulan({commit, state},dataObj) {
            return new Promise((resolve, reject) => {
                // if(dataObj.foto1){
                //     console.log("foto exist");
                // }
                // console.log(dataObj);
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
                    foto1:dataObj.foto1,
                    foto2:dataObj.foto2,
                    nama_pengusul: dataObj.nama_pengusul,
                    hp_pengusul: dataObj.hp_pengusul,
                    alamat_pengusul: dataObj.alamat_pengusul,
                    itemPerPage: state.rawData.per_page
                  })
                  .then(function (response) {
                    commit('fillRawData', response.data );
                    resolve(response.data);
                    // console.log(response.data.data);
                  })
                  .catch(function (error) {
                    // console.log(error);
                    reject(error);
                  });
            });
        },
        nextPage({commit,state}){
            return new Promise((resolve,reject)=>{
                var ini = this;
                Axios({
                    method:'get',
                    url: state.rawData.next_page_url+"&itemPerPage="+state.rawData.per_page
                }).then(function(response){
                    // console.log(response.data);
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
                    // console.log(response.data);
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
