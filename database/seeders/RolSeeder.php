<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rol1 = new Rol();
        $rol1->usuario="Administrador";
        $rol1->save();

        $rol2 = new Rol();
        $rol2->usuario="Usuario";
        $rol2->save();
    }
}
