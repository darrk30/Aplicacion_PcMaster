<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    public function componente()
    {
        return $this->belongsToMany('App\Models\Componente');
    }

    public function ordenensamblaje()
    {
        return $this->hasOne('App\Models\OrdenEnsamblaje');
    }

    public function enviopedido(){
        return $this->hasMany('App\Models\EnvioPedido');
    }
}
