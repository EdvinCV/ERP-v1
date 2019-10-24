
<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <meta charset="UTF-8">
    <title>Reporte de Compras</title>

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
  <hr class="hrt">
  <div>
    <center>
      <h2 style="color:#668c2d">Reporte de Compras</h2>
    </center>

    <table style="width: 100%" class="table">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Finalizado</th>
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
            <td>-----</td>
            <td>TOTAL </td>
            @foreach($total as $p)
                <td>{{$p->total}}</td>
             @endforeach
           
          </tr>
          </tbody>
        </table>
        <hr>
      <br>
       
     
        <center> <h2 style="color:#668c2d">Gastos</h2></center>
        <hr>
        <div class="container">
       <table width="50%" style="margin: 0 auto">
       <thead>
       <tr>
       <th class="th" style="background-color:#668c2d" ><center>Datos</center></th>
       </tr>
       </thead>
       <tbody>
       <tr>
       <th>
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
       </th>
       </tr>
       </tbody>
       </table>
       
        </div>
         
          </div>
        </div>
        

      
</body>
</html>