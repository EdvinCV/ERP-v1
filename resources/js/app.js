
require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify';
Vue.use(Vuetify);

import swal from 'sweetalert2';
window.swal = swal;


Vue.component('ordenescompra', require('./components/OrdenesCompra.vue').default);
Vue.component('Usuarios', require('./components/Usuarios.vue').default);
Vue.component('categoria', require('./components/Categoria.vue').default);
Vue.component('Roles', require('./components/Roles.vue').default);
Vue.component('Permisos', require('./components/Permisos.vue').default);
Vue.component('Presentacion', require('./components/Presentacion.vue').default);
Vue.component('Proveedor', require('./components/Proveedores.vue').default);
Vue.component('Cliente', require('./components/Clientes.vue').default);
Vue.component('Venta', require('./components/Ventas.vue').default);
Vue.component('Producto', require('./components/Producto.vue').default);
Vue.component('Historialcalidad', require('./components/Historialcalidad.vue').default);
Vue.component('Historialventas', require('./components/Historialventas.vue').default);
Vue.component('Orden', require('./components/Orden.vue').default);
Vue.component('Caja', require('./components/Caja.vue').default);
Vue.component('Acaja', require('./components/Acaja.vue').default);
Vue.component('chart', require('./components/chart.vue').default);
Vue.component('reportes', require('./components/reportes.vue').default);
Vue.component('reportes_prov', require('./components/reportesProv.vue').default);
Vue.component('reportes_clientes', require('./components/reportesClientes.vue').default);
Vue.component('reportes_compras', require('./components/reportesCompras.vue').default);
Vue.component('Ccaja', require('./components/Ccaja.vue').default);


const app = new Vue({
    el: '#app',
    data:{
        menu:101,
        ruta:''
    },
});
