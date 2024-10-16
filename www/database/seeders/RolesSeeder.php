<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_secretaria = Role::create(['name' => 'secretaria']);
<<<<<<< HEAD
        $role_veterinario = Role::create(['name' => 'veterinario']);
=======
        $role_psicologo = Role::create(['name' => 'psicologo']);
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
        $role_cliente = Role::create(['name' => 'cliente']);

    }
}
