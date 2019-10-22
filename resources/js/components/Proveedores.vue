<template>
    <div>
           <div class="contenedor" style="backgrounhd-color=#668C2D">
      <center> <h2 style="color:#668C2D">Proveedores</h2></center>
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
                  <v-btn style="background-color:#668c2d"  dark class="mb-2" v-on="on">Nuevo Proveedor</v-btn>
                </template>
                <v-card>
            <v-card-title style="background-color:#668c2d">
                        <span class="headline" style="color:#fff">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                 <v-text-field color="#668c2d" maxlength="50"  required :counter="50" :rules="nameRules" v-model="editedItem.nombre" label="Nombres"></v-text-field>
                                    <v-text-field color="#668c2d" maxlength="50"  required :counter="50" v-model="editedItem.apellido" label="Apellidos"></v-text-field>
                                    <v-text-field color="#668c2d" maxlength="100"  required :counter="100" v-model="editedItem.direccion" label="Direccion"></v-text-field>
                                    <v-text-field color="#668c2d" maxlength="20"  required :counter="20" v-model="editedItem.telefono" label="Telefono"></v-text-field>
                                    <v-text-field color="#668c2d" v-model="editedItem.nit" label="NIT"></v-text-field>
                                    <v-text-field  color="#668c2d" type="email" v-model="editedItem.correo" label="Correo"></v-text-field>
                                    <v-text-field color="#668c2d" maxlength="200"  required :counter="200" :rules="empresaRules" v-model="editedItem.nombreProveedor" label="Nombre Empresa"></v-text-field>
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
        
   <v-card-title>

        <div class="flex-grow-1"></div>
 
      </v-card-title>
        <v-data-table :headers="headers" :items="proveedores" class="elevation-1" :search="search">
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.nombreProveedor }}</td>
                <td class="text-xs-left">{{ props.item.nombre }}</td>
                <td class="text-xs-left">{{ props.item.apellido }}</td>
                <td class="text-xs-left">{{ props.item.direccion }}</td>
                <td class="text-xs-left">{{ props.item.telefono }}</td>
                <td class="text-xs-left">{{ props.item.nit }}</td>
                <td class="text-xs-left">{{ props.item.correo }}</td>
                
                
                <td class="justify-right layout px-0">
                    <v-icon title="Editar proveedor" small class="mr-2" @click="editItem(props.item)">
                        edit
                    </v-icon>
                    <v-icon title="Eliminar proveedor" small @click="deleteItem(props.item)">
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
            dialog: false,
            error: 0,
            errorMsj: [],
            headers: [
                {
                    text: 'Id',
                    align: 'left',
                    value: 'id'
                },
            ],
             valid: true,
             nitRules:[
                v => !!v || 'El campo de Nit no puede estar vacio',
             ],
                     nameRules: [
      v => !!v || 'El nombre del proveedor no puede estar vacio',
      v => (v && v.length <= 49) || 'El nombre del proveedor no puede ser mayor a 50',
       v => /[a-zA-Z]/.test(v) || 'El nombre del proveedor solo puede tener letras',
    ],
       direccion: [
      v => !!v || 'La direccion del proveedor no puede estar vacia',
      v => (v && v.length <= 99) || 'La direccion del proveedor no puede ser mayor a 100',
    ],
    empresaRules: [
      v => !!v || 'El nombre de la empresa no puede estar vacio',
      v => (v && v.length <= 199) || 'El nombre del proveedor no puede ser mayor a 199',
    ],
            errorMsj: [],

            headers: [
                { text: 'Proveedor', value: 'nombreProveedor' },
                { 
                    text: 'Nombre', 
                    value: 'nombre' 
                },
                { text: 'Apellido', value: 'apellido' },
                { text: 'Dirección', value: 'direccion' },
                { text: 'Teléfono', value: 'telefono' },
                { text: 'Nit', value: 'nit' },
                { text: 'Correo', value: 'correo' },
                { text: 'Acciones', value: 'action', sortable: false},
            ],
            proveedores: [],
            loader: null,
            loading: false,
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
                    this.errorMsj.push('Debe ingresar un nombre.');
                if (!this.editedItem.direccion)
                    this.errorMsj.push('Debe ingresar una dirección.');
                if (!this.editedItem.nombreProveedor)
                    this.errorMsj.push('Debe ingresar un nombre de proveedor.');
                if(!this.editedItem.nit){
                    this.editedItem.nit = 'CF';
                    x = true;
                }
                if(this.editedItem.nit)
                {
                    if((this.valNit(this.editedItem.nit))==false && this.editedItem.nit != 'CF')
                    this.errorMsj.push('NIT no valido. ');
                }
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },
            valNit(nit){
                var nd, add=0;
                if(nd =  /^(\d+)\-?([\dk])$/i.exec(nit)){
                    nd[2] = (nd[2].toLowerCase()=='k')?10:parseInt(nd[2]);
                    for (var i = 0; i < nd[1].length; i++) {
                        add += ( (((i-nd[1].length)*-1)+1) * nd[1][i] );
                    }
                    return ((11 - (add % 11)) % 11) == nd[2];
                }else{
                    return false;
                }
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
                    me.loader=null;
                    me.loading=false;
                    return;
                }
                if (this.editedIndex > -1) {
                    me.loader='loading';
                    me.loading=true;
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
                } else {
                    me.loader='loading';
                    me.loading=true;
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
                        me.loader=null;
                        me.loading=false;
                        swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: response.data,
                            showConfirmButton: false,
                            timer: 1500});
                        me.initialize();
                        me.close();
                    }).catch(function (error) {
                        me.loader=null;
                        me.loading=false;
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