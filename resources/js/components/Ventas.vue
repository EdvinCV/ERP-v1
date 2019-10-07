<template>
    <div>
        <center><h2 style="color:#668C2D">Venta</h2></center>
        <center><hr class="hrt"></center>
        <v-switch 
            v-model="switchFact"
            :label = "`Facturado`"
        ></v-switch>
        <v-flex lg3 md3 xs3 pa-2>
            <v-text-field v-model="editedItem.numFact" label="No. Factura"></v-text-field>
        </v-flex>
        <v-radio-group v-model="radios" row @change="pago()">
            <v-radio label="Efectivo" value="efectivo"></v-radio>
            <v-radio label="Cheque" value="cheque"></v-radio>
            <v-flex lg3 md3 xs3 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.cheque" label="No. Cheque" v-if="bandera"></v-text-field>
            </v-flex>
            <v-flex lg3 md3 xs3 pa-2>
                <v-text-field color="#668c2d" v-model="editedItem.banco" label="Banco" v-if="bandera"></v-text-field>
            </v-flex>
        </v-radio-group>
        <v-container fluid>
            <!--LAYOUT DE CLIENTE -->
            <h6>Información cliente</h6>
            <v-layout row>
                <v-flex lg6 md6 xs6 pa-2>
                    <multiselect @input="buscarNIT()" v-model="editedItem.idCliente" :options="clientes" placeholder="Seleccione un cliente"
                        label="nombreCliente" track-by="nombreCliente"></multiselect>
                </v-flex>
                <v-flex lg3 md3 xs6 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.nit" label="NIT" readonly></v-text-field>
                </v-flex>
                <v-flex lg3 md3 xs6 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.direccion" label="Dirección"></v-text-field>
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
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.precio" label="Precio"></v-text-field>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.descuento" label="Descuento" ></v-text-field>
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
                        <v-text-field color="#668c2d" v-model="editedItem.subtotal" label="Subtotal" readonly></v-text-field>
                    </v-flex>
                    <v-flex lg6 md6 xs2 pa-2>
                        <v-text-field color="#668c2d" v-model="editedItem.total" label="Total" readonly></v-text-field>
                    </v-flex>
                </v-layout>
            </template>      
            <hr>
            <template>
                <v-btn @click="save" block color="#668c2d" dark>GENERAR VENTA</v-btn>
                <v-btn @click="cotizacion" block color="#668c2d" dark>Cotización</v-btn>
              
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
            bandera: false,
            dialog: false,
            error: 0,
            radios: '',
            switchFact: false,
            errorMsj: [],
            headersAddP: [
                { text: 'Descripcion', value: 'prod' },
                { text: 'Cantidad', value: 'action'},
                { text: 'Precio', value: 'pu'},
                { text: 'Subtotal', value: 'prod' },
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
                total: '',
                cheque: '',
                banco: '',
                numFact: 0,
                detalle: []
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
                total: '',
                detalle: []
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
                if (!this.radios)
                    this.errorMsj.push('Elija un método de pago');
                if (this.bandera)
                {
                    if(!this.editedItem.cheque)
                        this.errorMsj.push('Ingrese número de cheque');
                    if(!this.editedItem.banco)
                        this.errorMsj.push('Ingrese nombre de banco');
                }
                if(!this.editedItem.idCliente)
                    this.errorMsj.push('Elija un cliente');
                if(!this.editedItem.numFact)
                    this.errorMsj.push('Ingrese número de factura');
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
            pago(){
               if(this.radios == "cheque")
                   this.bandera = true;
                else 
                    this.bandera = false;
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
                if(this.editedItem.cantProducto == 0 || this.editedItem.precio == 0 || !this.editedItem.detProducto || this.editedItem.descuento < 0 || this.editedItem.descuento > 100)
                    this.mostrarAlert();
                else{
                    me.carrito.push({
                    idProd: me.editedItem.detProducto.id,
                    nombreProducto: me.editedItem.detProducto.Producto,
                    cantidad: parseInt(me.editedItem.cantProducto),
                    precio: me.editedItem.detProducto.precioventa,
                    descuento: me.editedItem.descuento,
                    sub: ( (parseInt(me.editedItem.cantProducto) * parseFloat(me.editedItem.detProducto.precioventa) * (100 - me.editedItem.descuento)) / 100)
                    });
                    me.calcularTotal();
                    me.editedItem.cantProducto = 0;
                    me.editedItem.precio = 0;
                    me.editedItem.descuento = 0;
                    me.editedItem.detProducto = '';
                }            
            },
            eliminarProducto(e){
                let me = this;
                var item = e.item,
                    index = this.carrito.indexOf(item);
                
                this.carrito.splice(index,1);
                me.calcularTotal();
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
                else if(this.editedItem.precio <= 0){
                    swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Cantidad de precio incorrecto, vuelva a seleccionar producto.',
                            showConfirmButton: false,
                            timer: 1500});
                }
                else if(this.editedItem.descuento < 0 || this.editedItem.descuento > 100){
                    swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Cantidad de descuento incorrecta',
                            showConfirmButton: false,
                            timer: 1500});
                }
            },
            cotizacion(){
                axios({
                        method: 'post',
                        url: '/venta/cotizacion',
                        data: {
                            total: this.editedItem.total,
                            subtotal: this.editedItem.subtotal,
                            carrito: this.carrito,
                        }
                    }).then(function (response) {
                        swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Venta realizada',
                            showConfirmButton: false,
                            timer: 1500});
          
                    }).catch(function (error) {
                        swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: error.response.data.error,
                            showConfirmButton: true});
                
                    });
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
                        url: '/venta/nuevo',
                        data: {
                            total: this.editedItem.total,
                            subtotal: this.editedItem.subtotal,
                            idCliente: this.editedItem.idCliente.id,
                            switchFact: this.switchFact,
                            carrito: this.carrito,
                            cheque: this.editedItem.cheque,
                            banco: this.editedItem.banco,
                            radios: this.radios,
                            descuento: this.editedItem.descuento,
                            numFact: this.editedItem.numFact
                        }
                    }).then(function (response) {
                        swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Venta realizada',
                            showConfirmButton: false,
                            timer: 1500});
                        me.initialize();
                        me.close();
                        window.open(window.location.origin +'/ventas/'+response.data+'/factura');
                        
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