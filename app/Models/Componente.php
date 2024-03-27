<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function marca(){
        return $this->belongsTo('App\Models\Marca');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }


    public function pedido(){
        return $this->belongsToMany('App\Models\Pedido');
    }
   

    public function kardexes()
    {
        return $this->belongsToMany(Kardex::class);
    }

    public function ordenesReposicion()
    {
        return $this->belongsToMany(orden_reposicion::class, 'orden_reposicion_componentes')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}
    // public function DetallesPedido(){
    //     return $this->belogsToMany('App\Models\DetallesPedido');
    // }

