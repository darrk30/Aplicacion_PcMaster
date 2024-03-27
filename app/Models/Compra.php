<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable = ['codigo', 'fecha', 'fechaEntrega', 'precioTotal', 'proveedor_id', 'orden_reposicion_id'];

    public function ordenReposicion()
    {
        return $this->belongsTo(orden_reposicion::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
