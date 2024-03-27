<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud_componente extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function orden_ensamblaje()
    {
        return $this->belongsTo('App\Models\OrdenEnsamblaje');
    }
}
