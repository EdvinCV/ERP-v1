<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primarykey = 'id';
    protected $fillable = [
        'idcategoria','idpresentacion','idpersona','nombre','precioventa','preciocompra',
        'gastocomercializacion','utilidad','impuesto','maximoprecio','minimoprecio',
        'estado','codigo','cantidadapartado','existencia','porcComercializacion','porcUtilidad'
    ];
    public function categoria() {
        return $this->belongsTo('\App\Categoria');
    }
    public function presentacion() {
        return $this->belongsTo('\App\Presentacion');
    }
    public function persona() {
        return $this->belongsTo('\App\Persona');
    }
    public function historialcalidads()
    {
        return $this->hasMany('App\Historialcalidad');
    }
}
