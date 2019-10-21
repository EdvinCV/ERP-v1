
<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <meta charset="UTF-8">
    <title>Reporte de Compras</title>

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
    <center>
      <h2 style="color:#668c2d">Reporte de Compras</h2>
    </center>

    <table style="width: 100%" class="table">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Fecha</th>
              <th class="th">Parqueo</th>
              <th class="th">Combustible</th>
              <th class="th">Varios</th>
              <th class="th">Impuestos</th>
              <th class="th">Total</th>
              
            </tr>
          </thead>
          <tbody>
          @foreach($encabezados as $p)
            <tr>
              <td>{{ $p->id}}</td>
              <td>{{ $p->fecha}}</td>
              <td>{{ $p->gastosParqueo}}</td>
              <td>{{ $p->combustible}}</td>
              <td>{{ $p->gastosVarios}}</td>
              <td>{{ $p->impuestos}}</td>
              <td>{{ $p->totalCompra}}</td>
            </tr>
          @endforeach
          <tr>
            <td>-</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            
            <td>TOTAL </td>
            @foreach($total as $p)
                <td>{{$p->total}}</td>
             @endforeach
            <td></td>
          </tr>
          </tbody>
        </table>
      <br>
       
       <div class="container">
        <center> <h3 style="color:#668c2d">Gastos</h3></center>
        <hr>
        @foreach($parqueo as $p)
              <p>Gastos Parqueo: {{$p->parqueo}}</p>
          @endforeach
          @foreach($combustible as $c)
              <p>Combustible: {{$c->combustible}}</p>
          @endforeach
          @foreach($varios as $v)
              <p>Gastos Varios: {{$v->varios}}</p>
          @endforeach
          @foreach($impuestos as $i)
              <p>Impuestos: {{$i->impuestos}}</p>
          @endforeach
        </div>
         
          </div>
        </div>
        

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