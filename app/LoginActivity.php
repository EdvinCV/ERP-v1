<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    //
    protected $table = 'login_activities';
    protected $primarykey = 'id';
    protected $fillable = ['id','user_id'];
    public function user(){
        return $this->belongsTo('\App\User');
    }
}
