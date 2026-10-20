<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'user_id',
        'quadra_id',
        'data_reserva',
        'hora_inicio',
        'hora_fim',
        'horas_total',
        'total',
        'condicao_pagamento',
        'metodo_pagamento',
        'tipo_pagamento',
        'parcelas',
    ];

    protected function casts(): array
    {
        return [
            'data_reserva' => 'date',
            'total' => 'decimal:2',
            'horas_total' => 'decimal:2',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quadra(): BelongsTo
    {
        return $this->belongsTo(Quadra::class, 'quadra_id');
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(Pagamento::class, 'reserva_id');
    }
}