<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas';
    protected $primarykey = 'id';
    protected $fillable = ['cantidad','tipo','observacion','idEmpleado'];
    public function user() {
        return $this->belongsTo('\App\User');
    }
}
