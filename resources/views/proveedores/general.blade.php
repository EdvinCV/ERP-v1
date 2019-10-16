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
    <h6 style="color:#668c2d">Reporte Proveedores</h6>
  </center>
     
     <table class="table" style="width: 100%">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Proveedor</th>
              <th class="th">Direccion</th>
              <th class="th">Telefono</th>
              <th class="th">NIT</th>
              <th class="th">Total Productos</th>
            </tr>
          </thead>
          <tbody>
          @foreach($proveedores as $p)
            <tr>
              <td></td>
              <td>{{ $p->nombreProveedor}}</td>
              <td>{{ $p->direccion}}</td>
              <td>{{ $p->telefono}}</td>
              <td>{{ $p->nit}}</td>
              <td>{{ $p->productos}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
        <hr>
        <br>

        <!-- CLIENTES -->
        @foreach($proveedores as $prov)
        <div>
          <div>
            <h2>{{$prov->nombreProveedor}}</h2>
            <hr>
          </div>
          <div>
            <table style="width: 50%">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Presentacion</th>
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
            <hr>
            <br>
          </div>
        </div>
        @endforeach
        
        

    <div class="informatio" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 60%;">
                &copy; {{ date('Y') }} - 2019 ADAM · Asociación de Desarrollo Agrícola y Empresarial.
            </td>
            <td align="right" style="width: 40%;">
              Tel. (502) 7767 4672 | info@adam.org.gt
            </td>
        </tr>

    </table>
  </div>
  </body>
</html>