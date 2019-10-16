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
  <div class="information">
    <center><h5 >Asociación de Desarrollo Agrícola y Microempresarial</h5>
      <h2 style="color:#668c2d">Cotización</h2>  
    </center>     
     <table class="table" style="width: 100%">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Producto</th>
              <th class="th">Presentacion</th>
              <th class="th">Cantidad</th>
              <th class="th">Precio</th>
              <th class="th">Total</th>
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
            <td></td>
          </tr>
          </tbody>
        </table>

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