<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'slug', 'vigente'];

    public function componentes(){
        return $this->hasMany('App\Models\Componente');
    }

    public function getRouteKeyName()
    {
        return "slug";
    }
}
