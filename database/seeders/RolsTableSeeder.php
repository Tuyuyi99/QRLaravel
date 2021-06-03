<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::truncate();

        DB::table('rols') ->insert([
            'id' => '1', 
            'rol' => 'administrador'
        ]);

        DB::table('rols') ->insert([
            'id' => '2', 
            'rol' => 'usuario'
        ]); 
    }
}
