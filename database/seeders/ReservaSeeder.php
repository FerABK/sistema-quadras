<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = DB::table('users')
            ->where('role', 'cliente')
            ->orderBy('login')
            ->get();

        $quadras = DB::table('quadras')
            ->orderBy('id')
            ->get();

        for ($i = 0; $i < 40; $i++) {
            $usuario = $usuarios[$i];
            $quadra = $quadras[$i % $quadras->count()];

            $data = date(
                'Y-m-d',
                strtotime('2026-11-01 +' . $i . ' days')
            );

            $horaInicio = 8 + ($i % 10);
            $horaFim = $horaInicio + 1;

            DB::table('reservas')->updateOrInsert(
                [
                    'quadra_id' => $quadra->id,
                    'data_reserva' => $data,
                    'hora_inicio' => $horaInicio,
                ],
                [
                    'user_id' => $usuario->id,
                    'hora_fim' => $horaFim,
                    'horas_total' => 1,
                    'total' => $quadra->valor_hora,
                    'condicao_pagamento' => 'avista',
                    'metodo_pagamento' => 'pix',
                    'tipo_pagamento' => null,
                    'parcelas' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
