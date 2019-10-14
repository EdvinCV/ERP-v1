<template>

  
    <div>
       
        <div class="contenedor" style="background-color=#668C2D">
      <center> <h2 style="color:#668C2D">Presentacion</h2></center>
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
            <v-dialog v-model="dialog" max-width="600px">
                <template v-slot:activator="{ on }">
                    <v-btn style="background-color:#668c2d" dark class="mb-2" v-on="on">Nueva Presentacion</v-btn>
                </template>
                <v-card >
                 <v-card-title style="background-color:#668c2d">
                        <span class="headline" style="color:#fff">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                      <v-text-field color="#668c2d" type="text" v-model="editedItem.nombre" maxlength="50"  required :rules="nameRules" :counter="50" label="Nombre Presentacion"></v-text-field>
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
           
     
        <div class="flex-grow-1"></div>
    
      </v-card-title>

        <v-data-table :headers="headers" :items="presentacion" class="elevation-1" :search="search" >
            
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.nombre }}</td>
                <td class="justify-right layout px-0">
                    <v-icon title="Editar presentación" small class="mr-2" @click="editItem(props.item)">
                        edit
                    </v-icon>
                    <v-icon title="Eliminar presentación" small @click="deleteItem(props.item)">
                        delete
                    </v-icon>
                </td>
            </template>
            <template v-slot:no-data>
              <v-btn style="background-color:#668c2d" dark class="mb-2" @click="initialize">Recargar</v-btn>
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
                     nameRules: [
      v => !!v || 'El nombre de la presentacion no puede estar vacio',
      v => (v && v.length <= 49) || 'El nombre de la presentacion no puede ser mayor a 50',
       v => /[a-zA-Z]/.test(v) || 'la presentacion solo puede tener letras',
    
    ],
            error: 0,
            errorMsj: [],
            headers: [
                { 
                    text: 'Nombre', 
                    value: 'nombre' 
                },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            presentacion: [],
            editedIndex: -1,
            editedItem: {
                id: 0,
                nombre: '',
            },
            defaultItem: {
                id: 0,
                nombre: '',
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Nueva Presentacion' : 'Editar Presentacion'
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
                if (!this.editedItem.nombre)
                    this.errorMsj.push('El nombre de la Presentacion no puede estar vacio');
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            initialize() {
                axios.get('/presentacion')
                    .then(response => {
                        this.presentacion = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            editItem(item) {
                this.editedIndex = this.presentacion.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar esta Presentacion?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/presentacion/${item.id}/delete`).then(response => {
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
                        url: '/presentacion/actualizar',
                        data: {
                            id: this.editedItem.id,
                            nombre: this.editedItem.nombre
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
                        url: '/presentacion/registrar',
                        data: {
                            nombre: me.editedItem.nombre
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