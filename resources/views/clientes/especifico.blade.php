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
           @foreach($proveedor as $p)
            <h1>Proveedor: {{$p->nombreProveedor}}</h1>
          @endforeach
     <hr>
     </div>
        <!-- PROVEEDORES -->
        @foreach($prodsProveedor as $prod)
        <div>
          <div>
            <h2>{{$prod->nombre}} - {{$prod->presentacion}}</h2>
            <hr>
          </div>
          <div>
            <table style="width: 50%">
              <thead>
                <tr>
                  <th>Calificación</th>
                  <th>Observación</th>
                  <th>Fecha</th>
                </tr>
              </thead>
              <tbody>
              @foreach($historial as $h)
                @if($h->idproducto == $prod->id)
                <tr>
                  <td>{{$h->calificacion}}</td>
                  <td>{{$h->descripcion}}</td>
                  <td>{{$h->created_at}}</td>
                </tr>
                @endif
              @endforeach
              </tbody>
            

            </table>
            <hr>
            <br>
          </div>
        </div>
        @endforeach
        
    </body>
</html>