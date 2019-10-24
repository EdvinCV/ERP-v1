<!doctype html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Orden de Compra</title>
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
  <div >
    <center><h2 style="color:#668c2d">Orden de Compra #{{$id}}</h2></center>

    <table style="width: 100%" class="table">
          <thead style="background-color:#668c2d">
            <tr>
              <th class="th">#</th>
              <th class="th">Producto</th>
              <th class="th">Presentacion</th>
              <th class="th">Proveedor</th>
              <th class="th">Cantidad</th>
              <th class="th">Precio</th>
              <th class="th">Total</th>
            </tr>
          </thead>
          <tbody>
          @foreach($productos as $p)
            <tr>
              <td></td>
              <td>{{ $p->producto}}</td>
              <td>{{ $p->presentacion}}</td>
              <td>{{ $p->nombreProveedor}}</td>
              <td>{{ $p->cantidad}}</td>
              <td>{{ $p->preciocompra}}</td>
              <td id="subtotal">{{ $p->cantidad * $p->preciocompra}}</td>
            </tr>
          @endforeach
          <tr>
            <td>-</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>-----</td>
            <td>TOTAL </td>
            @foreach($total as $t)
              <td>{{$t->totalCompra}}</td>
            @endforeach
          </tr>
          </tbody>
        </table>
        
      <br>
       <center> <h3 style="color:#668c2d">Resumen compra</h3></center>
       <table width="50%" style="margin: 0 auto">
       <thead>
       <tr>
       <th class="th" style="background-color:#668c2d" ><center>Datos</center></th>
       </tr>
       </thead>
       <tbody>
       <tr>
       <th>
       @foreach($orden as $o)
            <p>Total Compra: {{$o->totalCompra}}</p>
            <p>Gastos Parqueo: {{$o->gastosParqueo}}</p>
            <p>Combustible: {{$o->combustible}}</p>
            <p>Gastos Varios: {{$o->gastosVarios}}</p>
            <p>Impuestos: {{$o->impuestos}}</p>
            <p>Total Venta: {{$o->totalVenta}}</p>
            <p>Utilidad Venta: {{$o->utilidadVenta}}</p>
            <p>Observaciones: {{$o->observaciones}}</p>
        @endforeach
       </th>
       </tr>
       </tbody>
       </table>





       <hr>
     

        <br>
       
        <center><h2 style="color:#668c2d">Productos distribuidos</h2></center>

        <!-- CLIENTES -->
        @foreach($clientes as $c)
        <div>
          <div>
            <h3 style="color:#668c2d">{{$c->nombreCliente}}</h3>
          </div>
          <div>
            <table style="width: 100%" class="table">
              <thead style="background-color:#668c2d">
                <tr>
                  <th class="th">Producto</th>
                  <th class="th">Presentacion</th>
                  <th class="th">Cantidad</th>
                </tr>
              </thead>
              <hr>
              <br>
              <tbody>
             
              @foreach($prodsClientes as $p)
                @if($p->idPersona == $c->idPersona)
                <tr>
                  <td>{{$p->producto}}</td>
                  <td>{{$p->presentacion}}</td>
                  <td>{{$p->cantidad}}</td>
                </tr>
              
                @endif
              @endforeach
              </tbody>
            

            </table>
          </div>
        </div>
        @endforeach
        <br>
        <br>
        <br>

</body>
</html>