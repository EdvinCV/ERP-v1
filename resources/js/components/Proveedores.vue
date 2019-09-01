<template>
    <div>
        <v-toolbar flat color="white">
            <v-text-field v-model="search" append-icon="search" label="Buscar" single-line hide-details></v-text-field>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="600px">
                <template v-slot:activator="{ on }">
                     <v-btn color="primary" dark class="mb-2" v-on="on">Nuevo Proveedor</v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                    <v-text-field v-model="editedItem.nombre" label="Nombres"></v-text-field>
                                    <v-text-field v-model="editedItem.apellido" label="Apellidos"></v-text-field>
                                    <v-text-field v-model="editedItem.direccion" label="Direccion"></v-text-field>
                                    <v-text-field v-model="editedItem.telefono" label="Telefono"></v-text-field>
                                    <v-text-field v-model="editedItem.nit" label="NIT"></v-text-field>
                                    <v-text-field v-model="editedItem.correo" label="Correo"></v-text-field>
                                    <v-text-field v-model="editedItem.nombreProveedor" label="Nombre Empresa"></v-text-field>
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
        

        <v-data-table :headers="headers" :items="proveedores" class="elevation-1" :search="search">
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.id }}</td>
                <td class="text-xs-left">{{ props.item.nombre }}</td>
                <td class="text-xs-left">{{ props.item.apellido }}</td>
                <td class="text-xs-left">{{ props.item.direccion }}</td>
                <td class="text-xs-left">{{ props.item.telefono }}</td>
                <td class="text-xs-left">{{ props.item.nit }}</td>
                <td class="text-xs-left">{{ props.item.correo }}</td>
                <td class="text-xs-left">{{ props.item.nombreProveedor }}</td>
                
                <td class="justify-right layout px-0">
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
                { 
                    text: 'Nombre', 
                    value: 'nombre' 
                },
                { text: 'Apellido', value: 'apellido' },
                { text: 'Direccion', value: 'direccion' },
                { text: 'Telefono', value: 'telefono' },
                { text: 'Nit', value: 'nit' },
                { text: 'Correo', value: 'correo' },
                { text: 'Proveedor', value: 'nombreProveedor' },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            proveedores: [],
            editedIndex: -1,
            editedItem: {
                id: 0,
                nombre: '',
                apellido: '',
                direccion: '',
                telefono: '',
                nit: '',
                correo: '',
                nombreProveedor: '',
                estado: true,
            },
            defaultItem: {
                id: 0,
                nombre: '',
                apellido: '',
                direccion: '',
                telefono: '',
                nit: '',
                correo: '',
                nombreProveedor: '',
                estado: true,
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Nuevo Proveedor' : 'Editar Proveedor'
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
             getColor (estado) {
                if (estado) return 'green'
                else return 'red'
                verEstado();            
            },

            verEstado (estado) {
                if(estado) return "Activo";
                else return "Inactivo";
            },
            validate() {
                this.error = 0;
                this.errorMsj = [];
                if (!this.editedItem.nombre)
                    this.errorMsj.push('El nombre de la Presentacion no puede estar vacio');
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            initialize() {
                axios.get('/proveedores')
                    .then(response => {
                        this.proveedores = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            editItem(item) {
                this.editedIndex = this.proveedores.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar este proveedor?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios({
                        method: 'put',
                        url: '/proveedores/eliminar',
                        data: {
                            id:item.id,
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
                        url: '/proveedores/actualizar',
                        data: {
                            id:this.editedItem.id,
                            nombre: me.editedItem.nombre,
                            apellido: me.editedItem.apellido,
                            direccion: me.editedItem.direccion,
                            telefono: me.editedItem.telefono,
                            nit: me.editedItem.nit,
                            correo: me.editedItem.correo,
                            nombreProveedor: me.editedItem.nombreProveedor
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
                        url: '/proveedores/nuevo',
                        data: {
                            nombre: me.editedItem.nombre,
                            apellido: me.editedItem.apellido,
                            direccion: me.editedItem.direccion,
                            telefono: me.editedItem.telefono,
                            nit: me.editedItem.nit,
                            correo: me.editedItem.correo,
                            nombreProveedor: me.editedItem.nombreProveedor
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