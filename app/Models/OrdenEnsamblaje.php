<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenEnsamblaje extends Model
{
    
    use HasFactory;
    protected $guarded = ['id'];

    public function pedido()
    {
        return $this->belongsTo('App\Models\Pedido');
    }

    public function solicitud_componente()
    {
        return $this->hasOne('App\Models\solicitud_componente');
    }
}
