<?php 
     $hoy = getdate();
     $total = 0;
?>

  
</script>
<head>
<style>

  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
  }
	.contenedor
	{
		border:1px solid;
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
</head>

<html>
      
       <h5>QUETZALTENANGO, GUATEMALA</h5>
     <h5>ADAM - INCOFIN</h5>
     <div class="contenedor">
          <h1>Orden de Compra #{{$id}}<?php
     ?></h1>
     
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

        <h2>Resumen compra</h2>
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

        <h3>Productos distribuidos</h3>

        <!-- CLIENTES -->
        @foreach($clientes as $c)
        <div>
          <div>
            <h2>{{$c->nombreCliente}}</h2>
          </div>
          <div>
            <table>
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Presentacion</th>
                  <th>Cantidad</th>
                </tr>
              </thead>
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