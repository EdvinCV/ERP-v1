<!doctype html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Clientes</title>

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
    <h2 style="color:#668c2d">Reporte Clientes</h2>
  </center>
     
     <table class="table" style="width: 100%">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Nombre</th>
              <th class="th">Apellido</th>
              <th class="th">Nombre Cliente</th>
              <th class="th">Dirección</th>
            </tr>
          </thead>
          <tbody>
          @foreach($clientes as $c)
            <tr>
              <td></td>
              <td>{{ $c->nombre}}</td>
              <td>{{ $c->apellido}}</td>
              <td>{{ $c->nombreCliente}}</td>
              <td>{{ $c->direccion}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
        <hr>
        <br>

  </body>
</html>