<?php 
     $hoy = getdate();
     $total = 0;
?>

<head>
<style>
	.contenedor{
        border:1px solid;
		width: 13.5cm;
        height: 21.3cm;
        border-color: red;
	}
    .nombre{
        padding-top: 3.3cm;
        padding-left: 2.3cm;
    }
    .direccion{
        padding-top: 0.8cm;
        padding-left: 2.3cm;
    }
    .fecha{
        width: 5.2cm;
        padding-top: 0.8cm;
        padding-left: 2.3cm;
        float: left;
    }
    .nit{
        padding-top: 0.8cm;
        padding-left: 0.8cm;
    }
    .encabezado{
        border:1px solid;
        border-color: green;
    }
    .detalle{
        padding-top: 1cm;
        padding-left: 1.2cm;
        padding-right: 0.7cm;
        height: 10.9cm;
        border:1px solid;
        border-color: blue;
    }
    .cantidad{
        width: 2cm;
        height: 10.4cm;
        float:left;
    }
    .descripcion{
        width: 7.7cm;
        height: 10.4cm;
        float:left;
    }
    .valor{
        width: 2.3cm;
        height: 10.4cm;
        float:left;
    }
    .letras{
        height: 0.6cm;
    }
    .info{
        height: 2.1cm;
    }
    .total{
        margin-left: 11cm;
    }

	</style>
</head>

<html>
     <div class="contenedor">
     <div class="encabezado">
        <div class="nombre">
            @foreach($ventas as $v)
                {{$v->nombreCliente}}
                <br>
            @endforeach
        </div>
        <div class="direccion">
            @foreach($ventas as $v)
                {{$v->direccion}}
                <br>
            @endforeach
        </div>
        <div class="fecha">
            @foreach($ventas as $v)
                {{$v->created_at}}
                <br>
            @endforeach
        </div>
        <div class="nit">
            @foreach($ventas as $v)
                {{$v->nit}}
                <br>
            @endforeach
        </div>
        </div>
        <div class="detalle">
            <div class="cantidad">
                @foreach($detalles as $d)
                    {{$d->cantidad}}
                    <br>
                @endforeach
            </div>
            <div class="descripcion">
                @foreach($detalles as $d)
                    {{$d->producto}}   -   {{$d->presentacion}}
                    <br>
                @endforeach
            </div>
            <div class="valor">
                @foreach($detalles as $d)
                    {{$d->subtotal}}
                    <br>
                @endforeach
            </div>
        </div>
        <div class="final">
            <div class="letras">
                Mil quinientos ochenta y cuatro quetzaltes
            </div>
            <div class="info">
                Info
            </div>
            <div class="total">
                @foreach($ventas as $v)
                    {{$v->total}}
                    <br>
                @endforeach
            </div>
        </div>
     </div>
</html>