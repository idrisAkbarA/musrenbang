/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify'
import Axios from 'axios';

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
    data: ()=>({
        drawer: true,
        loading: false, //* loading halaman
        show1: false, //*password
        dialog: false, //*password
        fad:false // transition fade
    }),
    beforeMount(){
        var that= this;
        this.transitionEndFunction(function() {
            that.fad=!that.fad;  
            console.log("ayam")
        });
        
    },
    methods:{
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
