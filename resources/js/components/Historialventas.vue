<template>
    <div>
       
       <center> <h2 style="color:#668C2D">Historial ventas</h2></center>
       <hr>
        <v-toolbar flat color="white">
             <v-text-field color="#668c2d"
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        </v-toolbar>
          <v-card-title>
           
     
        <div class="flex-grow-1"></div>
   
      </v-card-title>

        <v-data-table :headers="headers" :items="ventas" class="elevation-1" :search="search">
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.nombreCliente }}</td>
                <td class="text-xs-left">Q. {{ props.item.total }}</td>
                <td class="text-xs-left">{{ props.item.numeroFactura }}</td>
                <td class="text-xs-left">{{ props.item.created_at }}</td>
                <td class="text-xs-left"><v-chip :color="getColor(props.item.facturado)" dark>{{ verEstado(props.item.facturado) }}</v-chip></td>
                <td class="justify-center layout px-0">
                    <v-icon small @click="verDetalles(props.item.id)">
                        fas fa-edit
                    </v-icon>
                    <v-icon small @click="deleteItem(props.item)">
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
            ventas: [],
            error: 0,
            errorMsj: [],
            headers: [
                { text: 'Cliente', value: 'nombreCliente' },
                { text: 'Total', value: 'total' },
                { text: 'No. Factura', value: 'numeroFactura' },
                { text: 'Fecha', value: 'created_at' },
                { text: 'Facturado', value: 'facturado' },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            editedIndex: -1,
            editedItem: {
            },
            defaultItem: {
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
        },

        methods: {
            getColor (estado) {
                if (estado) return '#668C2D'
                else return 'red'
                verEstado();            
            },

            verEstado (estado) {
                if(estado) return "Facturado";
                else return "No Facturado";
            },

            validate() {
                this.error = 0;
                this.errorMsj = [];
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            initialize() {
                let me = this;
                axios.get('/ventas/listar')
                    .then(response => {
                        this.ventas = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            verDetalles(item) {
                window.open(window.location.origin +'/ventas/'+item+'/detalles');
            },

            deleteItem(item) {
                let me=this;
                swal.fire({
                    title: 'Quieres eliminar esta venta?',
                    text: "No podras revertir la eliminacion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/venta/${item.id}/eliminar`).then(response => {
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
                        url: '/permisos/editar',
                        data: {
                            id:this.editedItem.id,
                            estado:this.switch1
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