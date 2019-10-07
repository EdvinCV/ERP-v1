<template>
    <div>
        
            
            <v-dialog v-model="dialog"  max-width="600px">
                
                <v-card>
              <v-card-title style="background-color:#668c2d">
                        <span class="headline" style="color:#fff">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                    <v-text-field label="Cantidad"  prefix="Q" v-model="editedItem.cantidad"></v-text-field>
                                     <v-radio-group color="success" v-model="editedItem.tipo" column >
                                        <v-radio label="Apertura" value="1" color="success"></v-radio>
                                        <v-radio label="Cierre" value="2" color="success"></v-radio>
                                    </v-radio-group>
                                    <v-text-field label="Observaciones" v-model="editedItem.observacion"></v-text-field>
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
                        
                        <v-btn color="blue darken-1" flat @click="save">Guardar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        
        
    </div>
</template>
<script>
    export default {
        data: () => ({
            search: '',
            dialog: false,
            error: '',
            inicio: false,
            errorMsj: [],
            entradas: [],
            salidas: [],
            usuarios: 0,
            caja: [],
            editedIndex: -1,
            editedItem: {
                id: 0,
                cantidad: '',
                tipo: '',
                observacion: '',
            },
            defaultItem: {
                id: 0,
                cantidad: '',
                tipo: '',
                observacion: '',
            }
        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Registrar Caja' : 'Editar Categoria'
            }
        },
        watch: {
            dialog(val) {
                val || this.close()
            }
        },
        created() {
            this.initialize();
            this.cargaEntradas();   
            this.cargaSalidas();
           
        },
        mounted(){
            let me = this;
            this.InicioS();
            if(this.inicio == true)
            {
                this.dialog = true
            }
        },
        methods: {
            validate() {
                this.error = 0;
                this.errorMsj = [];
                this.cargaEntradas();
                this.cargaSalidas();
                var r;
                r = this.resta();
                if (!this.editedItem.cantidad)
                    this.errorMsj.push('La cantidad no puede estar vacia. ');
                if (!this.editedItem.tipo)
                    this.errorMsj.push('Se debe de asignar un tipo. ');
                if(this.editedItem.cantidad != r)
                    this.errorMsj.push('Las cantidades no coinciden. ')
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            initialize() {
                axios.get('/caja')
                    .then(response => {
                        this.caja = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            cargaEntradas() {
                let me = this;
                axios.get('/ventas/validartotal')
                .then(function (response) {
                    me.entradas = response.data;
                   
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
             cargaSalidas() {
                let me = this;
                axios.get('/compra/validartotal')
                .then(function (response) {
                    me.salidas = response.data;
                   
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            cargaUsuarios() {
                
                let me = this;
                axios.get('/usuario/inicio')
                .then(function (response) {
                    me.usuarios = response.data;
                    this.InicioS();
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            resta(){
                let me = this;
                var total;
                total =  parseFloat(this.entradas[0].Total) - parseFloat(this.salidas[0].Total);
                
                total = Number(total.toFixed(2));
                return total;
                console.log(this.entradas[0].Total);
            },
            InicioS(){
                let me = this;
                this.cargaUsuarios();
                if(this.usuarios == 0)
                {
                    this.inicio = true;
                }
            },
            editItem(item) {
                this.editedIndex = this.caja.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
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
                        url: '/caja/actualizar',
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
                        url: '/caja/registrar',
                        data: {
                            cantidad: me.editedItem.cantidad,
                            tipo: me.editedItem.tipo,
                            observacion: me.editedItem.observacion
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