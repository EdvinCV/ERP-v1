
require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify';
Vue.use(Vuetify);

import swal from 'sweetalert2';
window.swal = swal;

import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import Multiselect from 'vue-multiselect';
Vue.component('v-select', vSelect)


Vue.component('categoria', require('./components/Categoria.vue').default);
Vue.component('Roles', require('./components/Roles.vue').default);
Vue.component('Permisos', require('./components/Permisos.vue').default);
Vue.component('Presentacion', require('./components/Presentacion.vue').default);
Vue.component('Producto', require('./components/Producto.vue').default);
Vue.component('Historialcalidad', require('./components/Historialcalidad.vue').default);



const app = new Vue({
    el: '#app',
    data:{
        menu:0,
        ruta:''
    }
});
