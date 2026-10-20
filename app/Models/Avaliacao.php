<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'user_id',
        'quadra_id',
        'nota',
        'comentario',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quadra(): BelongsTo
    {
        return $this->belongsTo(Quadra::class, 'quadra_id');
    }
}