<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        DB::table('users') ->insert([
            'name' => 'Administrador',
            'surname' => 'admin admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'rol_id'=> '1'
        ]);

    }
}