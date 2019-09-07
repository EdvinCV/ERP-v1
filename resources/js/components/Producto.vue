<template>
    <div>
        <v-toolbar flat color="white">
            <v-text-field v-model="search" append-icon="search" label="Buscar" single-line hide-details></v-text-field>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="600px">
                <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">Nuevo Producto</v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                    <v-text-field v-model="editedItem.nombre" label="Nombre Producto"></v-text-field>
                                    <v-text-field label="Precio Venta"  prefix="Q" v-model="editedItem.precioventa"></v-text-field>
                                    <v-text-field label="Precio Compra" prefix="Q" v-model="editedItem.preciocompra"></v-text-field>    
                                    <v-text-field label="Gasto de Comercializacion" prefix="Q" v-model="editedItem.gastocomercializacion"></v-text-field>
                                    <v-text-field label="Utilidad" prefix="Q" v-model="editedItem.utilidad"></v-text-field>
                                    <v-text-field label="Impuesto" prefix="Q" v-model="editedItem.impuesto"></v-text-field>
                                    <v-text-field label="Precio Maximo" prefix="Q" v-model="editedItem.maximoprecio"></v-text-field>
                                    <v-text-field label="Precio Minimo" prefix="Q" v-model="editedItem.minimoprecio"></v-text-field>
                                    <v-text-field v-model="editedItem.codigo" label="Codigo"></v-text-field>
                                    <v-text-field v-model="editedItem.cantidadapartado" label="Cantidad Apartado"></v-text-field>
                                    <v-text-field v-model="editedItem.existencia" label="Existencia"></v-text-field>
                                    <v-flex xs12>
                                    <v-flex xs12>
                                        <multiselect v-model="idcategoria" :options="categorias" placeholder="Seleccione una categoria"
                                            label="nombre" track-by="nombre"></multiselect>
                                    </v-flex>
                                    <v-flex xs12>
                                        <multiselect v-model="idpresentacion" :options="presentaciones" placeholder="Seleccione una presentacion"
                                            label="nombre" track-by="nombre"></multiselect>
                                    </v-flex>
                                    <v-flex xs12>
                                        <multiselect v-model="idpersona" :options="personas" placeholder="Seleccione una persona"
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
                        <v-btn color="blue darken-1" flat @click="close">Cancelar</v-btn>
                        <v-btn color="blue darken-1" flat @click="save">Guardar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        

        <v-data-table :headers="headers" :items="producto" class="elevation-1" :search="search">
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.id }}</td>
                <td class="text-xs-left">{{ props.item.Producto }}</td>
                <td class="text-xs-left">{{ props.item.precioventa }}</td>
                <td class="text-xs-left">{{ props.item.preciocompra }}</td>
                <td class="text-xs-left">{{ props.item.gastocomercializacion }}</td>
                <td class="text-xs-left">{{ props.item.utilidad }}</td>
                <td class="text-xs-left">{{ props.item.impuesto }}</td>
                <td class="text-xs-left">{{ props.item.maximoprecio }}</td>
                <td class="text-xs-left">{{ props.item.minimoprecio }}</td>
                <td class="text-xs-left">{{ props.item.estado }}</td>
                <td class="text-xs-left">{{ props.item.codigo }}</td>
                <td class="text-xs-left">{{ props.item.cantidadapartado }}</td>
                <td class="text-xs-left">{{ props.item.existencia }}</td>
                <td class="text-xs-left">{{ props.item.categoria }}</td>
                <td class="text-xs-left">{{ props.item.presentacion }}</td>
                <td class="text-xs-left">{{ props.item.persona }}</td>
            

                <td class="justify-right layout px-0">
                    <v-icon small class="mr-2" @click="editItem(props.item)">
                        edit
                    </v-icon>
                    <v-icon small  @click="desactivar(props.item)">
                        delete
                    </v-icon>
                </td>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Recargar</v-btn>
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
            error: 0,
            errorMsj: [],
            select: [],
            categorias: [],
            presentaciones: [],
            personas: [],
            headers: [
                {
                    text: 'Id',
                    align: 'left',
                    value: 'id'
                },
              
                { 
                    text: 'Nombre', 
                    value: 'nombre' 
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
                    text: 'Gasto Comercializacion',
                    value: 'gastocomercializacion'
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
                    text: 'Precio Maximo',
                    value: 'maximoprecio'
                },
                {
                    text: 'Precio Minimo',
                    value: 'minimoprecio'
                },
                {
                    text: 'Estado',
                    value: 'estado',
                },
                {
                    text: 'Codigo',
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
                    text: 'Categoria',
                    value: 'categoria'
                },
                {
                    text: 'Presentacion',
                    value: 'idpresentacion'
                },
                {
                    text: 'Proveedor',
                    value: 'idpersona'
                },

                { text: 'Acciones', value: 'action', sortable: false},
            ],
            producto: [],
            idcategoria: -1,
            idpresentacion: -1,
            idpersona: -1,
            editedIndex: -1,
            editedItem: {
                id: 0,
                nombre: '',
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
            },
            defaultItem: {
                id: 0,
                nombre: '',
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
                idcategorias: '',
                idpresentacion: '',
                idpersona: '',
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
                this.errorMsj = [];
                if (!this.editedItem.nombre)
                    this.errorMsj.push('El nombre del producto no puede estar vacio');
                /*if(!this.editedItem.idcategoria)
                    this.errorMsj.push('Se debe asignar una categoria')
                if(!this.editedItem.idpresentacion)
                    this.errorMsj.push('Se debe asignar una presentacion')
                if(!this.editedItem.idpersona)
                    this.errorMsj.push('Se debe asignar un proveedor')*/
                if(!this.editedItem.precioventa)
                    this.errorMsj.push('Se debe asignar un precio de venta')
                if(!this.editedItem.preciocompra)
                    this.errorMsj.push('Se debe asignar una precio de compra')
                if(!this.editedItem.utilidad)
                    this.errorMsj.push('Se debe asignar un valor de utilidad')
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
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
                    title: 'Quieres elimiara a este producto?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminala!',
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
                            nombre: me.editedItem.nombre,
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

                            idcategoria:me.idcategoria.id,
                            idpresentacion:me.idpresentacion.id,
                            idpersona:me.idpersona.id

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
                            
                            nombre: me.editedItem.nombre,
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
                            idcategoria:me.idcategoria.id,
                            idpresentacion:me.idpresentacion.id,
                            idpersona:me.idpersona.id
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