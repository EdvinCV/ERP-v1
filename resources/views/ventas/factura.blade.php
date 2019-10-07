<?php 
     $hoy = getdate();
     $total = 0;
?>

<head>
<style>
	.contenedor{
        border:1px solid;
		width: 13.5cm;
        height: 19.9cm;
        border-color: red;
	}
    .nombre{
        padding-top: 3.2cm;
        padding-left: 2.5cm;
    }
    .direccion{
        padding-top: 0.3cm;
        padding-left: 2.5cm;
    }
    .fecha{
        width: 6.5cm;
        padding-top: 0.3cm;
        padding-left: 2.5cm;
        float: left;
    }
    .nit{
        padding-top: 0.3cm;
        padding-left: 0.8cm;
    }
    .encabezado{
        padding-top: 0.3cm;
        border:1px solid;
        border-color: green;
    }
    .detalle{
        padding-top: 1cm;
        padding-left: 1.2cm;
        padding-right: 0.7cm;
        height: 9.9cm;
        border:1px solid;
        border-color: blue;
        
    }
    .cantidad{
        width: 2cm;
        height: 9.9cm;
        float:left;
        font-family: calibri;
        font-size: 13px;
    }
    .descripcion{
        width: 7.7cm;
        height: 9.9cm;
        float:left;
        font-family: calibri;
        font-size: 13px;
    }
    .valor{
        width: 2.3cm;
        height: 9.9cm;
        float:left;
        font-family: calibri;
        font-size: 13px;
    }
    .final{
        width: 13.5cm;
        height: 3.3cm;
        border:1px solid;
        border-color: black;
    }
    .letras{
        padding-top: 0.15cm;
        margin-left: 1.4cm;
    }
    .info{
        padding-top: 0.3cm;
    }
    .total{
        padding-top: 1.2cm;
        margin-left: 10.8cm;
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
                @endforeach
            </div>
        </div>
     </div>
</html>