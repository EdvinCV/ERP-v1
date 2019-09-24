<template>
    <div>
        <v-toolbar flat color="white">
            <v-text-field v-model="search" append-icon="search" label="Buscar" single-line hide-details></v-text-field>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="600px">
                <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">Crear usuario</v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                      <v-container grid-list-md>
                        <v-layout wrap>
                          <v-flex xs12 sm12 md12>
                            <v-text-field
                                v-model="editedItem.name"
                                :counter="10"
                                label="Nombre"
                                :rules="[rules.required, rules.min]"
                            ></v-text-field>

                            <v-text-field
                                v-model="editedItem.email"
                                :rules="[rules.required, rules.email]"
                                label="Correo Electrónico"
                            ></v-text-field>

                            <v-text-field
                                v-model="editedItem.pass"
                                :append-icon="mostrar ? 'visibility' : 'visibility_off'"
                                :rules="[rules.required, rules.min]"
                                :type="mostrar ? 'text' : 'password'"
                                name="input-10-1"
                                label="Ingrese contraseña"
                                hint="Al menos 8 caracteres"
                                counter
                                @click:append="mostrar = !mostrar"
                                v-if="this.editedIndex === -1"
                            ></v-text-field>

                            <v-text-field
                                v-model="editedItem.confirmPass"
                                :append-icon="mostrar ? 'visibility' : 'visibility_off'"
                                :rules="[rules.required, rules.min]"
                                :type="mostrar ? 'text' : 'password'"
                                name="input-10-1"
                                label="Confirmar contraseña"
                                counter
                                @click:append="mostrar = !mostrar"
                                v-if="this.editedIndex === -1"
                            ></v-text-field>
                            <v-select
                                v-model="editedItem.rol"
                                :items="listaRoles"
                                item-text="nombreRol"
                                item-value="id"
                                label="Seleccionar rol"
                                persistent-hint
                                return-object
                                single-line
                            ></v-select>
                            <v-switch 
                                v-model="switch1"
                                :label = "switch1 ? 'Activado' : 'Desactivado'"
                                v-if="this.editedIndex > -1"
                            ></v-switch>
                                   
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
        

        <v-data-table :headers="headers" :items="users" class="elevation-1" :search="search">
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.name }}</td>
                <td class="text-xs-left">{{ props.item.email }}</td>
                <td class="text-xs-left">{{ props.item.nombreRol }}</td>
                <td class="text-xs-left"><v-chip :color="getColor(props.item.estado)" dark>{{ verEstado(props.item.estado) }}</v-chip></td>
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
     import multiselect from 'vue-multiselect'
    export default {
      components:{
            multiselect
        },
        data: () => ({
            search: '',
            dialog: false,
            mostrar: false,
            error: 0,
            switch1: false,
            errorMsj: [],
            listaRoles: [],
            headers: [
                { 
                    text: 'Nombre', value: 'nombre' 
                },
                {
                    text: 'Email', value: 'email',
                },
                {
                    text: 'Rol', value: 'rol'
                },
                {
                    text: 'Estado', value: 'estado'
                },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            users: [],
            editedIndex: -1,
            editedItem: {
                id: 0,
                name: '',
                email: '',
                pass: '',
                confirmPass: '',
                rol: 0,
            },
            defaultItem: {
                id: 0,
                name: '',
                email: '',
                pass: '',
                confirmPass: '',
                rol: 0,
            },
            rules: {
              required: value => !!value || 'Campo requerido.',
              counter: value => value.length <= 20 || 'Max 20 characters',
              email: value => {
              const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
              return pattern.test(value) || 'Correo electrónico invalido.'
              }
            },
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Nuevo usuario' : 'Editar usuario'
            }
        },
        watch: {
            dialog(val) {
                val || this.close()
            }
        },
        created() {
            this.initialize()
            this.cargarRoles()
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
                if (!this.editedItem.name)
                    this.errorMsj.push('El nombre no puede estar vacío.');
                if (this.editedItem.pass != this.editedItem.confirmPass)
                {
                    this.errorMsj.push('Las contraseñas no coinciden.');
                    this.editedItem.pass = '';
                    this.editedItem.confirmPass = '';
                }
                if (!this.editedItem.email)
                    this.errorMsj.push('El correo no puede estar vacío.');
                if (!this.editedItem.rol)
                    this.errorMsj.push('El rol no puede estar vacío.');
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            initialize() {
                axios.get('/usuarios')
                    .then(response => {
                        this.users = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            editItem(item) {
                this.editedIndex = this.users.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar este usuario?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/usuario/${item.id}/delete`).then(response => {
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
                        url: '/usuario/actualizar',
                        data: {
                            id: this.editedItem.id,
                            name: this.editedItem.name,
                            email: this.editedItem.email,
                            rol: this.editedItem.rol.id,
                            switch1: this.switch1
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
                        url: '/usuario/registrar',
                        data: {
                            name: me.editedItem.name,
                            email: me.editedItem.email,
                            pass: me.editedItem.pass,
                            rol: me.editedItem.rol.id
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
            cargarRoles(){
              let me = this;
                axios.get('/rol')
                .then(function (response) {
                    me.listaRoles = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            }
        }
    }
</script>
<style lang="scss">
    @import '~vuetify/dist/vuetify.min.css';
</style>