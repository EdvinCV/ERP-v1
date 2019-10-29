<template>
    <div>
        <div class="contenedor" style="backgrounhd-color=#668C2D">
            <center> <h2 style="color:#668C2D">Control de clientes</h2></center>
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
                    <v-btn style="background-color:#668c2d"  dark class="mb-2" v-on="on">Nuevo cliente</v-btn>
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
                                    <v-text-field color="#668c2d" maxlength="50"  required :counter="50" :rules="apellidoRules" v-model="editedItem.apellido" label="Apellidos"></v-text-field>
                                    <v-text-field color="#668c2d" maxlength="100"  required :counter="100" v-model="editedItem.direccion" label="Dirección"></v-text-field>
                                    <v-text-field  color="#668c2d" maxlength="20"  required :counter="20" v-model="editedItem.telefono" label="Teléfono"></v-text-field>
                                    <v-text-field color="#668c2d" :rules="nitRules" v-model="editedItem.nit" label="NIT"></v-text-field>
                                    <v-text-field color="#668c2d" type="email" v-model="editedItem.correo" label="Correo electrónico"></v-text-field>
                                    <v-text-field color="#668c2d" type="text" v-model="editedItem.dpi" label="DPI"></v-text-field>
                                    <v-text-field  color="#668c2d" maxlength="50"  required :counter="50" v-model="editedItem.nombreCliente" label="Empresa / Organización"></v-text-field>
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

        <v-data-table :headers="headers" :items="clientes" class="elevation-1" :search="search">
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.nombre }}</td>
                <td class="text-xs-left">{{ props.item.apellido }}</td>
                <td class="text-xs-left">{{ props.item.direccion }}</td>
                <td class="text-xs-left">{{ props.item.telefono }}</td>
                <td class="text-xs-left">{{ props.item.nit }}</td>
                <td class="text-xs-left">{{ props.item.correo }}</td>
                <td class="text-xs-left">{{ props.item.nombreCliente }}</td>
                <td class="justify-right layout px-0">
                    <v-icon title="Editar cliente" small class="mr-2" @click="editItem(props.item)">
                        edit
                    </v-icon>
                    <v-icon title="Eliminar cliente" small @click="deleteItem(props.item)">
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
        error: 0,
        loader: null,
        loading: false,
        nitRules:[
            v => !!v || 'El campo de NIT no puede estar vacio',
        ],
        nameRules: [
            v => !!v || 'El nombre del cliente no puede estar vacio',
            v => (v && v.length <= 49) || 'El nombre del proveedor no puede ser mayor a 50',
            v => /[a-zA-Z]/.test(v) || 'El nombre del proveedor solo puede tener letras',
        ],
        apellidoRules: [
            v => !!v || 'El apellido del cliente no puede estar vacio',
            v => (v && v.length <= 49) || 'El apellido del proveedor no puede ser mayor a 50',
            v => /[a-zA-Z]/.test(v) || 'El apellido del proveedor solo puede tener letras',
        ],
        direccion: [
            v => !!v || 'La direccion del cliente no puede estar vacia',
            v => (v && v.length <= 99) || 'El apellido del proveedor no puede ser mayor a 100',
        ],
        telefono: [
            v => !!v || 'El telefono del cliente no puede estar vacio',
            v => (v && v.length <= 13) || 'El telefono del proveedor no puede ser mayor a 20',
            v => /^[0-9]+$/.test(v) || 'El telefono del proveedor solo puede tener numeros',
        ],
        correoRules: [
            v => !!v || 'El campo de correo no puede estar vacio',
            v => /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/.test(v)|| 'El correo ingresado no existe',
        ],
        dpirules: [
            v => !!v || 'El campo de dpi no puede estar vacio',
        ],
        errorMsj: [],
        headers: [
            { text: 'Nombre', value: 'nombre' },
            { text: 'Apellido', value: 'apellido' },
            { text: 'Dirección', value: 'direccion' },
            { text: 'Teléfono', value: 'telefono' },
            { text: 'Nit', value: 'nit' },
            { text: 'Correo', value: 'correo' },
            { text: 'Cliente', value: 'nombreCliente' },
            { text: 'Acciones', value: 'action', sortable: false},
        ],
        clientes: [],
        editedIndex: -1,
        editedItem: {
            id: 0,
            nombre: '',
            apellido: '',
            direccion: '',
            telefono: '',
            nit: '',
            correo: '',
            nombreCliente: '',
            dpi: '',
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
            nombreCliente: '',
            dpi: '',
            estado: true,
        }
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nuevo cliente' : 'Editar cliente'
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
                this.errorMsj.push('Ingrese un nombre. ');
            if (!this.editedItem.apellido)
                this.errorMsj.push('Ingrese un apellido. ');
            if (!this.editedItem.nombreCliente)
                this.errorMsj.push('Ingrese nombre de empresa/organización. ');
            if(!this.editedItem.nit){
                this.editedItem.nit = 'CF';
                x = true;
            }
            if(this.editedItem.nit){
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
            axios.get('/clientes')
            .then(response => {
                this.clientes = response.data;
            })
            .catch(errors => {
                console.log(errors);
            });
        },
        editItem(item) {
            this.editedIndex = this.clientes.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            let me=this;
            swal.fire({
                title: '¿Quieres eliminar este cliente?',
                text: "Esta acción no se podrá revertir.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.value) {
                    axios({
                        method: 'put',
                        url: '/clientes/eliminar',
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
                    url: '/clientes/actualizar',
                    data: {
                        id:this.editedItem.id,
                        nombre: me.editedItem.nombre,
                        apellido: me.editedItem.apellido,
                        direccion: me.editedItem.direccion,
                        telefono: me.editedItem.telefono,
                        nit: me.editedItem.nit,
                        correo: me.editedItem.correo,
                        dpi: me.editedItem.dpi,
                        nombreCliente: me.editedItem.nombreCliente
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
                    url: '/clientes/nuevo',
                    data: {
                        nombre: me.editedItem.nombre,
                        apellido: me.editedItem.apellido,
                        direccion: me.editedItem.direccion,
                        telefono: me.editedItem.telefono,
                        nit: me.editedItem.nit,
                        correo: me.editedItem.correo,
                        dpi: me.editedItem.dpi,
                        nombreCliente: me.editedItem.nombreCliente
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