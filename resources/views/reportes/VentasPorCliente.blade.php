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
  <hr class="hrt">
  <center>
    <h2 style="color:#668c2d">Ventas: @foreach($cliente as $c) {{$c->nombreCliente}}@endforeach</h2>
  </center>
  
     <h3 style="color:#668c2d">Detalles de ventas</h3>
     <table class="table" style="width: 100%">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Total</th>
              <th class="th">Subtotal</th>
              <th class="th">IVA</th>
              <th class="th">Factura</th>
              <th class="th">Forma Pago</th>
              <th class="th">Cheque</th>
              <th class="th">Banco</th>
              <th class="th">Fecha</th>
            </tr>
          </thead>
          <tbody>
          @foreach($detallesVentas as $p)
            <tr>
              <td><?php echo $i; $i++;?></td>
              <td>{{ $p->total}}</td>
              <td>{{ $p->totalSinIVA}}</td>
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
            <td>@foreach($cliente as $c) {{$c->Total}}@endforeach</td>
          </tr>
          </tbody>
        </table>

        <div class="informatio" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 60%;">
                &copy; {{ date('Y') }} - 2019 INCOFIN.
            </td>
            <td align="right" style="width: 40%;">
              Tel. (502) 7767 4672 |  INFO@INCOFIN.COM.GT
            </td>
        </tr>

    </table>
</div>
        
    </body>
</html>