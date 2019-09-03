<template>
    <div>
        <v-toolbar flat color="white">
            <v-text-field v-model="search" append-icon="search" label="Buscar" single-line hide-details></v-text-field>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="700px">
                <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">Nuevo Rol</v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs6 sm6 md6>
                                    <v-autocomplete @change="buscarNIT()" v-model="editedItem.idCliente" item-text="nombreCliente" item-value="id" label="Clientes" :items="roles"></v-autocomplete>
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
                                    <v-autocomplete @change="buscarNIT()" v-model="editedItem.detProducto" item-text="nombreCliente" item-value="id" label="Nombre del producto" :items="roles"></v-autocomplete>
                                </v-flex>
                                <v-flex xs2 sm2 md2>
                                    <v-text-field v-model="editedItem.cantProducto" label="Cantidad" ></v-text-field>
                                </v-flex>
                                <v-flex xs2 sm2 md2>
                                    <v-text-field v-model="editedItem.ivaProd" label="Impuesto"></v-text-field>
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
                                                <v-icon small @click="deleteItem(props.item)">
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
        

        <v-data-table :headers="headers" :items="roles" class="elevation-1" :search="search">
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.id }}</td>
                <td class="text-xs-left">{{ props.item.nombreRol }}</td>
                <td class="justify-center layout px-0">
                    <v-icon small class="mr-2" @click="editItem(props.item)">
                        edit
                    </v-icon>
                    <v-icon small @click="deleteItem(props.item)">
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
    export default {
        data: () => ({
            search: '',
            dialog: false,
            error: 0,
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
            this.initialize()
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
                axios.get('/clientes')
                    .then(response => {
                        this.roles = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            buscarNIT(){
                let me = this;
                var cliente = this.roles.filter(function(c){
                    return c.id == me.editedItem.idCliente;
                });
                console.log(cliente[0].nit);
                this.editedItem.nit = cliente[0].nit;
                this.editedItem.direccion = cliente[0].direccion;
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