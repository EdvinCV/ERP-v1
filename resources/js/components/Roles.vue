<template>
    <div>
        <div class="contenedor" style="background-color=#668C2D">
            <center> <h2 style="color:#668C2D">Control de Roles</h2></center>
        </div>
    <hr>

    <v-toolbar flat color="white">
        <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar..."
            single-line
            hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="600px">
            <template v-slot:activator="{ on }">
                <v-btn style="background-color:#668c2d" dark class="mb-2" v-on="on">Nuevo Rol</v-btn>
            </template>
            <v-card>
                <v-card-title style="background-color:#668c2d">
                    <span class="headline" style="color:#fff">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12 sm12 md12>
                                <br><br>
                                <v-text-field color="#668c2d" v-model="editedItem.nombreRol" maxlength="50"  required :rules="nameRules" :counter="50" label="Nombre Rol"></v-text-field>
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

    <v-data-table :headers="headers" :items="roles" class="elevation-1" :search="search">
        <template v-slot:items="props">
            <td class="text-xs-left">{{ props.item.nombreRol }}</td>
            <td class="justify-right layout px-0">
                <v-icon title="Editar rol" small class="mr-2" @click="editItem(props.item)">
                    edit
                </v-icon>
                <v-icon title="Eliminar rol" small @click="deleteItem(props.item)">
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
    export default {
        data: () => ({
            search: '',
            loader: null,
            loading: false,
            dialog: false,
            error: 0,
            nameRules: [
                v => !!v || 'El rol no puede estar vacío.',
                v => (v && v.length <= 49) || 'El nombre del rol no puede ser mayor a 50.',
                v => /[a-zA-Z]/.test(v) || 'el rol solo puede tener letras.',
            ],
            errorMsj: [],
            headers: [
                { text: 'Rol', value: 'nombreRol' },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            roles: [],
            editedIndex: -1,
            editedItem: {
                id: 0,
                nombreRol: '',
            },
            defaultItem: {
                id: 0,
                nombreRol: '',
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
                    this.errorMsj.push('El nombre del rol no puede estar vacío.');
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            initialize() {
                axios.get('/rol')
                    .then(response => {
                        this.roles = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            editItem(item) {
                this.editedIndex = this.roles.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar este rol?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/rol/${item.id}/delete`).then(response => {
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
                me.loader='loading';
                me.loading=true;
                if (this.validate()) {
                        me.loader=null;
                        me.loading=false;
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
                        me.loader=null;
                        me.loading=false;
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