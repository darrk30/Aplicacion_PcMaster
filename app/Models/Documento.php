<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'siglas', 'cantidadDigitos','slug', 'vigente'];

    public function clientes(){
        return $this->hasMany('App\Models\Cliente');
    }

    public function users(){
        return $this->hasMany('App\Models\User');
    }

    public function getRouteKeyName()
    {
        return "slug";
    }
}
