<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
<<<<<<< HEAD
            AnimalsSeeder::class,
=======
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
            ConsultasSeeder::class,
        ]);
    }
}
