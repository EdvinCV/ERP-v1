<?php 
     $i = 1;
?>
<!doctype html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Reporte ventas</title>

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
<center><img src="assets/images/descarga.jpg" width="230" height="70"></center>
<hr class="hr">
  <center><h2 style="color:#668c2d">Reporte Ventas</h2></center>
  <br>
     <div class="contenedor">   
          <h1>VENTAS    @foreach($cliente as $c) {{$c->nombreCliente}} Total Q. {{$c->Total}} @endforeach</h1>
     </div>
    
        <h1>  </h1>
    <hr>
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
            <td>TOTAL </td>
            <td></td>
          </tr>
          </tbody>
        </table>

        
    </body>
</html>