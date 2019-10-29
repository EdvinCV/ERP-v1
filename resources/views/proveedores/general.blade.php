<?php 
  $i = 1;
?> 
<!doctype html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Reporte proveedores</title>

    <style type="text/css">
    
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #000;
            text-decoration: none;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .invoice table {
            margin: 25px;
            border: 1px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #fff;
            color: #000;
        }
        .informatio {
            background-color: #668c2d;
            color: #fff;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
         padding: 50px;
        }
        .hrt{
          background-color: #668c2d;
          width:75%;
        }
        .hrts{
          width:90%;
        }
        .th{
            color:#fff;
        }
    </style>

</head>
<body>
  <br>
  <br>
  <center><img src="assets/images/descarga.jpg" width="230" height="70"></center>
  <center>
    <h2 style="color:#668c2d">Reporte proveedores</h2>
  </center>
  <hr class="hrt">
 
  <div class="information">
    <center> <h3 style="color:#668c2d">Listado de proveedores</h3></center>
     </div>
     <table class="table" style="width: 100%">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Proveedor</th>
              <th class="th">Dirección</th>
              <th class="th">Teléfono</th>
              <th class="th">NIT</th>
              <th class="th">Total productos</th>
            </tr>
          </thead>
          <tbody>
          @foreach($proveedores as $p)
            <tr>
              <td><?php echo $i; $i++;?></td>
              <td>{{ $p->nombreProveedor}}</td>
              <td>{{ $p->direccion}}</td>
              <td>{{ $p->telefono}}</td>
              <td>{{ $p->nit}}</td>
              <td>{{ $p->productos}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
        
      
        <br>

        <center><h3 style="color:#668c2d">Listado de productos por proveedor</h3></center>
        <hr class="hrt">
        <!-- PROVEEDORES -->
        @foreach($proveedores as $prov)
        <div>
          <div>
            <center><h3 style="color:#668c2d">{{$prov->nombreProveedor}}</h3></center>
          
          </div>
          <div>
            <table style="margin: 0 auto" width="50%">
              <thead>
                <tr>
                  <th style="background-color:#668c2d" class="th">Producto</th>
                  <th style="background-color:#668c2d" class="th">Presentación</th>
                </tr>
              </thead>
              <tbody>
              @foreach($prodsProveedores as $p)
                @if($p->idPersona == $prov->idPersona)
                <tr>
                  <td>{{$p->producto}}</td>
                  <td>{{$p->presentacion}}</td>
                </tr>
                @endif
              @endforeach
              </tbody>
            

            </table>
            </div>
            <br>
            <hr class="hrts">
          
          </div>
        </div>
        @endforeach
        
        

    
  </body>
</html>