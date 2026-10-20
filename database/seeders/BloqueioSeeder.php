<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloqueioSeeder extends Seeder
{
    public function run(): void
    {
        $bloqueios = [
            [
                'quadra' => 'Futsal',
                'data' => '2026-11-15',
                'motivo' => 'Manutenção do piso',
            ],
            [
                'quadra' => 'Tênis',
                'data' => '2026-11-16',
                'motivo' => 'Manutenção da quadra',
            ],
            [
                'quadra' => 'Beach tennis',
                'data' => '2026-11-17',
                'motivo' => 'Evento particular',
            ],
        ];

        foreach ($bloqueios as $bloqueio) {
            $quadraId = DB::table('quadras')
                ->where('nome', $bloqueio['quadra'])
                ->value('id');

            DB::table('bloqueios')->updateOrInsert(
                [
                    'quadra_id' => $quadraId,
                    'data' => $bloqueio['data'],
                    'motivo' => $bloqueio['motivo'],
                ]
            );
        }
    }
}