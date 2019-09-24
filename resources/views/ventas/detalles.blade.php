<?php 
     $hoy = getdate();
     $total = 0;
?>

<head>
<style>
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
	</style>
</head>

<html>
     <h5>QUETZALTENANGO, GUATEMALA</h5>
     <h5>ADAM - INCOFIN</h5>
     <div class="contenedor">
          <h1>Venta</h1>
     </div>
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
     <h4>Generado Por: {{Auth::user()->name}} - {{Auth::user()->email}}</h4>

      @foreach($ventas as $v)
        <h4>Fecha Venta: {{ $v->created_at }}</h4>
        <h4>Forma pago: {{ $v->nombreTipo }}</h4>
        <h4>Cliente: {{ $v->nombreCliente }}</h4>
        <h4>Direccion: {{ $v->direccion }}</h4>
        <h4>NIT: {{ $v->nit }}</h4>
      @endforeach
  
     <br>
     <h2>Productos vendidos</h2>
    
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-dark">
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
        @foreach($ventas as $v)
          <h4>Subtotal: {{$v->totalSinIVA }}</h4>
          <h4>IVA: {{ $v->iva }}</h4>
          <h4>Total: {{ $v->total }}</h4>
        @endforeach
</html>