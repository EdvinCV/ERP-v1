<style>
.containers{

  margin: auto;
  border: 3px solid #73AD21;
}
.hr{
    background-color:#668C2D;
}
</style>
<template>
    <div>
        <center><h2 style="color:#668C2D">Venta</h2></center>
        <center><hr class="hrt" color="#668c2d"></center>
 
          <v-container >
         
      <h5 style="color:#668c2d">Factura</h5>
 <v-layout row>
          <v-switch  
            color="#668c2d"
            v-model="editedItem.switchFact"
            :label = "this.editedItem.switchFact ? 'Facturado' : 'No Facturado'"
        ></v-switch>
      
       

       
      <v-flex lg3 md3 xs3 pa-2 >
            <v-text-field color="#668c2d" v-model="editedItem.numFact" label="No. Factura"></v-text-field>
        </v-flex>
         </v-layout>
                <h5 style="color:#668c2d">Metodo de pago</h5>
              <v-layout row>
               
           <v-radio-group v-model="radios" row @change="pago()">
            <v-radio color="#668c2d" label="Efectivo" value="efectivo"></v-radio>
            <v-radio color="#668c2d" label="Cheque" value="cheque"></v-radio>
            <v-flex color="#668c2d" lg3 md3 xs3 pa-2>
                <v-text-field color="#668c2d" v-model="editedItem.cheque" label="No. Cheque" v-if="bandera"></v-text-field>
            </v-flex>
            <v-flex color="#668c2d" lg3 md3 xs3 pa-2>
                <v-text-field color="#668c2d" v-model="editedItem.banco" label="Banco" v-if="bandera"></v-text-field>
            </v-flex>
        </v-radio-group>
    
              </v-layout>
       <hr>
        
</v-container>
       
       
       
        <v-container>
           
        <!--LAYOUT DE CLIENTE -->
   
        <h5 style="color:#668c2d">Información cliente <v-btn @click="abrirModal"  style="background-color:#668c2d"  dark class="mb-2" v-on="on">Ingresar Cliente</v-btn></h5>
      
             
           
            <v-layout row>
                <v-flex lg6 md6 xs6 pa-2>
                    <multiselect title="Seleccione un cliente" @input="buscarNIT()" v-model="editedItem.idCliente" :options="clientes" placeholder="Seleccione un cliente"
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
                <hr>
            <h5 style="color:#668c2d">Ingrese productos</h5> 
        
            <v-layout row>
                <v-flex lg6 md6 xs6 pa-2>
                    <multiselect title="Seleccione producto" @input="buscarProducto()" v-model="editedItem.detProducto" :options="prods" placeholder="Seleccione un producto"
                                label="mostrar" track-by="Producto" :allowEmpty="true"></multiselect>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.cantProducto" label="Cantidad"></v-text-field>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.precio" label="Precio"></v-text-field>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.existencia" label="Stock" readonly></v-text-field>
                </v-flex>
                <v-flex lg2 md2 xs2 pa-2>
                    <v-text-field color="#668c2d" v-model="editedItem.descuento" label="Descuento" ></v-text-field>
                </v-flex>
                <v-flex xs1 sm1 md1>
                    <v-btn title="Agregar producto" @click="agregarProducto()" fab dark small color="#668c2d">
                        <v-icon dark>add</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
            <!--LAYOUT PRODUCTOS INGRESADOS-->
             <hr  color="#668c2d">
            <h5 style="color:#668c2d">Productos ingresados</h5>
           
            <template>
                <v-data-table :headers="headersAddP" :items="carrito" class="elevation-1" hide-actions>
                    <template v-slot:items="props">
                        <td class="text-xs-left">{{ props.item.nombreProducto }}</td>
                        <td class="text-xs-left">{{ props.item.cantidad }}</td>
                        <td class="text-xs-left">{{ props.item.precio }}</td>
                        <td class="text-xs-left">{{ props.item.sub }}</td>
                        <td class="justify-center layout px-0">
                            <v-icon title="Eliminar producto" small @click="eliminarProducto(props)">
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

        <div class="text-center">
            <v-dialog v-model="dialogModal" width="600px">
      <v-card>
        <v-card-title style="background-color:#668c2d">
          <span class="headline" style="color:#fff">Ingresar Cliente</span>
        </v-card-title>

        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
                <v-flex xs12 sm12 md12>
                    <v-text-field color="#668c2d" maxlength="50"  required :counter="50" v-model="editedItem.nombre" label="Nombres"></v-text-field>
                    <v-text-field color="#668c2d" maxlength="50"  required :counter="50" v-model="editedItem.apellido" label="Apellidos"></v-text-field>
                    <v-text-field color="#668c2d" maxlength="100"  required :counter="100" v-model="editedItem.direccionCliente" label="Direccion"></v-text-field>
                    <v-text-field  color="#668c2d" maxlength="20"  required :counter="20" v-model="editedItem.telefono" label="Telefono"></v-text-field>
                    <v-text-field color="#668c2d" :rules="nitRules" v-model="editedItem.nitCliente" label="NIT"></v-text-field>
                    <v-text-field color="#668c2d" type="email" v-model="editedItem.correo" label="Correo"></v-text-field>
                    <v-text-field color="#668c2d" type="text" v-model="editedItem.dpi" label="DPI"></v-text-field>
                    <v-text-field  color="#668c2d" maxlength="50"  required :counter="50" v-model="editedItem.nombreCliente" label="Cliente"></v-text-field>
                </v-flex> 
            </v-layout>
            </v-container>
        </v-card-text>

        <v-divider></v-divider>
        <div class="text-xs-center">
            <strong class="red--text text--lighten-1" v-for="e in errorMsj2" :key="e" v-text="e"></strong>
            <br>
        </div>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-spacer></v-spacer>
            <v-btn color="#668c2d" flat @click="closeModal">Cancelar</v-btn>
            <v-btn color="#668c2d" flat @click="guardarCliente">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
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
            nitRules:[
                v => !!v || 'El campo de Nit no puede estar vacio',
            ],
            bandera: false,
            dialog: false,
            dialogModal: false,
            error: 0,
            radios: '',
            errorMsj: [],
            errorMsj2: [],
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
                detalle: [],
                existencia: 0,
                switchFact: true,
                nombre: '',
                apellido: '',
                direccionCliente: '',
                telefono: '',
                nitCliente: '',
                correo: '',
                nombreCliente: '',
                dpi: '',
                estado: true,
            },
            defaultItem: {
                idCliente: '',
                nit: '',
                direccion: '',
                detProducto: '',
                cantProducto: '',
                numFact: 0,
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
                if(this.editedItem.numFact == 0 && this.facturado == true)
                    this.errorMsj.push('Ingrese número de factura');
                if(this.carrito == '')
                        this.errorMsj.push('No ha elejido ningún producto');
                if (this.errorMsj.length)
                    this.error = 1;
                this.editedIndex = -1;
                return this.error;
            },
            validateCliente() {
                this.error = 0;
                this.errorMsj2 = [];
                if(!this.editedItem.nombre)
                    this.errorMsj2.push('Ingrese un nombre.  ');
                if(!this.editedItem.direccionCliente)
                    this.errorMsj2.push('Ingrese una dirección.  ');
                if(!this.editedItem.nombreCliente)
                    this.errorMsj2.push('Ingrese un nombre de cliente.  ');
                if(!this.editedItem.nit)
                    this.editedItem.nit = "CF";
                if(this.editedItem.nit){
                    if((this.valNit(this.editedItem.nit))==false && this.editedItem.nit != 'CF')
                    this.errorMsj2.push('NIT no valido. ');
                }
                if (this.errorMsj2.length)
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
            valNit(nit){
                var nd, add=0;
                if(nd =  /^(\d+)\-?([\dk])$/i.exec(nit)){
                    nd[2] = (nd[2].toLowerCase()=='k')?10:parseInt(nd[2]);
                    for (var i = 0; i < nd[1].length; i++) {
                        add += ( (((i-nd[1].length)*-1)+1) * nd[1][i] );
                    }
                    return ((11 - (add % 11)) % 11) == nd[2];
                }else{
                    return false;
                }
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
            abrirModal(){
                this.dialogModal = true;
            },
            guardarCliente(){
            let me = this;
            if (this.validateCliente()) {
                return;
            }
            axios({
                method: 'post',
                url: '/clientes/nuevo',
                data: {
                    nombre: me.editedItem.nombre,
                    apellido: me.editedItem.apellido,
                    direccion: me.editedItem.direccionCliente,
                    telefono: me.editedItem.telefono,
                    nit: me.editedItem.nitCliente,
                    correo: me.editedItem.correo,
                    dpi: me.editedItem.dpi,
                    nombreCliente: me.editedItem.nombreCliente
                }
            }).then(function (response) {
                swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: response.data,
                    showConfirmButton: false,
                    timer: 1500});
                me.cargaClientes()
                me.closeModal();
            }).catch(function (error) {
                swal.fire({
                    position: 'top-end',
                    type: 'error',
                    title: error.response.data.error,
                    showConfirmButton: true});
                    me.initialize();
                    me.close();
                }); 
            },
            valNit(nit){
                var nd, add=0;
                if(nd =  /^(\d+)\-?([\dk])$/i.exec(nit)){
                    nd[2] = (nd[2].toLowerCase()=='k')?10:parseInt(nd[2]);
                    for (var i = 0; i < nd[1].length; i++) {
                        add += ( (((i-nd[1].length)*-1)+1) * nd[1][i] );
                    }
                    return ((11 - (add % 11)) % 11) == nd[2];
                }else{
                    return false;
                }
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
                this.editedItem.existencia = producto[0].existencia;
                this.editedItem.cantProducto = 0;
                this.editedItem.descuento = 0;
            },
            agregarProducto(){
                let me = this;
                if(this.carrito.length == 27){
                    swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'No puede ingresar más de 27 productos. Debe generar otra venta.',
                            showConfirmButton: false,
                            timer: 1500});
                }else {
                    if(this.editedItem.cantProducto == 0 || this.editedItem.precio == 0 || !this.editedItem.detProducto || this.editedItem.descuento < 0 || this.editedItem.descuento > 100 || this.editedItem.cantProducto > this.editedItem.existencia)
                        this.mostrarAlert();
                    else{
                        me.carrito.push({
                        idProd: me.editedItem.detProducto.id,
                        nombreProducto: me.editedItem.detProducto.Producto,
                        presentacion: me.editedItem.detProducto.presentacion,
                        cantidad: parseInt(me.editedItem.cantProducto),
                        precio: me.editedItem.detProducto.precioventa,
                        descuento: me.editedItem.descuento,
                        sub: parseFloat((((parseInt(me.editedItem.cantProducto) * parseFloat(me.editedItem.detProducto.precioventa) * (100 - me.editedItem.descuento)) / 100)))
                        });
                        me.calcularTotal();
                        me.editedItem.cantProducto = 0;
                        me.editedItem.precio = 0;
                        me.editedItem.descuento = 0;
                        me.editedItem.detProducto = '';
                        me.editedItem.existencia = 0;
                    }
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
               if(this.editedItem.cantProducto > this.editedItem.existencia){
                    swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'No existe producto suficiente en inventario.',
                            showConfirmButton: false,
                            timer: 1500});
                }
            },
            cotizacion(){
                axios({
                        method: 'post',
                        url: '/venta/cotizacion',
                        responseType:'arraybuffer',
                        data: {
                            carrito: this.carrito,
                            total: this.editedItem.total
                        }
                    }).then(function (response) {
                        let blob = new Blob([response.data], { type:   'application/pdf' } )
                        let link = document.createElement('a')
                        link.href = window.URL.createObjectURL(blob)
                        link.download = 'cotizacion.pdf'
                        link.click()
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
                me.editedItem.subtotal = Math.round(t/1.12,2);
                me.editedItem.total = t;
            },
            close() {
                this.error=0;
                this.dialog = false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },
            closeModal(){
                this.dialogModal = false;
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
                            switchFact: this.editedItem.switchFact,
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
                        if(me.editedItem.switchFact)
                            window.open(window.location.origin +'/ventas/'+response.data+'/factura');
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
                    this.carrito = [];
            }
        }
    }
</script>
<style lang="scss">
    @import '~vuetify/dist/vuetify.min.css';
</style>