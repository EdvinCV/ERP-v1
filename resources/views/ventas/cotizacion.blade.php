<?php 
     $hoy = getdate();
     $total = 0;
?>

  
</script>
<head>
<style>

  table, th, td {
    
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
      
     
    }
    .descripcion{
        width: 7.7cm;
        height: 10.4cm;
        float:left;
    }
    .columna{
     
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
     <h1>Cotizacion</h1>
        <hr class="hr">
        </div>
         
        <br>
    
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