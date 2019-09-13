<template>
    <div>
        <v-toolbar flat color="white">
            <v-text-field v-model="search" append-icon="search" label="Buscar" single-line hide-details></v-text-field>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="600px">
                <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">Nuevo historial de calidad</v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                     <v-flex xs12>
                                        <multiselect v-model="idproducto" :options="productos" placeholder="Seleccione un producto"
                                            label="Producto" track-by="Producto"></multiselect>
                                    </v-flex>
                                    
                                    <v-radio-group color="success" v-model="editedItem.calificacion" column >
                                        <v-radio label="Nada Satisfecho" value="1" color="success"></v-radio>
                                        <v-radio label="Poco Satisfecho" value="2"></v-radio>
                                        <v-radio label="Neutral" value="3"></v-radio>
                                        <v-radio label="Muy Satisfecho" value="4"></v-radio>
                                        <v-radio label="Totalmente Satisfecho" value="5"></v-radio>
                                    </v-radio-group>
                                    <v-date-picker v-model="editedItem.fecha" locale="es-GT" color="green lighten-1"></v-date-picker>
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
        

        <v-data-table :headers="headers" :items="historialcalidad" class="elevation-1" :search="search">
            <template v-slot:items="props">
                
                <td class="text-xs-left">{{ props.item.Producto }}</td>
                <td class="text-xs-left">{{ props.item.calificacion }}</td>
                <td class="text-xs-left">{{ props.item.fecha }}</td>
            
                <td class="justify-right layout px-0">
                    <v-icon small class="mr-2" @click="editItem(props.item)">
                        edit
                    </v-icon>
                    <v-icon small  @click="deleteItem(props.item)">
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
            productos: [],
            fecha: new Date().toISOString().substr(0, 10),
            headers: [
              
                { 
                    text: 'Producto', 
                    value: 'idproducto' 
                },
                {
                    text: 'Calificacion',
                    value: 'calificacion'
                },
                {
                    text: 'Fecha',
                    value: 'fecha'
                },
                

                { text: 'Acciones', value: 'action', sortable: false},
            ],
            historialcalidad: [],
            idproducto: -1,
            editedIndex: -1,
            editedItem: {
                id: 0,
                idproducto: '',
                calificacion: '',
            },
            defaultItem: {
                id: 0,
                idproducto: '',
                calificacion: '',
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Nuevo Historial de calidad' : 'Editar Historial de calidad'
            }
        },
        watch: {
            dialog(val) {
                val || this.close()
            }
        },
        created() {
            this.initialize();
            this.cargaProductos();
        },
        methods: {
            validate() {
                this.error = 0;
                this.errorMsj = [];
                if (!this.editedItem.calificacion)
                    this.errorMsj.push('Se debe asignar una calificacón');
                /*if(!this.editedItem.idcategoria)
                    this.errorMsj.push('Se debe asignar una categoria')*/
                if(!this.editedItem.fecha)
                    this.errorMsj.push('Se debe asignar una fecha');
                if((this.editedItem.fecha)>(new Date().toISOString()))
                    this.errorMsj.push('Se debe asignar una fecha anterior');
                //console.log(new Date().toISOString());
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
             cargaProductos() {
                let me = this;
                axios.get('/producto')
                .then(function (response) {
                    me.productos = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            initialize() {
                axios.get('/historialcalidad')
                    .then(response => {
                        this.historialcalidad = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            editItem(item) {
                this.editedIndex = this.historialcalidad.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },deleteItem(item) {
                let me=this;
                swal.fire({
                    title: '¿Quieres eliminar este historial de calidad?',
                    text: "¡No podras revertir la eliminación!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/historialcalidad/${item.id}/delete`).then(response => {
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
                        url: '/historialcalidad/actualizar',
                        data: {
                            id: me.editedItem.id,
                            calificacion: me.editedItem.calificacion,
                            idproducto: me.idproducto.id,
                            fecha: me.editedItem.fecha

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
                        url: '/historialcalidad/registrar',
                        data: {
                            calificacion: me.editedItem.calificacion,
                            idproducto:me.idproducto.id,   
                            fecha: me.editedItem.fecha
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