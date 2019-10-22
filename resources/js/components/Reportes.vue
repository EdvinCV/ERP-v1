
<template>
      
 <!-- Widgets -->
 <div>
  <div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-green hover-expand-effect">
        <div class="icon">
          <i class="material-icons">playlist_add_check</i>
        </div>
        <div class="content">
          <div class="text">VENTAS SEMANA</div>
            <div class="number count-to" data-from="0" >Q. {{this.editedItem.totalSemana}}</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
          <div class="icon">
            <i class="material-icons">favorite</i>
          </div>
          <div class="content">
            <div class="text">VENTAS DIA</div>
              <div class="number count-to" data-from="0" >Q. {{this.editedItem.totalDia}}</div>
            </div>
          </div>
        </div>
            
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-red hover-expand-effect">
            <div class="icon">
              <i class="material-icons">library_books</i>
            </div>
            <div class="content">
              <div class="text">GANANCIAS</div>
                <div class="number count-to" data-from="0" ><h6>{{this.editedItem.productoGanancia}}</h6></div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
              <div class="icon">
                <i class="material-icons">person_add</i>
              </div>
              <div class="content">
                  <div class="text">TOTAL CLIENTES</div>
                  <div class="number count-to" data-from="0" >{{this.editedItem.totalClientes}}</div>
              </div>
            </div>
          </div>
        </div>
        <!-- #END# Widgets -->

        <div class="row clearfix">
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            <div class="info-box bg-pink hover-zoom-effect">
              <div class="icon">
                <i class="material-icons">apps</i>
              </div>
              <div class="content">
                <div class="text">MÁS VENDIDO</div>
                <div class="number count-to" ><h6>{{this.editedItem.productoMasVendido}}</h6></div>
              </div>
            </div>
            <div class="info-box bg-blue-grey hover-zoom-effect">
              <div class="icon">
                <i class="material-icons">labels</i>
              </div>
              <div class="content">
                <div class="text">MENOS VENDIDO</div>
                <div class="number count-to" ><h6>{{this.editedItem.productoMenosVendido}}</h6></div>
              </div>
            </div>
            <div class="info-box bg-purple hover-zoom-effect">
              <div class="icon">
                <i class="material-icons">account_circle</i>
              </div>
              <div class="content">
                <div class="text">TOTAL PRODUCTOS</div>
                <div class="number count-to" >{{this.editedItem.totalProds}}</div>
              </div>
            </div>
          </div>

<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
  <div class="card">
    <div class="header">
      <center><h2>Ventas Historial</h2></center>
      <hr>
    </div>
    
    <div class="body">
      <div class="row">
			  <div class="col-md-8 col-md-offset-2">
				  <div class="card ">
            <center><h3>Por Cliente</h3></center>
            <div class="card-body d-flex justify-content-between align-items-center"> 
              <v-flex lg6 md6 xs6 pa-2>
                <multiselect v-model="editedItem.idCliente" :options="clientes" placeholder="Seleccione un cliente"
                    label="nombreCliente" track-by="nombreCliente"></multiselect>
              </v-flex>
            </div>

            <div class="card-body d-flex justify-content-between align-items-center">					
<template>
   <v-layout row wrap>
      <v-flex xs11 sm5>
        <v-dialog ref="dialog1" v-model="modal1" :return-value.sync="date1" width="290px">
          <template v-slot:activator="{ on }">
            <v-text-field v-model="date1" label="Fecha Inicial" prepend-icon="event"  v-on="on"></v-text-field>
          </template>
          <v-date-picker v-model="date1" scrollable  color="#668c2d" locale="gt">
            <v-btn flat color="primary" @click="modal1 = false">Cancelar</v-btn>
            <v-btn flat color="primary" @click="$refs.dialog1.save(date1)">OK</v-btn>
          </v-date-picker>
        </v-dialog>     
    </v-flex>
  </v-layout>

  <v-layout row wrap>
      <v-flex xs11 sm5>
        <v-dialog ref="dialog2" v-model="modal2" :return-value.sync="date2" width="290px">
          <template v-slot:activator="{ on }">
            <v-text-field v-model="date2" label="Fecha Final" prepend-icon="event"  v-on="on"></v-text-field>
          </template>
          <v-date-picker v-model="date2" scrollable color="#668c2d" locale="gt">
            <v-btn flat color="primary" @click="modal = false">Cancelar</v-btn>
            <v-btn flat color="primary" @click="$refs.dialog2.save(date2)">OK</v-btn>
          </v-date-picker>
        </v-dialog>     
    </v-flex>
  </v-layout>
</template>


</v-layout>
        
					</div>
          	<div class="card-body d-flex justify-content-between align-items-center">
           <center>  <v-btn @click="generalVentas" style="background-color:#668c2d"  dark class="mb-2">VENTAS GENERAL</v-btn><v-btn @click="guardarEspecificoClientes" style="background-color:#668c2d"  dark class="mb-2">CLIENTE</v-btn></center>
           </div>
				</div>
			</div>
		</div>
         
    <hr>
                 
                    <br>
      <div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="card">
           <center>  <h3>Productos</h3></center>
    
          <div class="card-body d-flex justify-content-between align-items-center">					
<template>
   <v-layout row wrap>
      <v-flex xs11 sm5>
        <v-dialog ref="dialog3" v-model="modal3" :return-value.sync="date3" width="290px">
          <template v-slot:activator="{ on }">
            <v-text-field v-model="date3" label="Fecha Inicial" prepend-icon="event"  v-on="on"></v-text-field>
          </template>
          <v-date-picker v-model="date3" color="#668c2d" scrollable  locale="gt">
            <v-btn flat color="primary" @click="modal3 = false">Cancelar</v-btn>
            <v-btn flat color="primary" @click="$refs.dialog3.save(date3)">OK</v-btn>
          </v-date-picker>
        </v-dialog>     
    </v-flex>
  </v-layout>

  <v-layout row wrap>
      <v-flex xs11 sm5>
        <v-dialog ref="dialog4" v-model="modal4" :return-value.sync="date4" width="290px">
          <template v-slot:activator="{ on }">
            <v-text-field v-model="date4" label="Fecha Final" prepend-icon="event"  v-on="on"></v-text-field>
          </template>
          <v-date-picker v-model="date4" color="#668c2d" scrollable  locale="gt">
            <v-btn flat color="primary" @click="modal4 = false">Cancelar</v-btn>
            <v-btn flat color="primary" @click="$refs.dialog4.save(date4)">OK</v-btn>
          </v-date-picker>
        </v-dialog>     
    </v-flex>
  </v-layout>
</template>          
  </div>
  <div class="card-body d-flex justify-content-between align-items-center">
           <center>  <v-btn @click="guardarEspecificoProducto" style="background-color:#668c2d"  dark class="mb-2">Generar</v-btn></center>
           </div>
				</div>
			</div>
		</div>

                
            
                  
                     </div>
                </div>
            </div>        
        </div>
  
        
        

        </div>
        
</template>

<script>
  import multiselect from 'vue-multiselect'
  export default {
    components:{
            multiselect
    },
    data: () => ({
      date1: new Date().toISOString().substr(0, 10),
      date2: new Date().toISOString().substr(0, 10),
      date3: new Date().toISOString().substr(0, 10),
      date4: new Date().toISOString().substr(0, 10),
      menu: false,
      modal1: false,
      modal2: false,
      modal3: false,
      modal4: false,
      clientes: [],
      productos: [],
      rangos: [{"nombre": "Semana"}, {"nombre": "Mes"}, {"nombre": "Año"}],
      editedItem:{
        idCliente: '',
        idProducto: '',
        totalSemana: 0,
        totalDia: 0,
        productoGanancia: '',
        productoMasVendido: '',
        productoMenosVendido: '',
        totalProds: 0,
        totalClientes: 0,
      }
    }),
  
    created() {
            this.cargaClientes();
            this.cargaProducto();
            this.totalVentas();
        },

    methods: {
      cargaClientes() {
                let me = this;
                axios.get('/clientes')
                .then(function (response) {
                    me.clientes = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
      },
      cargaProducto(){
                let me = this;
                axios.get('/producto')
                .then(function (response) {
                    me.productos = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
      },
      generalVentas(){
        
      },
      generalProductos(){
      },
      guardarEspecificoClientes(){
        axios({
            method: 'post',
            url: '/ventas/reporteVClientes',
            responseType:'arraybuffer',
            data: {
                date1: this.date1,
                date2: this.date2,
                idCliente: this.editedItem.idCliente.idPersona
            }
        }).then(function (response) {
            let blob = new Blob([response.data], { type:   'application/pdf' } )
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = 'reporteClientes.pdf'
            link.click()
        }).catch(function (error) {
            swal.fire({
            position: 'top-end',
            type: 'error',
            title: error.response.data.error,
            showConfirmButton: true});
          });
      },
      guardarEspecificoProducto(){
        axios({
            method: 'post',
            url: '/ventas/reporteProductos',
            responseType:'arraybuffer',
            data: {
                date3: this.date3,
                date4: this.date4,
                idProducto: this.editedItem.idProducto.id
            }
        }).then(function (response) {
            let blob = new Blob([response.data], { type:   'application/pdf' } )
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = 'reporteProductos.pdf'
            link.click()
        }).catch(function (error) {
            swal.fire({
            position: 'top-end',
            type: 'error',
            title: error.response.data.error,
            showConfirmButton: true});
          });
      },
      totalVentas(){
        let me = this;
          axios.get('/ventas/totalSemana')
          .then(function (response) {
              me.editedItem.totalSemana = response.data;
              if(me.editedItem.totalSemana[0].total > 0)
                me.editedItem.totalSemana = me.editedItem.totalSemana[0].total;
              else
                me.editedItem.totalSemana = 0;
          })
          .catch(function (error) {
              console.log(error.response);
          });

          axios.get('/ventas/totalDia')
          .then(function (response) {
              me.editedItem.totalDia = response.data;
              if(me.editedItem.totalDia[0].dia > 0)
                me.editedItem.totalDia = me.editedItem.totalDia[0].dia;
              else
                me.editedItem.totalDia = 0;
          })
          .catch(function (error) {
              console.log(error.response);
          });

          axios.get('/ventas/productoGanancias')
          .then(function (response) {
              me.editedItem.productoGanancia = response.data;
              me.editedItem.productoGanancia = me.editedItem.productoGanancia[0].nombre;
          })
          .catch(function (error) {
              console.log(error.response);
          });

          axios.get('/ventas/productoMasVendido')
          .then(function (response) {
              me.editedItem.productoMasVendido = response.data;
              me.editedItem.productoMasVendido = me.editedItem.productoMasVendido[0].producto;
          })
          .catch(function (error) {
              console.log(error.response);
          });

          axios.get('/ventas/productoMenosVendido')
          .then(function (response) {
              me.editedItem.productoMenosVendido = response.data;
              me.editedItem.productoMenosVendido = me.editedItem.productoMenosVendido[0].producto;
          })
          .catch(function (error) {
              console.log(error.response);
          });

          axios.get('/totalClientes')
          .then(function (response) {
              me.editedItem.totalClientes = response.data;
              me.editedItem.totalClientes = me.editedItem.totalClientes[0].total;
          })
          .catch(function (error) {
              console.log(error.response);
          });

          axios.get('/totalProds')
          .then(function (response) {
              me.editedItem.totalProds = response.data;
            
          })
          .catch(function (error) {
              console.log(error.response);
          });
          //Verificar si no son nulo.
      },
    }
  }
</script>


<style scoped>
.info-box {
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  height: 80px;
  display: flex;
  cursor: default;
  background-color: #fff;
  position: relative;
  overflow: hidden;
  margin-bottom: 30px; }
  .info-box .icon {
    display: inline-block;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.12);
    width: 80px; }
    .info-box .icon i {
      color: #fff;
      font-size: 50px;
      line-height: 80px; }
    .info-box .icon .chart.chart-bar {
      height: 100%;
      line-height: 100px; }
      .info-box .icon .chart.chart-bar canvas {
        vertical-align: baseline !important; }
    .info-box .icon .chart.chart-pie {
      height: 100%;
      line-height: 123px; }
      .info-box .icon .chart.chart-pie canvas {
        vertical-align: baseline !important; }
    .info-box .icon .chart.chart-line {
      height: 100%;
      line-height: 115px; }
      .info-box .icon .chart.chart-line canvas {
        vertical-align: baseline !important; }
  .info-box .content {
    display: inline-block;
    padding: 7px 10px; }
    .info-box .content .text {
      font-size: 13px;
      margin-top: 11px;
      color: #555; }
    .info-box .content .number {
      font-weight: normal;
      font-size: 26px;
      margin-top: -4px;
      color: #555; }

.info-box.hover-zoom-effect .icon {
  overflow: hidden; }
  .info-box.hover-zoom-effect .icon i {
    -moz-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease; }

.info-box.hover-zoom-effect:hover .icon i {
  opacity: 0.4;
  -moz-transform: rotate(-32deg) scale(1.4);
  -ms-transform: rotate(-32deg) scale(1.4);
  -o-transform: rotate(-32deg) scale(1.4);
  -webkit-transform: rotate(-32deg) scale(1.4);
  transform: rotate(-32deg) scale(1.4); }

.info-box.hover-expand-effect:after {
  background-color: rgba(0, 0, 0, 0.05);
  content: ".";
  position: absolute;
  left: 80px;
  top: 0;
  width: 0;
  height: 100%;
  color: transparent;
  -moz-transition: all 0.95s;
  -o-transition: all 0.95s;
  -webkit-transition: all 0.95s;
  transition: all 0.95s; }

.info-box.hover-expand-effect:hover:after {
  width: 100%; }
  .bg-red {
  background-color: #F44336 !important;
  color: #fff; }
  .bg-red .content .text,
  .bg-red .content .number {
    color: #fff !important; }

.bg-pink {
  background-color: #E91E63 !important;
  color: #fff; }
  .bg-pink .content .text,
  .bg-pink .content .number {
    color: #fff !important; }

.bg-purple {
  background-color: #9C27B0 !important;
  color: #fff; }
  .bg-purple .content .text,
  .bg-purple .content .number {
    color: #fff !important; }

.bg-deep-purple {
  background-color: #673AB7 !important;
  color: #fff; }
  .bg-deep-purple .content .text,
  .bg-deep-purple .content .number {
    color: #fff !important; }

.bg-indigo {
  background-color: #3F51B5 !important;
  color: #fff; }
  .bg-indigo .content .text,
  .bg-indigo .content .number {
    color: #fff !important; }

.bg-blue {
  background-color: #2196F3 !important;
  color: #fff; }
  .bg-blue .content .text,
  .bg-blue .content .number {
    color: #fff !important; }

.bg-light-blue {
  background-color: #03A9F4 !important;
  color: #fff; }
  .bg-light-blue .content .text,
  .bg-light-blue .content .number {
    color: #fff !important; }

.bg-cyan {
  background-color: #00BCD4 !important;
  color: #fff; }
  .bg-cyan .content .text,
  .bg-cyan .content .number {
    color: #fff !important; }

.bg-teal {
  background-color: #009688 !important;
  color: #fff; }
  .bg-teal .content .text,
  .bg-teal .content .number {
    color: #fff !important; }

.bg-green {
  background-color: #4CAF50 !important;
  color: #fff; }
  .bg-green .content .text,
  .bg-green .content .number {
    color: #fff !important; }

.bg-light-green {
  background-color: #8BC34A !important;
  color: #fff; }
  .bg-light-green .content .text,
  .bg-light-green .content .number {
    color: #fff !important; }

.bg-lime {
  background-color: #CDDC39 !important;
  color: #fff; }
  .bg-lime .content .text,
  .bg-lime .content .number {
    color: #fff !important; }

.bg-yellow {
  background-color: #ffe821 !important;
  color: #fff; }
  .bg-yellow .content .text,
  .bg-yellow .content .number {
    color: #fff !important; }

.bg-amber {
  background-color: #FFC107 !important;
  color: #fff; }
  .bg-amber .content .text,
  .bg-amber .content .number {
    color: #fff !important; }

.bg-orange {
  background-color: #FF9800 !important;
  color: #fff; }
  .bg-orange .content .text,
  .bg-orange .content .number {
    color: #fff !important; }

.bg-deep-orange {
  background-color: #FF5722 !important;
  color: #fff; }
  .bg-deep-orange .content .text,
  .bg-deep-orange .content .number {
    color: #fff !important; }

.bg-brown {
  background-color: #795548 !important;
  color: #fff; }
  .bg-brown .content .text,
  .bg-brown .content .number {
    color: #fff !important; }

.bg-grey {
  background-color: #9E9E9E !important;
  color: #fff; }
  .bg-grey .content .text,
  .bg-grey .content .number {
    color: #fff !important; }

.bg-blue-grey {
  background-color: #607D8B !important;
  color: #fff; }
  .bg-blue-grey .content .text,
  .bg-blue-grey .content .number {
    color: #fff !important; }

.bg-black {
  background-color: #000000 !important;
  color: #fff; }
  .bg-black .content .text,
  .bg-black .content .number {
    color: #fff !important; }

.bg-white {
  background-color: #ffffff !important;
  color: #fff; }
  .bg-white .content .text,
  .bg-white .content .number {
    color: #fff !important; }
    
</style>
