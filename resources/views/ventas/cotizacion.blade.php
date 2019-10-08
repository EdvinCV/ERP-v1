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
          <h1>Cotizacion</h1>
     </div>
    
        <h1>  </h1>
    
        
              </p>
           

     <table style="width: 100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Producto</th>
              <th>Presentacion</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
          @foreach($detalles as $d)
          <tr>
            <td>-</td>
            <td>{{$d['nombreProducto']}}</td>
            <td>{{$d['presentacion']}}</td>
            <td>{{$d['cantidad']}}</td>
            <td>{{$d['precio']}}</td>
            <td>{{$d['sub']}}</td>
          </tr>
          @endforeach
          <tr>
            <td>-</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>TOTAL </td>
            <td>{{$total}}</td>
          </tr>
          </tbody>
        </table>

    </body>
</html>