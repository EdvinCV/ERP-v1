<template>

    <div>
           <div class="contenedor" style="background-color=#668C2D">
      <center> <h2 style="color:#668C2D">Productos</h2></center>
        </div>
     <hr>
        <v-toolbar flat color="white" >
           
            <v-spacer></v-spacer>
           
            
            <v-dialog v-model="dialog" max-width="600px">
                
                <template v-slot:activator="{ on }">
                   <v-btn style="background-color:#668c2d" dark class="mb-2" v-on="on">Nuevo Producto</v-btn>
                </template>
                <v-card>
               <v-card-title style="background-color:#668c2d">
                        <span class="headline" style="color:#fff">{{ formTitle }}</span>
                    </v-card-title>
                    
                    <v-card-text justify="center">
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                    <v-text-field color="#668c2d" type="text" v-model="editedItem.Producto" label="Nombre Producto" 
                                    maxlength="200"  required :rules="nameRules" :counter="200"></v-text-field>
                                     <v-layout row>
                                         <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field color="#668c2d" label="Precio Venta" :rules="decimalRules" prefix="Q" v-model="editedItem.precioventa"></v-text-field>
                                     </v-flex>
                                    <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field color="#668c2d" label="Precio Compra" :rules="decimalRules" prefix="Q" v-model="editedItem.preciocompra" ></v-text-field>    
                                     </v-flex>
                                     </v-layout>
                                    <v-layout row>
                                        <v-flex lg6 md6 xs6 pa-2>
                                            <v-text-field color="#668c2d" @change="porcentajes()" label="Porcentaje de Comercialización" :rules="decimalRules" v-model="editedItem.porcComercializacion"></v-text-field>
                                        </v-flex>
                                         <v-flex lg6 md6 xs6 pa-2>
                                            <v-text-field color="#668c2d" label="Gasto de Comercialización" :rules="decimalRules" prefix="Q" v-model="editedItem.gastocomercializacion"></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                      <v-layout row>
                                        <v-flex lg6 md6 xs6 pa-2 @change="porcentajes2()">
                                            <v-text-field color="#668c2d" @change="imp()" label="Porcentaje de Utilidad" :rules="decimalRules" v-model="editedItem.porcUtilidad" ></v-text-field>
                                        </v-flex>
                                         <v-flex lg6 md6 xs6 pa-2>
                                            <v-text-field color="#668c2d" label="Utilidad" :rules="decimalRules" prefix="Q" v-model="editedItem.utilidad" ></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                     <v-layout row>
                                    <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field color="#668c2d" label="Impuesto" :rules="decimalRules" prefix="Q" v-model="editedItem.impuesto"></v-text-field>
                                     </v-flex>
                                       <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field color="#668c2d" label="Precio Máximo" :rules="decimalRules" prefix="Q" v-model="editedItem.maximoprecio"></v-text-field>
                                     </v-flex>
                                     </v-layout>
                                      <v-layout row>
                                       <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field color="#668c2d" label="Precio Mínimo" :rules="decimalRules" prefix="Q" v-model="editedItem.minimoprecio"></v-text-field>
                                     </v-flex>
                                     <v-flex lg6 md6 xs6 pa-2>
                                    <v-text-field color="#668c2d" v-model="editedItem.codigo" label="Código"></v-text-field>
                                    </v-flex>
                                    </v-layout>
                                    <v-text-field color="#668c2d" v-model="editedItem.cantidadapartado" label="Cantidad Apartado" :rules="numberRules"></v-text-field>
                                    <v-text-field color="#668c2d" v-model="editedItem.existencia" label="Existencia" :rules="numberRules"></v-text-field>
                                    <v-flex xs12>
                                    <v-flex xs12>
                                        <multiselect v-model="editedItem.idcategoria" :options="categorias" placeholder="Seleccione una categoría"
                                            label="nombre" track-by="nombre"></multiselect>
                                    </v-flex>
                                    <v-flex xs12>
                                        <multiselect v-model="editedItem.idpresentacion" :options="presentaciones" placeholder="Seleccione una presentación"
                                            label="nombre" track-by="presentacion"></multiselect>
                                    </v-flex>
                                    <v-flex xs12>
                                         <multiselect v-model="editedItem.idpersona" :options="personas" placeholder="Seleccione un Proveedor"
                                            label="nombre" track-by="nombreProveedor"></multiselect>
                                    </v-flex>
                                </v-flex>                                    
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <template v-if="error">
                        <v-divider></v-divider>
                        <div class="text-xs-center">
                            <strong class="red--text text--lighten-1" v-for="e in errorMsj" :key="e" v-text="e"></strong>
                            <br>
                        </div>
                        <v-divider></v-divider>
                    </template>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="#668c2d" flat @click="close">Cancelar</v-btn>
                      <v-btn color="#668c2d" flat @click="save">Guardar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        
           <v-card-title>
           
      <v-switch v-model="switch1" label="Ver todo" color="success"></v-switch>
        <div class="flex-grow-1"></div>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Buscar"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>

        <v-data-table :headers="switch1 == true ? headers : headersC" :items="producto" class="elevation-1" :search="search">
            
            <template v-slot:items="props">
               
                <td class="text-xs-left">{{ props.item.Producto }}</td>
                <td class="text-xs-left">{{ props.item.presentacion }}</td>
                <td class="text-xs-left">{{ props.item.persona }}</td>
                <td class="text-xs-left">{{ props.item.precioventa }}</td>
                <td class="text-xs-left">{{ props.item.preciocompra }}</td>
                <template v-if="switch1 == true">
                    <td class="text-xs-left">{{ props.item.porcComercializacion }}</td>
                    <td class="text-xs-left">{{ props.item.gastocomercializacion }}</td>
                    <td class="text-xs-left">{{ props.item.porcUtilidad }}</td>
                    <td class="text-xs-left">{{ props.item.utilidad }}</td>
                    <td class="text-xs-left">{{ props.item.impuesto }}</td>
                    <td class="text-xs-left">{{ props.item.maximoprecio }}</td>
                    <td class="text-xs-left">{{ props.item.minimoprecio }}</td>
                    <td class="text-xs-left">{{ props.item.codigo }}</td>
                    <td class="text-xs-left">{{ props.item.cantidadapartado }}</td>
                    <td class="text-xs-left">{{ props.item.existencia }}</td>
                    <td class="text-xs-left">{{ props.item.categoria }}</td>
                </template>
            

                <td class="justify-right layout px-0">
                    <v-icon title="Editar producto" small class="mr-2" @click="editItem(props.item)">
                        edit
                    </v-icon>
                    <v-icon title="Eliminar producto" small  @click="desactivar(props.item)">
                        delete
                    </v-icon>
                </td>
            </template>
            <template v-slot:no-data>
               <v-btn style="background-color:#668c2d" dark class="mb-2"  @click="initialize">Recargar</v-btn>
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

            
            nameRules: [
            v => !!v || 'El nombre del producto no puede estar vacio',
            v => (v && v.length <= 199) || 'El nombre del producto no puede ser mayor a 200',
            v => /[a-zA-Z]/.test(v) || 'El nombre del producto solo puede tener letras',
            ],
            decimalRules:[
                v => /^\d{1,3}(?:,\s?\d{3})*(?:\.\d*)?$/.test(v) || 'Solo es permitido usar numeros',
            ],
            numberRules:[
                v => /^[0-9]+$/.test(v) || 'Solo es permitido usar numeros',
            ],
            error: 0,
            errorMsj: [],
            select: [],
            categorias: [],
            presentaciones: [],
            personas: [],
            switch1: false,
                
            headersC: [
                { 
                    text: 'Producto', 
                    value: 'Producto' 
                }, 
                {
                    text: 'Presentación',
                    value: 'presentacion'
                },
                {
                    text: 'Proveedor',
                    value: 'persona'
                },
                {
                    text: 'Precio Venta',
                    value: 'precioventa'
                },
                {
                    text: 'Precio Compra',
                    value: 'preciocompra'
                }
                ],
            headers: [
                { 
                    text: 'Producto', 
                    value: 'Producto' 
                }, 
                {
                    text: 'Presentación',
                    value: 'presentacion'
                },
                {
                    text: 'Proveedor',
                    value: 'persona'
                },
                {
                    text: 'Precio Venta',
                    value: 'precioventa'
                },
                {
                    text: 'Precio Compra',
                    value: 'preciocompra'
                },
                {
                    text: 'Porcentaje Comercialización',
                    value: 'porcComercializacion'
                },
                {
                    text: 'Gasto Comercialización',
                    value: 'gastoComercializacion'
                },
                {
                    text: 'Porcentaje Utilidad',
                    value: 'porcUtilidad'
                },
                {
                    text: 'Utilidad',
                    value: 'utilidad'
                },
                {
                    text: 'Impuesto',
                    value: 'impuesto'
                },
                {
                    text: 'Precio Máximo',
                    value: 'maximoprecio'
                },
                {
                    text: 'Precio Mínimo',
                    value: 'minimoprecio'
                },
                {
                    text: 'Código',
                    value: 'codigo'
                },
                {
                    text: 'Apartado',
                    value: 'cantidadapartado'
                },
                {
                    text: 'Existencia',
                    value: 'existencia'
                },
                {
                    text: 'Categoría',
                    value: 'categoria'
                },
               
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            bandera:false,
            producto: [],
            idcategoria: -1,
            idpresentacion: -1,
            idpersona: -1,
            editedIndex: -1,
            editedItem: {
                id: 0,
                Producto: '',
                precioventa: '',
                preciocompra: '',
                gastocomercializacion: '',
                utilidad: '',
                impuesto: '',
                maximoprecio: '',
                minimoprecio: '',
                estado: '',
                codigo: '',
                cantidadapartado: '',
                existencia: '',
                idcategoria: '',
                idpresentacion: '',
                idpersona: '',
                porcComercializacion: '',
                porcUtilidad: '',
            },
            defaultItem: {
                id: 0,
                Producto: '',
                precioventa: '',
                preciocompra: '',
                gastocomercializacion: '',
                utilidad: '',
                impuesto: '',
                maximoprecio: '',
                minimoprecio: '',
                estado: '',
                codigo: '',
                cantidadapartado: '',
                existencia: '',
                idcategoria: '',
                idpresentacion: '',
                idpersona: '',
                porcComercializacion: '',
                porcUtilidad: '',
                
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Nueva Producto' : 'Editar Producto'
            }
            
        },
        watch: {
            dialog(val) {
                val || this.close()
            }
        },
        created() {
            this.initialize();
            this.cargaCategorias();
            this.cargaPresentaciones();
            this.cargaPersonas();

        },
        methods: {
            validate() {
                
                this.error = 0;
                var x = true;
                this.errorMsj = [];
                let me = this;
                var s = me.vercodigo();
                if (!this.editedItem.Producto)
                    this.errorMsj.push('El nombre del producto no puede estar vacio.');
                    
                if(!this.editedItem.idcategoria)
                    this.errorMsj.push('Se debe asignar una categoría.')
                if(!this.editedItem.idpresentacion)
                    this.errorMsj.push('Se debe asignar una presentación. ')
                if(!this.editedItem.idpersona)
                    this.errorMsj.push('Se debe asignar un proveedor. ')
                if(!this.editedItem.precioventa)
                    this.errorMsj.push('Se debe asignar un precio de venta. ')
                if(!this.editedItem.preciocompra)
                    this.errorMsj.push('Se debe asignar una precio de compra. ')
                if(!this.editedItem.utilidad)
                    this.errorMsj.push('Se debe asignar un valor de utilidad. ')
                if(!this.editedItem.codigo)
                    this.errorMsj.push('Se debe asignar un código. ')
                console.log('s '+ s);
                
                if(this.bandera==false)
                    this.errorMsj.push('El código ya existe. ')
                
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            
            porcentajes(){
                let me = this;
                var r;
                r = this.editedItem.preciocompra * this.editedItem.porcComercializacion;
                r = Number(r.toFixed(2));
                this.editedItem.gastocomercializacion = r;
                return r;
                console.log(this.editedItem.gastocomercializacion);
            },
             porcentajes2(){
                let me = this;
                var r; 
                r = parseFloat(this.editedItem.preciocompra) + parseFloat(this.editedItem.gastocomercializacion);
                r = r * parseFloat(this.editedItem.porcUtilidad);
                r = Number(r.toFixed(2));
                this.editedItem.utilidad = r;
                return r;
                console.log(r);
            },
            imp(){
                let me = this;
                var i = 0.19;
                var r;
                r = parseFloat(this.editedItem.preciocompra) + parseFloat(this.editedItem.gastocomercializacion) + parseFloat(this.editedItem.utilidad);
                r = r * i;
                r = Number(r.toFixed(2));
                this.editedItem.impuesto = r;
                return r;
                console.log(me.r);
            },
            vercodigo()
            {
                let me = this;
                var si = 0;
                var cod = this.editedItem.codigo;
                if(me.producto.length>0)
                {
                    for(var x =0; x< me.producto.length; x++)
                    {
                        console.log(me.producto[x].codigo);
                    
                        if(me.producto[x].codigo.toUpperCase() == cod.toUpperCase()&&me.editedItem.id==me.producto[x].id)
                        {
                            me.bandera=true;
                            break;                                            
                        }else if(me.producto[x].codigo.toUpperCase() == cod.toUpperCase()&&me.editedItem.id!=me.producto[x].id){
                            me.bandera=false;
                            break;
                        }else{
                            me.bandera=true;
                        }
                    }
                }else {
                    me.bandera = true;
                }
                return me.bandera;
            },
             cargaCategorias() {
                let me = this;
                axios.get('/categoria')
                .then(function (response) {
                    me.categorias = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
             cargaPresentaciones() {
                let me = this;
                axios.get('/presentacion')
                .then(function (response) {
                    me.presentaciones = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            cargaPersonas() {
                let me = this;
                axios.get('/proveedores')
                .then(function (response) {
                    me.personas = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            initialize() {
                axios.get('/producto')
                    .then(response => {
                        this.producto = response.data;
                        
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
                   
            },
            editItem(item) {
                this.editedIndex = this.producto.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
                
            },desactivar(item){
                let me=this;
                swal.fire({
                    title: '¿Quieres eliminar este producto?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                       axios({
                        method: 'put',
                        url: 'producto/desactivar',
                        data: {
                            id:item.id,
                            }
                        }).then(response => {
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
            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar este Producto?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/producto/${item.id}/delete`).then(response => {
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
                        url: '/producto/actualizar',
                        data: {
                            id: me.editedItem.id,
                            Producto: this.editedItem.Producto,
                            precioventa: me.editedItem.precioventa,
                            preciocompra: me.editedItem.preciocompra,
                            gastocomercializacion: me.editedItem.gastocomercializacion,
                            utilidad: me.editedItem.utilidad,
                            impuesto: me.editedItem.impuesto,
                            maximoprecio: me.editedItem.maximoprecio,
                            minimoprecio: me.editedItem.minimoprecio,
                            estado: me.editedItem.estado,
                            codigo: me.editedItem.codigo,
                            cantidadapartado: me.editedItem.cantidadapartado,
                            existencia: me.editedItem.existencia,
                            idcategoria:me.editedItem.idcategoria.id,
                            idpresentacion:me.editedItem.idpresentacion.id,
                            idpersona:me.editedItem.idpersona.id,
                            porcComercializacion: me.editedItem.porcComercializacion,
                            porcUtilidad: me.editedItem.porcUtilidad
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
                } else {
                    axios({
                        method: 'post',
                        url: '/producto/registrar',
                        data: {
                            
                            Producto: me.editedItem.Producto,
                            precioventa: me.editedItem.precioventa,
                            preciocompra: me.editedItem.preciocompra,
                            gastocomercializacion: me.editedItem.gastocomercializacion,
                            utilidad: me.editedItem.utilidad,
                            impuesto: me.editedItem.impuesto,
                            maximoprecio: me.editedItem.maximoprecio,
                            minimoprecio: me.editedItem.minimoprecio,
                            estado: me.editedItem.estado,
                            codigo: me.editedItem.codigo,
                            cantidadapartado: me.editedItem.cantidadapartado,
                            existencia: me.editedItem.existencia,
                            idcategoria:me.editedItem.idcategoria.id,
                            idpresentacion:me.editedItem.idpresentacion.id,
                            idpersona:me.editedItem.idpersona.id,
                            porcComercializacion: me.editedItem.porcComercializacion,
                            porcUtilidad: me.editedItem.porcUtilidad
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
            close() {
                this.dialog = false;
                this.editar = 0;
       
                this.editedItem.Producto = '';
                this.editedItem.precioventa = '';
                this.editedItem.preciocompra ='';
                this.editedItem.gastocomercializacion ='';
                this.editedItem.utilidad = '';
                this.editedItem.impuesto = '';
                this.editedItem.maximoprecio ='';
                this.editedItem.minimoprecio ='';
                this.editedItem.codigo ='';
                this.editedItem.cantidadapartado='';
                this.editedItem.existencia='';
                this.editedItem.porcComercializacion='',
                this.editedItem.porcUtilidad='';
          
                this.error = 0;
                this.errorMsj = [];
            }
        }
    }
</script>
<style lang="scss">
    @import '~vuetify/dist/vuetify.min.css';
</style>