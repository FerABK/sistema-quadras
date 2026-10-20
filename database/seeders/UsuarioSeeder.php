<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $agora = now();

        DB::table('users')->updateOrInsert(
            ['login' => 'admin'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin123!'),
                'role' => 'administrador',
                'created_at' => $agora,
                'updated_at' => $agora,
            ]
        );

        for ($i = 1; $i <= 40; $i++) {
            $numero = str_pad($i, 2, '0', STR_PAD_LEFT);

            DB::table('users')->updateOrInsert(
                ['login' => 'cliente' . $numero],
                [
                    'name' => 'Cliente ' . $numero,
                    'password' => Hash::make('Cliente123!'),
                    'role' => 'cliente',
                    'created_at' => $agora,
                    'updated_at' => $agora,
                ]
            );
        }
    }
}
