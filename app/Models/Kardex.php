<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;
    protected $fillable = ['tipoTransaccion', 'fecha', 'ubicacion', 'descripcion', 'proveedor_id', 'solicitud_componente_id'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function componentes()
    {
        return $this->belongsToMany(Componente::class);
    }
}
