<template>
    <div>
        <div class="contenedor" style="backgrounhd-color=#668C2D">
            <center> <h2 style="color:#668C2D">Gestión de permisos</h2></center>
        </div>
        <hr>
        <v-toolbar flat color="white">
            <v-text-field
                v-model="search"
                append-icon="search"
                label="Buscar"
                single-line
                hide-details
            ></v-text-field>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on }">
                    <v-btn style="background-color:#668c2d"  dark class="mb-2" v-on="on">Asignar Permiso</v-btn>
                </template>
                <v-card>
                <v-card-title style="background-color:#668c2d">
                    <span class="headline" style="color:#fff">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12 sm12 md12>
                                <multiselect v-model="selectRol" :options="listaRoles" placeholder="Seleccione un rol"
                                            label="nombreRol" track-by="nombreRol" :allowEmpty="true">
                                </multiselect>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                                <multiselect v-model="selectPermiso" :options="listaPermisos" placeholder="Seleccione un permiso"
                                            label="nombrePermiso" track-by="nombrePermiso" :allowEmpty="true">
                                </multiselect>
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
                    <v-btn color="#668c2d" flat :loading="loading" :disabled="loading" @click="save">Guardar</v-btn>
                </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>

        <v-data-table :headers="headers" :items="permisos" class="elevation-1" :search="search">
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.nombreRol }}</td>
                <td class="text-xs-left">{{ props.item.nombrePermiso }}</td>
                <td class="justify-right layout px-0">
                    <v-icon title="Eliminar permiso" small @click="deleteItem(props.item)">
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
            selectRol: [],
            selectPermiso: [],
            switch1: false,
            error: 0,
            loader: null,
            loading: false,
            bandera: 0,
            errorMsj: [],
            headers: [
                { text: 'Rol', value: 'nombreRol' },
                { text: 'Permiso', value: 'nombrePermiso' },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            permisos: [],
            listaRoles: [],
            listaPermisos: [],
            editedIndex: -1,
            editedItem: {
                id: 0,
                nombreRol: '',
                nombrePermiso: '',
                estado: true,
            },
            defaultItem: {
                id: 0,
                nombreRol: '',
                nombrePermiso: '',
                estado: true,
            }
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Asignar Permisos' : 'Editar Permiso'
            }
        },

        watch: {
            dialog(val) {
                val || this.close();
            }
        },

        created() {
            this.initialize();
            this.cargaPermisos();
            this.cargaRoles();
        },

        methods: {
            getColor (estado) {
                if (estado) return '#668C2D'
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
                if(this.selectRol == '')
                    this.errorMsj.push("Seleccione un rol.  ");
                if(this.selectPermiso == '')
                    this.errorMsj.push("Seleccione un permiso.  ");
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            initialize() {
                let me = this;
                axios.get('/permisos')
                    .then(response => {
                        this.permisos = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            cargaPermisos() {
                let me = this;
                axios.get('/listaP')
                .then(function (response) {
                    me.listaPermisos = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            cargaRoles() {
                let me = this;
                axios.get('/rol')
                .then(function (response) {
                    me.listaRoles = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            editItem(item) {
                this.editedIndex = this.permisos.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar este permiso?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/rolPermiso/${item.id}/delete`).then(response => {
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
                                        
                } else {
                    me.loader='loading'
                    me.loading=true
                    axios({
                        method: 'post',
                        url: '/rolPermiso/nuevo',
                        data: {
                            nombreRol : this.selectRol.id,
                            nombrePermiso : this.selectPermiso.id
                        }
                    }).then(function (response) {
                        swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: response.data,
                            showConfirmButton: false,
                            timer: 1500});
                        me.loader=null;
                        me.loading=false;
                        me.initialize();
                        me.close();
                    }).catch(function (error) {
                        swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: error.response.data.error,
                            showConfirmButton: true});
                        me.loader=null;
                        me.loading=false;
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