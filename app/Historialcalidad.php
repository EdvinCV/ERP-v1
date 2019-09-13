<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historialcalidad extends Model
{
    protected $table = 'historialcalidads';
    protected $primarykey = 'id';
    protected $fillable = ['id','calificacion','fecha','idproducto'];
    public function producto() {
        return $this->belongsTo('\App\Producto');
    }
}
