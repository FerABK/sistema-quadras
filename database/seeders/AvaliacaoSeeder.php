<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvaliacaoSeeder extends Seeder
{
    public function run(): void
    {
        $avaliacoes = [
            [
                'login' => 'cliente01',
                'quadra' => 'Futebol Society',
                'nota' => 5,
                'comentario' => 'Ótima quadra e bem conservada.',
            ],
            [
                'login' => 'cliente02',
                'quadra' => 'Vôlei',
                'nota' => 4,
                'comentario' => 'Boa estrutura e espaço adequado.',
            ],
            [
                'login' => 'cliente03',
                'quadra' => 'Basquete',
                'nota' => 5,
                'comentario' => 'Excelente experiência.',
            ],
        ];

        foreach ($avaliacoes as $avaliacao) {
            $usuarioId = DB::table('users')
                ->where('login', $avaliacao['login'])
                ->value('id');

            $quadraId = DB::table('quadras')
                ->where('nome', $avaliacao['quadra'])
                ->value('id');

            DB::table('avaliacoes')->updateOrInsert(
                [
                    'user_id' => $usuarioId,
                    'quadra_id' => $quadraId,
                ],
                [
                    'nota' => $avaliacao['nota'],
                    'comentario' => $avaliacao['comentario'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
