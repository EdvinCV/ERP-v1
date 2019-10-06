<template>
    <div>
     <div class="contenedor" style="background-color=#668C2D">
      <center> <h2 style="color:#668C2D">Orden Compra</h2></center>
        </div>
     <hr>
        <v-container fluid>
            <!--LAYOUT DE CLIENTE -->
            <h6>Encargado compra</h6>
            <v-layout row>
                <v-flex lg6 md6 xs6 pa-2 >
                    <multiselect  v-model="editedItem.idEncargado" :options="compras" placeholder="Seleccione un encargado"
                        label="name" track-by="name"></multiselect>
                </v-flex>
            </v-layout>
            <h6>Información cliente</h6>
            <v-layout row>
                <v-flex lg6 md6 xs6 pa-2>
                    <multiselect  v-model="editedItem.idCliente" :options="clientes" placeholder="Seleccione un cliente"
                        label="nombreCliente" track-by="nombreCliente"></multiselect>
                </v-flex>
            </v-layout>
            <!--LAYOUT DE PRODUCTOS-->
            <h6>Ingrese productos</h6> 
            <v-layout row>
                <v-flex lg6 md6 xs6 pa-2>
                    <multiselect @input="buscarProducto()" v-model="editedItem.detProducto" :options="prods" placeholder="Seleccione un producto"
                        label="mostrar" track-by="Producto" :allowEmpty="true"></multiselect>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.cantProducto" label="Cantidad"></v-text-field>
                </v-flex>
                <v-flex xs1 sm1 md1>
                    <v-btn @click="agregarProducto()" fab dark small color="#668c2d">
                        <v-icon dark>add</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
            <!--LAYOUT PRODUCTOS INGRESADOS-->
            <h6>Listado Orden Compra</h6>
            <template>
                <v-data-table
                    :headers="headersAddP"
                    :items="carrito"
                    class="elevation-1"
                    hide-actions
                >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.nombreProducto }}</td>
                    <td class="text-xs-left">{{ props.item.presentacion }}</td>
                    <td class="text-xs-left">{{ props.item.cantidad }}</td>
                    <td class="text-xs-left">{{ props.item.nombreCliente }}</td>
                    <td class="justify-left layout px-0">
                        <v-icon small @click="eliminarProducto(props)">
                            delete
                        </v-icon>
                    </td>
                </template>
                </v-data-table>
            </template>
            <br>      
            <template>
                <v-btn @click="save" block color="#668c2d" dark>GENERAR</v-btn>
            </template>                                          
        </v-container>
    </div>
</template>

<script>
    import multiselect from 'vue-multiselect'
    export default {
        components:{
            multiselect
        },
        data: () => ({
            search: '',
            dialog: false,
            error: 0,
            errorMsj: [],
            headersAddP: [
                { text: 'Producto', value: 'producto' },
                { text: 'Presentacion', value: 'presentacion'},
                { text: 'Cantidad', value: 'cantidad'},
                { text: 'Cliente', value: 'cliente'},
                { text: 'Eliminar', value: 'eliminar'}
            ],
            carrito: [],
            prods: [],
            clientes: [],
            compras: [],
            editedIndex: -1,
            editedItem: {
               cantProducto: 0,
               detProducto: '',
               idCliente: '',
               nombreCliente: '',
            },
            defaultItem: {
              cantProducto: 0,
               detProducto: '',
               idCliente: '',
               nombreCliente: '',
            }
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Nuevo Rol' : 'Editar Rol'
            }
        },

        watch: {
            dialog(val) {
                val || this.close()
            }
        },

        created() {
            this.initialize(),
            this.cargaProductos(),
            this.cargaClientes()
            this.cargaCompras()
        },

        methods: {
            validate() {
                this.error = 0;
                this.errorMsj = [];
                if(!this.editedItem.idCliente)
                    this.errorMsj.push('Elija un cliente');
                if(!this.editedItem.idEncargado)
                    this.errorMsj.push('Elija un encargado');
                if(this.carrito == '')
                        this.errorMsj.push('No ha elejido ningún producto');
                if (this.errorMsj.length)
                    this.error = 1;
                this.editedIndex = -1;
                return this.error;
            },
            initialize() {
                axios.get('/producto')
                    .then(response => {
                        this.prods = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            cargaProductos() {
                let me = this;
                axios.get('/producto')
                .then(function (response) {
                    me.prods = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            cargaClientes() {
                let me = this;
                axios.get('/clientes')
                .then(function (response) {
                    me.clientes = response.data;

                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            cargaCompras() {
                let me = this;
                axios.get('/rolCompras')
                .then(function (response) {
                    me.compras = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            agregarProducto(){
                let me = this;
               if(this.editedItem.cantProducto <= 0 || this.editedItem.detProducto == '' || this.editedItem.idCliente == '')
                    this.mostrarAlert();
                else{
                    me.carrito.push({
                        idProd: me.editedItem.detProducto.id,
                        nombreProducto: me.editedItem.detProducto.Producto,
                        presentacion: me.editedItem.detProducto.presentacion,
                        cantidad: parseInt(me.editedItem.cantProducto),
                        cliente: me.editedItem.idCliente.id,
                        nombreCliente: me.editedItem.idCliente.nombreCliente
                    });
                    this.editedItem.cantProducto = 0;
                    this.editedItem.detProducto = '';
                }
            },
            buscarProducto(){
                let me = this;
                var producto = this.prods.filter(function(p){
                    return p.id == me.editedItem.detProducto.id;
                });
                this.editedItem.precio = producto[0].precioventa;
                this.editedItem.cantProducto = 0;
                this.editedItem.descuento = 0;
            },
            eliminarProducto(e){
                let me = this;
                var item = e.item,
                    index = this.carrito.indexOf(item);
                
                this.carrito.splice(index,1);
            },
            mostrarAlert(){
                if(this.editedItem.detProducto == ''){
                    swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Seleccione un producto.',
                            showConfirmButton: false,
                            timer: 1500});
                }
                else if(this.editedItem.cantProducto <= 0){
                    swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Ingrese una cantidad de producto.',
                            showConfirmButton: false,
                            timer: 1500});
                }
                else if(this.editedItem.idCliente == ''){
                    swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Seleccione un cliente.',
                            showConfirmButton: false,
                            timer: 1500});
                }
            },
            close() {
                this.error=0;
                this.dialog = false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },
            save() {
                let me = this;
                if (this.validate()) {
                        this.errorMsj.forEach(function(element){
                            swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: element,
                            showConfirmButton: false,
                            timer: 1500});
                        })
                        return;
                    }
                axios({
                        method: 'post',
                        url: '/compra/nuevo',
                        data: {
                            carrito: this.carrito,
                            idEncargado: this.editedItem.idEncargado.id
                        }
                    }).then(function (response) {
                        swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Orden generada',
                            showConfirmButton: false,
                            timer: 1500});
                        me.initialize();
                        me.close();
                        window.open(window.location.origin +'/compra/'+response.data+'/orden');
                        
                    }).catch(function (error) {
                        swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: error.response.data.error,
                            showConfirmButton: true});
                        me.initialize();
                        me.close();
                    });      
                    this.carrito = [];
            }
        }
    }
</script>
<style lang="scss">
    @import '~vuetify/dist/vuetify.min.css';
</style>