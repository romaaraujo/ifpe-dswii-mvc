<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Database\Factories\UsuarioFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        Usuario::factory()->count(1)->create();
    }
}
