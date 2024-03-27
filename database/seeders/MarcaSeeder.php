<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marca::create([
            'nombre' => 'ASUS',            
            'slug' => 'asus',
            'vigente' => 1
        ]);   
        Marca::create([
            'nombre' => 'MSI',            
            'slug' => 'msi',
            'vigente' => 1
        ]); 
        Marca::create([
            'nombre' => 'AMD',            
            'slug' => 'amd',
            'vigente' => 1
        ]);      
    }
}
