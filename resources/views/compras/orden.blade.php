<?php 
     $hoy = getdate();
     $total = 0;
?>

<head>
<style>
	.contenedor
	{
		border:1px solid;
		text-align:center;
	}
	.contenedor>span {
		display:inline-block;
		vertical-align:middle;
		line-height:normal;
	}
    .detalle{
        padding-top: 1cm;
        padding-left: 1.2cm;
        padding-right: 0.7cm;
        height: 10.9cm;
        border:1px solid;
        border-color: blue;
    }
    .descripcion{
        width: 7.7cm;
        height: 10.4cm;
        float:left;
    }
    .columna{
        width: 2cm;
        height: 10.4cm;
        float:left;
    }
	</style>
</head>

<html>
     <
       h5>QUETZALTENANGO, GUATEMALA</h5>
     <h5>ADAM - INCOFIN</h5>
     <div class="contenedor">
          <h1>Orden de Compra <?php 
          print_r($hoy["mday"] . '/');
          print_r($hoy["mon"] . '/');
          print_r($hoy["year"] . '<br>');
     ?></h1>
     </div>
    
        <h1>  </h1>
    
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Producto</th>
              <th>Presentacion</th>
              @foreach($clientes as $c)
                <th>{{$c->nombreCliente}}</th>
              @endforeach
              <th>Total</th>    
              <th>Precio</th>
              <th>Total</th>
            </tr>
          </thead>
          <div class="detalle">
            <div class="descripcion">
                @foreach($productos as $p)
                    <p>{{$p->producto}}  {{$p->presentacion}}</p>
                @endforeach  
            </div>
            @foreach($clientes as $c)
            <div class="columna">
                
                    @foreach($productos as $p)
                        @if($p->nombreCliente == $c->nombreCliente)
                            {{$p->cantidad}}
                            <br>
                        @endif
                    @endforeach
                
            </div>
            @endforeach
          </div>


        </table>
</html>