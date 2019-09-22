<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre','apellido','direccion','telefono','nit','correo','estado'
    ];
    public function productos()
    {
        return $this->hasMany('App\Producto');
    }
}
