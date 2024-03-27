<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'nombres' => 'Kevin Daniel',
            'apellidos' => 'Rivera Rojas',
            'telefono' => '942407799',
            'correo' => 'kevin@gmail.com',
            'direccion' => 'Av. Manuel Burga Puelles 341 - Lambayeque',
            'documento_id' => 1,
            'numeroDoc' => '77777777',            
            'vigente' => 1
        ]);  
    }        
}
