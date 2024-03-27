<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    //relacion uno a muchos inversa
    public function documento(){
        return $this->belongsTo('App\Models\Documento');
    }

    public function pedido(){
        return $this->hasMany('App\Models\Pedido');
    }
}
