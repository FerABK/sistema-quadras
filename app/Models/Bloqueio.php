<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bloqueio extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'quadra_id',
        'data',
        'motivo',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'date',
        ];
    }

    public function quadra(): BelongsTo
    {
        return $this->belongsTo(Quadra::class, 'quadra_id');
    }
}