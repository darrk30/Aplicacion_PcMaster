<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'contacto'];

    public function kardexes()
    {
        return $this->hasMany(Kardex::class);
    }
    public function compra()
    {
        return $this->hasOne(Compra::class);
    }
}
