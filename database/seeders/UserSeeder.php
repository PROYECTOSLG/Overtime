<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Victor Hugo Arroyo Jamaica',
            'email' => 'hugo.arroyo@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'RH'
        ]);

        User::create([
            'name' => 'Alejandra Guadalupr Lora Nieves',
            'email' => 'alejandra.lora@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'RH'
        ]);

        User::create([
            'name' => 'Antonio Gomez Flores',
            'email' => 'antonio.gomez@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'POWER PACK'
        ]);

        User::create([
            'name' => 'Luis Giovanni Gutierrez Lopez',
            'email' => 'giovanni.gutierrez@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'GEN 3'
        ]);

        User::create([
            'name' => 'Yossiri Estrada Saenz',
            'email' => 'yossiri.estrada@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'NEXTEER'
        ]);

        User::create([
            'name' => 'Eduardo Mejia Silverio',
            'email' => 'eduardo.silverio@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'NEXTEER'
        ]);

        User::create([
            'name' => 'Maria Jose Hernandez Gonzalez',
            'email' => 'maria.hernandez@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'MFG CAMARA'
        ]);

        User::create([
            'name' => 'Hector Antonio Castillo Gallegos',
            'email' => 'hector.castillo@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'MFG CAMARA'
        ]);

        User::create([
            'name' => 'Jose Antonio Gutierrez Vivas',
            'email' => 'antonio.gutierrez@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'CUSTOMER QA MOTOR'
        ]);

        User::create([
            'name' => 'Melina Hernandez Garcia',
            'email' => 'melina.garcia@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'PROCESS QA MOTOR'
        ]);

        User::create([
            'name' => 'Karel Carreon Barrera',
            'email' => 'karel.carreon@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'PROCESS QA MOTOR'
        ]);

        User::create([
            'name' => 'Jose Antonio Espinoza Bravo',
            'email' => 'antonio.espinoza@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'SQA MOTOR'
        ]);

        User::create([
            'name' => 'Gabriel Flores Vilchis',
            'email' => 'gabriel.flores@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'METROLOGIA'
        ]);

        User::create([
            'name' => 'Erick Duarte Rivera',
            'email' => 'erick.duarte@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'ALMACEN'
        ]);

        User::create([
            'name' => 'ADRIANA ACOSTA PICHARDO',
            'email' => 'adriana.acosta@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'MANTENIMIENTO'
        ]);

        User::create([
            'name' => 'Alvaro Camacho Alegria',
            'email' => 'alvaro.camacho@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'IT'
        ]);

        User::create([
            'name' => 'Alberto Aguilar Ramirez',
            'email' => 'alberto.aguilar@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'EESH'
        ]);

        User::create([
            'name' => 'Rigoberto Emmanuel Orozco',
            'email' => 'emmanuel.orozco@lginnotek.com',
            'password' => bcrypt('lginnotek01'),
            'role' => 'EESH'
        ]);
    }
}
