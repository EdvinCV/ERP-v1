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
    <center><h4 >Asociación de Desarrollo Agrícola y Microempresarial</h4>
      <h2 style="color:#668c2d">Detalles de venta</h2>
    </center>

      @foreach($ventas as $v)
        <h5>Fecha Venta: {{ $v->created_at }}</h5>
        <h5>Forma pago: {{ $v->nombreTipo }}</h5>
        <h5>Cliente: {{ $v->nombreCliente }}</h5>
        <h5>Direccion: {{ $v->direccion }}</h5>
        <h5>NIT: {{ $v->nit }}</h5>
      @endforeach
    
    <br>
    <center> <h3 style="color:#668c2d">Productos vendidos</h3></center>
    <hr class="hrt">
      <table class="table" width="100%" >
          <thead style="background-color:#668c2d" class="thead-dark">
            <!--style="background-color:#668C2D" -->
            <tr>
              <th class="th">#</th>
              <th class="th">Producto</th>
              <th class="th">Presentacion</th>
              <th class="th">Cantidad</th>    
              <th class="th">Precio</th>
              <th class="th">Subtotal</th>
              <th class="th">Proveedor</th>
              
            </tr>
          </thead>
          <tbody>
          @foreach($detalles as $d)
          <!--
            style="background-color:#DCEDC8"
          -->
          <tr>
              <td>1</td>
              <td>{{ $d->producto }}</td>
              <td>{{ $d->presentacion }}</td>
              <td>{{ $d->cantidad }}</td>
              <td>{{ $d->precio }}</td>
              <td>{{ $d->subtotal }}</td>
              <td>{{ $d->nombreProveedor }}</td>
            </tr> 
          @endforeach      
               
          </tbody>
        </table>
        <hr>
    
        @foreach($ventas as $v)
          <h5>Subtotal: {{$v->totalSinIVA }}</h5>
          <h5>IVA: {{ $v->iva }}</h5>
          <h5>Total: {{ $v->total }}</h5>
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