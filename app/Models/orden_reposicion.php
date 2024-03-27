<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orden_reposicion extends Model
{
    use HasFactory;
    protected $fillable = ['fecha', 'estado'];

    public function componentes()
    {
        return $this->belongsToMany(Componente::class, 'orden_reposicion_componentes')
            ->withPivot('cantidad')
            ->withTimestamps();
    }

    public function compra()
    {
        return $this->hasOne(Compra::class);
    }
}
