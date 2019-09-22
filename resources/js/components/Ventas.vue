<template>
    <div>
        <h2>Venta</h2>
        <v-switch 
            v-model="switchFact"
            :label = "`Generar Factura`"
        ></v-switch>
        <v-container fluid>
            <!--LAYOUT DE CLIENTE -->
            <h6>Información cliente</h6>
            <v-layout row>
                <v-flex lg6 md6 xs6 pa-2>
                    <multiselect @input="buscarNIT()" v-model="editedItem.idCliente" :options="clientes" placeholder="Seleccione un cliente"
                        label="nombreCliente" track-by="nombreCliente"></multiselect>
                </v-flex>
                <v-flex lg3 md3 xs6 pa-2>
                    <v-text-field v-model="editedItem.nit" label="NIT" readonly></v-text-field>
                </v-flex>
                <v-flex lg3 md3 xs6 pa-2>
                    <v-text-field v-model="editedItem.direccion" label="Dirección"></v-text-field>
                </v-flex>
            </v-layout>
            <!--LAYOUT DE PRODUCTOS-->
            <h6>Ingrese productos</h6> 
            <v-layout row>
                <v-flex lg6 md6 xs6 pa-2>
                    <multiselect @input="buscarProducto()" v-model="editedItem.detProducto" :options="prods" placeholder="Seleccione un producto"
                        label="Producto" track-by="Producto" :allowEmpty="true"></multiselect>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field v-model="editedItem.cantProducto" label="Cantidad"></v-text-field>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field v-model="editedItem.precio" label="Precio"></v-text-field>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field v-model="editedItem.descuento" label="Descuento" ></v-text-field>
                </v-flex>
                <v-flex xs1 sm1 md1>
                    <v-btn @click="agregarProducto()" fab dark small color="primary">
                        <v-icon dark>add</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
            <!--LAYOUT PRODUCTOS INGRESADOS-->
            <h6>Productos ingresados</h6>
            <template>
                <v-data-table
                    :headers="headersAddP"
                    :items="carrito"
                    class="elevation-1"
                    hide-actions
                >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.nombreProducto }}</td>
                    <td class="text-xs-left">{{ props.item.cantidad }}</td>
                    <td class="text-xs-left">{{ props.item.precio }}</td>
                    <td class="text-xs-left">{{ props.item.sub }}</td>
                    <td class="justify-center layout px-0">
                        <v-icon small @click="eliminarProducto(props)">
                            delete
                        </v-icon>
                    </td>
                </template>
                </v-data-table>
                <v-layout row>
                    <v-flex lg6 md6 xs2 pa-2>
                        <v-text-field v-model="editedItem.subtotal" label="Subtotal" readonly></v-text-field>
                    </v-flex>
                    <v-flex lg6 md6 xs2 pa-2>
                        <v-text-field v-model="editedItem.total" label="Total" readonly></v-text-field>
                    </v-flex>
                </v-layout>
            </template>      
            <template>
                <v-btn @click="save" block color="success" dark>GENERAR</v-btn>
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
            switchFact: false,
            errorMsj: [],
            headersAddP: [
                { text: 'Descripcion', value: 'prod' },
                { text: 'Cantidad', value: 'action'},
                { text: 'Precio', value: 'pu'},
                { text: 'Valor', value: 'prod' },
            ],
            carrito: [],
            prods: [],
            clientes: [],
            editedIndex: -1,
            editedItem: {
                id: 0,
                idCliente: '',
                nit: '',
                direccion: '',
                detProducto: '',
                cantProducto: '',
                precio: '',
                subtotal: '',
                descuento: '',
                total: ''
            },
            defaultItem: {
                idCliente: '',
                nit: '',
                direccion: '',
                detProducto: '',
                cantProducto: '',
                precio: '',
                subtotal: '',
                descuento: '',
                total: ''
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
        },

        methods: {
            validate() {
                this.error = 0;
                this.errorMsj = [];
                if (!this.editedItem.nombreRol)
                    this.errorMsj.push('El nombre del rol no puede estar vacio');
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
            buscarNIT(){
                let me = this;
                var cliente = this.clientes.filter(function(c){
                    return c.id == me.editedItem.idCliente.id;
                });
                console.log(cliente[0].nit);
                this.editedItem.nit = cliente[0].nit;
                this.editedItem.direccion = cliente[0].direccion;
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
            agregarProducto(){
                let me = this;
                me.carrito.push({
                    idProd: 5,
                    nombreProducto: me.editedItem.detProducto.Producto,
                    cantidad: parseInt(me.editedItem.cantProducto),
                    precio: me.editedItem.detProducto.precioventa,
                    sub: parseInt(me.editedItem.cantProducto) * parseFloat(me.editedItem.detProducto.precioventa)
                });
                me.calcularTotal();
                me.editedItem.cantProducto = 0;
                me.editedItem.precio = 0;
                me.editedItem.descuento = 0;        
                console.log(me.carrito); 
            },
            eliminarProducto(e){
                let me = this;
                var item = e.item,
                    index = this.carrito.indexOf(item);
                
                this.carrito.splice(index,1);
                me.calcularTotal();
            },
            calcularTotal(){
                let me = this;
                var t = 0;
                me.carrito.forEach(function(e){
                    t += e.sub;
                })
                me.editedItem.subtotal = t;
                var iva = t*0.12;
                me.editedItem.total = t + iva ;
            },
            save() {
                let me = this;
                axios({
                        method: 'post',
                        url: '/venta/nuevo',
                        data: {
                            total: this.editedItem.total,
                            subtotal: this.editedItem.subtotal,
                            idCliente: this.editedItem.idCliente.id,
                            carrito: this.editedItem.carrito
                        }
                    }).then(function (response) {
                        swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: response.data,
                            showConfirmButton: false,
                            timer: 1500});
                        me.initialize();
                        me.close();
                    }).catch(function (error) {
                        swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: error.response.data.error,
                            showConfirmButton: true});
                        me.initialize();
                        me.close();
                    });      
                    console.log(this.editedItem.idCliente);
            }
        }
    }
</script>
<style lang="scss">
    @import '~vuetify/dist/vuetify.min.css';
</style>