<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quadra extends Model
{
    protected $table = 'quadras';

    protected $fillable = [
        'nome',
        'tipo',
        'valor_hora',
        'imagem',
    ];

    protected function casts(): array
    {
        return [
            'valor_hora' => 'decimal:2',
        ];
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'quadra_id');
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'quadra_id');
    }
}