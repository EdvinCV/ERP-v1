<?php 
     $hoy = getdate();
     $total = 0;
?>

  
</script>
<head>
<style>

  table, th, td {
   
    border-collapse: collapse;
  }
	.contenedor
	{
	
		text-align:center;
	}
	.contenedor>span {
		display:inline-block;
		vertical-align:middle;
		line-height:normal;
	}
    .detalle{
        padding-top: 1cm;
        padding-left: 1.2cm;
        padding-right: 0.7cm;
        height: 10.9cm;
        border:1px solid;
        border-color: blue;
    }
    .descripcion{
        width: 7.7cm;
        height: 10.4cm;
        float:left;
    }
    .columna{
        width: 2cm;
        height: 10.4cm;
        float:left;
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
  <br>
     <div class="contenedor">
          <h1>Orden de Compra #{{$id}}<?php
     ?></h1>
     <hr>
     </div>

     <table style="width: 100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Producto</th>
              <th>Presentacion</th>
              <th>Proveedor</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
          @foreach($productos as $p)
            <tr>
              <td></td>
              <td>{{ $p->producto}}</td>
              <td>{{ $p->presentacion}}</td>
              <td>{{ $p->nombreProveedor}}</td>
              <td>{{ $p->cantidad}}</td>
              <td>{{ $p->preciocompra}}</td>
              <td id="subtotal">{{ $p->cantidad * $p->preciocompra}}</td>
            </tr>
          @endforeach
          <tr>
            <td>-</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>----- </td>
            <td>-----</td>
          </tr>
          <tr>
            <td>-</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>TOTAL </td>
            <td></td>
          </tr>
          </tbody>
        </table>
<br>
       <center> <h1>Resumen compra</h1></center>
       <hr>
        @foreach($orden as $o)
            <p>Total Compra: {{$o->totalCompra}}</p>
            <p>Gastos Parqueo: {{$o->gastosParqueo}}</p>
            <p>Combustible: {{$o->combustible}}</p>
            <p>Gastos Varios: {{$o->gastosVarios}}</p>
            <p>Impuestos: {{$o->impuestos}}</p>
            <p>Total Venta: {{$o->totalVenta}}</p>
            <p>Utilidad Venta: {{$o->utilidadVenta}}</p>
            <p>Observaciones: {{$o->observaciones}}</p>
        @endforeach

        <br>

        <center><h1>Productos distribuidos</h1></center>
<hr>
        <!-- CLIENTES -->
        @foreach($clientes as $c)
        <div>
          <div>
            <h2>{{$c->nombreCliente}}</h2>
          </div>
          <div>
            <table style="width: 50%">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Presentacion</th>
                  <th>Cantidad</th>
                </tr>
              </thead>
              <hr>
              <br>
              <tbody>
             
              @foreach($prodsClientes as $p)
                @if($p->idPersona == $c->idPersona)
                <tr>
                  <td>{{$p->producto}}</td>
                  <td>{{$p->presentacion}}</td>
                  <td>{{$p->cantidad}}</td>
                </tr>
              
                @endif
              @endforeach
              </tbody>
            

            </table>
          </div>
        </div>
        @endforeach
        
    </body>
</html>