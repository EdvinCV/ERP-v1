<template>
    <div>
         <div class="contenedor" style="backgrounhd-color=#668C2D">
      <center> <h2 style="color:#668C2D">Ordenes de Compra</h2></center>
        </div>
     <hr>
        <!-- FINALIZAR ORDEN DE COMPRA --> 
        <v-toolbar flat color="white">
            <v-text-field v-model="search" append-icon="search" label="Buscar" single-line hide-details></v-text-field>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="600px">
                <v-card>
                    
                    <v-card-title style="background-color:#668c2d">
                        <span class="headline" style="color:#fff">Finalizar Orden Compra #{{this.editedItem.orden}}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout>
                                <v-flex xs1 sm1 md1>
                                    <v-btn @click="contadorMenos()" fab dark small color="#668c2d">
                                        <v-icon dark>fas fa-arrow-alt-circle-left</v-icon>
                                    </v-btn>
                                </v-flex>
                                <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field readonly v-model="editedItem.producto"></v-text-field>
                                </v-flex>
                                <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field readonly v-model="editedItem.nombreProveedor"></v-text-field>
                                </v-flex>
                                <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field v-model="editedItem.precioCompra"></v-text-field>
                                </v-flex>
                                <v-flex xs1 sm1 md1>
                                    <v-btn @click="contadorMas()" fab dark small color="#668c2d">
                                        <v-icon dark>fas fa-arrow-alt-circle-right</v-icon>
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                                
                            <v-flex lg12 md12 xs12 pa-2>
                                    <v-text-field label="Gastos parqueo" v-model="editedItem.parqueo"></v-text-field>
                                </v-flex>
                                <v-flex lg12 md12 xs12 pa-2>
                                    <v-text-field label="Gastos Combustible" v-model="editedItem.combustible"></v-text-field>
                                </v-flex>
                                <v-flex lg12 md12 xs12 pa-2>
                                    <v-text-field label="Gastos varios" v-model="editedItem.gastosVarios"></v-text-field>
                                </v-flex>
                                <v-flex lg12 md12 xs12 pa-2>
                                    <v-text-field label="Observaciones" v-model="editedItem.observaciones"></v-text-field>
                                </v-flex>
                        </v-container>
                <template v-if="error">
                        <v-divider></v-divider>
                        <div class="text-xs-center">
                            <strong class="red--text text--lighten-1" v-for="e in errorMsj" :key="e" v-text="e"></strong>
                            <br>
                        </div>
                        <v-divider></v-divider>
                    </template>
                    </v-card-text>
        
            
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" flat @click="close">Cerrar</v-btn>
                        <v-btn color="green darken-1" flat @click="save">Guardar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>

    <!--EDITAR ORDEN-->
            <v-dialog v-model="dialogEditar"  persistent max-width="700px">
                <v-card>

                    <v-card-title style="background-color:#668c2d">
                        <span style="color:#fff" class="headline">Editar Orden Compra #{{this.editedItem.orden}}</span>
                    </v-card-title>
                   
                    <v-card-text>
                        <h6>Seleccione cliente</h6>
                        <v-layout row>
                            <v-flex lg6 md6 xs6 pa-2>
                                <multiselect  v-model="editedItem.idCliente" :options="clientes" placeholder="Seleccione un cliente"
                                        label="nombreCliente" track-by="nombreCliente"></multiselect>
                            </v-flex>
                        </v-layout>
                        
                        <h6>Seleccione productos</h6> 
                        <v-layout row>
                            <v-flex lg6 md6 xs6 pa-2>
                                <multiselect v-model="editedItem.detProducto" :options="prods" placeholder="Seleccione un producto"
                                            label="mostrar" track-by="Producto" :allowEmpty="true"></multiselect>
                            </v-flex>
                            <v-flex lg2 md2 xs2 pa-2>
                                <v-text-field v-model="editedItem.cantProducto" label="Cantidad"></v-text-field>
                            </v-flex>
                            <v-flex xs1 sm1 md1>
                                <v-btn @click="agregarProducto()" fab dark small color="primary">
                                    <v-icon dark>add</v-icon>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                           
                        <v-alert :value="this.editedItem.bandera" type="error">
                           {{this.editedItem.errorMsj}}
                        </v-alert>
                        <v-data-table :headers="headersApp" :items="detalles" class="elevation-1" hide-actions>
                            
                            <template v-slot:items="props">
                                <td class="text-xs-left">{{ props.item.producto }}</td>
                                <td class="text-xs-left">{{ props.item.presentacion }}</td>
                                <td class="text-xs-left">{{ props.item.cantidad }}</td>
                                <td class="text-xs-left">{{ props.item.nombreCliente }}</td>
                                <td class="text-xs-left"></td>
                                <td class="justify-center layout px-0">
                                    <v-icon left small @click="eliminarProducto(props)">
                                        delete
                                    </v-icon>
                                </td>
                            </template>
                        </v-data-table> 
                        <br>
                                 
                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="blue darken-1" flat @click="close">Cerrar</v-btn>
                        <v-btn color="blue darken-1" flat @click="editarCompra">Guardar</v-btn>
                    </v-card-actions>

                </v-card>
            </v-dialog>
           <v-card-title>
        
        <div class="flex-grow-1"></div>
   
      </v-card-title>
            <v-data-table :headers="headers" :items="ordenes" class="elevation-1" :search="search">
            
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.id }}</td>
                    <td class="text-xs-left">{{ props.item.totalCompra }}</td>
                    <td class="text-xs-left">Q. {{ props.item.totalVenta }}</td>
                    <td class="text-xs-left">{{ props.item.created_at }}</td>
                    <td class="text-xs-left"><v-chip :color="getColor(props.item.finalizado)" dark>{{ verEstado(props.item.finalizado) }}</v-chip></td>
                    <td class="justify-center layout px-0">
                        <v-icon v-if="!props.item.finalizado" small class="mr-2" title="Imprimir orden" @click="imprimirOrden(props.item.id)">
                            print
                        </v-icon>
                        <v-icon v-if="props.item.finalizado" class="mr-2" small title="Resumen orden" @click="imprimirOrdenFinalizada(props.item.id)">
                            fas fa-copy
                        </v-icon>
                        <v-icon  title="Finalizar orden" class="mr-2" small v-if="!props.item.finalizado" @click="finalizarOrden(props.item.id)">
                            fas fa-check-square
                        </v-icon>
                        <v-icon title="Editar orden" small v-if="!props.item.finalizado" @click="editarOrden(props.item.id)">
                            fas fa-tasks
                        </v-icon>
                        <v-icon title="Eliminar orden"  class="mr-2" small @click="deleteItem(props.item)">
                            delete
                        </v-icon>
                    </td>
                </template>
            
                <template v-slot:no-data>
                    <v-btn color="#668c2d"  @click="initialize">Recargar</v-btn>
                </template>
            
                <template v-slot:no-results>
                    <v-alert :value="true" color="error" icon="warning">
                    No hay resultados de "{{ search }}".
                </v-alert>
                </template>
            </v-data-table>
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
            dialogEditar: false,
            error: 0,
            errorMsj: [],
            prods: [],
            clientes: [],
            ordenes: [],
            detalles: [],
            detallesGenerales: [],
            detallesEliminados: [],
            headers: [
                { text: 'Orden', value: 'id' },
                { text: 'TotalCompra', value: 'totalCompra' },
                { text: 'TotalVenta', value: 'totalVenta' },
                { text: 'Fecha', value: 'created_at' },
                { text: 'Estado', value: 'estado' },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            headersApp: [
                { text: 'Producto', value: 'producto' },
                { text: 'Presentacion', value: 'presentacion' },
                { text: 'Cantidad', value: 'cantidad' },
                { text: 'Cliente', value: 'cliente' },
                { text: 'Eliminar Producto', value: 'acciones'}
            ],
            editedIndex: -1,
            editedItem: {
                idCliente: 0,
                orden: 0,
                producto: '',
                nombreProveedor: '',
                precioCompra: 0,
                contador: 0,
                parqueo: 0,
                combustible: 0,
                gastosVarios: 0,
                observaciones: '',
                detProducto: 0,
                cantProducto: 0,
                bandera: false
            },
            defaultItem: {
                contador: 0,
                idCliente: 0,
                orden: 0,
                producto: '',
                nombreProveedor: '',
                precioCompra: 0,
                contador: 0,
                parqueo: 0,
                combustible: 0,
                gastosVarios: 0,
                observaciones: '',
                detProducto: 0,
                cantProducto: 0
            }
        }),
        computed: {
        },
        watch: {
            dialog(val) {
                val || this.close();
            }
        },
        created() {
            this.initialize()
        },

        methods: {
            getColor (estado) {
                if (estado) return '#668C2D'
                else return 'red'
                verEstado();            
            },
            verEstado (estado) {
                if(estado) return "Finalizado";
                else return "No finalizado";
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
            cargarOrdenes(){
                axios.get('/compra/ordenes')
                    .then(response => {
                        this.ordenes = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            agregarProducto(){
                let me = this;
                this.editedItem.errorMsj = '';
                this.editedItem.bandera = true;
                if(this.editedItem.cantProducto <= 0 || this.editedItem.detProducto == '' || this.editedItem.idCliente == ''){
                    if(this.editedItem.idCliente == ' ')
                        this.editedItem.errorMsj = 'Seleccione un cliente.';
                    else if(this.editedItem.detProducto == '')
                        this.editedItem.errorMsj = 'Seleccione un producto.';
                    else if(this.editedItem.cantidad <= 0)
                        this.editedItem.errorMsj = 'Ingrese cantidad correcta.';
                } else {
                    //Agregar producto
                    this.editedItem.bandera = false;
                    me.detalles.push({
                        id: 0,
                        idp: this.editedItem.detProducto.id,
                        producto: this.editedItem.detProducto.Producto,
                        presentacion: this.editedItem.detProducto.presentacion,
                        nombreProveedor: this.editedItem.detProducto.nombreProveedor,
                        cantidad: this.editedItem.cantProducto,
                        cliente: this.editedItem.idCliente.idPersona,
                        nombreCliente: this.editedItem.idCliente.nombreCliente
                    });
                    this.editedItem.cantProducto = 0;
                    this.editedItem.detProducto = '';
                }
            },
            finalizarOrden(item){
                this.dialog = true;
                var detallesOrden = this.detalles.filter(function(p){
                    return p.idCompraEncabezado == item;
                });
                this.detalles = detallesOrden;
                this.editedItem.orden = item;
                this.editedItem.contador = 0;
                this.contadorMenos();
            },
            editarOrden(item){
                this.dialogEditar = true;
                var detallesOrden = this.detalles.filter(function(p){
                    return p.idCompraEncabezado == item;
                });
                this.detalles = detallesOrden;
                this.editedItem.orden = item;
            },
            validate() {
                this.error = 0;
                this.errorMsj = [];
                if(this.editedItem.observaciones == '')
                    this.errorMsj.push('Debe ingresar una observación.');
                if(this.editedItem.parqueo = '' || this.editedItem.parqueo < 0){
                    this.errorMsj.push('Debe ingresar una cantidad de parqueo correcta.');
                    this.editedItem.parqueo = 0;
                }
                if(this.editedItem.combustible = '' || this.editedItem.combustible < 0){
                    this.errorMsj.push('Debe ingresar una cantidad de combustible correcta.');
                    this.editedItem.combustible = 0;
                }
                if(this.editedItem.gastosVarios = '' || this.editedItem.gastosVarios < 0){
                    this.errorMsj.push('Debe ingresar una cantidad de gastos correcta.');
                    this.editedItem.gastosVarios = 0;
                }
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            initialize() {
                let me = this;
                axios.get('/compra/ordenes')
                    .then(response => {
                        this.ordenes = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
                this.cargarOrdenes()
                this.cargarDetalles()
                this.cargaProductos()
                this.cargaClientes()
            },
            verDetalles(item) {
                window.open(window.location.origin +'/ventas/'+item+'/detalles');
            },
            contadorMas(){
                if(this.editedItem.contador >= (this.detalles.length-1)){
                    this.editedItem.contador = (this.detalles.length-1); 
                }
                else{
                    this.detalles[this.editedItem.contador].precioCompra = this.editedItem.precioCompra;
                    this.editedItem.contador = this.editedItem.contador + 1;
                    this.editedItem.producto = this.detalles[this.editedItem.contador].producto;
                    this.editedItem.nombreProveedor = this.detalles[this.editedItem.contador].nombreProveedor;
                    this.editedItem.precioCompra = this.detalles[this.editedItem.contador].precioCompra;
                }
            },
            contadorMenos(){
                if(this.editedItem.contador <= 0){
                    this.editedItem.contador = 0;
                    this.editedItem.producto = this.detalles[this.editedItem.contador].producto;
                    this.editedItem.nombreProveedor = this.detalles[this.editedItem.contador].nombreProveedor;
                    this.editedItem.precioCompra = this.detalles[this.editedItem.contador].precioCompra;
                }
                else{
                    this.detalles[this.editedItem.contador].precioCompra = this.editedItem.precioCompra;
                    this.editedItem.contador = this.editedItem.contador - 1;
                    this.editedItem.producto = this.detalles[this.editedItem.contador].producto;
                    this.editedItem.nombreProveedor = this.detalles[this.editedItem.contador].nombreProveedor;
                    this.editedItem.precioCompra = this.detalles[this.editedItem.contador].precioCompra;
                }
            },
            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar esta orden de compra?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/compra/${item.id}/eliminar`).then(response => {
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
                this.dialogEditar = false;
                this.editedItem.contador = 0;
                this.editedItem.producto = '';
                this.editedItem.nombreProveedor = '';
                this.editedItem.precioCompra = '';
                this.editedItem.parqueo = 0;
                this.editedItem.combustible = 0;
                this.editedItem.gastosVarios = 0;
                this.editedItem.observaciones = 0;
                this.editedItem.idCliente = '';
                this.editedItem.detProducto = '';
                this.recargarDetalles();
            },
            cargarDetalles() {
                let me = this;
                axios.get('/compra/detalles')
                    .then(response => {
                        me.detalles = response.data;
                        me.detallesGenerales = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });              
            },
            recargarDetalles(){
                this.detalles = this.detallesGenerales;
            },
            editarCompra(){
                let me = this;
                if (this.validate()) {
                        return;
                    }
                if (this.editedIndex > -1) {                   
                } else {
                    if(this.detalles.length == 1)
                    {
                        this.detalles[0].precioCompra = this.editedItem.precioCompra;
                    }
                    axios({
                        method: 'post',
                        url: '/compra/editar',
                        data: {
                            orden: this.editedItem.orden,
                            detalles: this.detalles,
                            detallesEliminados: this.detallesEliminados
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
            },
            save() {
                let me = this;
                if (this.validate()) {
                        return;
                    }
                if (this.editedIndex > -1) {                   
                } else {
                    axios({
                        method: 'post',
                        url: '/compra/guardar',
                        data: {
                            orden: this.editedItem.orden,
                            detalles: this.detalles,
                            precioCompra: this.editedItem.precioCompra,
                            precioVenta: this.editedItem.precioVenta,
                            parqueo: this.editedItem.parqueo,
                            combustible: this.editedItem.combustible,
                            gastosVarios: this.editedItem.gastosVarios,
                            observaciones: this.editedItem.observaciones
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
            },
            eliminarProducto(e){
                let me = this;
                me.detallesEliminados.push({
                    idDetalle: e.item.idC
                });
                var item = e.item,
                index = this.detalles.indexOf(item);
                this.detalles.splice(index,1);
            },
            imprimirOrden(item){
                window.open(window.location.origin +'/compra/'+item+'/orden');
            },
            imprimirOrdenFinalizada(item){
                window.open(window.location.origin +'/compra/'+item+'/finalizada');
            }
        }
    }
</script>
<style lang="scss">
    @import '~vuetify/dist/vuetify.min.css';
</style>