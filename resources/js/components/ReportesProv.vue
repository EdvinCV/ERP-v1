
<template>
      
        <div class="row clearfix">
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            <div class="info-box bg-cyan hover-zoom-effect">
              <div class="icon">
                <i class="material-icons">library_books</i>
              </div>
              <div class="content">
                <div class="text">PROVEEDORES</div>
                <div class="number count-to" >{{this.editedItem.totalProvs}}</div>
              </div>
            </div>
            <div class="info-box bg-orange hover-zoom-effect">
              <div class="icon">
                <i class="material-icons">person_add</i>
              </div>
              <div class="content">
                <div class="text">MAYOR PROVEEDOR</div>
                <div class="number count-to" >{{this.editedItem.mayorProv[0].nombreProveedor}}</div>
              </div>
            </div>
            <div class="info-box bg-blue-grey hover-zoom-effect">
              <div class="icon">
                <i class="material-icons">apps</i>
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
      <center><h2>Historial Proveedores</h2></center>
      <hr>
    </div>
    
    <div class="body">
      <div class="row">
			  <div class="col-md-8 col-md-offset-2">
				  <div class="card ">
            <div class="card-body d-flex justify-content-between align-items-center"> 
              <v-flex lg6 md6 xs6 pa-2>
                <multiselect v-model="editedItem.idProveedor" :options="proveedores" placeholder="Seleccione un proveedor"
                    label="nombreProveedor" track-by="nombreProveedor"></multiselect>
              </v-flex>
              <center> <v-btn @click="reporteGeneral" style="background-color:#668c2d"  dark class="mb-2">General</v-btn></center>
            </div>

           				
<template>
  
 
</template>


</v-layout>
        
					
          	<div class="card-body d-flex justify-content-between align-items-center">
           <center>  <v-btn @click="reporteEspecifico" style="background-color:#668c2d"  dark class="mb-2">Generar</v-btn></center>
           </div>
				</div>
			</div>
		</div>
         
    <hr>
                 
                    <br>
  

                
            
                  
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
      date: new Date().toISOString().substr(0, 10),
      date2: new Date().toISOString().substr(0, 10),
      date3: new Date().toISOString().substr(0, 10),
      date4: new Date().toISOString().substr(0, 10),
      menu: false,
      modal: false,
      proveedores: [],
      editedItem:{
        idProveedor: '',
        totalProvs: 0,
        mayorProv: '',
        totalProds: 0
      }
    }),
  
    created() {
            this.cargaProveedores()
            this.cargaDatosProveedores()
            this.cargaProv()
        },

    methods: {
      cargaDatosProveedores(){
        let me = this;
        axios.get('/proveedores')
        .then(function (response) {
            me.proveedores = response.data;
            me.editedItem.totalProvs = me.proveedores.length; 
        })
        .catch(function (error) {
            console.log(error.response);
        });

        axios.get('/mayorProv')
        .then(function (response) {
            me.editedItem.mayorProv = response.data;
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

      },
      cargaProveedores() {
                let me = this;
                axios.get('/proveedores')
                .then(function (response) {
                    me.proveedores = response.data;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
      },
      reporteGeneral(){
        window.open(window.location.origin +'/reporteProveedores');
      },
      reporteEspecifico(){
        if(this.editedItem.idProveedor == ''){
          swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Seleccione un proveedor.',
                            showConfirmButton: false,
                            timer: 1500});

        }else
          window.open(window.location.origin +'/reporteProveedores/'+this.editedItem.idProveedor.idPersona);
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
