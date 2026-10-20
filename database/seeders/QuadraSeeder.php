<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuadraSeeder extends Seeder
{
    public function run(): void
    {
        $quadras = [
            [
                'nome' => 'Futebol Society',
                'tipo' => 'Futebol Society',
                'valor_hora' => 150,
                'imagem' => '1780883859_futebolsociety.jpg',
            ],
            [
                'nome' => 'Futsal',
                'tipo' => 'Futsal',
                'valor_hora' => 90,
                'imagem' => '1780883959_futsal.jpg',
            ],
            [
                'nome' => 'Basquete',
                'tipo' => 'Basquete',
                'valor_hora' => 100,
                'imagem' => '1780883979_basquete.webp',
            ],
            [
                'nome' => 'Vôlei',
                'tipo' => 'Vôlei',
                'valor_hora' => 110,
                'imagem' => '1780884607_volei.jpg',
            ],
            [
                'nome' => 'Tênis',
                'tipo' => 'Tênis',
                'valor_hora' => 160,
                'imagem' => '1780884021_tenis.jfif',
            ],
            [
                'nome' => 'Beach tennis',
                'tipo' => 'Beach tennis',
                'valor_hora' => 140,
                'imagem' => '1780884039_beachtenis.jpg',
            ],
            [
                'nome' => 'Badminton',
                'tipo' => 'Badminton',
                'valor_hora' => 70,
                'imagem' => '1780884061_badminton.jpg',
            ],
        ];

        foreach ($quadras as $quadra) {
            DB::table('quadras')->updateOrInsert(
                ['nome' => $quadra['nome']],
                [
                    ...$quadra,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}