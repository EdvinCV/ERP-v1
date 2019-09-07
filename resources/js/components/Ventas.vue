<template>
    <div>
        <h2>Venta</h2>
        <v-switch 
            v-model="switchFact"
            :label = "`Generar Factura`"
        ></v-switch>
        <v-container>
                            <v-layout wrap>
                                <v-flex xs6 sm6 md6>
                                    <multiselect @input="buscarNIT()" v-model="editedItem.idCliente" :options="clientes" placeholder="Seleccione un cliente"
                                            label="nombreCliente" track-by="nombreCliente"></multiselect>
                                </v-flex>
                                <v-flex xs3 sm3 md3>
                                    <v-text-field v-model="editedItem.nit" label="NIT" readonly></v-text-field>
                                </v-flex>
                                <v-flex xs3 sm3 md3>
                                    <v-text-field v-model="editedItem.direccion" label="Dirección"></v-text-field>
                                </v-flex>
                            </v-layout>
                                <h6>Ingrese productos</h6>
                            <v-layout wrap>
                                <v-flex xs7 sm7 md7>
                                    <multiselect @input="buscarProducto()" v-model="editedItem.detProducto" :options="roles" placeholder="Seleccione un producto"
                                            label="Producto" track-by="Producto"></multiselect>
                                </v-flex>
                                <v-flex xs2 sm2 md2>
                                    <v-text-field v-model="editedItem.cantProducto" label="Cantidad" ></v-text-field>
                                </v-flex>
                                <v-flex xs2 sm2 md2>
                                    <v-text-field v-model="editedItem.precio" label="Precio"></v-text-field>
                                </v-flex>
                                <v-flex xs1 sm1 md1>
                                    <v-btn @click="agregarProducto()" fab dark small color="primary">
                                        <v-icon dark>add</v-icon>
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                                <h6>Productos ingresados</h6>
                                <template>
                                    <v-data-table
                                        :headers="headersAddP"
                                        :items="carrito"
                                        class="elevation-1"
                                        hide-actions
                                    >
                                        <template v-slot:items="props">
                                            <td class="text-xs-left">{{ props.item.idProd }}</td>
                                            <td class="text-xs-left">{{ props.item.nombreProducto }}</td>
                                            <td class="text-xs-left">{{ props.item.cantidad }}</td>
                                            <td class="text-xs-left">{{ props.item.iva }}</td>
                                            <td class="text-xs-left">{{ props.item.sub }}</td>
                                            <td class="justify-center layout px-0">
                                                <v-icon small @click="eliminarProducto(props)">
                                                    delete
                                                </v-icon>
                                            </td>
                                        </template>
                                    </v-data-table>
                                    <v-text-field v-model="editedItem.total" label="Total" readonly></v-text-field>
                                </template>                                
                            <v-layout wrap>
                            </v-layout>
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
            headers: [
                {
                    text: 'Id',
                    align: 'left',
                    value: 'id'
                },
                { text: 'Rol', value: 'nombreRol' },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            headersAddP: [
                {
                    text: 'No.',
                    align: 'left',
                    value: 'contador'
                },
                { text: 'Producto', value: 'prod' },
                { text: 'Cantidad', value: 'action'},
                { text: 'IVA', value: 'prod' },
                { text: 'Subtotal', value: 'prod' },
            ],
            roles: [],
            carrito: [],
            prods: [],
            clientes: [],
            editedIndex: -1,
            editedItem: {
                id: 0,
                nombreRol: '',
                idCliente: '',
                nit: '',
                direccion: '',
                detProducto: '',
                cantProducto: '',
                ivaProd: '',
                subtotal: '',
                total: ''
            },
            defaultItem: {
                id: 0,
                nombreRol: '',
                nit: '',
                direccion: ''
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
                return this.error;
            },
            initialize() {
                axios.get('/producto')
                    .then(response => {
                        this.roles = response.data;
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
            },
            agregarProducto(){
                let me = this;
                me.carrito.push({
                    idProd: 5,
                    nombreProducto: me.editedItem.detProducto,
                    cantidad: parseInt(me.editedItem.cantProducto),
                    iva: parseFloat(me.editedItem.ivaProd),
                    sub: parseInt(me.editedItem.cantProducto) * parseFloat(me.editedItem.ivaProd)
                });
                me.calcularTotal();
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
                me.editedItem.total = t;
            },
            editItem(item) {
                this.editedIndex = this.roles.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar este Rol?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/Rol/${item.id}/delete`).then(response => {
                            me.initialize();
                            swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: response.data,
                            showConfirmButton: false,
                            timer: 1500});
                        }).catch(error => {
                            swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: error.response.data.error,
                            showConfirmButton: true});
                        });
                    }
                });
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
                        return;
                    }
                if (this.editedIndex > -1) {
                    axios({
                        method: 'put',
                        url: '/rol/editar',
                        data: {
                            id:this.editedItem.id,
                            nombre: this.editedItem.nombreRol
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
                        console.log(error.response);
                        swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: error.response.data.error,
                            showConfirmButton: true});
                        me.initialize();
                        me.close();
                    });                    
                } else {
                    axios({
                        method: 'post',
                        url: '/rol/nuevo',
                        data: {
                            nombre: me.editedItem.nombreRol
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
                }
            }
        }
    }
</script>
<style lang="scss">
    @import '~vuetify/dist/vuetify.min.css';
</style>