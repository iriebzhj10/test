<?php

namespace Database\Seeders;
use App\Models\TypeParametre;
use App\Models\Parametre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            TypeParametreSeeder::class,
            ParametreSeeder::class
        );
    }
}
