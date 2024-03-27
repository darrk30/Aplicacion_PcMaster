<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Kevin Daniel',
            'email' => 'kevin@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Administrador');
        User::create([
            'name' => 'Alejando Tapia',
            'email' => 'tapia@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Vendedor');
        User::create([
            'name' => 'Claudia Odar',
            'email' => 'odar@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Jefe de Compras');
        User::create([
            'name' => 'Axel Ludeña',
            'email' => 'axel@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Jefe de Almacen');
        User::create([
            'name' => 'Genaro',
            'email' => 'genaro@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Jefe de Ensamblaje');
    }
}
