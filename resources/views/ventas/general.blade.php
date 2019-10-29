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
<hr class="hr">
     <center><h2 style="color:#668c2d">Resumen de ventas</h2></center>
  <br>

     <table class="table" style="width: 100%">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Fecha</th>
              <th class="th">No. Factura</th>
              <th class="th">Cliente</th>
              <th class="th">IVA</th>
              <th class="th">Subtotal</th>
              <th class="th">Total</th>
            </tr>
          </thead>
          <tbody>
          @foreach($ventas as $p)
            <tr>
              <td><?php echo $i; $i++;?></td>
              <td>{{ $p->fecha}}</td>
              <td>{{ $p->numeroFactura}}</td>
              <td>{{ $p->nombreCliente}}</td>
              <td>{{ number_format((float)$p->iva,2,'.','')}}</td>
              <td>{{ number_format((float)$p->totalSinIVA,2,'.','')}}</td>
              <td>{{number_format((float)$p->total,2,'.','')}}</td>
            </tr>
          @endforeach
          <tr>
            <td>-</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>TOTAL </td>
            <td>@foreach($total as $c){{number_format((float)$c->total,2,'.','')}}@endforeach</td>
          </tr>
   
          </tbody>
        </table>


     
        
    </body>
</html>