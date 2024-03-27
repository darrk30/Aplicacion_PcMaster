<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Documento::create([
            'nombre' => 'Documento Nacional de Identidad',
            'siglas' => 'DNI',
            'cantidadDigitos' => '8',
            'slug' => 'dni',
            'vigente' => 1
        ]);  
        Documento::create([
            'nombre' => 'Carnet de Extrajería',
            'siglas' => 'CE',
            'cantidadDigitos' => '20',
            'slug' => 'dni',
            'vigente' => 1
        ]);        
    }
}
