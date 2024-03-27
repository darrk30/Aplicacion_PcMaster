<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'nombre' => 'Memorias RAM',            
            'slug' => 'memorias-ram',
            'vigente' => 1
        ]);   
        Category::create([
            'nombre' => 'Procesadores',            
            'slug' => 'procesadores',
            'vigente' => 1
        ]); 
        Category::create([
            'nombre' => 'Discos Duros',            
            'slug' => 'discos-duros',
            'vigente' => 1
        ]);      
    }
}
