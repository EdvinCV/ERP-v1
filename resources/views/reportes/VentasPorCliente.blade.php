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
          <h1>VENTAS    @foreach($cliente as $c) {{$c->nombreCliente}} Total Q. {{$c->Total}} @endforeach</h1>
     </div>
    
        <h1>  </h1>
    
     <table style="width: 100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Subtotal</th>
              <th>IVA</th>
              <th>Total</th>
              <th>Factura</th>
              <th>Forma Pago</th>
              <th>Cheque</th>
              <th>Banco</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
          @foreach($detallesVentas as $p)
            <tr>
              <td></td>
              <td>{{ $p->totalSinIVA}}</td>
              <td>{{ $p->total}}</td>
              <td>{{ $p->iva}}</td>
              <td>{{ $p->numeroFactura}}</td>
              <td>{{ $p->nombreTipo}}</td>
              <td>{{ $p->cheque}}</td>
              <td>{{ $p->banco}}</td>
              <td>{{ $p->created_at}}</td>
            </tr>
          @endforeach
          <tr>
            <td>-</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>----- </td>
            <td>----- </td>
            <td>----- </td>
            <td>-----</td>
          </tr>
          <tr>
            <td>-</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>----- </td>
            <td>----- </td>
            <td>TOTAL </td>
            <td></td>
          </tr>
          </tbody>
        </table>

        
    </body>
</html>