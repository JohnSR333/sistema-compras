<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordencompras', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->decimal('total', 10, 2);
            $table->string('tipopago');
            $table->decimal('saldopendiente', 10, 2);
            $table->string('estado');
            $table->string('registradopor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordencompras');
    }
};
