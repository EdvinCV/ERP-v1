<!doctype html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Reporte por proyecto</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
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
        .th{
            color:#fff;
        }
    </style>

</head>
<body>
  <br>      
  <center><img src="assets/images/descarga.jpg" width="230" height="70"></center>
  <hr class="hrt">
  <center><h5 >Asociación de Desarrollo Agrícola y Microempresarial</h5>
    @foreach($proveedor as $p)
      <h2 style="color:#668c2d">Proveedor: {{$p->nombreProveedor}}</h2>
    @endforeach
  </center>
  
        <!-- PROVEEDORES -->
        @foreach($prodsProveedor as $prod)
        <div>
          <div>
            <h3 style="color:#668c2d">{{$prod->nombre}} - {{$prod->presentacion}}</h3>
            <hr>
          </div>
          <div>
            <table class="table" style="width: 50%">
              <thead style="background-color:#668c2d">
                <tr>
                  <th class="th">Calificación</th>
                  <th class="th">Observación</th>
                  <th class="th">Fecha</th>
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