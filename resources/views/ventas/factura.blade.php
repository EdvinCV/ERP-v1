<?php 
     $hoy = getdate();
     $total = 0;
?>

<head>
<style>
	.contenedor{
        
		width: 13.5cm;
        height: 19.9cm;
        
	}
    .nombre{
        padding-top: 2cm;
        padding-left: 1.6cm;
    }
    .direccion{
        padding-top: 0.3cm;
        padding-left: 1.6cm;
    }
    .fecha{
        width: 6.1cm;
        padding-top: 0.3cm;
        padding-left: 1.6cm;
        float: left;
    }
    .nit{
        padding-top: 0.3cm;
        padding-left: 0.2cm;
    }
    .encabezado{
        padding-top: 0.3cm;
    
        
    }
    .detalle{
        padding-top: 0.7cm;
        padding-left: 1cm;
        padding-right: 0.7cm;
        height: 9.9cm;
        
        
        
    }
    .cantidad{
        width: 1.2cm;
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
        
        
    }
    .letras{
        padding-top: 0.5cm;
        margin-left: 1.4cm;
    }
    .info{
        padding-top: 0.3cm;
    }
    .total{
        padding-top: 2.2cm;
        margin-left: 10cm;
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
                {{$v->fecha}}
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
                    {{$d->producto}}   -   {{$d->presentacion}}  -  {{ number_format((float)$d->precioventa,2,'.','')   }}
                    <br>
                @endforeach
            </div>
            <div class="valor">
                @foreach($detalles as $d)
                    {{ number_format((float)$d->subtotal,2,'.','') }}
                    <br>
                @endforeach
            </div>
        </div>
        <div class="final">
            <div class="letras">
                {{$totalLetras}}
            </div>
            <div class="info">
                
            </div>
            <div class="total">
                @foreach($ventas as $v)
                    {{ numb er_format((float)$v->total,2,'.','') }}
                @endforeach
            </div>
        </div>
     </div>
</html>