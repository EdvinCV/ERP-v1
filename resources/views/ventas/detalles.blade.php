<?php 
     $hoy = getdate();
     $total = 0;
?>

<head>
<style>
	.contenedor
	{

    text-align:center;
    
   
	}
	.contenedor>span {
		display:inline-block;
		vertical-align:middle;
		line-height:normal;
  }
  .cont{
  
  }
  .cont>span{
    display:inline-block;
		vertical-align:middle;
		line-height:normal;
  }
  .hr{
  
  width: 80%;
  }
  </style>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<html>
  
<center><img src="assets/images/descarga.jpg" width="230" height="70"></center>
<hr class="hr">
     <center> <h5>QUETZALTENANGO, GUATEMALA</h5>
     <?php 
          echo "<br>" . "Generado Fecha: ";
          print_r($hoy["mday"] . '/');
          print_r($hoy["mon"] . '/');
          print_r($hoy["year"] . '<br>');
          echo "Hora: ";
          print_r($hoy["hours"].':');
          print_r($hoy["minutes"].':');
          print_r($hoy["seconds"]);
     ?>
  </center>


<div class="contenedor">
        <h1>Venta</h1>
        <hr class="hr">
        </div>
      
<br>

     <h6>Generado Por: {{Auth::user()->name}} - {{Auth::user()->email}}</h6>

      @foreach($ventas as $v)
        <h6>Fecha Venta: {{ $v->created_at }}</h6>
        <h6>Forma pago: {{ $v->nombreTipo }}</h6>
        <h6>Cliente: {{ $v->nombreCliente }}</h6>
        <h6>Direccion: {{ $v->direccion }}</h6>
        <h6>NIT: {{ $v->nit }}</h6>
      @endforeach
  
    
    
    <br>
   <center> <h1 >Productos vendidos</h1></center>
<hr>
     <table width="100%" >
          <thead class="thead-dark">
            <!--style="background-color:#668C2D" -->
            <tr>
              <th>#</th>
              <th>Producto</th>
              <th>Presentacion</th>
              <th>Cantidad</th>    
              <th>Precio</th>
              <th>Subtotal</th>
              <th>Proveedor</th>
              
            </tr>
          </thead>
          <tbody>
          @foreach($detalles as $d)
          <!--
            style="background-color:#DCEDC8"
          -->
          <tr>
              <td>1</td>
              <td>{{ $d->producto }}</td>
              <td>{{ $d->presentacion }}</td>
              <td>{{ $d->cantidad }}</td>
              <td>{{ $d->precio }}</td>
              <td>{{ $d->subtotal }}</td>
              <td>{{ $d->nombreProveedor }}</td>
            </tr> 
          @endforeach           
          </tbody>
        </table>
        <hr>
    
        @foreach($ventas as $v)
          <h6>Subtotal: {{$v->totalSinIVA }}</h6>
          <h6>IVA: {{ $v->iva }}</h6>
          <h6>Total: {{ $v->total }}</h6>
        @endforeach

</html>