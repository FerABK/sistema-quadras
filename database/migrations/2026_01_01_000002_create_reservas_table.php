
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('quadra_id')->constrained('quadras')->restrictOnDelete();
            $table->date('data_reserva');
            $table->unsignedTinyInteger('hora_inicio');
            $table->unsignedTinyInteger('hora_fim');
            $table->decimal('horas_total', 5, 2)->default(1);
            $table->decimal('total', 10, 2);
            $table->string('condicao_pagamento', 50);
            $table->string('metodo_pagamento', 30);
            $table->string('tipo_pagamento', 20)->nullable();
            $table->unsignedTinyInteger('parcelas')->nullable();
            $table->timestamps();

            $table->unique(['quadra_id', 'data_reserva', 'hora_inicio']);
            $table->index(['user_id', 'data_reserva']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
